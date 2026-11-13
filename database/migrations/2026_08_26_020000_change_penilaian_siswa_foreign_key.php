<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penilaian_mapel')) {
            return;
        }

        DB::statement('ALTER TABLE `penilaian_mapel` DROP FOREIGN KEY `penilaian_mapel_ibfk_2`');
        DB::statement('ALTER TABLE `penilaian_mapel` MODIFY `siswa_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `penilaian_mapel` ADD CONSTRAINT `penilaian_mapel_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `calon_siswa` (`id`) ON DELETE CASCADE');
    }

    public function down(): void
    {
        if (!Schema::hasTable('penilaian_mapel')) {
            return;
        }

        DB::statement('ALTER TABLE `penilaian_mapel` DROP FOREIGN KEY `penilaian_mapel_ibfk_2`');
        DB::statement('ALTER TABLE `penilaian_mapel` ADD CONSTRAINT `penilaian_mapel_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `datasiswa` (`id`)');
    }
};
