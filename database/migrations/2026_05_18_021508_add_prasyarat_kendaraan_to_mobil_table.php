<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->text('prasyarat_kendaraan')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->dropColumn('prasyarat_kendaraan');
        });
    }
};