<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KebijakanPembatalan;

class KebijakanSeeder extends Seeder
{
    public function run(): void
    {
        KebijakanPembatalan::create([
            'judul'       => 'Kebijakan Pembatalan Booking',
            'isi'         => 'Pembatalan yang dilakukan lebih dari 24 jam sebelum tanggal sewa akan mendapatkan pengembalian dana penuh. Pembatalan kurang dari 24 jam sebelum tanggal sewa dikenakan biaya pembatalan sebesar 50% dari total pembayaran. Pembatalan yang dilakukan setelah tanggal sewa dimulai tidak mendapatkan pengembalian dana.',
            'tipe'        => 'pembatalan',
            'status'      => 'aktif',
            'dibuat_oleh' => 1, // Super Admin
        ]);

        KebijakanPembatalan::create([
            'judul'       => 'Kebijakan Pengembalian Dana',
            'isi'         => 'Pengembalian dana akan diproses maksimal 7 hari kerja setelah pembatalan dikonfirmasi. Dana dikembalikan melalui metode pembayaran yang sama dengan saat melakukan booking. Biaya transfer ditanggung oleh penyewa.',
            'tipe'        => 'pengembalian_dana',
            'status'      => 'aktif',
            'dibuat_oleh' => 1, // Super Admin
        ]);
    }
}