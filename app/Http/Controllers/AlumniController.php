<?php

// app/Http/Controllers/AlumniController.php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Exports\AlumniExport;
use App\Imports\AlumniImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::latest()->paginate(10);
        return view('alumnis.index', compact('alumnis'));
    }

    public function create()
    {
        return view('alumnis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'nik_siswa' => 'nullable|string|max:20',
            'nama_siswa' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jeniskelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:10',
            'program' => 'nullable|in:Keagamaan,MIPA,IPS',
            'anak_ke' => 'nullable|integer',
            'no_kk' => 'nullable|string|max:20',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:50',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:50',
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
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alumni-photos', 'public');
        }

        Alumni::create($validated);

        return redirect()->route('alumnis.index')
            ->with('success', 'Alumni created successfully.');
    }

    public function show(Alumni $alumni)
    {
        return view('alumnis.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('alumnis.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'nik_siswa' => 'nullable|string|max:20',
            'nama_siswa' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jeniskelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:10',
            'program' => 'nullable|in:Keagamaan,MIPA,IPS',
            'anak_ke' => 'nullable|integer',
            'no_kk' => 'nullable|string|max:20',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ayah' => 'nullable|string|max:50',
            'nik_ibu' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|in:SD/MI,SMP/MTS,SMA/MA,D3,S1,S2,S3',
            'pekerjaan_ibu' => 'nullable|string|max:50',
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
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($alumni->foto) {
                Storage::disk('public')->delete($alumni->foto);
            }
            $validated['foto'] = $request->file('foto')->store('alumni-photos', 'public');
        }

        $alumni->update($validated);

        return redirect()->route('alumnis.index')
            ->with('success', 'Alumni updated successfully');
    }

    public function destroy(Alumni $alumni)
    {
        // Delete photo if exists
        if ($alumni->foto) {
            Storage::disk('public')->delete($alumni->foto);
        }

        $alumni->delete();

        return redirect()->route('alumnis.index')
            ->with('success', 'Alumni deleted successfully');
    }
    // public function export(Request $request)
    // {
    //     $selectedIds = $request->input('selected');

    //     if (!$selectedIds || count($selectedIds) === 0) {
    //         return redirect()->back()->with('error', 'Pilih data alumni yang ingin diekspor.');
    //     }

    //     return Excel::download(new AlumniExport($selectedIds), 'data-alumni-terpilih.xlsx');
    // }
    public function export(Request $request)
    {
        $selectedIds = json_decode($request->input('selected'));

        if (empty($selectedIds)) {
            return back()->with('error', 'Pilih data yang akan diexport');
        }

        return Excel::download(new AlumniExport($selectedIds), 'alumni-export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new AlumniImport, $request->file('file'));

        return back()->with('success', 'Data alumni berhasil diimport!');
    }
}
