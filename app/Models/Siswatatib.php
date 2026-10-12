<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswatatib extends Model
{
    protected $table = 'siswa_tatib';

    protected $fillable = [
        'id_siswa',
        'id_tatib',
        'tanggal',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tatib()
    {
        return $this->belongsTo(Tatib::class, 'tatib_id');
    }
}