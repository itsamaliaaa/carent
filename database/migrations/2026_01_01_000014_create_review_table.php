<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review', function (Blueprint $table) {
            $table->id('review_id');
            $table->unsignedBigInteger('booking_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('rating');
            $table->text('komentar');
            $table->boolean('status_tampilkan')->default(true);
            $table->datetime('tanggal_posting');

            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};