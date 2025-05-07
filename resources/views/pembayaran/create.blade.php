@extends('layouts1.app')

@section('content')
<div class="container">
    <h2>Tambah Pembayaran Baru</h2>

    <form method="POST" action="{{ route('pembayaran.store', $ppdb->id) }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Detail Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Jenis Pembayaran</label>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="SPP"
                               class="form-check-input jenis-checkbox" id="spp">
                        <label class="form-check-label" for="spp">SPP</label>
                        <input type="number" name="nominal_spp" class="form-control mt-1 nominal-input"
                               placeholder="Nominal SPP" disabled>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Infaq"
                               class="form-check-input jenis-checkbox" id="infaq">
                        <label class="form-check-label" for="infaq">Infaq</label>
                        <input type="number" name="nominal_infaq" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Infaq" disabled>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Seragam"
                               class="form-check-input jenis-checkbox" id="seragam">
                        <label class="form-check-label" for="seragam">Seragam</label>
                        <input type="number" name="nominal_seragam" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Seragam" disabled>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="jenis_pembayaran[]" value="Kolektif"
                               class="form-check-input jenis-checkbox" id="kolektif">
                        <label class="form-check-label" for="kolektif">Kolektif</label>
                        <input type="number" name="nominal_kolektif" class="form-control mt-1 nominal-input"
                               placeholder="Nominal Kolektif" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Belum Lunas" selected>Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Pembayaran
        </button>
        <a href="{{ route('pembayaran.index', $ppdb->id) }}" class="btn btn-secondary">
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
