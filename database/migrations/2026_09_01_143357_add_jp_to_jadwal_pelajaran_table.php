<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->unsignedTinyInteger('jp_mulai')->after('jam_selesai');
            $table->unsignedTinyInteger('jp_selesai')->after('jp_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropColumn(['jp_mulai', 'jp_selesai']);
        });
    }
};