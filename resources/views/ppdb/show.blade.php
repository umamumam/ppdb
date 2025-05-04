@extends('layouts2.landing')

@section('title', 'Detail Pendaftaran PPDB')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <h5 class="mb-0">Detail Pendaftaran PPDB</h5>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-info btn-sm">
                    <i class="bi bi-file-earmark-arrow-up"></i> Upload Berkas
                </a>
                <a href="{{ route('ppdb.edit', $ppdb->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('ppdb.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-4">
                <!-- Foto Profil -->
                <div class="text-center mb-4">
                    @if($ppdb->foto)
                    <img src="{{ asset('storage/' . $ppdb->foto) }}" alt="Foto Siswa"
                        class="img-thumbnail rounded-circle mb-2"
                        style="width: 180px; height: 180px; object-fit: cover; border: 3px solid #3490dc;">
                    @else
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 180px; height: 180px; margin: 0 auto; border: 3px dashed #ccc;">
                        <i class="bi bi-person-fill" style="font-size: 3rem; color: #6c757d;"></i>
                    </div>
                    @endif
                    <h4 class="mt-3">{{ $ppdb->nama_siswa }}</h4><br>
                    <span class="badge bg-{{ $ppdb->jenis_pendaftar == 'alumni' ? 'success' : 'primary' }} fs-6">
                        {{ $ppdb->jenis_pendaftar == 'alumni' ? 'Naik Tingkat' : 'Peserta Baru' }}
                    </span>
                </div>

                <!-- Informasi Singkat -->
                <div>
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Singkat</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-card-text me-2 text-primary"></i>
                                <strong>No. Pendaftaran:</strong> {{ $ppdb->no_pendaftaran }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-calendar me-2 text-primary"></i>
                                <strong>Tahun Ajaran:</strong> {{ $ppdb->tahunPelajaran->tahun ?? '-' }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-book me-2 text-primary"></i>
                                <strong>Program:</strong> {{ $ppdb->program ?? '-' }}
                            </li>
                            <li>
                                <i class="bi bi-telephone me-2 text-primary"></i>
                                <strong>No. HP:</strong> {{ $ppdb->hp_siswa ?? '-' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-8">
                <!-- Data Pribadi -->
                <div>
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Data Pribadi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-123 me-2"></i>NISN</label>
                                    <div class="form-control bg-light">{{ $ppdb->nisn ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-credit-card me-2"></i>NIK</label>
                                    <div class="form-control bg-light">{{ $ppdb->nik_siswa ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i>Jenis
                                        Kelamin</label>
                                    <div class="form-control bg-light">{{ $ppdb->jeniskelamin }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-calendar-date me-2"></i>TTL</label>
                                    <div class="form-control bg-light">
                                        {{ $ppdb->tempat_lahir }}, {{ $ppdb->tgl_lahir ?
                                        $ppdb->tgl_lahir->format('d-m-Y') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-geo-alt me-2"></i>Alamat</label>
                            <div class="form-control bg-light" style="min-height: 80px;">{{ $ppdb->alamat }}</div>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div>
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-people-fill me-2"></i>Data Orang Tua</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Ayah</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <div class="form-control bg-light">{{ $ppdb->nama_ayah }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <div class="form-control bg-light">{{ $ppdb->pendidikan_ayah }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <div class="form-control bg-light">{{ $ppdb->pekerjaan_ayah }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2">Ibu</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <div class="form-control bg-light">{{ $ppdb->nama_ibu }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <div class="form-control bg-light">{{ $ppdb->pendidikan_ibu }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <div class="form-control bg-light">{{ $ppdb->pekerjaan_ibu }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-telephone me-2"></i>No. HP Orang Tua</label>
                            <div class="form-control bg-light">{{ $ppdb->hp_ortu ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Asal Sekolah -->
                <div>
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-building me-2"></i>Asal Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <div class="form-control bg-light">{{ $ppdb->asal_sekolah ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NPSN</label>
                                    <div class="form-control bg-light">{{ $ppdb->npsn ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Sekolah</label>
                            <div class="form-control bg-light">{{ $ppdb->alamat_sekolah ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control.bg-light {
        border: none;
        background-color: #f8f9fa !important;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .card-header.bg-light {
        background-color: #f8f9fa !important;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
</style>
@endsection
