<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    protected $table = 'sesi_absensi';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'tgl',
        'token',
        'status',
    ];

    protected $casts = [
        'tgl' => 'date',
    ];

    public function jadwal()
    {
        return $this->belongsTo(
            Jadwal_Pelajaran::class,
            'jadwal_pelajaran_id'
        );
    }

    public function absensi()
    {
        return $this->hasMany(
            Absensi::class,
            'sesi_absensi_id'
        );
    }
}
