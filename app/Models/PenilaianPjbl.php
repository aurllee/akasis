<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPjbl extends Model
{
    use HasFactory;

    protected $table = 'penilaian_pjbl';

    protected $fillable = [
        'pjbl_id',
        'pjbl_penguji_id',
        'siswa_id',
        'nilai',
    ];

    public function pjbl()
    {
        return $this->belongsTo(Pjbl::class, 'pjbl_id');
    }

    public function pjblPenguji()
    {
        return $this->belongsTo(
            PjblPenguji::class,
            'pjbl_penguji_id',
            'id'
        );
    }

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'siswa_id',
            'id'
        );
    }
}