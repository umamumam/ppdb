@extends('layouts1.app')

@section('title', 'Import Data Alumni')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Import Data Alumni</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Petunjuk:</strong>
                <ul>
                    <li>Download template import terlebih dahulu</li>
                    <li>Isi data sesuai dengan kolom yang tersedia</li>
                    <li>Pastikan format tanggal: YYYY-MM-DD</li>
                    <li>Untuk field enum, gunakan nilai yang sesuai (lihat dropdown di form)</li>
                    <li>Ukuran file maksimal 2MB</li>
                </ul>
            </div>

            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('alumnis.template') }}" class="btn btn-success">
                    <i class="fas fa-download me-1"></i> Download Template
                </a>
                <a href="{{ route('alumnis.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('alumnis.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">File Excel</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-1"></i> Import Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
