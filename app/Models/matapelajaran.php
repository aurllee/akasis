<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'warna',
    ];

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal_Pelajaran::class,
            'mata_pelajaran_id',
            'id'
        );
    }
}
