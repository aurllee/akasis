<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SakitGuru extends Model
{
    protected $table = 'sakit_guru';

    protected $fillable = [
        'sakit_id',
        'guru_id',
        'jadwal_pelajaran_id',
        'status',
        'catatan',
        'diverifikasi_at',
    ];

    protected $casts = [
        'diverifikasi_at' => 'datetime',
    ];

    public function sakit()
    {
        return $this->belongsTo(
            Sakit::class,
            'sakit_id'
        );
    }

    public function guru()
    {
        return $this->belongsTo(
            DataGuru::class,
            'guru_id'
        );
    }

    public function jadwal()
    {
        return $this->belongsTo(
            JadwalPelajaran::class,
            'jadwal_pelajaran_id'
        );
    }
}