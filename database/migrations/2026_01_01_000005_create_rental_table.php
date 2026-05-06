<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental', function (Blueprint $table) {
            $table->id('rental_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('nama_rental');
            $table->string('logo_perusahaan')->nullable();
            $table->text('alamat');
            $table->string('kota');
            $table->text('deskripsi')->nullable();
            $table->string('no_telp', 20);
            $table->string('email');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental');
    }
};