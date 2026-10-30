<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaporDetail extends Model
{
    protected $table = 'rapor_detail';

    protected $fillable = [
        'rapor_id',
        'mata_pelajaran_id',
        'nilai_mapel',
        'nilai_pjbl',
        'nilai_akhir',
        'status',
        'deskripsi_capaian',
    ];

    public function rapor()
    {
        return $this->belongsTo(RaporSiswa::class, 'rapor_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}