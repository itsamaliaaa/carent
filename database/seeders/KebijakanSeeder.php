<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KebijakanPembatalan;

class KebijakanSeeder extends Seeder
{
    public function run(): void
    {
        Schema::table('kebijakan', function (Blueprint $table) {
            $table->enum('tipe', [
                'pembatalan',
                'pengembalian_dana',
                'syarat_ketentuan_umum', 
            ])->change();
        });
    }
}