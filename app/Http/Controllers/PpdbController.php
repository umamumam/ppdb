<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use Illuminate\Validation\Rule;
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
        return view('ppdb.create', compact('tahunPelajaran'));
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
            'no_kk' => 'nullable|string|max:20',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'hp_siswa' => 'nullable|string|max:15',
            'hp_ortu' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'asal_sekolah' => 'nullable|string|max:100',
            'npsn' => 'nullable|string|max:20',
            'nsm' => 'nullable|string|max:20',
            'alamat_sekolah' => 'nullable|string',
            'no_kip' => 'nullable|string|max:20',
            'no_kks' => 'nullable|string|max:20',
            'no_pkh' => 'nullable|string|max:20',
        ];

        $alumniRules = [
            'nisn' => 'required|exists:alumnis,nisn',
            'nama_siswa' => 'nullable|string|max:100',
            'nis' => 'nullable|string|max:20',
            'nik_siswa' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $baruRules = [
            'nisn' => 'nullable|string|max:20|unique:ppdbs,nisn',
            'nama_siswa' => 'required|string|max:100',
            'nis' => 'nullable|string|max:20|unique:ppdbs,nis',
            'nik_siswa' => 'nullable|string|max:20|unique:ppdbs,nik_siswa',
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
        return view('ppdb.edit', compact('ppdb', 'tahunPelajaran'));
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
            'no_kk' => 'nullable|string|max:20',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'hp_siswa' => 'nullable|string|max:15',
            'hp_ortu' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'asal_sekolah' => 'nullable|string|max:100',
            'npsn' => 'nullable|string|max:20',
            'nsm' => 'nullable|string|max:20',
            'alamat_sekolah' => 'nullable|string',
            'no_kip' => 'nullable|string|max:20',
            'no_kks' => 'nullable|string|max:20',
            'no_pkh' => 'nullable|string|max:20',
        ];

        $alumniRules = [
            'nisn' => ['required', 'exists:alumnis,nisn'],
            'nama_siswa' => 'required|string|max:100',
            'nis' => 'nullable|string|max:20',
            'nik_siswa' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
        ];

        $baruRules = [
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('ppdbs')->ignore($ppdb->id)],
            'nama_siswa' => 'required|string|max:100',
            'nis' => ['nullable', 'string', 'max:20', Rule::unique('ppdbs')->ignore($ppdb->id)],
            'nik_siswa' => ['nullable', 'string', 'max:20', Rule::unique('ppdbs')->ignore($ppdb->id)],
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
}
