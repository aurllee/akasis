<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
    ];

    public $timestamps = false;

    public function calonSiswa()
    {
        return $this->hasMany(
            CalonSiswa::class,
            'jurusan_id'
        );
    }
}