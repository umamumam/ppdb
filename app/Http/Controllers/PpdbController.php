<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ppdb;
use App\Models\Ujian;
use App\Models\Alumni;
use App\Models\Petugas;
use App\Exports\PpdbExport;
use App\Imports\PpdbImport;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PpdbController extends Controller
{
    public function index()
    {
        $ppdbs = Ppdb::with('tahunPelajaran')->latest()->get();
        return view('ppdb.index', compact('ppdbs'));
    }

    public function create()
    {
        $tahunPelajaran = TahunPelajaran::where('active', true)->first();
        $petugas = Petugas::all();
        return view('ppdb.create', compact('tahunPelajaran', 'petugas'));
    }

    public function store(Request $request)
    {
        $commonRules = [
            'jenis_pendaftar' => 'required|in:baru,alumni',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jeniskelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:20',
            'program' => 'nullable|in:Keagamaan,MIPA,IPS',
            'anak_ke' => 'nullable|integer|min:1',
            'no_kk' => 'nullable|string|max:16',
            'nik_ayah' => 'nullable|string|max:16',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:16',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'hp_siswa' => 'nullable|string|max:13',
            'hp_ortu' => 'nullable|string|max:13',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:5',
            'asal_sekolah' => 'nullable|string|max:100',
            'npsn' => 'nullable|string|max:20',
            'nsm' => 'nullable|string|max:20',
            'alamat_sekolah' => 'nullable|string',
            'no_kip' => 'nullable|string|max:20',
            'no_kks' => 'nullable|string|max:20',
            'no_pkh' => 'nullable|string|max:20',
            'petugas_id' => 'nullable|exists:petugas,id',
        ];

        $alumniRules = [
            'nisn' => 'required|string|size:10|exists:alumnis,nisn',
            'nama_siswa' => 'nullable|string|max:100',
            'nis' => 'nullable|string|max:10',
            'nik_siswa' => 'nullable|string|max:16',
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $baruRules = [
            'nisn' => 'nullable|string|max:10|unique:ppdbs,nisn',
            'nama_siswa' => 'required|string|max:100',
            'nis' => 'nullable|string|max:10|unique:ppdbs,nis',
            'nik_siswa' => 'nullable|string|max:16|unique:ppdbs,nik_siswa',
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $rules = $request->jenis_pendaftar == 'alumni'
            ? array_merge($commonRules, $alumniRules)
            : array_merge($commonRules, $baruRules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tahunPelajaran = TahunPelajaran::where('active', true)->firstOrFail();

        $data = $request->except('foto');
        $data['tahun_pelajaran_id'] = $tahunPelajaran->id;

        if ($request->jenis_pendaftar == 'alumni') {
            $alumni = Alumni::where('nisn', $request->nisn)->first();
            if ($alumni) {
                $data = array_merge($alumni->toArray(), $data);
            }
        }

        // Handle file upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_siswa', 'public');
            $data['foto'] = $path; // Simpan path lengkap
        }

        $ppdb = new Ppdb($data);
        $ppdb->no_pendaftaran = $ppdb->generateNoPendaftaran();
        $ppdb->save();

        // return redirect()->route('ppdb.index')->with('success', 'Data PPDB berhasil disimpan');
        return redirect()->route('ppdb.show', $ppdb->id)->with('success', 'Data PPDB berhasil disimpan');
    }

    public function show(Ppdb $ppdb)
    {
        return view('ppdb.show', compact('ppdb'));
    }

    public function edit(Ppdb $ppdb)
    {
        $tahunPelajaran = TahunPelajaran::all();
        $petugas = Petugas::all();
        return view('ppdb.edit', compact('ppdb', 'tahunPelajaran', 'petugas'));
    }

    public function update(Request $request, Ppdb $ppdb)
    {
        $commonRules = [
            'jenis_pendaftar' => 'required|in:baru,alumni',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jeniskelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:20',
            'program' => 'nullable|in:Keagamaan,MIPA,IPS',
            'anak_ke' => 'nullable|integer|min:1',
            'no_kk' => 'nullable|string|max:16',
            'nik_ayah' => 'nullable|string|max:16',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:16',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'hp_siswa' => 'nullable|string|max:13',
            'hp_ortu' => 'nullable|string|max:13',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'asal_sekolah' => 'nullable|string|max:100',
            'npsn' => 'nullable|string|max:20',
            'nsm' => 'nullable|string|max:20',
            'alamat_sekolah' => 'nullable|string',
            'no_kip' => 'nullable|string|max:20',
            'no_kks' => 'nullable|string|max:20',
            'no_pkh' => 'nullable|string|max:20',
            'petugas_id' => 'nullable|exists:petugas,id',
        ];

        $alumniRules = [
            'nisn' => ['required', 'exists:alumnis,nisn'],
            'nama_siswa' => 'required|string|max:100',
            'nis' => 'nullable|string|max:20',
            'nik_siswa' => 'nullable|string|max:16',
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $baruRules = [
            'nisn' => ['nullable', 'string', 'max:10', Rule::unique('ppdbs')->ignore($ppdb->id)],
            'nama_siswa' => 'required|string|max:100',
            'nis' => ['nullable', 'string', 'max:10', Rule::unique('ppdbs')->ignore($ppdb->id)],
            'nik_siswa' => ['nullable', 'string', 'max:16', Rule::unique('ppdbs')->ignore($ppdb->id)],
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $rules = $request->jenis_pendaftar == 'alumni'
            ? array_merge($commonRules, $alumniRules)
            : array_merge($commonRules, $baruRules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('foto');

        // Handle file upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_siswa', 'public');
            $data['foto'] = $path; // Simpan path lengkap
        }

        $ppdb->update($data);

        return redirect()->route('ppdb.index')->with('success', 'Data PPDB berhasil diperbarui');
    }

    public function destroy(Ppdb $ppdb)
    {
        // Delete photo if exists
        if ($ppdb->foto) {
            Storage::disk('public')->delete($ppdb->foto);
        }

        $ppdb->delete();
        return redirect()->route('ppdb.index')->with('success', 'Data PPDB berhasil dihapus');
    }

    public function getAlumniData(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:alumnis,nisn'
        ]);

        $alumni = Alumni::where('nisn', $request->nisn)->first();
        return response()->json($alumni);
    }
    public function export(Request $request)
    {
        $selectedIds = json_decode($request->input('selected'));

        if (empty($selectedIds)) {
            return back()->with('error', 'Pilih data yang akan diexport');
        }

        return Excel::download(new PpdbExport($selectedIds), 'ppdb-export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new PpdbImport, $request->file('file'));

        return back()->with('success', 'Data PPDB berhasil diimport!');
    }

    public function search(Request $request)
    {
        $ppdb = Ppdb::where('nisn', $request->nisn)->first();
        return view('ppdb.search', compact('ppdb'));
    }

    public function cetak($id)
    {
        $ppdb = Ppdb::with('tahunPelajaran')->findOrFail($id);
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $ujian = Ujian::all()->sortBy('tanggal');
        $photoPath = storage_path('app/public/' . $ppdb->foto);
        $photoBase64 = null;
        if ($ppdb->foto && file_exists($photoPath)) {
            $type = pathinfo($photoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($photoPath);
            $photoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        $pdf = Pdf::loadView('ppdb.kartu', compact('ppdb', 'tanggal', 'ujian', 'photoBase64'))->setPaper('a4');
        return $pdf->stream('kartu_ppdb.pdf');
    }

    public function cetakSurat($id)
    {
        $ppdb = Ppdb::with('tahunPelajaran', 'petugas')->findOrFail($id);
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $photoPath = storage_path('app/public/' . $ppdb->foto);
        $photoBase64 = null;
        if ($ppdb->foto && file_exists($photoPath)) {
            $type = pathinfo($photoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($photoPath);
            $photoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        $materaiPath = public_path('materai.png');
        $materaiBase64 = null;
        if (file_exists($materaiPath)) {
            $materaiData = file_get_contents($materaiPath);
            $materaiBase64 = 'data:image/png;base64,' . base64_encode($materaiData);
        }
        $template = $ppdb->jenis_pendaftar == 'alumni' ? 'ppdb.naik' : 'ppdb.baru';
        $pdf = Pdf::loadView($template, [
            'ppdb' => $ppdb,
            'tanggal' => $tanggal,
            'photoBase64' => $photoBase64,
            'materaiBase64' => $materaiBase64
        ])->setPaper('a4');
        $filename = $ppdb->jenis_pendaftar == 'alumni'
            ? 'surat_naik_' . $ppdb->no_pendaftaran . '.pdf'
            : 'surat_baru_' . $ppdb->no_pendaftaran . '.pdf';
        return $pdf->stream($filename);
    }

    public function cetakBuktiPendaftaran($id)
    {
        $ppdb = Ppdb::with('tahunPelajaran')->findOrFail($id);
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $photoBase64 = null;
        if ($ppdb->foto) {
            $photoPath = storage_path('app/public/' . $ppdb->foto);
            if (file_exists($photoPath)) {
                $photoBase64 = 'data:' . mime_content_type($photoPath) . ';base64,' . base64_encode(file_get_contents($photoPath));
            }
        }
        $kopPath = public_path('kop.png');
        $kopBase64 = null;
        if (file_exists($kopPath)) {
            $kopBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($kopPath));
        }
        $pdf = Pdf::loadView('ppdb.bukti_pendaftaran', [
            'ppdb' => $ppdb,
            'tanggal' => $tanggal,
            'photoBase64' => $photoBase64,
            'kopBase64' => $kopBase64
        ])->setPaper('a4');

        return $pdf->stream('bukti_pendaftaran_' . $ppdb->no_pendaftaran . '.pdf');
    }
    public function getLaporanPendaftaranSiswa(Request $request)
    {
        $tahunPelajaran = TahunPelajaran::where('active', true)->first();
        if (!$tahunPelajaran) {
            return redirect()->back()->with('error', 'Tidak ada tahun pelajaran yang aktif');
        }
        $data = DB::table('ppdbs')
            ->select(
                'nama_siswa',
                'nisn',
                'jenis_pendaftar',
                'asal_sekolah',
                DB::raw("CASE
                    WHEN jenis_pendaftar = 'alumni' THEN 'Naik Tingkat'
                    WHEN jenis_pendaftar = 'baru' THEN 'Peserta Baru'
                    ELSE 'Lainnya'
                END as keterangan")
            )
            ->where('tahun_pelajaran_id', $tahunPelajaran->id)
            ->get();

        $totalAlumni = $data->where('jenis_pendaftar', 'alumni')->count();
        $totalBaru = $data->where('jenis_pendaftar', 'baru')->count();
        $totalSemua = $data->count();
        if ($request->has('preview') && $request->preview == 'pdf') {
            $pdf = Pdf::loadView('ppdb.laporan-pdf', [
                'data' => $data,
                'totalAlumni' => $totalAlumni,
                'totalBaru' => $totalBaru,
                'totalSemua' => $totalSemua,
                'tahunPelajaran' => $tahunPelajaran->tahun,
            ]);
            return $pdf->stream('preview-laporan-ppdb.pdf');
        }
        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('ppdb.laporan-pdf', [
                'data' => $data,
                'totalAlumni' => $totalAlumni,
                'totalBaru' => $totalBaru,
                'totalSemua' => $totalSemua,
                'tahunPelajaran' => $tahunPelajaran->tahun,
            ]);
            $filename = 'laporan-ppdb-' . str_replace(['/', '\\', ' '], '-', $tahunPelajaran->tahun) . '.pdf';
            return $pdf->download($filename);
        }
        return view('ppdb.laporan', [
            'data' => $data,
            'totalAlumni' => $totalAlumni,
            'totalBaru' => $totalBaru,
            'totalSemua' => $totalSemua,
            'tahunPelajaran' => $tahunPelajaran->tahun,
        ]);
    }
}
