<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('jadwal_pelajaran', 'jam_pelajaran_id')) {
            foreach (DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'jadwal_pelajaran' AND COLUMN_NAME = 'jam_pelajaran_id' AND REFERENCED_TABLE_NAME IS NOT NULL") as $constraint) {
                DB::statement('ALTER TABLE jadwal_pelajaran DROP FOREIGN KEY ' . $constraint->CONSTRAINT_NAME);
            }
            DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_pelajaran_id BIGINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('jadwal_pelajaran', 'jam_pelajaran_id')) {
            DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_pelajaran_id BIGINT UNSIGNED NOT NULL');
        }
    }
};
