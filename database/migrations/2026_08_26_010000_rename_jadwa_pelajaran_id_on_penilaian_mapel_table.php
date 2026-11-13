<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('penilaian_mapel')
            && Schema::hasColumn('penilaian_mapel', 'jadwa_pelajaran_id')
            && !Schema::hasColumn('penilaian_mapel', 'jadwal_pelajaran_id')
        ) {
            DB::statement(
                'ALTER TABLE `penilaian_mapel` CHANGE `jadwa_pelajaran_id` `jadwal_pelajaran_id` INT NOT NULL'
            );
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('penilaian_mapel')
            && Schema::hasColumn('penilaian_mapel', 'jadwal_pelajaran_id')
            && !Schema::hasColumn('penilaian_mapel', 'jadwa_pelajaran_id')
        ) {
            DB::statement(
                'ALTER TABLE `penilaian_mapel` CHANGE `jadwal_pelajaran_id` `jadwa_pelajaran_id` INT NOT NULL'
            );
        }
    }
};
