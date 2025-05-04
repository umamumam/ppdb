<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Menampilkan semua pembayaran untuk siswa PPDB tertentu
    public function index($ppdb_id)
    {
        $ppdb = Ppdb::with(['pembayarans' => function($query) {
            $query->orderBy('tgl_bayar', 'desc');
        }])->findOrFail($ppdb_id);

        return view('pembayaran.index', compact('ppdb'));
    }

    // Menampilkan form tambah pembayaran
    public function create($ppdb_id)
    {
        $ppdb = Ppdb::findOrFail($ppdb_id);
        return view('pembayaran.create', compact('ppdb'));
    }

    // Menyimpan pembayaran baru
    public function store(Request $request, $ppdb_id)
    {
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|in:SPP,Infaq,Seragam',
            'nominal' => 'required|numeric|min:1000',
            'tgl_bayar' => 'required|date',
            'status' => 'required|in:Lunas,Belum Lunas',
            'keterangan' => 'nullable|string|max:255'
        ]);

        Pembayaran::create($validated + ['ppdb_id' => $ppdb_id]);

        return redirect()->route('pembayaran.index', $ppdb_id)
            ->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    // Menampilkan form edit pembayaran
    public function edit($ppdb_id, $pembayaran_id)
    {
        $pembayaran = Pembayaran::where('ppdb_id', $ppdb_id)->findOrFail($pembayaran_id);
        return view('pembayaran.edit', compact('pembayaran', 'ppdb_id'));
    }

    // Update data pembayaran
    public function update(Request $request, $ppdb_id, $pembayaran_id)
    {
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|in:SPP,Infaq,Seragam',
            'nominal' => 'required|numeric|min:1000',
            'tgl_bayar' => 'required|date',
            'status' => 'required|in:Lunas,Belum Lunas',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $pembayaran = Pembayaran::where('ppdb_id', $ppdb_id)
                        ->findOrFail($pembayaran_id)
                        ->update($validated);

        return redirect()->route('pembayaran.index', $ppdb_id)
            ->with('success', 'Pembayaran berhasil diperbarui!');
    }

    // Hapus pembayaran
    public function destroy($ppdb_id, $pembayaran_id)
    {
        Pembayaran::where('ppdb_id', $ppdb_id)
            ->findOrFail($pembayaran_id)
            ->delete();

        return redirect()->route('pembayaran.index', $ppdb_id)
            ->with('success', 'Pembayaran berhasil dihapus!');
    }
}
