<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use App\Models\Alumni;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ppdbs = Ppdb::with(['tahunPelajaran', 'alumni'])->latest()->get();
        return view('ppdb.index', compact('ppdbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunPelajarans = TahunPelajaran::where('active', true)->get();
        return view('ppdb.create', compact('tahunPelajarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->jenis_pendaftar === 'alumni' && empty($request->nisn)) {
            return redirect()->back()
                ->with('error', 'NISN wajib diisi untuk pendaftar alumni')
                ->withInput();
        }

        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $this->prepareData($request);

        if ($request->jenis_pendaftar == 'alumni') {
            $alumni = Alumni::where('nisn', $request->nisn)->first();
            if (!$alumni) {
                return redirect()->back()
                    ->with('error', 'NISN tidak ditemukan di database alumni')
                    ->withInput();
            }
            $data = $this->fillFromAlumni($data, $alumni);
        }

        // Handle file upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        Ppdb::create($data);

        return redirect()->route('ppdb.index')
            ->with('success', 'Data pendaftaran berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ppdb $ppdb)
    {
        return view('ppdb.show', compact('ppdb'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ppdb $ppdb)
    {
        $tahunPelajarans = TahunPelajaran::all();
        return view('ppdb.edit', compact('ppdb', 'tahunPelajarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ppdb $ppdb)
    {
        $validator = $this->validateRequest($request, $ppdb);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $this->prepareData($request);

        if ($request->jenis_pendaftar == 'alumni') {
            $alumni = Alumni::where('nisn', $request->nisn)->first();
            if (!$alumni) {
                return redirect()->back()
                    ->with('error', 'NISN tidak ditemukan di database alumni')
                    ->withInput();
            }
            $data = $this->fillFromAlumni($data, $alumni);
        }

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($ppdb->foto) {
                $this->deleteFoto($ppdb->foto);
            }
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        $ppdb->update($data);

        return redirect()->route('ppdb.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ppdb $ppdb)
    {
        // Delete foto if exists
        if ($ppdb->foto) {
            $this->deleteFoto($ppdb->foto);
        }

        $ppdb->delete();

        return redirect()->route('ppdb.index')
            ->with('success', 'Data pendaftaran berhasil dihapus');
    }

    /**
     * Check alumni by NISN
     */
    public function checkAlumni(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string'
        ]);

        $alumni = Alumni::where('nisn', $request->nisn)->first();

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $alumni
        ]);
    }

    /**
     * Validate request data
     */
    private function validateRequest(Request $request, $ppdb = null)
    {
        $rules = [
            'jenis_pendaftar' => 'required|in:baru,alumni',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($request->jenis_pendaftar == 'alumni') {
            $rules['nisn'] = [
                'required',
                'string',
                Rule::exists('alumnis', 'nisn'),
                $ppdb ? Rule::unique('ppdbs', 'nisn')->ignore($ppdb->id) : 'unique:ppdbs,nisn'
            ];
        } else {
            $rules = array_merge($rules, [
                'nis' => 'nullable|string|unique:ppdbs,nis' . ($ppdb ? ',' . $ppdb->id : ''),
                'nisn' => 'nullable|string|unique:ppdbs,nisn' . ($ppdb ? ',' . $ppdb->id : ''),
                'nik_siswa' => 'nullable|string|unique:ppdbs,nik_siswa' . ($ppdb ? ',' . $ppdb->id : ''),
                'nama_siswa' => 'required|string|max:255',
                'jeniskelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_lahir' => 'required|string|max:255',
                'tgl_lahir' => 'required|date',
                'kelas' => 'nullable|string|max:50',
                'program' => 'nullable|in:Keagamaan,MIPA,IPS',
                'anak_ke' => 'nullable|integer|min:1',
                'no_kk' => 'nullable|string|max:255',
                'nik_ayah' => 'nullable|string|max:255',
                'nama_ayah' => 'nullable|string|max:255',
                'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
                'pekerjaan_ayah' => 'nullable|string|max:255',
                'nik_ibu' => 'nullable|string|max:255',
                'nama_ibu' => 'nullable|string|max:255',
                'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
                'pekerjaan_ibu' => 'nullable|string|max:255',
                'hp_siswa' => 'nullable|string|max:20',
                'hp_ortu' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'kode_pos' => 'nullable|string|max:10',
                'asal_sekolah' => 'nullable|string|max:255',
                'npsn' => 'nullable|string|max:255',
                'nsm' => 'nullable|string|max:255',
                'alamat_sekolah' => 'nullable|string',
                'no_kip' => 'nullable|string|max:255',
                'no_kks' => 'nullable|string|max:255',
                'no_pkh' => 'nullable|string|max:255',
            ]);
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * Prepare data for create/update
     */
    private function prepareData(Request $request)
    {
        $data = $request->except('_token', '_method', 'foto');

        // Set default kelas if empty
        if (empty($data['kelas'])) {
            $data['kelas'] = 'X';
        }

        return $data;
    }

    /**
     * Fill data from alumni
     */
    private function fillFromAlumni($data, $alumni)
    {
        $fieldsToCopy = [
            'nis',
            'nik_siswa',
            'nama_siswa',
            'foto',
            'jeniskelamin',
            'tempat_lahir',
            'tgl_lahir',
            'kelas',
            'program',
            'anak_ke',
            'no_kk',
            'nik_ayah',
            'nama_ayah',
            'pendidikan_ayah',
            'pekerjaan_ayah',
            'nik_ibu',
            'nama_ibu',
            'pendidikan_ibu',
            'pekerjaan_ibu',
            'hp_siswa',
            'hp_ortu',
            'alamat',
            'kode_pos',
            'asal_sekolah',
            'npsn',
            'nsm',
            'alamat_sekolah',
            'no_kip',
            'no_kks',
            'no_pkh',
        ];

        foreach ($fieldsToCopy as $field) {
            if (empty($data[$field])) {
                $data[$field] = $alumni->$field;
            }
        }

        return $data;
    }

    /**
     * Upload foto
     */
    private function uploadFoto($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/foto_siswa', $filename);
        return str_replace('public/', '', $path);
    }

    /**
     * Delete foto
     */
    private function deleteFoto($path)
    {
        if (file_exists(storage_path('app/public/' . $path))) {
            unlink(storage_path('app/public/' . $path));
        }
    }
}
