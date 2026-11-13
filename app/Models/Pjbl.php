<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pjbl extends Model
{
    use HasFactory;

    protected $table = 'pjbl';

    protected $fillable = [
        'kelas_id',
        'tahun_ajaran_id',
        'tanggal',
        'periode',
        'mulai_penilaian',
        'batas_penilaian',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'mulai_penilaian' => 'datetime',
        'batas_penilaian' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(
            TahunAjaran::class,
            'tahun_ajaran_id',
            'id'
        );
    }

    public function penguji()
    {
        return $this->hasMany(
            PjblPenguji::class,
            'pjbl_id'
        );
    }


    public function getNamaPeriodeAttribute()
    {
        $periode = strtolower($this->periode ?? '');

        preg_match('/(\d+)/', $periode, $matches);

        $nomor = isset($matches[1])
            ? (int) $matches[1]
            : null;

        return match ($nomor) {

            1 => 'PJBL Ganjil Smt 1',

            2 => 'PJBL Genap Smt 2',

            default =>
            'PJBL ' .
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $this->periode
                    )
                ),
        };
    }
}
