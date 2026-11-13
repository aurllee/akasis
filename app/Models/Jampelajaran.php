<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jam_pelajaran';

    protected $fillable = [
        'hari',
        'jp',
        'jam_mulai',
        'jam_selesai',
    ];

    public function jadwalPelajaran()
    {
        return $this->hasMany(Jadwal_pelajaran::class, 'jam_pelajaran_id');
    }
}