<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        Rental::create([
            'admin_id'    => 2, // Admin Aflah
            'nama_rental' => 'Aflah Jaya Rental',
            'alamat'      => 'Jl. Soekarno Hatta No. 123, Bandung',
            'kota'        => 'Bandung',
            'deskripsi'   => 'Rental mobil terpercaya di Bandung dengan armada lengkap dan pelayanan profesional.',
            'no_telp'     => '+6289876543210',
            'email'       => 'aflahjayrental@gmail.com',
            'latitude'    => -6.9175,
            'longitude'   => 107.6191,
            'status'      => 'aktif',
        ]);

        Rental::create([
            'admin_id'    => 3, // Admin Berkah
            'nama_rental' => 'Berkah Rental Mobil',
            'alamat'      => 'Jl. Margonda Raya No. 45, Depok',
            'kota'        => 'Depok',
            'deskripsi'   => 'Solusi rental mobil keluarga dengan harga terjangkau dan armada terawat.',
            'no_telp'     => '+6285711223344',
            'email'       => 'berkahrentalmobil@gmail.com',
            'latitude'    => -6.3728,
            'longitude'   => 106.8317,
            'status'      => 'aktif',
        ]);
    }
}