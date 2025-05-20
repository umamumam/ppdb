@extends('layouts2.landing')

@section('content')
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1>Edit Data Pendaftaran Murid Baru</h1>

    <form action="{{ route('ppdb.update', $ppdb->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Jenis Pendaftar Selection -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="no_pendaftaran" class="fw-bold"><i class="fas fa-file-alt me-2"></i>No.
                            Pendaftaran</label>
                        <input type="text" class="form-control" value="{{ $ppdb->no_pendaftaran }}" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tgl_daftar" class="fw-bold"><i class="fas fa-calendar-alt me-2"></i>Tanggal
                            Pendaftaran</label>
                        <input type="text" class="form-control" value="{{ $ppdb->created_at->format('d/m/Y') }}"
                            readonly>
                    </div>
                </div>
                <input type="hidden" name="tahun_pelajaran_id" value="{{ $ppdb->tahun_pelajaran_id }}">
                <input type="hidden" name="jenis_pendaftar" value="{{ $ppdb->jenis_pendaftar }}">
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Identitas Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $ppdb->nisn }}"
                            maxlength="10" oninput="validateNISN()">
                        <div class="invalid-feedback">
                            NISN harus terdiri dari 10 karakter.
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik_siswa" class="form-label">NIK Siswa</label>
                        <input type="text" class="form-control" id="nik_siswa" name="nik_siswa"
                            value="{{ $ppdb->nik_siswa }}" maxlength="16" oninput="validateNIKSiswa()">
                        <div class="invalid-feedback">
                            NIK Siswa harus terdiri dari 16 karakter.
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required
                            value="{{ $ppdb->nama_siswa }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $ppdb->jeniskelamin == 'Laki-laki' ? 'selected' : ''
                                }}>Laki-laki</option>
                            <option value="Perempuan" {{ $ppdb->jeniskelamin == 'Perempuan' ? 'selected' : ''
                                }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="anak_ke" class="form-label">Anak Ke</label>
                        <input type="number" class="form-control" id="anak_ke" name="anak_ke" min="1"
                            value="{{ $ppdb->anak_ke }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ $ppdb->tempat_lahir }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                            value="{{ \Carbon\Carbon::parse($ppdb->tgl_lahir)->format('Y-m-d') }}">
                        {{-- <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                            value="{{ $ppdb->tgl_lahir }}"> --}}
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="hp_siswa">No. HP Siswa</label>
                        <input type="text" name="hp_siswa" id="hp_siswa" class="form-control"
                            value="{{ $ppdb->hp_siswa }}">
                    </div>
                    <div class="col-md-8 mb-2">
                        <label for="program">Program / Peminatan</label>
                        <select name="program" id="program" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Keagamaan" {{ $ppdb->program == 'Keagamaan' ? 'selected' : '' }}>Keagamaan
                            </option>
                            <option value="MIPA" {{ $ppdb->program == 'MIPA' ? 'selected' : '' }}>MIPA</option>
                            <option value="IPS" {{ $ppdb->program == 'IPS' ? 'selected' : '' }}>IPS</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control"
                            value="{{ $ppdb->kode_pos }}">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="foto" class="form-label">Foto Siswa</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                        @if($ppdb->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $ppdb->foto) }}" alt="Foto Siswa" style="max-width: 100px;">
                            <small class="d-block">Foto saat ini</small>
                        </div>
                        @endif
                        <small class="text-muted">Format: JPG/PNG, Maksimal 2MB</small>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ $ppdb->alamat }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Keluarga -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Orang Tua</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="no_kk">Nomor KK</label>
                        <input type="text" name="no_kk" id="no_kk" class="form-control" value="{{ $ppdb->no_kk }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="hp_ortu">No. HP Orang Tua</label>
                        <input type="text" name="hp_ortu" id="hp_ortu" class="form-control"
                            value="{{ $ppdb->hp_ortu }}">
                    </div>

                    <h6>Data Ayah</h6>
                    <div class="col-md-6 mb-2">
                        <label for="nik_ayah">NIK Ayah</label>
                        <input type="text" name="nik_ayah" id="nik_ayah" class="form-control"
                            value="{{ $ppdb->nik_ayah }}" maxlength="16" oninput="validateNIKAyah()">
                        <div class="invalid-feedback">
                            NIK Ayah harus terdiri dari 16 karakter.
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control"
                            value="{{ $ppdb->nama_ayah }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pendidikan_ayah">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/MI" {{ $ppdb->pendidikan_ayah == 'SD/MI' ? 'selected' : '' }}>SD/MI
                            </option>
                            <option value="SMP/MTS" {{ $ppdb->pendidikan_ayah == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS
                            </option>
                            <option value="SMA/MA" {{ $ppdb->pendidikan_ayah == 'SMA/MA' ? 'selected' : '' }}>SMA/MA
                            </option>
                            <option value="D3" {{ $ppdb->pendidikan_ayah == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ $ppdb->pendidikan_ayah == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ $ppdb->pendidikan_ayah == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ $ppdb->pendidikan_ayah == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control"
                            value="{{ $ppdb->pekerjaan_ayah }}">
                    </div>

                    <h6>Data Ibu</h6>
                    <div class="col-md-6 mb-2">
                        <label for="nik_ibu">NIK Ibu</label>
                        <input type="text" name="nik_ibu" id="nik_ibu" class="form-control" value="{{ $ppdb->nik_ibu }}"
                            maxlength="16" oninput="validateNIKIbu()">
                        <div class="invalid-feedback">
                            NIK Ibu harus terdiri dari 16 karakter.
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control"
                            value="{{ $ppdb->nama_ibu }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pendidikan_ibu">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/MI" {{ $ppdb->pendidikan_ibu == 'SD/MI' ? 'selected' : '' }}>SD/MI
                            </option>
                            <option value="SMP/MTS" {{ $ppdb->pendidikan_ibu == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS
                            </option>
                            <option value="SMA/MA" {{ $ppdb->pendidikan_ibu == 'SMA/MA' ? 'selected' : '' }}>SMA/MA
                            </option>
                            <option value="D3" {{ $ppdb->pendidikan_ibu == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ $ppdb->pendidikan_ibu == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ $ppdb->pendidikan_ibu == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ $ppdb->pendidikan_ibu == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control"
                            value="{{ $ppdb->pekerjaan_ibu }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Sekolah -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Sekolah Asal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="asal_sekolah">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control"
                            value="{{ $ppdb->asal_sekolah }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="npsn">NPSN</label>
                        <input type="text" name="npsn" id="npsn" class="form-control" value="{{ $ppdb->npsn }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nsm">NSM</label>
                        <input type="text" name="nsm" id="nsm" class="form-control" value="{{ $ppdb->nsm }}">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="alamat_sekolah">Alamat Sekolah</label>
                        <input type="text" name="alamat_sekolah" id="alamat_sekolah" class="form-control"
                            value="{{ $ppdb->alamat_sekolah }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Bantuan -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Data Bantuan Sosial</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="no_kip">No. KIP</label>
                        <input type="text" name="no_kip" id="no_kip" class="form-control" value="{{ $ppdb->no_kip }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="no_kks">No. KKS</label>
                        <input type="text" name="no_kks" id="no_kks" class="form-control" value="{{ $ppdb->no_kks }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="no_pkh">No. PKH</label>
                        <input type="text" name="no_pkh" id="no_pkh" class="form-control" value="{{ $ppdb->no_pkh }}">
                    </div>
                    <hr>
                    <div class="form-group mt-4">
                        <label for="petugas_id">Petugas Pendaftar</label>
                        <select name="petugas_id" id="petugas_id" class="form-control">
                            <option value="">-- Pilih Petugas Pendaftar --</option>
                            @foreach ($petugas as $item)
                            <option value="{{ $item->id }}" {{ $ppdb->petugas_id == $item->id ? 'selected' : '' }}>{{
                                $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">Update Data</button>
            <a href="{{ route('ppdb.index') }}" class="btn btn-secondary btn-lg ml-2">Kembali</a>
            <a href="{{ route('ppdb.cetak-bukti', $ppdb->id) }}" class="btn btn-success btn-lg ml-2" target="_blank">
                <i class="fas fa-print"></i> Cetak Bukti
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    });
</script>
<script>
    function validateNISN() {
        const nisnInput = document.getElementById('nisn');
        if (nisnInput.value.length === 10) {
            nisnInput.classList.remove('is-invalid');
        } else {
            nisnInput.classList.add('is-invalid');
        }
    }
    window.addEventListener('DOMContentLoaded', validateNISN);
    function validateNIKSiswa() {
        const nikInput = document.getElementById('nik_siswa');
        if (nikInput.value.length === 16) {
            nikInput.classList.remove('is-invalid');
        } else {
            nikInput.classList.add('is-invalid');
        }
    }
    window.addEventListener('DOMContentLoaded', validateNIKSiswa);
    function validateNIKAyah() {
        const input = document.getElementById('nik_ayah');
        if (input.value.length === 16) {
            input.classList.remove('is-invalid');
        } else {
            input.classList.add('is-invalid');
        }
    }
    window.addEventListener('DOMContentLoaded', validateNIKAyah);
    function validateNIKIbu() {
        const input = document.getElementById('nik_ibu');
        if (input.value.length === 16) {
            input.classList.remove('is-invalid');
        } else {
            input.classList.add('is-invalid');
        }
    }

    window.addEventListener('DOMContentLoaded', validateNIKIbu);
</script>
@endsection
{{--
<script>
    // Handle option selection
    document.getElementById('option-baru').addEventListener('click', function() {
        selectOption('baru');
    });

    document.getElementById('option-alumni').addEventListener('click', function() {
        selectOption('alumni');
    });

    function selectOption(option) {
        // Reset all options
        document.querySelectorAll('.option-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Highlight selected option
        document.getElementById('option-' + option).classList.add('selected');

        // Set hidden field value
        document.getElementById('jenis_pendaftar').value = option;

        // Show appropriate NISN field
        if (option === 'baru') {
            document.getElementById('nisn-baru-field').style.display = 'block';
            document.getElementById('alumni-field').style.display = 'none';
            document.getElementById('nisn_baru').required = true;
            document.getElementById('nisn_alumni').required = false;
        } else if (option === 'alumni') {
            document.getElementById('nisn-baru-field').style.display = 'none';
            document.getElementById('alumni-field').style.display = 'block';
            document.getElementById('nisn_baru').required = false;
            document.getElementById('nisn_alumni').required = true;
        }
    }

    // Alumni search functionality
    document.getElementById('cari-alumni').addEventListener('click', function () {
        const nisn = document.getElementById('nisn_alumni').value;

        if (!nisn) {
            alert('Silakan masukkan NISN');
            return;
        }

        fetch(`/get-alumni-data?nisn=${nisn}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Data alumni tidak ditemukan');
                }
                return response.json();
            })
            .then(data => {
                // Data Pribadi
                document.getElementById('nama_siswa').value = data.nama_siswa || '';
                document.getElementById('nis').value = data.nis || '';
                document.getElementById('nisn').value = data.nisn || '';
                document.getElementById('nik_siswa').value = data.nik_siswa || '';
                document.getElementById('jeniskelamin').value = data.jeniskelamin || '';
                document.getElementById('tempat_lahir').value = data.tempat_lahir || '';
                document.getElementById('tgl_lahir').value = data.tgl_lahir || '';
                document.getElementById('anak_ke').value = data.anak_ke || '';

                // Data Keluarga
                document.getElementById('no_kk').value = data.no_kk || '';
                document.getElementById('nik_ayah').value = data.nik_ayah || '';
                document.getElementById('nama_ayah').value = data.nama_ayah || '';
                document.getElementById('pendidikan_ayah').value = data.pendidikan_ayah || '';
                document.getElementById('pekerjaan_ayah').value = data.pekerjaan_ayah || '';
                document.getElementById('nik_ibu').value = data.nik_ibu || '';
                document.getElementById('nama_ibu').value = data.nama_ibu || '';
                document.getElementById('pendidikan_ibu').value = data.pendidikan_ibu || '';
                document.getElementById('pekerjaan_ibu').value = data.pekerjaan_ibu || '';
                document.getElementById('hp_ortu').value = data.hp_ortu || '';

                // Data Alamat
                document.getElementById('alamat').value = data.alamat || '';
                document.getElementById('kode_pos').value = data.kode_pos || '';
                document.getElementById('hp_siswa').value = data.hp_siswa || '';

                // Data Sekolah
                document.getElementById('kelas').value = data.kelas || '';
                document.getElementById('program').value = data.program || '';
                document.getElementById('asal_sekolah').value = data.asal_sekolah || '';
                document.getElementById('npsn').value = data.npsn || '';
                document.getElementById('nsm').value = data.nsm || '';
                document.getElementById('alamat_sekolah').value = data.alamat_sekolah || '';

                // Data Bantuan
                document.getElementById('no_kip').value = data.no_kip || '';
                document.getElementById('no_kks').value = data.no_kks || '';
                document.getElementById('no_pkh').value = data.no_pkh || '';

                alert('Data alumni berhasil dimuat');
            })
            .catch(error => {
                alert(error.message);
            });
    });

    // Handle photo removal
    document.getElementById('remove-foto')?.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentElement.querySelector('img').style.display = 'none';
        this.style.display = 'none';
        document.getElementById('remove-foto-input').value = '1';
    });
</script>
@endsection --}}
