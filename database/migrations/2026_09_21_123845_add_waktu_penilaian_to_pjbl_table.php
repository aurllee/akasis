<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('pjbl', function (Blueprint $table) {
            if (!Schema::hasColumn('pjbl', 'mulai_penilaian')) {
                $table->dateTime('mulai_penilaian')->nullable();
            }

            if (!Schema::hasColumn('pjbl', 'batas_penilaian')) {
                $table->dateTime('batas_penilaian')->nullable();
            }
        });
    }

    
    public function down(): void
    {
        Schema::table('pjbl', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('pjbl', 'mulai_penilaian')) {
                $columns[] = 'mulai_penilaian';
            }

            if (Schema::hasColumn('pjbl', 'batas_penilaian')) {
                $columns[] = 'batas_penilaian';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
