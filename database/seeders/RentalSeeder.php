<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        Rental::create([
            'admin_id'         => 2,
            'nama_rental'      => 'Aflah Jaya Rental',
            'logo_perusahaan'  => 'images/logo/logo-rental-1.png',
            'alamat'           => 'Jl. Soekarno Hatta No. 123, Bandung',
            'kota'             => 'Bandung',
            'deskripsi'        => 'Rental mobil terpercaya di Bandung.',
            'no_telp'          => '+6289876543210',
            'email'            => 'aflah@gmail.com',
            'latitude'         => -6.9175,
            'longitude'        => 107.6191,
            'status'           => 'aktif',
        ]);

        Rental::create([
            'admin_id'         => 3,
            'nama_rental'      => 'Cahya Rental',
            'logo_perusahaan'  => 'images/logo/logo-rental-2.png',
            'alamat'           => 'Jl. Margonda Raya No. 45, Depok',
            'kota'             => 'Depok',
            'deskripsi'        => 'Rental mobil keluarga terbaik.',
            'no_telp'          => '+6285711223344',
            'email'            => 'cahya@gmail.com',
            'latitude'         => -6.3728,
            'longitude'        => 106.8317,
            'status'           => 'aktif',
        ]);

        Rental::create([
            'admin_id'         => 4,
            'nama_rental'      => 'Mobilio Rental',
            'logo_perusahaan'  => 'images/logo/logo-rental-3.png',
            'alamat'           => 'Jl. Sudirman No. 88, Jakarta',
            'kota'             => 'Jakarta',
            'deskripsi'        => 'Sewa mobil terpercaya.',
            'no_telp'          => '+6281234567890',
            'email'            => 'mobilio@gmail.com',
            'latitude'         => -6.2000,
            'longitude'        => 106.8166,
            'status'           => 'aktif',
        ]);

        Rental::create([
            'admin_id'         => 5,
            'nama_rental'      => 'KeRental',
            'logo_perusahaan'  => 'images/logo/logo-rental-4.png',
            'alamat'           => 'Jl. Ahmad Yani No. 10, Surabaya',
            'kota'             => 'Surabaya',
            'deskripsi'        => 'Rental mobil murah dan lengkap.',
            'no_telp'          => '+6281122233344',
            'email'            => 'kerental@gmail.com',
            'latitude'         => -7.2575,
            'longitude'        => 112.7521,
            'status'           => 'aktif',
        ]);
    }
}