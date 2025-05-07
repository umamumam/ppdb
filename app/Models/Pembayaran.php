<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppdb_id',
        'jenis_pembayaran',
        'nominal_spp',
        'nominal_infaq',
        'nominal_seragam',
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
    public function getTotalNominalAttribute()
    {
        return $this->nominal_spp + $this->nominal_infaq + $this->nominal_seragam + $this->nominal_kolektif;
    }
}
