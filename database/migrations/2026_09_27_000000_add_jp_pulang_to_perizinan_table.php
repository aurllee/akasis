<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perizinan', function (Blueprint $table) {
            $table->unsignedTinyInteger('jp_pulang')->nullable()->after('jam_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('perizinan', function (Blueprint $table) {
            $table->dropColumn('jp_pulang');
        });
    }
};
