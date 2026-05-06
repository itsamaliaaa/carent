<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reply_review', function (Blueprint $table) {
            $table->id('reply_id');
            $table->unsignedBigInteger('review_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->text('komentar');
            $table->datetime('tanggal_balas');

            $table->foreign('review_id')->references('review_id')->on('review')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reply_review');
    }
};