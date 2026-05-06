<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_mobil', function (Blueprint $table) {
            $table->id('foto_id');
            $table->unsignedBigInteger('mobil_id'); 
            $table->string('url_foto');
            $table->boolean('is_primary')->default(false);
            $table->unsignedTinyInteger('urutan')->default(0);
        
            $table->foreign('mobil_id')
                  ->references('mobil_id')
                  ->on('mobil')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_mobil');
    }
};