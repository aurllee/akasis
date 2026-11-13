<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PjblPenguji extends Model
{
    use HasFactory;

    protected $table = 'pjbl_penguji';

    protected $fillable = [
        'pjbl_id',
        'guru_id',
        'jenis_peguji',
    ];

    
    public function pjbl()
    {
        return $this->belongsTo(Pjbl::class, 'pjbl_id');
    }

    
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianPjbl::class, 'pjbl_penguji_id');
    }
}