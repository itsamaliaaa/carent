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
            $table->enum('transmisi', ['Manual', 'Matic']);                         
            $table->enum('kategori', ['harian', 'keluarga', 'rombongan', 'travel']);
            $table->unsignedTinyInteger('kapasitas_penumpang');
            $table->enum('jenis_bahan_bakar', ['Ditanggung Penyewa', 'Sudah Termasuk'])->default('Ditanggung Penyewa'); 
            $table->decimal('harga_per_hari', 12, 2);
            $table->decimal('biaya_admin', 12, 2)->default(0);
            $table->decimal('biaya_over_km', 10, 2)->default(0);
            $table->unsignedInteger('batas_km_per_hari')->default(0);
            $table->text('deskripsi')->nullable();                      
            $table->enum('asuransi', ['Termasuk', 'Tidak Termasuk'])->default('Termasuk'); // ✅ pindah dari migration terpisah
            $table->decimal('tarif_driver', 12, 2)->nullable();                     // ✅ pindah dari migration terpisah
            $table->enum('status', ['Tersedia', 'Tidak Tersedia', 'Perbaikan', 'Nonaktif'])->default('Tersedia');
            $table->timestamps();

            $table->foreign('rental_id')->references('rental_id')->on('rental')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
