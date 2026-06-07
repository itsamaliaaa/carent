<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KebijakanPembatalan;

class KebijakanSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = \App\Models\User::where('role', 'super_admin')->first();

        DB::table('kebijakan')->insert([
            [
                'judul'      => 'Kebijakan Pembatalan',
                'tipe'       => 'pembatalan',
                'isi'        => "Pembatalan hanya dapat dilakukan jika status booking belum selesai.\nPengguna wajib mengisi alasan pembatalan pada form yang tersedia.\nPembatalan tidak dapat dilakukan setelah waktu sewa dimulai.",
                'status'     => 'aktif',
                'dibuat_oleh'=> $superAdmin->user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul'      => 'Kebijakan Pengembalian Dana',
                'tipe'       => 'pengembalian_dana',
                'isi'        => "Lebih dari 48 jam sebelum waktu sewa: Pengguna berhak mendapatkan pengembalian dana 100%.\n24-48 jam sebelum waktu sewa: Pengguna berhak mendapatkan pengembalian dana 75%.\nKurang dari 24 jam sebelum waktu sewa: Pengguna berhak mendapatkan pengembalian dana 50%.\nPada hari H atau setelah waktu sewa dimulai: Pengguna tidak mendapatkan pengembalian dana (0%).",
                'status'     => 'aktif',
                'dibuat_oleh'=> $superAdmin->user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}