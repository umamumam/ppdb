@extends('layouts1.app')

@section('content')
<div class="container">
    <h2>Laporan Pembayaran</h2>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0" style="color: white">Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.pembayaran') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="all" {{ $status=='all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Lunas" {{ $status=='Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ $status=='Belum Lunas' ? 'selected' : '' }}>Belum Lunas
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Siswa (Opsional)</label>
                        <select name="ppdb_id" class="form-control">
                            <option value="">Semua Siswa</option>
                            @foreach($ppdbs as $ppdb)
                            <option value="{{ $ppdb->id }}" {{ $ppdbId==$ppdb->id ? 'selected' : '' }}>
                                {{ $ppdb->nama_siswa }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('laporan.pembayaran.cetak', request()->query()) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                        <a href="{{ route('pembayaran.export.excel', request()->all()) }}" class="btn btn-warning">Export Excel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Tgl. Transaksi</th>
                            <th>Nama Murid Baru</th>
                            <th>Uraian Transaksi</th>
                            <th>Bayar Syahriyah</th>
                            <th>Bayar Infaq</th>
                            <th>Bayar Seragam</th>
                            <th>Bayar Kitab</th>
                            <th>Bayar Kolektif</th>
                            <th>Total Bayar</th>
                            <th>Status Bayar</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayarans as $key => $pembayaran)
                        @php
                        $total = $pembayaran->nominal_spp + $pembayaran->nominal_infaq +
                        $pembayaran->nominal_seragam + $pembayaran->nominal_kitab +
                        $pembayaran->nominal_kolektif;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pembayaran->tgl_bayar->format('d/m/Y') }}</td>
                            <td>{{ $pembayaran->ppdb->nama_siswa }}</td>
                            <td>{{ $pembayaran->keterangan }}</td>
                            <td class="text-end">{{ number_format($pembayaran->nominal_spp, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($pembayaran->nominal_infaq, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($pembayaran->nominal_seragam, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($pembayaran->nominal_kitab, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($pembayaran->nominal_kolektif, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">{{ number_format($total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->status == 'Lunas' ? 'success' : 'warning' }}">
                                    {{ $pembayaran->status }}
                                </span>
                            </td>
                            <td>{{ $pembayaran->petugas->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <th colspan="4">TOTAL</th>
                            <th class="text-end">{{ number_format($pembayarans->sum('nominal_spp'), 0, ',', '.') }}</th>
                            <th class="text-end">{{ number_format($pembayarans->sum('nominal_infaq'), 0, ',', '.') }}
                            </th>
                            <th class="text-end">{{ number_format($pembayarans->sum('nominal_seragam'), 0, ',', '.') }}
                            </th>
                            <th class="text-end">{{ number_format($pembayarans->sum('nominal_kitab'), 0, ',', '.') }}
                            </th>
                            <th class="text-end">{{ number_format($pembayarans->sum('nominal_kolektif'), 0, ',', '.') }}
                            </th>
                            <th class="text-end">{{ number_format(
                                $pembayarans->sum('nominal_spp') +
                                $pembayarans->sum('nominal_infaq') +
                                $pembayarans->sum('nominal_seragam') +
                                $pembayarans->sum('nominal_kitab') +
                                $pembayarans->sum('nominal_kolektif'),
                                0, ',', '.') }}
                            </th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
