<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapor_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siswa_id');
            $table->integer('kelas_id');
            $table->integer('tahun_ajaran_id');
            $table->string('semester', 20);
            $table->text('deskripsi_capaian')->nullable();
            $table->text('catatan_wali_kelas')->nullable();
            $table->string('status', 30)->default('draft');
            $table->timestamp('finalized_at')->nullable();
            $table->timestamp('dipublikasikan_at')->nullable();
            $table->timestamps();
            $table->unique(
                ['siswa_id', 'kelas_id', 'tahun_ajaran_id', 'semester'],
                'rapor_siswa_periode_unique'
            );
            $table->index(['kelas_id', 'tahun_ajaran_id', 'semester']);
        });

        Schema::create('rapor_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rapor_id');
            $table->integer('mata_pelajaran_id');
            $table->decimal('nilai_mapel', 5, 2)->nullable();
            $table->decimal('nilai_pjbl', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('status', 30)->default('perlu_revisi');
            $table->text('deskripsi_capaian')->nullable();
            $table->timestamps();
            $table->unique(['rapor_id', 'mata_pelajaran_id'], 'rapor_detail_mapel_unique');
        });

        Schema::create('permintaan_revisi_rapor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rapor_id');
            $table->integer('siswa_id');
            $table->integer('kelas_id');
            $table->integer('tahun_ajaran_id');
            $table->string('semester', 20);
            $table->integer('mata_pelajaran_id');
            $table->integer('guru_id');
            $table->text('alasan_revisi');
            $table->string('status', 30)->default('menunggu');
            $table->timestamps();
            $table->index(['rapor_id', 'status']);
            $table->index(['guru_id', 'status']);
        });

        Schema::create('nilai_akhir_rapor_mapel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siswa_id');
            $table->integer('kelas_id');
            $table->integer('tahun_ajaran_id');
            $table->string('semester', 20);
            $table->integer('mata_pelajaran_id');
            $table->decimal('nilai_akhir', 5, 2);
            $table->timestamps();
            $table->unique(
                ['siswa_id', 'kelas_id', 'tahun_ajaran_id', 'semester', 'mata_pelajaran_id'],
                'nilai_akhir_rapor_mapel_key_unique'
            );
        });

        Schema::create('deskripsi_capaian_mapel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siswa_id');
            $table->integer('kelas_id');
            $table->integer('tahun_ajaran_id');
            $table->string('semester', 20);
            $table->integer('mata_pelajaran_id');
            $table->text('deskripsi_capaian')->nullable();
            $table->timestamps();
            $table->unique(
                ['siswa_id', 'kelas_id', 'tahun_ajaran_id', 'semester', 'mata_pelajaran_id'],
                'deskripsi_capaian_mapel_key_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deskripsi_capaian_mapel');
        Schema::dropIfExists('nilai_akhir_rapor_mapel');
        Schema::dropIfExists('permintaan_revisi_rapor');
        Schema::dropIfExists('rapor_detail');
        Schema::dropIfExists('rapor_siswa');
    }
};
