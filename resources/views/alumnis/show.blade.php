@extends('layouts1.app')

@section('title', 'Detail Alumni')

@section('content')
<div class="container mt-4">
    {{-- <h3 class="mb-4">Detail Alumni</h3> --}}

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">Data Alumni</h3>
                <div>
                    <a href="{{ route('alumnis.edit', $alumni->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{ route('alumnis.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar</a>
                    <form action="{{ route('alumnis.destroy', $alumni->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($alumni->foto)
                    <img src="{{ asset('storage/' . $alumni->foto) }}" alt="Foto Alumni" class="img-fluid rounded mb-3"
                        style="max-height: 200px;">
                    @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3"
                        style="height: 200px; width: 200px;">
                        <span class="text-muted">No Photo</span>
                    </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Siswa</h5>
                            <hr>
                            <p><strong>NIS:</strong> {{ $alumni->nis ?? '-' }}</p>
                            <p><strong>NISN:</strong> {{ $alumni->nisn ?? '-' }}</p>
                            <p><strong>NIK:</strong> {{ $alumni->nik_siswa ?? '-' }}</p>
                            <p><strong>Nama:</strong> {{ $alumni->nama_siswa }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $alumni->jeniskelamin ?? '-' }}</p>
                            <p><strong>Tempat/Tgl Lahir:</strong> {{ $alumni->tempat_lahir ?? '-' }}, {{
                                $alumni->tgl_lahir ? $alumni->tgl_lahir->format('d/m/Y') : '-' }}</p>
                            <p><strong>Kelas:</strong> {{ $alumni->kelas ?? '-' }}</p>
                            <p><strong>Program:</strong> {{ $alumni->program ?? '-' }}</p>
                            <p><strong>Anak Ke:</strong> {{ $alumni->anak_ke ?? '-' }}</p>
                            <p><strong>No KK:</strong> {{ $alumni->no_kk ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Kontak</h5>
                            <hr>
                            <p><strong>HP Siswa:</strong> {{ $alumni->hp_siswa ?? '-' }}</p>
                            <p><strong>HP Orang Tua:</strong> {{ $alumni->hp_ortu ?? '-' }}</p>
                            <p><strong>Alamat:</strong> {{ $alumni->alamat ?? '-' }}</p>
                            <p><strong>Kode Pos:</strong> {{ $alumni->kode_pos ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5>Data Ayah</h5>
                    <p><strong>NIK Ayah:</strong> {{ $alumni->nik_ayah ?? '-' }}</p>
                    <p><strong>Nama Ayah:</strong> {{ $alumni->nama_ayah ?? '-' }}</p>
                    <p><strong>Pendidikan:</strong> {{ $alumni->pendidikan_ayah ?? '-' }}</p>
                    <p><strong>Pekerjaan:</strong> {{ $alumni->pekerjaan_ayah ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Data Ibu</h5>
                    <p><strong>NIK Ibu:</strong> {{ $alumni->nik_ibu ?? '-' }}</p>
                    <p><strong>Nama Ibu:</strong> {{ $alumni->nama_ibu ?? '-' }}</p>
                    <p><strong>Pendidikan:</strong> {{ $alumni->pendidikan_ibu ?? '-' }}</p>
                    <p><strong>Pekerjaan:</strong> {{ $alumni->pekerjaan_ibu ?? '-' }}</p>
                </div>
            </div>

            <hr>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5>Data Sekolah</h5>
                    <p><strong>Asal Sekolah:</strong> {{ $alumni->asal_sekolah ?? '-' }}</p>
                    <p><strong>NPSN:</strong> {{ $alumni->npsn ?? '-' }}</p>
                    <p><strong>NSM:</strong> {{ $alumni->nsm ?? '-' }}</p>
                    <p><strong>Alamat Sekolah:</strong> {{ $alumni->alamat_sekolah ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Data Bantuan</h5>
                    <p><strong>No KIP:</strong> {{ $alumni->no_kip ?? '-' }}</p>
                    <p><strong>No KKS:</strong> {{ $alumni->no_kks ?? '-' }}</p>
                    <p><strong>No PKH:</strong> {{ $alumni->no_pkh ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
