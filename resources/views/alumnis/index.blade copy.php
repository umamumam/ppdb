@extends('layouts1.app')

@section('content')
<div class="container">
    <h1>Data Alumni</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Import File Alumni</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('alumnis.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="file">Pilih File Excel (.xlsx, .xls, .csv):</label>
                            <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-file-import me-1"></i> Import Data
                        </button>
                        <a href="{{ asset('templates/template_import_alumni.xlsx') }}" class="btn btn-success ms-2">
                            <i class="fas fa-download me-1"></i> Download Template
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Alumni MTs Darul Falah</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('alumnis.export') }}" id="exportForm">
                @csrf
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <a href="{{ route('alumnis.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Alumni
                        </a>
                    </div>
                    <div>
                        <button type="button" id="selectAllBtn" class="btn btn-secondary me-2">
                            <i class="fas fa-check-square me-1"></i> Pilih Semua
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-export me-1"></i> Export Yang Dipilih
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="alumniTable" class="table table-striped table-hover dt-responsive nowrap" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Program</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alumnis as $alumni)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected[]" value="{{ $alumni->id }}" class="row-checkbox">
                                    </td>
                                    <td>{{ $alumni->nama_siswa }}</td>
                                    <td>{{ $alumni->nis }}</td>
                                    <td>{{ $alumni->nisn }}</td>
                                    <td>
                                        <span class="badge bg-{{ $alumni->program == 'MIPA' ? 'info' : ($alumni->program == 'IPS' ? 'success' : 'warning') }}">
                                            {{ $alumni->program }}
                                        </span>
                                    </td>
                                    <td>{{ $alumni->kelas }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('alumnis.show', $alumni->id) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('alumnis.edit', $alumni->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('alumnis.destroy', $alumni->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data alumni</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @if($alumnis->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $alumnis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all functionality
        const selectAll = document.getElementById('selectAll');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const checkboxes = document.querySelectorAll('.row-checkbox');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        selectAllBtn.addEventListener('click', function() {
            selectAll.checked = !selectAll.checked;
            const event = new Event('change');
            selectAll.dispatchEvent(event);
        });

        // Check if any checkbox is checked when submitting export form
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu alumni untuk diexport');
            }
        });

        // Initialize DataTable
        $('#alumniTable').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>

<style>
    .table-responsive {
        overflow-x: auto;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5em;
    }
</style>

@endsection
