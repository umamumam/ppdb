<?php

namespace App\Http\Controllers;

use App\Models\DokumenSiswa;
use App\Models\Ppdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenSiswaController extends Controller
{
    public function showUploadForm($ppdb_id)
    {
        $ppdb = Ppdb::findOrFail($ppdb_id);
        $dokumen = $ppdb->dokumenSiswa;
        return view('ppdb.upload_dokumen', compact('ppdb', 'dokumen'));
    }

    public function upload(Request $request, $ppdb_id)
    {
        $request->validate([
            'kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $ppdb = Ppdb::findOrFail($ppdb_id);
        $data = ['ppdb_id' => $ppdb_id];

        foreach (['kk', 'akte', 'surat_keterangan_lulus', 'kip'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->$field) {
                    Storage::delete('public/' . $ppdb->dokumenSiswa->$field);
                }

                $file = $request->file($field);
                $path = $file->store("dokumen_siswa/{$ppdb_id}", 'public');
                $data[$field] = $path;
            }
        }

        DokumenSiswa::updateOrCreate(
            ['ppdb_id' => $ppdb_id],
            $data
        );

        return redirect()->route('ppdb.show', $ppdb_id)
            ->with('success', 'Dokumen berhasil diupload!');
    }

    public function previewDokumen($ppdb_id)
    {
        $ppdb = Ppdb::with('dokumenSiswa')->findOrFail($ppdb_id);
        return view('ppdb.preview_dokumen', compact('ppdb'));
    }

    public function deleteDokumen($ppdb_id, $docType)
    {
        $dokumen = DokumenSiswa::where('ppdb_id', $ppdb_id)->firstOrFail();

        if ($dokumen->$docType) {
            Storage::delete('public/' . $dokumen->$docType);
            $dokumen->update([$docType => null]);
        }

        return redirect()->back()
            ->with('success', 'Dokumen berhasil dihapus!');
    }
}
