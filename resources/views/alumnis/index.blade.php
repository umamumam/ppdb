@extends('layouts1.app')

@section('title', 'Daftar Alumni')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Daftar Alumni</h4>
                    <div>
                        <a href="{{ route('alumnis.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Tambah Alumni
                        </a>
                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Import
                        </button>
                        <button type="button" class="btn btn-info" id="exportButton" disabled onclick="submitExportForm()">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        <button type="button" class="btn btn-danger" id="deleteAllButton" disabled onclick="confirmDeleteAll()">
                            <i class="fas fa-trash"></i> Hapus Semua
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
                <form id="exportForm" action="{{ route('alumnis.export') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="selected" id="selectedIds">
                </form>
                <form id="deleteAllForm" action="{{ route('alumnis.delete-all') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected" id="deleteSelectedIds">
                </form>
                <div class="table-responsive">
                    <table id="res-config" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th width="50px">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Foto</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat</th>
                                <th>Tgl. Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnis as $alumni)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected[]" value="{{ $alumni->id }}" class="export-checkbox">
                                </td>
                                <td>
                                    @if($alumni->foto)
                                    <img src="{{ asset('storage/' . $alumni->foto) }}"
                                        alt="Foto {{ $alumni->nama_siswa }}" class="img-thumbnail rounded-circle"
                                        width="50" height="50" style="cursor: pointer; object-fit: cover;"
                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-img="{{ asset('storage/' . $alumni->foto) }}"
                                        data-title="{{ $alumni->nama_siswa }}">
                                    @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>{{ $alumni->nisn }}</td>
                                <td>{{ $alumni->nama_siswa }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $alumni->jeniskelamin == 'Laki-laki' ? 'primary' : 'secondary' }}">
                                        {{ $alumni->jeniskelamin }}
                                    </span>
                                </td>
                                <td>{{ $alumni->tempat_lahir }}</td>
                                <td>{{ \Carbon\Carbon::parse($alumni->tgl_lahir)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- <a href="{{ route('alumnis.show', $alumni->id) }}" class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}
                                        {{-- <a href="{{ route('alumnis.edit', $alumni->id) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a> --}}
                                        <form action="{{ route('alumnis.destroy', $alumni->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-button"
                                                data-id="{{ $alumni->id }}" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
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
                <h5 class="modal-title" id="imageModalLabel">Foto Alumni</h5>
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
                <h5 class="modal-title">Import Data Alumni</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('alumnis.import') }}" enctype="multipart/form-data">
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
                    text: 'Data alumni ini akan dihapus permanen!',
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
                    text: 'Pilih setidaknya satu data alumni untuk diexport!',
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
<script>
    function updateSelectedCheckboxes() {
        const selected = Array.from(document.querySelectorAll('.export-checkbox:checked')).map(cb => cb.value);
        document.getElementById('deleteSelectedIds').value = JSON.stringify(selected);
        document.getElementById('selectedIds').value = JSON.stringify(selected);

        document.getElementById('deleteAllButton').disabled = selected.length === 0;
        document.getElementById('exportButton').disabled = selected.length === 0;
    }

    // Checkbox event listener
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.export-checkbox');
        checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedCheckboxes));

        document.getElementById('select-all').addEventListener('change', function () {
            const isChecked = this.checked;
            checkboxes.forEach(cb => cb.checked = isChecked);
            updateSelectedCheckboxes();
        });
    });

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus Semua?',
            text: 'Data alumni yang dipilih akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllForm').submit();
            }
        });
    }

    function submitExportForm() {
        document.getElementById('exportForm').submit();
    }
</script>

@endsection
