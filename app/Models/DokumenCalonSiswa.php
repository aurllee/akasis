<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DokumenCalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_calon_siswa';

    protected $fillable = [
        'calon_siswa_id',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'mime_type',
        'ukuran_file',
        'status',
        'catatan',
        'tanggal_verifikasi',
        'verifikator_id',
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];

    

    public function calonSiswa()
    {
        return $this->belongsTo(
            CalonSiswa::class,
            'calon_siswa_id'
        );
    }

    

    public function verifier()
    {
        return $this->belongsTo(
            User::class,
            'verifikator_id'
        );
    }
}