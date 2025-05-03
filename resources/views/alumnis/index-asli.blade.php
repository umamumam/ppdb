@extends('layouts1.app')

@section('title', 'Daftar Alumni')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Daftar Alumni</h4>
                    <a href="{{ route('alumnis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Alumni
                    </a>
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

                <div class="table-responsive">
                    <table id="res-config" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <th>Program</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnis as $alumni)
                            <tr>
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
                                <td>{{ $alumni->nis }}</td>
                                <td>{{ $alumni->nama_siswa }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $alumni->jeniskelamin == 'Laki-laki' ? 'primary' : 'secondary' }}">
                                        {{ $alumni->jeniskelamin }}
                                    </span>
                                </td>
                                <td>{{ $alumni->kelas }}</td>
                                <td>{{ $alumni->program }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('alumnis.show', $alumni->id) }}" class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('alumnis.edit', $alumni->id) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('alumnis.destroy', $alumni->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-button"
                                                data-id="{{ $alumni->id }}" data-bs-toggle="tooltip" title="Hapus">
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

                <div class="d-flex justify-content-center mt-3">
                    {{ $alumnis->links() }}
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
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Image preview in modal
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imgSrc = button.getAttribute('data-img');
        const imgTitle = button.getAttribute('data-title');

        const modalImg = document.getElementById('modalImage');
        const modalTitle = imageModal.querySelector('.modal-title');

        modalImg.src = imgSrc;
        modalTitle.textContent = 'Foto: ' + imgTitle;
    });
});
</script>

@endsection
