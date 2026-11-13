<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian_mapel';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'siswa_id',
        'jenis_nilai',
        'judul_tugas',
        'nilai',
        'tanggal_penilaian',
    ];

    public function jadwalPelajaran()
    {
        return $this->belongsTo(Jadwal_Pelajaran::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
