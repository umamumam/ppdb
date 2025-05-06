@extends('layouts2.landing')

@section('content')
<div class="container">
    <h1>Edit Data PPDB</h1>

    <form action="{{ route('ppdb.update', $ppdb->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Jenis Pendaftar Selection -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Jenis Pendaftar</h5>
            </div>
            <div class="card-body">
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card option-card {{ $ppdb->jenis_pendaftar == 'baru' ? 'selected' : '' }}" id="option-baru" style="cursor: pointer;">
                            <div class="card-body text-center">
                                <h5>Siswa Baru</h5>
                                <p>Klik untuk memilih</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card option-card {{ $ppdb->jenis_pendaftar == 'alumni' ? 'selected' : '' }}" id="option-alumni" style="cursor: pointer;">
                            <div class="card-body text-center">
                                <h5>Alumni</h5>
                                <p>Klik untuk memilih</p>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <input type="hidden" name="jenis_pendaftar" id="jenis_pendaftar" value="{{ $ppdb->jenis_pendaftar }}">

                <!-- NISN Field for New Students -->
                <div id="nisn-baru-field" class="form-group" style="display: {{ $ppdb->jenis_pendaftar == 'baru' ? 'block' : 'none' }};">
                    <label for="nisn_baru">NISN (Nomor Induk Siswa Nasional) *</label>
                    <input type="text" name="nisn" id="nisn_baru" class="form-control" placeholder="Masukkan NISN"
                           value="{{ $ppdb->jenis_pendaftar == 'baru' ? $ppdb->nisn : '' }}"
                           {{ $ppdb->jenis_pendaftar == 'baru' ? 'required' : '' }}>
                    <small class="text-muted">Wajib diisi untuk siswa baru</small>
                </div>

                <!-- NISN Field for Alumni -->
                <div id="alumni-field" class="form-group" style="display: {{ $ppdb->jenis_pendaftar == 'alumni' ? 'block' : 'none' }};">
                    <label for="nisn_alumni">NISN Alumni</label>
                    <input type="text" name="nisn" id="nisn_alumni" class="form-control" placeholder="Masukkan NISN Alumni"
                           value="{{ $ppdb->jenis_pendaftar == 'alumni' ? $ppdb->nisn : '' }}"
                           {{ $ppdb->jenis_pendaftar == 'alumni' ? 'required' : '' }}>
                    <button type="button" id="cari-alumni" class="btn btn-secondary mt-2">Cari Data Alumni</button>
                </div>
                <div class="form-group mt-4">
                    <label for="petugas_id" class="fw-bold"><i class="fas fa-user-tie me-2"></i>Petugas</label>
                    <select name="petugas_id" id="petugas_id" class="form-control">
                        <option value="">-- Pilih Petugas --</option>
                        @foreach ($petugas as $item)
                            <option value="{{ $item->id }}" {{ $ppdb->petugas_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Diisi oleh petugas</small>
                </div>
                <div class="form-group mt-3">
                    <label for="no_pendaftaran">No. Pendaftaran</label>
                    <input type="text" class="form-control" value="{{ $ppdb->no_pendaftaran }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tahun_pelajaran_id">Tahun Pelajaran</label>
                    <select name="tahun_pelajaran_id" id="tahun_pelajaran_id" class="form-control">
                        @foreach($tahunPelajaran as $tp)
                            <option value="{{ $tp->id }}" {{ $ppdb->tahun_pelajaran_id == $tp->id ? 'selected' : '' }}>
                                {{ $tp->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- All other form sections -->
        <div id="form-sections">
            <!-- Informasi Pribadi -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Pribadi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control"
                               value="{{ $ppdb->nama_siswa }}" required>
                    </div>

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" value="{{ $ppdb->nis }}">
                    </div>
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" class="form-control" value="{{ $ppdb->nisn }}">
                    </div>
                    <div class="form-group">
                        <label for="nik_siswa">NIK Siswa</label>
                        <input type="text" name="nik_siswa" id="nik_siswa" class="form-control"
                               value="{{ $ppdb->nik_siswa }}">
                    </div>

                    <div class="form-group">
                        <label for="jeniskelamin">Jenis Kelamin</label>
                        <select name="jeniskelamin" id="jeniskelamin" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $ppdb->jeniskelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $ppdb->jeniskelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                               value="{{ $ppdb->tempat_lahir }}">
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"
                               value="{{ $ppdb->tgl_lahir }}">
                    </div>

                    <div class="form-group">
                        <label for="anak_ke">Anak Ke</label>
                        <input type="number" name="anak_ke" id="anak_ke" class="form-control" min="1"
                               value="{{ $ppdb->anak_ke }}">
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Siswa</label>
                        @if($ppdb->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $ppdb->foto) }}" alt="Foto Siswa" style="max-width: 200px;">
                                <br>
                                <a href="#" id="remove-foto" class="text-danger">Hapus Foto</a>
                                <input type="hidden" name="remove_foto" id="remove-foto-input" value="0">
                            </div>
                        @endif
                        <input type="file" name="foto" id="foto" class="form-control-file">
                        <small class="text-muted">Format: JPG/PNG, Maksimal 2MB</small>
                    </div>
                </div>
            </div>

            <!-- Informasi Keluarga -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Keluarga</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="no_kk">Nomor KK</label>
                        <input type="text" name="no_kk" id="no_kk" class="form-control" value="{{ $ppdb->no_kk }}">
                    </div>

                    <h6>Data Ayah</h6>
                    <div class="form-group">
                        <label for="nik_ayah">NIK Ayah</label>
                        <input type="text" name="nik_ayah" id="nik_ayah" class="form-control"
                               value="{{ $ppdb->nik_ayah }}">
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control"
                               value="{{ $ppdb->nama_ayah }}">
                    </div>

                    <div class="form-group">
                        <label for="pendidikan_ayah">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/MI" {{ $ppdb->pendidikan_ayah == 'SD/MI' ? 'selected' : '' }}>SD/MI</option>
                            <option value="SMP/MTS" {{ $ppdb->pendidikan_ayah == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS</option>
                            <option value="SMA/MA" {{ $ppdb->pendidikan_ayah == 'SMA/MA' ? 'selected' : '' }}>SMA/MA</option>
                            <option value="D3" {{ $ppdb->pendidikan_ayah == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ $ppdb->pendidikan_ayah == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ $ppdb->pendidikan_ayah == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ $ppdb->pendidikan_ayah == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control"
                               value="{{ $ppdb->pekerjaan_ayah }}">
                    </div>

                    <h6>Data Ibu</h6>
                    <div class="form-group">
                        <label for="nik_ibu">NIK Ibu</label>
                        <input type="text" name="nik_ibu" id="nik_ibu" class="form-control"
                               value="{{ $ppdb->nik_ibu }}">
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control"
                               value="{{ $ppdb->nama_ibu }}">
                    </div>

                    <div class="form-group">
                        <label for="pendidikan_ibu">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/MI" {{ $ppdb->pendidikan_ibu == 'SD/MI' ? 'selected' : '' }}>SD/MI</option>
                            <option value="SMP/MTS" {{ $ppdb->pendidikan_ibu == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS</option>
                            <option value="SMA/MA" {{ $ppdb->pendidikan_ibu == 'SMA/MA' ? 'selected' : '' }}>SMA/MA</option>
                            <option value="D3" {{ $ppdb->pendidikan_ibu == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ $ppdb->pendidikan_ibu == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ $ppdb->pendidikan_ibu == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ $ppdb->pendidikan_ibu == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control"
                               value="{{ $ppdb->pekerjaan_ibu }}">
                    </div>

                    <div class="form-group">
                        <label for="hp_ortu">No. HP Orang Tua</label>
                        <input type="text" name="hp_ortu" id="hp_ortu" class="form-control"
                               value="{{ $ppdb->hp_ortu }}">
                    </div>
                </div>
            </div>

            <!-- Informasi Alamat -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Alamat</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ $ppdb->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control"
                               value="{{ $ppdb->kode_pos }}">
                    </div>

                    <div class="form-group">
                        <label for="hp_siswa">No. HP Siswa</label>
                        <input type="text" name="hp_siswa" id="hp_siswa" class="form-control"
                               value="{{ $ppdb->hp_siswa }}">
                    </div>
                </div>
            </div>

            <!-- Informasi Sekolah -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $ppdb->kelas }}">
                    </div>

                    <div class="form-group">
                        <label for="program">Program</label>
                        <select name="program" id="program" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Keagamaan" {{ $ppdb->program == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                            <option value="MIPA" {{ $ppdb->program == 'MIPA' ? 'selected' : '' }}>MIPA</option>
                            <option value="IPS" {{ $ppdb->program == 'IPS' ? 'selected' : '' }}>IPS</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="asal_sekolah">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control"
                               value="{{ $ppdb->asal_sekolah }}">
                    </div>

                    <div class="form-group">
                        <label for="npsn">NPSN</label>
                        <input type="text" name="npsn" id="npsn" class="form-control" value="{{ $ppdb->npsn }}">
                    </div>

                    <div class="form-group">
                        <label for="nsm">NSM</label>
                        <input type="text" name="nsm" id="nsm" class="form-control" value="{{ $ppdb->nsm }}">
                    </div>

                    <div class="form-group">
                        <label for="alamat_sekolah">Alamat Sekolah</label>
                        <input type="text" name="alamat_sekolah" id="alamat_sekolah" class="form-control"
                               value="{{ $ppdb->alamat_sekolah }}">
                    </div>
                </div>
            </div>

            <!-- Informasi Bantuan -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Bantuan</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="no_kip">No. KIP</label>
                        <input type="text" name="no_kip" id="no_kip" class="form-control" value="{{ $ppdb->no_kip }}">
                    </div>

                    <div class="form-group">
                        <label for="no_kks">No. KKS</label>
                        <input type="text" name="no_kks" id="no_kks" class="form-control" value="{{ $ppdb->no_kks }}">
                    </div>

                    <div class="form-group">
                        <label for="no_pkh">No. PKH</label>
                        <input type="text" name="no_pkh" id="no_pkh" class="form-control" value="{{ $ppdb->no_pkh }}">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-lg">Update Data</button>
                <a href="{{ route('ppdb.index') }}" class="btn btn-secondary btn-lg ml-2">Kembali</a>
            </div>
        </div>
    </form>
</div>

<style>
    .option-card {
        transition: all 0.3s ease;
    }
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .option-card.selected {
        background-color: #e9f7fe;
        border: 2px solid #3490dc;
    }
</style>

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
@endsection
