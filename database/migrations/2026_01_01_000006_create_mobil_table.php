<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('mobil_id');
            $table->unsignedBigInteger('rental_id');
            $table->string('nama_mobil');
            $table->year('tahun');
            $table->enum('transmisi', ['manual', 'matic']);
            $table->enum('kategori', ['harian', 'keluarga', 'rombongan', 'travel']);
            $table->unsignedTinyInteger('kapasitas_penumpang');
            $table->enum('jenis_bahan_bakar', ['bensin', 'solar', 'hybrid', 'listrik'])->default('bensin');
            $table->decimal('harga_per_hari', 12, 2);
            $table->decimal('biaya_admin', 12, 2)->default(0);
            $table->decimal('biaya_over_km', 10, 2)->default(0);
            $table->unsignedInteger('batas_km_per_hari')->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'disewa', 'perbaikan', 'nonaktif'])->default('tersedia');
            $table->timestamps();

            $table->foreign('rental_id')->references('rental_id')->on('rental')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};












