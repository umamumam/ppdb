@extends('layouts2.landing')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-black">
                    <h4 class="mb-0">
                        <i class="fas fa-search me-2"></i>Cari Data PPDB
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('ppdb.search') }}" method="GET">
                        <div class="mb-4">
                            <label for="nisn" class="form-label fw-bold">
                                <i class="fas fa-id-card me-1"></i> Masukkan NISN
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                                <input type="number" name="nisn" id="nisn" class="form-control form-control-lg" required
                                    value="{{ request('nisn') }}">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                            <small class="text-muted">Masukkan Nomor Induk Siswa Nasional (NISN) yang valid</small>
                        </div>
                    </form>

                    @if(request()->filled('nisn'))
                    @if($ppdb)
                    <div class="search-result mt-4">
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1">Data Ditemukan!</h5>
                                <p class="mb-0">Berikut hasil pencarian untuk NISN: <strong>{{ request('nisn')
                                        }}</strong></p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        @if($ppdb->foto)
                                        <img src="{{ asset('storage/' . $ppdb->foto) }}"
                                            class="img-thumbnail rounded-circle mb-3" width="120" height="120"
                                            alt="Foto Siswa">
                                        @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 120px; height: 120px; margin: 0 auto 1rem;">
                                            <i class="fas fa-user text-muted fa-3x"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <span class="mb-1"><i class="fas fa-user me-1"></i> Nama
                                                    Lengkap:</span>
                                                <p class="text-primary">{{ $ppdb->nama_siswa }}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="mb-1"><i class="fas fa-id-card me-1"></i>
                                                    NISN:</span>
                                                <p class="text-dark">{{ $ppdb->nisn }}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="mb-1"><i class="fas fa-file-alt me-1"></i> No.
                                                    Pendaftaran:</span>
                                                <p class="text-dark">{{ $ppdb->no_pendaftaran }}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="mb-1"><i class="fas fa-tag me-1"></i> Jenis
                                                    Pendaftar:</span><br>
                                                <span
                                                    class="badge bg-{{ $ppdb->jenis_pendaftar == 'baru' ? 'primary' : 'secondary' }}">
                                                    <i
                                                        class="fas fa-{{ $ppdb->jenis_pendaftar == 'baru' ? 'user-plus' : 'user-graduate' }} me-1"></i>
                                                    {{ $ppdb->jenis_pendaftar == 'alumni' ? 'Naik Tingkat' : 'Peserta
                                                    Baru' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="row g-2">
                                                <div class="col-12 col-sm-6 col-md-auto">
                                                    <a href="{{ route('ppdb.show', $ppdb->id) }}"
                                                        class="btn btn-primary w-100">
                                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                                    </a>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-auto">
                                                    <a href="{{ route('ppdb.cetak-bukti', $ppdb->id) }}"
                                                        class="btn btn-danger w-100">
                                                        <i class="fas fa-print me-1"></i> Cetak
                                                    </a>
                                                </div>
                                                {{--<div class="col-12 col-sm-6 col-md-auto">
                                                    <a href="{{ route('ppdb.edit', $ppdb->id) }}"
                                                        class="btn btn-outline-secondary w-100">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-danger mt-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1">Data Tidak Ditemukan</h5>
                                <p class="mb-0">Tidak ada data PPDB dengan NISN: <strong>{{ request('nisn') }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('ppdb.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Buat Baru
                            </a>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
    }

    .form-control-lg {
        height: calc(2.5rem + 2px);
        font-size: 1.1rem;
    }

    .search-result {
        transition: all 0.3s ease;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endsection
@endsection
