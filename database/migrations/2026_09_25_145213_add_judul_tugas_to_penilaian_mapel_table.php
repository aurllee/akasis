<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaian_mapel', function (Blueprint $table) {
            $table->string('judul_tugas')->nullable()->after('jenis_nilai');
        });
    }

    public function down(): void
    {
        Schema::table('penilaian_mapel', function (Blueprint $table) {
            $table->dropColumn('judul_tugas');
        });
    }
};
