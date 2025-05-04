@extends('layouts1.app')

@section('title', 'Data Pendaftaran PPDB')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pendaftaran PPDB</h5>
        <a href="{{ route('ppdb.create') }}" class="btn btn-primary">Tambah Pendaftaran</a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
        @endif
        <div class="table-responsive">
            <table id="res-config" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>No Pendaftaran</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Pendaftar</th>
                        <th>Tahun Pelajaran</th>
                        <th>Program</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ppdbs as $key => $ppdb)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ppdb->no_pendaftaran }}</td>
                        <td>{{ $ppdb->nisn }}</td>
                        <td>{{ $ppdb->nama_siswa }}</td>
                        <td>
                            <span class="badge bg-{{ $ppdb->jenis_pendaftar == 'baru' ? 'primary' : 'secondary' }}">
                                {{ $ppdb->jenis_pendaftar }}
                            </span>
                        </td>
                        {{-- <td>{{ ucfirst($ppdb->jenis_pendaftar) }}</td> --}}
                        <td>{{ $ppdb->tahunPelajaran->tahun ?? '-' }}</td>
                        <td>{{ $ppdb->program ?? '-' }}</td>
                        <td>
                            <a href="{{ route('ppdb.show', $ppdb->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('ppdb.edit', $ppdb->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('ppdb.destroy', $ppdb->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
