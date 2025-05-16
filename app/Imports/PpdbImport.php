<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Ppdb;
use App\Models\TahunPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PpdbImport implements ToModel, WithHeadingRow
{
    protected $tahunPelajaranId;

    public function __construct($tahunPelajaranId = null)
    {
        $this->tahunPelajaranId = $tahunPelajaranId ?? 1; // Default tahun pelajaran
    }

    public function model(array $row)
    {
        // Cek apakah data sudah ada berdasarkan no_pendaftaran
        $existingData = Ppdb::where('no_pendaftaran', $row['no_pendaftaran'] ?? null)->first();

        // Jika ada, update data yang ada
        if ($existingData) {
            $existingData->update([
                'nis' => $row['nis'] ?? null,
                'nisn' => $row['nisn'] ?? null,
                'nik_siswa' => $row['nik_siswa'] ?? null,
                'nama_siswa' => $row['nama_siswa'] ?? null,
                'jeniskelamin' => $row['jeniskelamin'] ?? null,
                'tempat_lahir' => $row['tempat_lahir'] ?? null,
                'tgl_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
                'kelas' => $row['kelas'] ?? null,
                'program' => $row['program'] ?? null,
                'anak_ke' => $row['anak_ke'] ?? null,
                'no_kk' => $row['no_kk'] ?? null,
                'nik_ayah' => $row['nik_ayah'] ?? null,
                'nama_ayah' => $row['nama_ayah'] ?? null,
                'pendidikan_ayah' => $row['pendidikan_ayah'] ?? null,
                'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
                'nik_ibu' => $row['nik_ibu'] ?? null,
                'nama_ibu' => $row['nama_ibu'] ?? null,
                'pendidikan_ibu' => $row['pendidikan_ibu'] ?? null,
                'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
                'hp_siswa' => $row['hp_siswa'] ?? null,
                'hp_ortu' => $row['hp_orang_tua'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'kode_pos' => $row['kode_pos'] ?? null,
                'asal_sekolah' => $row['asal_sekolah'] ?? null,
                'npsn' => $row['npsn'] ?? null,
                'nsm' => $row['nsm'] ?? null,
                'alamat_sekolah' => $row['alamat_sekolah'] ?? null,
                'no_kip' => $row['no_kip'] ?? null,
                'no_kks' => $row['no_kks'] ?? null,
                'no_pkh' => $row['no_pkh'] ?? null,
                'jenis_pendaftar' => $row['jenis_pendaftar'] ?? 'baru',
                'tahun_pelajaran_id' => $row['tahun_pelajaran_id'] ?? $this->tahunPelajaranId
            ]);

            return null; // Karena kita melakukan update, return null untuk skip pembuatan baru
        }

        // Jika tidak ada, buat data baru
        return new Ppdb([
            'no_pendaftaran' => $row['no_pendaftaran'] ?? $this->generateNoPendaftaran($row['tahun_pelajaran_id'] ?? $this->tahunPelajaranId),
            'nis' => $row['nis'] ?? null,
            'nisn' => $row['nisn'] ?? null,
            'nik_siswa' => $row['nik_siswa'] ?? null,
            'nama_siswa' => $row['nama_siswa'] ?? null,
            'jeniskelamin' => $row['jeniskelamin'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tgl_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
            'kelas' => $row['kelas'] ?? null,
            'program' => $row['program'] ?? null,
            'anak_ke' => $row['anak_ke'] ?? null,
            'no_kk' => $row['no_kk'] ?? null,
            'nik_ayah' => $row['nik_ayah'] ?? null,
            'nama_ayah' => $row['nama_ayah'] ?? null,
            'pendidikan_ayah' => $row['pendidikan_ayah'] ?? null,
            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
            'nik_ibu' => $row['nik_ibu'] ?? null,
            'nama_ibu' => $row['nama_ibu'] ?? null,
            'pendidikan_ibu' => $row['pendidikan_ibu'] ?? null,
            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
            'hp_siswa' => $row['hp_siswa'] ?? null,
            'hp_ortu' => $row['hp_orang_tua'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'kode_pos' => $row['kode_pos'] ?? null,
            'asal_sekolah' => $row['asal_sekolah'] ?? null,
            'npsn' => $row['npsn'] ?? null,
            'nsm' => $row['nsm'] ?? null,
            'alamat_sekolah' => $row['alamat_sekolah'] ?? null,
            'no_kip' => $row['no_kip'] ?? null,
            'no_kks' => $row['no_kks'] ?? null,
            'no_pkh' => $row['no_pkh'] ?? null,
            'jenis_pendaftar' => $row['jenis_pendaftar'] ?? 'baru',
            'tahun_pelajaran_id' => $row['tahun_pelajaran_id'] ?? $this->tahunPelajaranId
        ]);
    }

    private function generateNoPendaftaran($tahunPelajaranId)
    {
        $tahunPelajaran = TahunPelajaran::find($tahunPelajaranId);

        if (!$tahunPelajaran) {
            throw new \Exception("Tahun pelajaran tidak ditemukan");
        }

        $tahunAjaran = $tahunPelajaran->tahun;
        $tahunParts = explode('/', $tahunAjaran);
        $tahun = substr($tahunParts[0], -2);

        $lastNumber = Ppdb::where('tahun_pelajaran_id', $tahunPelajaranId)
            ->orderBy('no_pendaftaran', 'desc')
            ->first();

        $nextNumber = $lastNumber ? (int)substr($lastNumber->no_pendaftaran, 2) + 1 : 1;

        return $tahun . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function parseDate($value)
    {
        if (empty($value)) return null;

        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
            }
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                return Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
