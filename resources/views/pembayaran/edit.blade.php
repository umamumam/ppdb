@extends('layouts1.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5>Edit Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembayaran.update', [$ppdb_id, $pembayaran->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                            <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="">Pilih Jenis</option>
                                <option value="SPP" {{ $pembayaran->jenis_pembayaran == 'SPP' ? 'selected' : '' }}>SPP
                                </option>
                                <option value="Infaq" {{ $pembayaran->jenis_pembayaran == 'Infaq' ? 'selected' : ''
                                    }}>Infaq</option>
                                <option value="Seragam" {{ $pembayaran->jenis_pembayaran == 'Seragam' ? 'selected' : ''
                                    }}>Seragam</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal"
                                value="{{ old('nominal', $pembayaran->nominal) }}" required min="1000">
                        </div>

                        <div class="mb-3">
                            <label for="tgl_bayar" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar"
                                value="{{ old('tgl_bayar', $pembayaran->tgl_bayar->format('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Lunas" {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>Lunas
                                </option>
                                <option value="Belum Lunas" {{ $pembayaran->status == 'Belum Lunas' ? 'selected' : ''
                                    }}>Belum Lunas</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"
                                rows="2">{{ old('keterangan', $pembayaran->keterangan) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pembayaran.index', $ppdb_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
