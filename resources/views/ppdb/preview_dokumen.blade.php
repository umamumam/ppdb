@extends('layouts1.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dokumen PPDB: {{ $ppdb->nama_siswa }}</h2>

    <div class="card shadow">
        <div class="card-body">
            <!-- Tabel Preview Dokumen -->
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th width="30%">Jenis Dokumen</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- KK -->
                    <tr>
                        <td>Kartu Keluarga (KK)</td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->kk)
                            <span class="text-success">✓ Terupload</span>
                            @else
                            <span class="text-danger">× Belum diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->kk)
                            <a href="{{ asset('storage/' . $ppdb->dokumenSiswa->kk) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </a>
                            @else
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-upload"></i> Upload
                            </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Akte -->
                    <tr>
                        <td>Akte Kelahiran</td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->akte)
                            <span class="text-success">✓ Terupload</span>
                            @else
                            <span class="text-danger">× Belum diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->akte)
                            <a href="{{ asset('storage/' . $ppdb->dokumenSiswa->akte) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </a>
                            @else
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-upload"></i> Upload
                            </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Surat Keterangan Lulus -->
                    <tr>
                        <td>Surat Keterangan Lulus (SKL)</td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->surat_keterangan_lulus)
                            <span class="text-success">✓ Terupload</span>
                            @else
                            <span class="text-danger">× Belum diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->surat_keterangan_lulus)
                            <a href="{{ asset('storage/' . $ppdb->dokumenSiswa->surat_keterangan_lulus) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </a>
                            @else
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-upload"></i> Upload
                            </a>
                            @endif
                        </td>
                    </tr>

                    <!-- KIP -->
                    <tr>
                        <td>Kartu Indonesia Pintar (KIP)</td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->kip)
                            <span class="text-success">✓ Terupload</span>
                            @else
                            <span class="text-danger">× Belum diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($ppdb->dokumenSiswa && $ppdb->dokumenSiswa->kip)
                            <a href="{{ asset('storage/' . $ppdb->dokumenSiswa->kip) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </a>
                            @else
                            <a href="{{ route('ppdb.upload-dokumen', $ppdb->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-upload"></i> Upload
                            </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('ppdb.show', $ppdb->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Profil PPDB
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus dokumen ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(docType, ppdbId) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus dokumen ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/ppdb/${ppdbId}/delete-dokumen/${docType}`;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<style>
    .table th {
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
</style>
@endpush
