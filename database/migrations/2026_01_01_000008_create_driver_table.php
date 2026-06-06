<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->id('driver_id');
            $table->unsignedBigInteger('rental_id');
            $table->string('nama_driver');
            $table->string('foto')->nullable();
            $table->unsignedTinyInteger('umur');
<<<<<<< HEAD
            $table->string('no_telepon');
=======
            $table->string('no_telp', 20);
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
            $table->decimal('tarif_harian', 12, 2);
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();

            $table->foreign('rental_id')->references('rental_id')->on('rental')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver');
    }
};