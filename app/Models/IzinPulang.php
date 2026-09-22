<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinPulang extends Model
{
    protected $table = 'izin_pulang';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'alasan',
        'dokumen',
        'status_kesiswaan',
        'status_guru_mapel',
        'catatan_kesiswaan',
        'catatan_guru_mapel',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'siswa_id'
        );
    }
}
