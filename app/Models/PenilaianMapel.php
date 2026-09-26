<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Jadwal_Pelajaran;

class PenilaianMapel extends Model
{
    protected $table = 'penilaian_mapel';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'jadwal_pelajaran_id',
        'siswa_id',
        'jenis_nilai',
        'judul_tugas',
        'nilai',
        'tanggal_penilaian',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal_Pelajaran::class, 'jadwal_pelajaran_id', 'id');
    }

    public function jadwalPelajaran()
    {
        return $this->belongsTo(Jadwal_Pelajaran::class, 'jadwal_pelajaran_id', 'id');
    }
}
