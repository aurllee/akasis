<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinan';

    protected $fillable = [
        'siswa_id',
        'jenis',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
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
        return $this->belongsTo(Siswa::class);
    }

    public function walikelas()
    {
        return $this->belongsTo(Guru::class, 'walikelas_id');
    }
}