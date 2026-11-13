<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;

class Sakit extends Model
{
    protected $table = 'sakit';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'alasan',
        'dokumen',
        'walikelas_id',
        'status_walikelas',
        'waktu_verifikasi_walikelas',
        'catatan_walikelas',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_verifikasi_walikelas' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'siswa_id'
        );
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'walikelas_id');
    }

    public function guru()
{
    return $this->belongsTo(Guru::class, 'guru_id');
}
}