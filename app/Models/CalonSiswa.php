<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';

    protected $fillable = [
        'no_pendaftaran',
        'pin',
        'jurusan_id',
        'jalur_pendaftaran',
        'nama_lengkap',
        'nik',
        'no_kk',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'no_hp',
        'email',
        'nama_ayah',
        'nama_ibu',
        'no_hp_ortu',
        'asal_sekolah',
        'tahun_lulus',
        'npsn_sekolah_asal',
        'status',
        'status_penerimaan',
        'status_daftar_ulang',
        'catatan_revisi',
        'tanggal_daftar_ulang',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar_ulang' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function dokumen()
    {
        return $this->hasMany(
            DokumenCalonSiswa::class,
            'calon_siswa_id'
        );
    }

    public function pembagianKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }

    public function scopeNotAssignedToClass(Builder $query): Builder
    {
        return $query->whereNotExists(function ($subquery) {
            $subquery->selectRaw('1')
                ->from('datasiswa')
                ->join('siswa_kelas', 'datasiswa.id', '=', 'siswa_kelas.siswa_id')
                ->whereRaw('BINARY calon_siswa.nisn = BINARY datasiswa.nisn');
        });
    }
}
