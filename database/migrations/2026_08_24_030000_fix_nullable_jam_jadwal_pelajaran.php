<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_mulai TIME NULL, MODIFY jam_selesai TIME NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE jadwal_pelajaran MODIFY jam_mulai TIME NOT NULL, MODIFY jam_selesai TIME NOT NULL');
    }
};
