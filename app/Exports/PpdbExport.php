<?php

namespace App\Exports;

use App\Models\Ppdb;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PpdbExport implements FromCollection, WithHeadings, WithMapping
{
    protected $selectedIds;

    public function __construct(array $selectedIds)
    {
        $this->selectedIds = $selectedIds;
    }

    public function collection()
    {
        return Ppdb::whereIn('id', $this->selectedIds)->get([
            'no_pendaftaran',
            'nis',
            'nisn',
            'nik_siswa',
            'nama_siswa',
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
            'jenis_pendaftar'
        ]);
    }

    public function headings(): array
    {
        return [
            'No Pendaftaran',
            'NIS',
            'NISN',
            'NIK Siswa',
            'Nama Siswa',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kelas',
            'Program',
            'Anak ke',
            'No KK',
            'NIK Ayah',
            'Nama Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'HP Siswa',
            'HP Orang Tua',
            'Alamat',
            'Kode Pos',
            'Asal Sekolah',
            'NPSN',
            'NSM',
            'Alamat Sekolah',
            'No KIP',
            'No KKS',
            'No PKH',
            'Jenis Pendaftar'
        ];
    }

    public function map($row): array
    {
        return [
            $row->no_pendaftaran,
            $row->nis,
            $row->nisn,
            $row->nik_siswa,
            $row->nama_siswa,
            $row->jeniskelamin,
            $row->tempat_lahir,
            $row->tgl_lahir ? Carbon::parse($row->tgl_lahir)->format('d-m-Y') : '',
            $row->kelas,
            $row->program,
            $row->anak_ke,
            $row->no_kk,
            $row->nik_ayah,
            $row->nama_ayah,
            $row->pendidikan_ayah,
            $row->pekerjaan_ayah,
            $row->nik_ibu,
            $row->nama_ibu,
            $row->pendidikan_ibu,
            $row->pekerjaan_ibu,
            $row->hp_siswa,
            $row->hp_ortu,
            $row->alamat,
            $row->kode_pos,
            $row->asal_sekolah,
            $row->npsn,
            $row->nsm,
            $row->alamat_sekolah,
            $row->no_kip,
            $row->no_kks,
            $row->no_pkh,
            $row->jenis_pendaftar
        ];
    }
}
