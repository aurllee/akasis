<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_pelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'kelas_id',
        'guru_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'jumlah_jp',
        'mata_pelajaran_id',
        'ruangan_id',
        'is_published',
    ];

    protected $casts = [
    'is_published' => 'boolean',
];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'mata_pelajaran_id',
            'id'
        );
    }
    public function mapel()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'mata_pelajaran_id',
            'id'
        );
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function jamPelajaran()
{
    return $this->belongsTo(JamPelajaran::class, 'jam_pelajaran_id');
}

public function jadwalPelajaran()
    {
        return $this->belongsTo(Jadwal_pelajaran::class, 'jadwal_pelajaran_id');
    }
}
