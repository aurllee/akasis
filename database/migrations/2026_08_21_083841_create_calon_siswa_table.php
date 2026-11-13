<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calon_siswa', function (Blueprint $table) {

            $table->id();

            
            
            

            $table->string('no_pendaftaran')->unique();
            $table->string('pin')->nullable();

            $table->foreignId('jurusan_id')
                ->constrained('jurusan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('jalur_pendaftaran')->nullable();

            
            
            

            $table->string('nama_lengkap');

            $table->string('nik', 16)
                ->nullable()
                ->unique();

            $table->string('nisn', 10)
                ->nullable()
                ->unique();

            $table->string('jenis_kelamin', 20)
                ->nullable();

            $table->string('tempat_lahir')
                ->nullable();

            $table->date('tanggal_lahir')
                ->nullable();

            $table->text('alamat')
                ->nullable();

            $table->string('rt', 5)
                ->nullable();

            $table->string('rw', 5)
                ->nullable();

            $table->string('kelurahan')
                ->nullable();

            $table->string('kecamatan')
                ->nullable();

            $table->string('kabupaten')
                ->nullable();

            $table->string('provinsi')
                ->nullable();

            $table->string('kode_pos', 10)
                ->nullable();

            
            
            

            $table->string('no_hp')
                ->nullable();

            $table->string('email')
                ->nullable();

            
            
            

            $table->string('nama_ayah')
                ->nullable();

            $table->string('nama_ibu')
                ->nullable();

            $table->string('no_hp_orang_tua')
                ->nullable();

            
            
            

            $table->string('asal_sekolah')
                ->nullable();

            $table->string('npsn_sekolah_asal')
                ->nullable();

            
            
            

            $table->enum('status', [
                'Draft',
                'Terdaftar',
                'Lolos',
                'Tidak Lolos',
                'Daftar Ulang',
                'Revisi',
                'Terverifikasi',
                'Siswa Aktif'
            ])->default('Draft');

            $table->text('catatan_revisi')
                ->nullable();

            
            
            

            $table->timestamp('tanggal_daftar_ulang')
                ->nullable();

            $table->timestamp('tanggal_verifikasi')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};