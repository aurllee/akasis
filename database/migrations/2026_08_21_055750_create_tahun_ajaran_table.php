<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        if (Schema::hasTable('tahun_ajaran')) {
            return;
        }

        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 9); 
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->boolean('status')->default(false); 
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran'); 
    }
};
