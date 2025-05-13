@extends('layouts1.app')

@section('title', 'Data Pendaftaran PPDB')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <h4 class="card-title mb-0">Data Pendaftaran PPDB</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('ppdb.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pendaftaran
                        </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Import
                        </button>
                        <button type="button" class="btn btn-info" id="exportButton" disabled
                            onclick="submitExportForm()">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                    </div>
                </div>
                <hr>
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
                <form id="exportForm" action="{{ route('ppdb.export') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="selected" id="selectedIds">
                </form>
                <div class="table-responsive">
                    <table id="res-config" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th width="50px">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Foto</th>
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
                            @foreach ($ppdbs as $ppdb)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected[]" value="{{ $ppdb->id }}"
                                        class="export-checkbox">
                                </td>
                                <td>
                                    @if($ppdb->foto)
                                    <img src="{{ asset('storage/' . $ppdb->foto) }}" alt="Foto {{ $ppdb->nama_siswa }}"
                                        class="img-thumbnail rounded-circle" width="50" height="50"
                                        style="cursor: pointer; object-fit: cover;" data-bs-toggle="modal"
                                        data-bs-target="#imageModal" data-img="{{ asset('storage/' . $ppdb->foto) }}"
                                        data-title="{{ $ppdb->nama_siswa }}">
                                    @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>{{ $ppdb->no_pendaftaran }}</td>
                                <td>{{ $ppdb->nisn }}</td>
                                <td>{{ $ppdb->nama_siswa }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $ppdb->jenis_pendaftar == 'baru' ? 'primary' : 'secondary' }}">
                                        {{ $ppdb->jenis_pendaftar == 'baru' ? 'Murid Baru' : 'Naik Tingkat' }}
                                    </span>
                                </td>
                                <td>{{ $ppdb->tahunPelajaran->tahun ?? '-' }}</td>
                                <td>{{ $ppdb->program ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('ppdb.show', $ppdb->id) }}" class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ppdb.preview-dokumen', $ppdb->id) }}"
                                            class="btn btn-secondary btn-sm" data-bs-toggle="tooltip"
                                            title="Lihat Dokumen">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <a href="{{ route('pembayaran.index', $ppdb->id) }}"
                                            class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                            title="Kelola Pembayaran">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </a>
                                        <a href="{{ route('ppdb.cetak', $ppdb->id) }}" class="btn btn-warning btn-sm"
                                            data-bs-toggle="tooltip" title="Cetak Kartu" target="_blank">
                                            <i class="fas fa-id-card"></i>
                                        </a>
                                        <a href="{{ route('ppdb.cetak-surat', $ppdb->id) }}"
                                            class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            title="Cetak Surat Pendaftaran" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <a href="{{ route('ppdb.edit', $ppdb->id) }}" class="btn btn-primary btn-sm"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('ppdb.destroy', $ppdb->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-button"
                                                data-id="{{ $ppdb->id }}" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="imageModalLabel">Foto Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Import Data PPDB</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('ppdb.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel (.xlsx, .csv):</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // SweetAlert delete confirmation
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data pendaftaran ini akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Image preview in modal
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const imgSrc = button.getAttribute('data-img');
                const imgTitle = button.getAttribute('data-title');

                const modalImg = document.getElementById('modalImage');
                const modalTitle = imageModal.querySelector('.modal-title');

                modalImg.src = imgSrc;
                modalTitle.textContent = 'Foto: ' + imgTitle;
            });
        }

        // Select all checkboxes
        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.export-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateExportButton();
            });
        }

        // Update export button state when checkboxes change
        document.querySelectorAll('.export-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateExportButton);
        });

        function updateExportButton() {
            const checkedBoxes = document.querySelectorAll('.export-checkbox:checked');
            const exportButton = document.getElementById('exportButton');

            if (exportButton) {
                exportButton.disabled = checkedBoxes.length === 0;
            }
        }

        window.submitExportForm = function() {
            const checkedBoxes = document.querySelectorAll('.export-checkbox:checked');
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih setidaknya satu data pendaftaran untuk diexport!',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Pastikan form dan input tersedia
            const exportForm = document.getElementById('exportForm');
            const selectedIdsInput = document.getElementById('selectedIds');

            if (exportForm && selectedIdsInput) {
                selectedIdsInput.value = JSON.stringify(selectedIds);
                exportForm.submit();
            } else {
                console.error('Form export tidak ditemukan!');
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Form export tidak tersedia',
                    confirmButtonColor: '#3085d6'
                });
            }
        };
    });
</script>

@endsection
