<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_pelajarans';

    protected $fillable = [
        'tahun',
        'active',
    ];
    public function ppdbs()
    {
        return $this->hasMany(Ppdb::class);
    }
}
