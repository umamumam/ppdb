@extends('layouts1.app')

@section('content')
<div class="container">
    <h2>Edit Pembayaran</h2>

    <form method="POST" action="{{ route('pembayaran.update', [$ppdb_id, $pembayaran->id]) }}">
        @csrf
        @method('PUT')

        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Detail Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Jenis Pembayaran</label>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="SPP"
                               class="form-check-input jenis-checkbox" id="spp"
                               {{ in_array('SPP', $selectedJenis) ? 'checked' : '' }}>
                        <label class="form-check-label" for="spp">SPP</label>
                        <input type="number" name="nominal_spp" class="form-control mt-1 nominal-input"
                               placeholder="Nominal SPP"
                               value="{{ $pembayaran->nominal_spp }}"
                               {{ in_array('SPP', $selectedJenis) ? '' : 'disabled' }}>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Infaq"
                               class="form-check-input jenis-checkbox" id="infaq"
                               {{ in_array('Infaq', $selectedJenis) ? 'checked' : '' }}>
                        <label class="form-check-label" for="infaq">Infaq</label>
                        <input type="number" name="nominal_infaq" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Infaq"
                               value="{{ $pembayaran->nominal_infaq }}"
                               {{ in_array('Infaq', $selectedJenis) ? '' : 'disabled' }}>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Seragam"
                               class="form-check-input jenis-checkbox" id="seragam"
                               {{ in_array('Seragam', $selectedJenis) ? 'checked' : '' }}>
                        <label class="form-check-label" for="seragam">Seragam</label>
                        <input type="number" name="nominal_seragam" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Seragam"
                               value="{{ $pembayaran->nominal_seragam }}"
                               {{ in_array('Seragam', $selectedJenis) ? '' : 'disabled' }}>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Kolektif"
                               class="form-check-input jenis-checkbox" id="kolektif"
                               {{ in_array('Kolektif', $selectedJenis) ? 'checked' : '' }}>
                        <label class="form-check-label" for="kolektif">Kolektif</label>
                        <input type="number" name="nominal_kolektif" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Kolektif"
                               value="{{ $pembayaran->nominal_kolektif }}"
                               {{ in_array('Kolektif', $selectedJenis) ? '' : 'disabled' }}>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control"
                               value="{{ $pembayaran->tgl_bayar->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Belum Lunas" {{ $pembayaran->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Lunas" {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ $pembayaran->keterangan }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Pembayaran
        </button>
        <a href="{{ route('pembayaran.index', $ppdb_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aktifkan input nominal saat checkbox dipilih
    document.querySelectorAll('.jenis-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const nominalInput = this.closest('.form-check').querySelector('.nominal-input');
            nominalInput.disabled = !this.checked;
            nominalInput.required = this.checked;
            if (!this.checked) {
                nominalInput.value = '';
            }
        });
    });
});
</script>
@endsection
