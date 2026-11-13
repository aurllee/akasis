<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['izin_keluar', 'izin_pulang'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('status_wali_kelas')->default('pending')->after('status_guru');
                $table->timestamp('waktu_verifikasi_wali_kelas')->nullable()->after('status_wali_kelas');
                $table->text('catatan_wali_kelas')->nullable()->after('waktu_verifikasi_wali_kelas');
            });
        }
    }

    public function down(): void
    {
        foreach (['izin_keluar', 'izin_pulang'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['status_wali_kelas', 'waktu_verifikasi_wali_kelas', 'catatan_wali_kelas']);
            });
        }
    }
};
