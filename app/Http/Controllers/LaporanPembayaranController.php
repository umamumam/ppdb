<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ppdb;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPembayaranExport;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'all');
        $ppdbId = $request->input('ppdb_id');

        $query = Pembayaran::with(['ppdb', 'petugas'])
            ->whereBetween('tgl_bayar', [$startDate, $endDate])
            ->orderBy('tgl_bayar', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($ppdbId) {
            $query->where('ppdb_id', $ppdbId);
        }

        $pembayarans = $query->get();
        $ppdbs = Ppdb::all();

        return view('laporan.pembayaran.index', compact(
            'pembayarans',
            'ppdbs',
            'startDate',
            'endDate',
            'status',
            'ppdbId'
        ));
    }

    public function cetak(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status', 'all');
        $ppdbId = $request->input('ppdb_id');

        $query = Pembayaran::with(['ppdb', 'petugas'])
            ->whereBetween('tgl_bayar', [$startDate, $endDate])
            ->orderBy('tgl_bayar', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($ppdbId) {
            $query->where('ppdb_id', $ppdbId);
        }

        $pembayarans = $query->get();

        // Hitung total per jenis pembayaran
        $totalSpp = $pembayarans->sum('nominal_spp');
        $totalInfaq = $pembayarans->sum('nominal_infaq');
        $totalSeragam = $pembayarans->sum('nominal_seragam');
        $totalKitab = $pembayarans->sum('nominal_kitab');
        $totalKolektif = $pembayarans->sum('nominal_kolektif');
        $totalAll = $totalSpp + $totalInfaq + $totalSeragam + $totalKitab + $totalKolektif;

        $data = [
            'pembayarans' => $pembayarans,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalSpp' => $totalSpp,
            'totalInfaq' => $totalInfaq,
            'totalSeragam' => $totalSeragam,
            'totalKitab' => $totalKitab,
            'totalKolektif' => $totalKolektif,
            'totalAll' => $totalAll,
        ];

        $pdf = Pdf::loadView('laporan.pembayaran.cetak', $data)
            ->setPaper([0, 0, 595.28, 935.43], 'landscape');

        return $pdf->stream('laporan-pembayaran.pdf');
    }
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'all');
        $ppdbId = $request->input('ppdb_id');

        $query = Pembayaran::with(['ppdb', 'petugas'])
            ->whereBetween('tgl_bayar', [$startDate, $endDate])
            ->orderBy('tgl_bayar', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($ppdbId) {
            $query->where('ppdb_id', $ppdbId);
        }

        $pembayarans = $query->get();

        $totalSpp = $pembayarans->sum('nominal_spp');
        $totalInfaq = $pembayarans->sum('nominal_infaq');
        $totalSeragam = $pembayarans->sum('nominal_seragam');
        $totalKitab = $pembayarans->sum('nominal_kitab');
        $totalKolektif = $pembayarans->sum('nominal_kolektif');
        $totalAll = $totalSpp + $totalInfaq + $totalSeragam + $totalKitab + $totalKolektif;

        $data = [
            'pembayarans' => $pembayarans,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalSpp' => $totalSpp,
            'totalInfaq' => $totalInfaq,
            'totalSeragam' => $totalSeragam,
            'totalKitab' => $totalKitab,
            'totalKolektif' => $totalKolektif,
            'totalAll' => $totalAll,
        ];

        return Excel::download(new LaporanPembayaranExport($data), 'laporan-pembayaran.xlsx');
    }
}
