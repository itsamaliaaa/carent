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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // e.g., TRX12345
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->string('car_name');
            $table->date('pickup_date');
            $table->date('return_date');
            $table->time('pickup_time');
            $table->time('return_time');
            $table->integer('duration');
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'success'])->default('pending');
            $table->timestamps();
            $table->string('driver_name')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'success', 'cancelled'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
