<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Ppdb;
use App\Models\Petugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendaftar = Ppdb::count();
        $naikTingkat = Ppdb::where('jenis_pendaftar', 'alumni')->count();
        $pesertaBaru = Ppdb::where('jenis_pendaftar', 'baru')->count();
        $totalAlumni = Alumni::count();
        $totalPetugas = Petugas::count();

        // Data untuk chart
        $chartData = [
            'naikTingkat' => [
                'Laki-laki' => Ppdb::where('jenis_pendaftar', 'alumni')
                    ->where('jeniskelamin', 'Laki-laki')
                    ->count(),
                'Perempuan' => Ppdb::where('jenis_pendaftar', 'alumni')
                    ->where('jeniskelamin', 'Perempuan')
                    ->count()
            ],
            'pesertaBaru' => [
                'Laki-laki' => Ppdb::where('jenis_pendaftar', 'baru')
                    ->where('jeniskelamin', 'Laki-laki')
                    ->count(),
                'Perempuan' => Ppdb::where('jenis_pendaftar', 'baru')
                    ->where('jeniskelamin', 'Perempuan')
                    ->count()
            ],
            'alumni' => [
                'Laki-laki' => Alumni::where('jeniskelamin', 'Laki-laki')->count(),
                'Perempuan' => Alumni::where('jeniskelamin', 'Perempuan')->count()
            ]
        ];

        return view('dashboard', compact(
            'totalPendaftar',
            'naikTingkat',
            'pesertaBaru',
            'totalAlumni',
            'totalPetugas',
            'chartData'
        ));
    }
}
