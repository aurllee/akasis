<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
        DB::statement("ALTER TABLE users ADD COLUMN username VARCHAR(255) NOT NULL UNIQUE AFTER id");
        DB::statement("ALTER TABLE users ADD COLUMN role_id BIGINT UNSIGNED NOT NULL DEFAULT 1 AFTER password");
        DB::statement("ALTER TABLE users ADD COLUMN guru_id BIGINT UNSIGNED NULL AFTER role_id");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users DROP COLUMN guru_id");
        DB::statement("ALTER TABLE users DROP COLUMN role_id");
        DB::statement("ALTER TABLE users DROP COLUMN username");
    }
};
