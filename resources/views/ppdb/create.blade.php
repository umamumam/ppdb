@extends('layouts2.landing')

@section('content')
<div class="container">
    <h1>Sistim Penerimaan Murid Baru</h1>

    <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Jenis Pendaftar Selection -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Pilih Jenis Layanan</h5>
            </div>
            <div class="card-body">
                <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
                <div class="row" id="selectable-row">
                    <!-- Kolom 1 - Siswa Baru -->
                    <div class="col-md-3 mb-4">
                        <div class="card option-card h-100" id="option-baru"
                            style="cursor: pointer; border-left: 4px solid #3490dc;" onclick="hideParentRow(this)">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper mb-3">
                                    <i class="fas fa-user-plus fa-3x text-primary"></i>
                                </div>
                                <h3 class="card-title">Murid Baru</h3>
                                <p class="text-muted mb-0">Klik untuk memilih</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-success"><i class="fas fa-info-circle"></i> Untuk calon siswa
                                    baru</small>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2 - Alumni MTs -->
                    <div class="col-md-3 mb-4">
                        <div class="card option-card h-100" id="option-alumni"
                            style="cursor: pointer; border-left: 4px solid #38c172;" onclick="hideParentRow(this)">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper mb-3">
                                    <i class="fas fa-user-graduate fa-3x text-success"></i>
                                </div>
                                <h3 class="card-title">Naik Tingkat</h3>
                                <p class="text-muted mb-0">Klik untuk memilih</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-primary"><i class="fas fa-info-circle"></i> Untuk alumni MTs
                                    DAFA</small>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 3 - Informasi -->
                    <div class="col-md-3 mb-4">
                        <a href="/ppdb/search" class="text-decoration-none">
                            <div class="card h-100 bg-light" style="cursor: pointer; transition: all 0.3s ease;">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-center mb-3">
                                        <i class="fas fa-file-alt text-primary me-2"></i>Bukti Pendaftaran
                                    </h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-search text-info me-2"></i> Cari bukti pendaftaran</li>
                                        <li class="mb-2"><i class="fas fa-download text-info me-2"></i> Unduh bukti pendaftaran</li>
                                        <li class="mb-2"><i class="fas fa-print text-info me-2"></i> Cetak bukti pendaftaran</li>
                                    </ul>
                                    <div class="alert alert-primary mt-3">
                                        <small><i class="fas fa-external-link-alt me-2"></i> Klik untuk mencari bukti pendaftaran</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Kolom 4 - Informasi -->
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 bg-light">
                            <div class="card-body p-4">
                                <h4 class="card-title text-center mb-3"><i
                                        class="fas fa-info-circle text-info me-2"></i>Informasi</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Pilih jenis
                                        pendaftaran</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Isi data
                                        dengan benar</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Upload
                                        dokumen lengkap</li>
                                </ul>
                                <div class="alert alert-info mt-3">
                                    <small><i class="fas fa-exclamation-circle me-2"></i> Pastikan data yang dimasukkan
                                        valid</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function hideParentRow(element) {
                            const row = document.getElementById('selectable-row');
                            row.style.transition = "opacity 0.3s ease";
                            row.style.opacity = "0";
                            setTimeout(function() {
                                row.style.display = "none";
                            }, 300);
                        }
                </script>
                <input type="hidden" name="jenis_pendaftar" id="jenis_pendaftar" value="">

                <!-- NISN Field for New Students -->
                <div id="nisn-baru-field" class="form-group mt-4" style="display: none;">
                    <label for="nisn_baru" class="fw-bold"><i class="fas fa-id-card me-2"></i>NISN (Nomor Induk Siswa
                        Nasional) *</label>
                    <input type="text" name="nisn" id="nisn_baru" class="form-control" placeholder="Masukkan NISN">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Wajib diisi untuk siswa
                        baru</small>
                </div>

                <!-- NISN Field for Alumni -->
                <div id="alumni-field" class="form-group mt-4" style="display: none;">
                    <label for="nisn_alumni" class="fw-bold"><i class="fas fa-id-card me-2"></i>NISN (Nomor Induk Siswa
                        Nasional) *</label>
                    <div class="input-group">
                        <input type="text" name="nisn" id="nisn_alumni" class="form-control"
                            placeholder="Masukkan NISN Alumni">
                        <button type="button" id="cari-alumni" class="btn btn-secondary">
                            <i class="fas fa-search me-1"></i>Cari Data
                        </button>
                    </div>
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Wajib diisi untuk alumni</small>
                </div>
                <div class="form-group mt-4">
                    <label for="no_pendaftaran" class="fw-bold"><i class="fas fa-file-alt me-2"></i>No.
                        Pendaftaran</label>
                    <input type="text" class="form-control bg-light" value="Akan digenerate otomatis" readonly>
                </div>

                <input type="hidden" name="tahun_pelajaran_id" value="{{ $tahunPelajaran->id }}">
            </div>

            <style>
                .option-card {
                    transition: all 0.3s ease;
                    border-radius: 8px;
                }

                .option-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                }

                .option-card.selected {
                    background-color: #f8f9fa;
                    border-left: 4px solid #ffc107 !important;
                }

                .icon-wrapper {
                    background-color: rgba(52, 144, 220, 0.1);
                    width: 80px;
                    height: 80px;
                    margin: 0 auto;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                #option-alumni .icon-wrapper {
                    background-color: rgba(56, 193, 114, 0.1);
                }
            </style>
        </div>

        <!-- All other form sections - initially hidden -->
        <div id="form-sections" style="display: none;">
            <!-- Informasi Pribadi -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Data Identitas Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri -->

                        {{-- <div class="col-md-4 mb-2">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis">
                        </div> --}}
                        <div class="col-md-6 mb-2">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="nik_siswa" class="form-label">NIK Siswa</label>
                            <input type="text" class="form-control" id="nik_siswa" name="nik_siswa">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="anak_ke" class="form-label">Anak Ke</label>
                            <input type="number" class="form-control" id="anak_ke" name="anak_ke" min="1">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="hp_siswa">No. HP Siswa</label>
                            <input type="text" name="hp_siswa" id="hp_siswa" class="form-control">
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <label for="kelas">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control">
                        </div> --}}
                        <div class="col-md-8 mb-2">
                            <label for="program">Program / Peminatan</label>
                            <select name="program" id="program" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Keagamaan">Keagamaan</option>
                                <option value="MIPA">MIPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="foto" class="form-label">Foto Siswa</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <small class="text-muted">Format: JPG/PNG, Maksimal 2MB</small>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
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
                            <input type="text" name="no_kk" id="no_kk" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="hp_ortu">No. HP Orang Tua</label>
                            <input type="text" name="hp_ortu" id="hp_ortu" class="form-control">
                        </div>
                        <h6>Data Ayah</h6>
                        <div class="col-md-6 mb-2">
                            <label for="nik_ayah">NIK Ayah</label>
                            <input type="text" name="nik_ayah" id="nik_ayah" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="nama_ayah">Nama Ayah</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="pendidikan_ayah">Pendidikan Ayah</label>
                            <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="SD/MI">SD/MI</option>
                                <option value="SMP/MTS">SMP/MTS</option>
                                <option value="SMA/MA">SMA/MA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control">
                        </div>

                        <h6>Data Ibu</h6>
                        <div class="col-md-6 mb-2">
                            <label for="nik_ibu">NIK Ibu</label>
                            <input type="text" name="nik_ibu" id="nik_ibu" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="pendidikan_ibu">Pendidikan Ibu</label>
                            <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="SD/MI">SD/MI</option>
                                <option value="SMP/MTS">SMP/MTS</option>
                                <option value="SMA/MA">SMA/MA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control">
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
                            <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="npsn">NPSN</label>
                            <input type="text" name="npsn" id="npsn" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="nsm">NSM</label>
                            <input type="text" name="nsm" id="nsm" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="alamat_sekolah">Alamat Sekolah</label>
                            <input type="text" name="alamat_sekolah" id="alamat_sekolah" class="form-control">
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
                            <input type="text" name="no_kip" id="no_kip" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="no_kks">No. KKS</label>
                            <input type="text" name="no_kks" id="no_kks" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="no_pkh">No. PKH</label>
                            <input type="text" name="no_pkh" id="no_pkh" class="form-control">
                        </div>
                        <hr>
                        <div class="form-group mt-4">
                            <label for="petugas_id">Petugas Pendaftar</label>
                            <select name="petugas_id" id="petugas_id" class="form-control">
                                <option value="">-- Pilih Petugas Pendaftar --</option>
                                @foreach ($petugas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            {{-- <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Diisi oleh petugas</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            document.getElementById('nisn-baru-field').style.display = 'none';
            document.getElementById('alumni-field').style.display = 'none';
            document.getElementById('nisn_baru').required = false;
            document.getElementById('nisn_alumni').required = false;
        } else if (option === 'alumni') {
            document.getElementById('nisn-baru-field').style.display = 'none';
            document.getElementById('alumni-field').style.display = 'block';
            document.getElementById('nisn_baru').required = false;
            document.getElementById('nisn_alumni').required = true;
        }

        // Show the rest of the form
        document.getElementById('form-sections').style.display = 'block';
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
</script>
@endsection
