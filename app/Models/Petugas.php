<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = ['nama'];

    public function ppdbs()
    {
        return $this->hasMany(Ppdb::class);
    }
}
