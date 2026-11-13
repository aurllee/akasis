<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->unsignedTinyInteger('jp_mulai')->nullable()->after('hari');
        });

        DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_mulai TIME NULL, MODIFY jam_selesai TIME NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_mulai TIME NOT NULL, MODIFY jam_selesai TIME NOT NULL');

        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropColumn('jp_mulai');
        });
    }
};
