<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nisn',
        'nik_siswa',
        'nama_siswa',
        'foto',
        'jeniskelamin',
        'tempat_lahir',
        'tgl_lahir',
        'kelas',
        'program',
        'anak_ke',
        'no_kk',
        'nik_ayah',
        'nama_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'nik_ibu',
        'nama_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'hp_siswa',
        'hp_ortu',
        'alamat',
        'kode_pos',
        'asal_sekolah',
        'npsn',
        'nsm',
        'alamat_sekolah',
        'no_kip',
        'no_kks',
        'no_pkh',
        'jenis_pendaftar',
        'no_pendaftaran',
        'tahun_pelajaran_id'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function generateNoPendaftaran()
    {
        $tahunAjaran = $this->tahunPelajaran->tahun;
        $tahunParts = explode('/', $tahunAjaran);
        $tahun = substr($tahunParts[0], -2);
        $lastNumber = Ppdb::where('tahun_pelajaran_id', $this->tahun_pelajaran_id)
            ->orderBy('no_pendaftaran', 'desc')
            ->first();
        $nextNumber = $lastNumber ? (int)substr($lastNumber->no_pendaftaran, 2) + 1 : 1;

        return $tahun . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
    public function dokumenSiswa()
    {
        return $this->hasOne(DokumenSiswa::class);
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
