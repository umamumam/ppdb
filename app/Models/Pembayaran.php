<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppdb_id',
        'petugas_id',
        'jenis_pembayaran',
        'nominal_spp',
        'nominal_infaq',
        'nominal_seragam',
        'nominal_kitab',
        'nominal_kolektif',
        'tgl_bayar',
        'status',
        'keterangan'
    ];
    protected $casts = [
        'tgl_bayar' => 'date'
    ];
    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
    public function getTotalNominalAttribute()
    {
        return $this->nominal_spp + $this->nominal_infaq + $this->nominal_seragam + $this->nominal_kitab + $this->nominal_kolektif;
    }
}
