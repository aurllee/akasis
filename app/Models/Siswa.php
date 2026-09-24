<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'datasiswa';

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jk',
        'tanggal_lahir',
        'agama',
        'nik',
        'no_kk',
        'alamat',
        'nama_orang_tua',
        'no_hp',
        'email',
        'nama_orang_tua',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public $timestamps = false;


    public static function generateNis()
    {
        $lastSiswa = self::orderBy('nis', 'desc')->first();

        if (!$lastSiswa) {
            return '0001';
        }

        $lastNis = (int) $lastSiswa->nis;
        $newNis = $lastNis + 1;

        return str_pad($newNis, 4, '0', STR_PAD_LEFT);
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }

    public function pembagianKelas()
    {
        return $this->hasMany(PembagianKelas::class);
    }
    public function absensi()
{
    return $this->hasMany(
        Absensi::class,
        'siswa_id'
    );
}

    public function sakit()
    {
        return $this->hasMany(
            Sakit::class,
            'siswa_id'
        );
    }

    public function izinKeluar()
    {
        return $this->hasMany(
            IzinKeluar::class,
            'siswa_id'
        );
    }

    public function izinPulang()
    {
        return $this->hasMany(
            IzinPulang::class,
            'siswa_id'
        );
    }

    public function dispen()
    {
        return $this->hasMany(
            Dispen::class,
            'siswa_id'
        );
    }

    public function penilaianMapel()
    {
        return $this->hasMany(PenilaianMapel::class, 'siswa_id');
    }
}
