<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekening_rental', function (Blueprint $table) {
            $table->id('rekening_id');
            $table->unsignedBigInteger('rental_id');
            $table->enum('tipe', ['transfer', 'qris']);
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('url_qris')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->foreign('rental_id')->references('rental_id')->on('rental')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekening_rental');
    }
};