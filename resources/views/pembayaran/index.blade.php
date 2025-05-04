@extends('layouts1.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0" style="color: white">Daftar Pembayaran - {{ $ppdb->nama_siswa }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pembayaran.create', $ppdb->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    <a href="{{ route('ppdb.show', $ppdb->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ppdb->pembayarans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenis_pembayaran }}</td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td>
                                @if($item->tgl_bayar)
                                    {{ \Carbon\Carbon::parse($item->tgl_bayar)->translatedFormat('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Lunas' ? 'success' : 'danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('pembayaran.edit', [$ppdb->id, $item->id]) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pembayaran.destroy', [$ppdb->id, $item->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus pembayaran ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
