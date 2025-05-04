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
        'nominal',
        'tgl_bayar',
        'status',
        'keterangan'
    ];
    protected $casts = [
        'tgl_bayar' => 'date'
    ];
    // Relationship with PPDB
    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }
}
