<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kebijakan_pembatalan', function (Blueprint $table) {
            $table->id('kebijakan_id');
            $table->string('judul');
            $table->text('isi');
            $table->enum('tipe', ['pembatalan', 'pengembalian_dana']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->unsignedBigInteger('dibuat_oleh');
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebijakan_pembatalan');
    }
};