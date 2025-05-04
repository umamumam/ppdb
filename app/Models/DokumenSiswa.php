<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppdb_id',
        'kk',
        'akte',
        'surat_keterangan_lulus',
        'kip'
    ];

    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }
}
