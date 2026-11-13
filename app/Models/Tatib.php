<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tatib extends Model
{
    protected $table = 'tatib';

    protected $fillable = [
        'jenis_pelanggaran',
        'poin_pelanggaran',
        'keterangan',
    ];
}
