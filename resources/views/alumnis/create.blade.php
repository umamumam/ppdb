@extends('layouts1.app')

@section('title', 'Tambah Alumni')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Alumni</h1>

    <form action="{{ route('alumnis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card p-3 mb-4">
            <div class="row">
                <h5>Identitas Siswa</h5>
                <hr>
                <div class="col-md-4 mb-2">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="nik_siswa" class="form-label">NIK Siswa</label>
                    <input type="text" class="form-control" id="nik_siswa" name="nik_siswa">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="nama_siswa" class="form-label">Nama Siswa *</label>
                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jeniskelamin" name="jeniskelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="anak_ke" class="form-label">Anak Ke-</label>
                    <input type="number" class="form-control" id="anak_ke" name="anak_ke">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="no_kk" class="form-label">Nomor KK</label>
                    <input type="text" class="form-control" id="no_kk" name="no_kk">
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
                    <label for="hp_siswa" class="form-label">HP Siswa</label>
                    <input type="text" class="form-control" id="hp_siswa" name="hp_siswa">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="program" class="form-label">Program</label>
                    <select class="form-select" id="program" name="program">
                        <option value="">Pilih Program</option>
                        <option value="Keagamaan">Keagamaan</option>
                        <option value="MIPA">MIPA</option>
                        <option value="IPS">IPS</option>
                    </select>
                </div>
                <div class="col-md-8 mb-2">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="kode_pos" class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                </div>
                <div class="mb-2">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                </div>
            </div>
        </div>

        <div class="card p-3 mb-4">
            <div class="row">
                <h5>Data Orang Tua</h5>
                <div class="col-md-6 mb-2">
                    <label for="nik_ayah" class="form-label">NIK Ayah</label>
                    <input type="text" class="form-control" id="nik_ayah" name="nik_ayah">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                    <select class="form-select" id="pendidikan_ayah" name="pendidikan_ayah">
                        <option value="">Pilih Pendidikan</option>
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
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="nik_ibu" class="form-label">NIK Ibu</label>
                    <input type="text" class="form-control" id="nik_ibu" name="nik_ibu">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                    <select class="form-select" id="pendidikan_ibu" name="pendidikan_ibu">
                        <option value="">Pilih Pendidikan</option>
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
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu">
                </div>
            </div>
            <div class="col-md-12 mb-2">
                <label for="hp_ortu" class="form-label">HP Orang Tua</label>
                <input type="text" class="form-control" id="hp_ortu" name="hp_ortu">
            </div>
        </div>
</div>

<div class="card p-3 mb-4">
    <div class="row">
        <h5>Data Sekolah Asal</h5>
        <div class="col-md-4 mb-2">
            <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
            <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah">
        </div>
        <div class="col-md-4 mb-2">
            <label for="npsn" class="form-label">NPSN</label>
            <input type="text" class="form-control" id="npsn" name="npsn">
        </div>
        <div class="col-md-4 mb-2">
            <label for="nsm" class="form-label">NSM</label>
            <input type="text" class="form-control" id="nsm" name="nsm">
        </div>
        <div class="mb-2">
            <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
            <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" rows="2"></textarea>
        </div>
    </div>
</div>
<div class="card p-3 mb-4">
    <div class="row">
        <h5>Data Bantuan Sosial</h5>
        <div class="col-md-4 mb-2">
            <label for="no_kip" class="form-label">No KIP</label>
            <input type="text" class="form-control" id="no_kip" name="no_kip">
        </div>
        <div class="col-md-4 mb-2">
            <label for="no_kks" class="form-label">No KKS</label>
            <input type="text" class="form-control" id="no_kks" name="no_kks">
        </div>
        <div class="col-md-4 mb-2">
            <label for="no_pkh" class="form-label">No PKH</label>
            <input type="text" class="form-control" id="no_pkh" name="no_pkh">
        </div>
    </div>
</div>


<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('alumnis.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
@endsection
