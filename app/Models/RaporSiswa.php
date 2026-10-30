<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaporSiswa extends Model
{
    protected $table = 'rapor_siswa';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
        'semester',
        'deskripsi_capaian',
        'catatan_wali_kelas',
        'status',
        'finalized_at',
    ];

    protected $casts = [
        'finalized_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(RaporDetail::class, 'rapor_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}