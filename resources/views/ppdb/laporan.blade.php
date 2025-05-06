@extends('layouts1.app')

@section('title', 'Laporan Penerimaan Peserta Didik')

@section('content')
    <div class="container mt-4">
        <!-- Card for Header -->
        <div class="card shadow mb-4">
            <div class="card-body text-center py-4">
                <h3 class="card-title font-weight-bold">LAPORAN PENERIMAAN PESERTA DIDIK BARU</h3>
                <h4 class="card-subtitle mb-2">MA DARUL FALAH SIRAHAN CLUWAK PATI</h4>
                <h5 class="text-muted">TAHUN PELAJARAN: {{ $tahunPelajaran }}</h5>
            </div>
        </div>

        <!-- Card for Summary -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <p class="mb-1">Naik Tingkat</p>
                            <h4 class="font-weight-bold">{{ $totalAlumni }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <p class="mb-1">Peserta Baru</p>
                            <h4 class="font-weight-bold">{{ $totalBaru }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-primary text-white">
                            <p class="mb-1">Total Semua</p>
                            <h4 class="font-weight-bold">{{ $totalSemua }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Laporan PPDB</h6>
                <div>
                    <a href="{{ url()->current() }}?preview=pdf" target="_blank" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-eye"></i> Preview PDF
                    </a>
                    <a href="{{ url()->current() }}?export=pdf" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Jenis</th>
                                <th>Asal Sekolah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $siswa)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $siswa->nisn }}</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                    <td>{{ $siswa->keterangan }}</td>
                                    <td>{{ $siswa->asal_sekolah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            border: none;
        }
        .table th {
            white-space: nowrap;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@endsection
