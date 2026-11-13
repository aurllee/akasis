<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembagianKelas extends Model
{
    use HasFactory;

    protected $table = 'pembagian_kelas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pembagianKelas()
{
    return $this->hasMany(SiswaKelas::class, 'siswa_id');
}

}