<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->unsignedBigInteger('booking_id');
            $table->enum('metode_pembayaran', ['transfer', 'qris']);
            $table->string('bukti_pembayaran');
            $table->decimal('jumlah_bayar', 14, 2);
            $table->enum('status_pembayaran', ['pending', 'lunas', 'expired'])->default('pending');
            $table->datetime('tanggal_bayar')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->decimal('jumlah_refund', 14, 2)->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
            $table->foreign('verified_by')->references('user_id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};