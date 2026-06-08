<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        Rental::firstOrCreate(
            ['email' => 'aflah@gmail.com'],
            [
                'admin_id'        => 2,
                'nama_rental'     => 'Aflah Jaya Rental',
                'logo_perusahaan' => 'images/logo/logo-rental-1.png',
                'alamat'          => 'Jl. Soekarno Hatta No. 123, Bandung',
                'kota'            => 'Bandung',
                'deskripsi'       => 'Rental mobil terpercaya di Bandung.',
                'no_telp'         => '+6289876543210',
                'google_maps'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7834784427987!2d107.65287347403547!3d-6.9164704676921955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e70035050dff%3A0x4eb581ba1a29a366!2sAFLAH%20JAYA%20RENTAL!5e0!3m2!1sid!2sid!4v1780807232383!5m2!1sid!2sid',
                'status'          => 'aktif',
            ]
        );

        Rental::firstOrCreate(
            ['email' => 'cahya@gmail.com'],
            [
                'admin_id'        => 3,
                'nama_rental'     => 'Cahya Rental',
                'logo_perusahaan' => 'images/logo/logo-rental-2.png',
                'alamat'          => 'Jl. Margonda Raya No. 45, Depok',
                'kota'            => 'Depok',
                'deskripsi'       => 'Rental mobil keluarga terbaik.',
                'no_telp'         => '+6285711223344',
                'google_maps'     => null,
                'status'          => 'aktif',
            ]
        );

        Rental::firstOrCreate(
            ['email' => 'mobilio@gmail.com'],
            [
                'admin_id'        => 4,
                'nama_rental'     => 'Mobilio Rental',
                'logo_perusahaan' => 'images/logo/logo-rental-3.png',
                'alamat'          => 'Jl. Sudirman No. 88, Jakarta',
                'kota'            => 'Jakarta',
                'deskripsi'       => 'Sewa mobil terpercaya.',
                'no_telp'         => '+6281234567890',
                'google_maps'     => null,
                'status'          => 'aktif',
            ]
        );

        Rental::firstOrCreate(
            ['email' => 'kerental@gmail.com'],
            [
                'admin_id'        => 5,
                'nama_rental'     => 'KeRental',
                'logo_perusahaan' => 'images/logo/logo-rental-4.png',
                'alamat'          => 'Jl. Ahmad Yani No. 10, Surabaya',
                'kota'            => 'Surabaya',
                'deskripsi'       => 'Rental mobil murah dan lengkap.',
                'no_telp'         => '+6281122233344',
                'google_maps'     => null,
                'status'          => 'aktif',
            ]
        );
    }
}
