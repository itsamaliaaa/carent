<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_status_booking', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('booking_id');
            $table->string('status_lama')->nullable();
            $table->string('status_baru');
            $table->datetime('waktu_perubahan');
            $table->unsignedBigInteger('diubah_oleh')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
            $table->foreign('diubah_oleh')->references('user_id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_booking');
    }
};