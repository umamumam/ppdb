<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek apakah nisn sudah ada di database
        $existingAlumni = Alumni::where('nisn', $row['nisn'])->first();

        // Jika ada, hapus data lama
        if ($existingAlumni) {
            $existingAlumni->delete();
        }

        // Simpan data yang baru
        return new Alumni([
            'nama_siswa'       => $row['nama_siswa'] ?? null,
            'nis'              => $row['nis'] ?? null,
            'nisn'             => $row['nisn'] ?? null,
            'nik_siswa'        => $row['nik_siswa'] ?? null,
            'foto'             => $row['foto'] ?? null,
            'jeniskelamin'     => $row['jeniskelamin'] ?? null,
            'tempat_lahir'     => $row['tempat_lahir'] ?? null,
            // 'tgl_lahir'        => $row['tgl_lahir'] ?? null,
            'tgl_lahir'        => $this->parseDate($row['tgl_lahir'] ?? null),
            'kelas'            => $row['kelas'] ?? null,
            'program'          => $row['program'] ?? null,
            'anak_ke'          => $row['anak_ke'] ?? null,
            'no_kk'            => $row['no_kk'] ?? null,
            'nik_ayah'         => $row['nik_ayah'] ?? null,
            'nama_ayah'        => $row['nama_ayah'] ?? null,
            'pendidikan_ayah'  => $row['pendidikan_ayah'] ?? null,
            'pekerjaan_ayah'   => $row['pekerjaan_ayah'] ?? null,
            'nik_ibu'          => $row['nik_ibu'] ?? null,
            'nama_ibu'         => $row['nama_ibu'] ?? null,
            'pendidikan_ibu'   => $row['pendidikan_ibu'] ?? null,
            'pekerjaan_ibu'    => $row['pekerjaan_ibu'] ?? null,
            'hp_siswa'         => $row['hp_siswa'] ?? null,
            'hp_ortu'          => $row['hp_ortu'] ?? null,
            'alamat'           => $row['alamat'] ?? null,
            'kode_pos'         => $row['kode_pos'] ?? null,
            'asal_sekolah'     => $row['asal_sekolah'] ?? null,
            'npsn'             => $row['npsn'] ?? null,
            'nsm'              => $row['nsm'] ?? null,
            'alamat_sekolah'   => $row['alamat_sekolah'] ?? null,
            'no_kip'           => $row['no_kip'] ?? null,
            'no_kks'           => $row['no_kks'] ?? null,
            'no_pkh'           => $row['no_pkh'] ?? null,
        ]);
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
