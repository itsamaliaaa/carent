<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('car_id')->constrained(); // Relationship to cars table
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->string('payment_proof')->nullable(); // Store file path
            $table->enum('status', ['pending', 'confirmed', 'success'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
