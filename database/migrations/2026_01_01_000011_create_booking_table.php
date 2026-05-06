<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->string('kode_booking')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rental_id');
            $table->unsignedBigInteger('mobil_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->boolean('pakai_driver')->default(false);

            // Data Pengendara
            $table->string('nama_pengendara');
            $table->string('no_telp_pengendara', 20);
            $table->string('no_sim_pengendara');
            $table->date('tgl_lahir_pengendara')->nullable();

            // Jadwal
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali');
            $table->time('waktu_ambil');
            $table->time('waktu_kembali');
            $table->text('lokasi_penjemputan');
            $table->decimal('latitude_penjemputan', 10, 8)->nullable();
            $table->decimal('longitude_penjemputan', 11, 8)->nullable();

            // Harga
            $table->decimal('total_harga', 14, 2);
            $table->json('rincian_harga')->nullable();

            // Persetujuan
            $table->boolean('setuju_syarat')->default(false);
            $table->timestamp('waktu_setuju_syarat')->nullable();

            // Pembatalan
            $table->text('alasan_pembatalan')->nullable();
            $table->datetime('tanggal_pembatalan')->nullable();
            $table->unsignedBigInteger('dibatalkan_oleh')->nullable();

            // Deposit
            $table->enum('status_deposit', ['belum', 'dikembalikan'])->default('belum');
            $table->datetime('tanggal_deposit_dikembalikan')->nullable();

            // Lainnya
            $table->text('catatan')->nullable();
            $table->enum('status_booking', [
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'berjalan',
                'selesai',
                'ditolak',
                'dibatalkan'
            ])->default('menunggu_konfirmasi');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('rental_id')->references('rental_id')->on('rental');
            $table->foreign('mobil_id')->references('mobil_id')->on('mobil');
            $table->foreign('driver_id')->references('driver_id')->on('driver')->nullOnDelete();
            $table->foreign('dibatalkan_oleh')->references('user_id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};