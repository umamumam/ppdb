<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ppdb;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    // Menampilkan semua pembayaran untuk siswa PPDB tertentu
    public function index($ppdb_id)
    {
        $ppdb = Ppdb::with(['pembayarans' => function ($query) {
            $query->orderBy('tgl_bayar', 'desc');
        }, 'pembayarans.petugas'])->findOrFail($ppdb_id);

        return view('pembayaran.index', compact('ppdb'));
    }

    // Menampilkan form tambah pembayaran
    public function create($ppdb_id)
    {
        $ppdb = Ppdb::findOrFail($ppdb_id);
        $petugas = Petugas::all();
        return view('pembayaran.create', compact('ppdb', 'petugas'));
    }

    // Menyimpan pembayaran baru
    public function store(Request $request, $ppdb_id)
    {
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|array|min:1',
            'jenis_pembayaran.*' => 'in:SPP,Infaq,Seragam,Kitab,Kolektif',
            'nominal_spp' => 'nullable|required_if:jenis_pembayaran,SPP|numeric|min:1000',
            'nominal_infaq' => 'nullable|required_if:jenis_pembayaran,Infaq|numeric|min:1000',
            'nominal_seragam' => 'nullable|required_if:jenis_pembayaran,Seragam|numeric|min:1000',
            'nominal_kitab' => 'nullable|required_if:jenis_pembayaran,Kitab|numeric|min:1000',
            'nominal_kolektif' => 'nullable|required_if:jenis_pembayaran,Kolektif|numeric|min:1000',
            'tgl_bayar' => 'required|date',
            'status' => 'required|in:Cash,Transfer',
            'keterangan' => 'nullable|string|max:255',
            'petugas_id' => 'nullable|exists:petugas,id'
        ]);

        // Calculate total nominal
        $total = 0;
        foreach ($request->jenis_pembayaran as $jenis) {
            $total += $request->input('nominal_' . strtolower($jenis));
        }

        // Create payment record
        Pembayaran::create([
            'ppdb_id' => $ppdb_id,
            'petugas_id' => $request->petugas_id,
            'jenis_pembayaran' => implode(', ', array_map('trim', $request->jenis_pembayaran)),
            // 'jenis_pembayaran' => implode(',', $request->jenis_pembayaran),
            'nominal_spp' => $request->nominal_spp,
            'nominal_infaq' => $request->nominal_infaq,
            'nominal_seragam' => $request->nominal_seragam,
            'nominal_kitab' => $request->nominal_kitab,
            'nominal_kolektif' => $request->nominal_kolektif,
            'tgl_bayar' => $request->tgl_bayar,
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('pembayaran.index', $ppdb_id)
            ->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    // Menampilkan form edit pembayaran
    public function edit($ppdb_id, $pembayaran_id)
    {
        $pembayaran = Pembayaran::where('ppdb_id', $ppdb_id)->findOrFail($pembayaran_id);
        $selectedJenis = explode(',', $pembayaran->jenis_pembayaran);
        $petugas = Petugas::all();
        $ppdb = Ppdb::findOrFail($ppdb_id);
        return view('pembayaran.edit', compact('pembayaran', 'ppdb_id', 'selectedJenis', 'petugas'));
    }

    // Update data pembayaran
    public function update(Request $request, $ppdb_id, $pembayaran_id)
    {
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|array|min:1',
            'jenis_pembayaran.*' => 'in:SPP,Infaq,Seragam,Kitab,Kolektif',
            'nominal_spp' => 'nullable|required_if:jenis_pembayaran,SPP|numeric|min:1000',
            'nominal_infaq' => 'nullable|required_if:jenis_pembayaran,Infaq|numeric|min:1000',
            'nominal_seragam' => 'nullable|required_if:jenis_pembayaran,Seragam|numeric|min:1000',
            'nominal_kitab' => 'nullable|required_if:jenis_pembayaran,Kitab|numeric|min:1000',
            'nominal_kolektif' => 'nullable|required_if:jenis_pembayaran,Kolektif|numeric|min:1000',
            'tgl_bayar' => 'required|date',
            'status' => 'required|in:Cash,Transfer',
            'keterangan' => 'nullable|string|max:255',
            'petugas_id' => 'nullable|exists:petugas,id'
        ]);

        $pembayaran = Pembayaran::where('ppdb_id', $ppdb_id)
            ->findOrFail($pembayaran_id);

        $pembayaran->update([
            'jenis_pembayaran' => implode(',', $request->jenis_pembayaran),
            'nominal_spp' => $request->nominal_spp,
            'nominal_infaq' => $request->nominal_infaq,
            'nominal_seragam' => $request->nominal_seragam,
            'nominal_kitab' => $request->nominal_kitab,
            'nominal_kolektif' => $request->nominal_kolektif,
            'tgl_bayar' => $request->tgl_bayar,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'petugas_id' => $request->petugas_id
        ]);

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
    public function cetakKuitansi(Request $request, $ppdb_id, $pembayaran_id)
    {
        Carbon::setLocale('id');
        $pembayaran = Pembayaran::with(['ppdb', 'ppdb.tahunPelajaran', 'petugas'])
            ->where('ppdb_id', $ppdb_id)
            ->findOrFail($pembayaran_id);
        $jenis_pembayaran = [
            'Infaq' => $pembayaran->nominal_infaq,
            'Seragam' => $pembayaran->nominal_seragam,
            'Syahriyah' => $pembayaran->nominal_spp,
            'Kitab' => $pembayaran->nominal_kitab,
            'Kolektif' => $pembayaran->nominal_kolektif
        ];
        $total = $pembayaran->nominal_spp + $pembayaran->nominal_infaq
            + $pembayaran->nominal_seragam + $pembayaran->nominal_kitab + $pembayaran->nominal_kolektif;
        $data = [
            'pembayaran' => $pembayaran,
            'jenis_pembayaran' => $jenis_pembayaran,
            'total' => $total,
            'tanggal' => now()->translatedFormat('d F Y H:i:s'),
            'kode_transaksi' => 'INV-' . str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT),
            'tahun_pelajaran' => str_replace('/', '', $pembayaran->ppdb->tahunPelajaran->tahun),
            'petugas' => $pembayaran->petugas->nama ? $pembayaran->petugas->nama : 'Petugas Belum Dipilih'
        ];
        $pdf = Pdf::loadView('pembayaran.kuitansi', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true);
        if ($request->has('preview')) {
            return $pdf->stream('kuitansi-pembayaran.pdf');
        }
        if ($request->has('download')) {
            $filename = 'Kuitansi-' . $pembayaran->ppdb->nama_siswa . '-' . $pembayaran->id . '.pdf';
            return $pdf->download($filename);
        }
        return $pdf->stream('kuitansi-pembayaran.pdf');
    }
}
