@extends('layouts1.app')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran</h2>
    <a href="{{ route('pembayaran.create', $ppdb->id) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Pembayaran
    </a>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Pembayaran</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ppdb->pembayarans as $pembayaran)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->translatedFormat('d F Y') }}</td>
                            <td>
                                @foreach(explode(',', $pembayaran->jenis_pembayaran) as $jenis)
                                <span class="badge bg-primary me-1">{{ $jenis }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($pembayaran->nominal_spp)
                                SPP: Rp {{ number_format($pembayaran->nominal_spp) }}<br>
                                @endif
                                @if($pembayaran->nominal_infaq)
                                Infaq: Rp {{ number_format($pembayaran->nominal_infaq) }}<br>
                                @endif
                                @if($pembayaran->nominal_seragam)
                                Seragam: Rp {{ number_format($pembayaran->nominal_seragam) }}<br>
                                @endif
                                @if($pembayaran->nominal_kolektif)
                                Kolektif: Rp {{ number_format($pembayaran->nominal_kolektif) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->status == 'Lunas' ? 'success' : 'warning' }}">
                                    {{ $pembayaran->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pembayaran.edit', [$ppdb->id, $pembayaran->id]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('pembayaran.cetak', ['ppdb_id' => $ppdb->id, 'pembayaran_id' => $pembayaran->id, 'preview' => true]) }}"
                                    class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Cetak
                                </a>
                                {{-- <a href="{{ route('pembayaran.cetak', ['ppdb_id' => $ppdb->id, 'pembayaran_id' => $pembayaran->id, 'download' => true]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> PDF
                                </a> --}}
                                <form action="{{ route('pembayaran.destroy', [$ppdb->id, $pembayaran->id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus data ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
