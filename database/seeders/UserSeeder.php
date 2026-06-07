<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Super Admin',
            'email'        => 'superadmin@carent.com',
            'no_telp'      => '+6281234567890',
            'password'     => Hash::make('PasswordSuperAdmin1#'),
            'role'         => 'super_admin',
        ]);

        User::create([
            'nama_lengkap' => 'Admin Aflah Jaya Rental',
            'email'        => 'adminaflah@carent.com',
            'no_telp'      => '+6289876543210',
            'password'     => Hash::make('PasswordAdminAflah2#'),
            'role'         => 'admin_rental',
        ]);

        User::create([
            'nama_lengkap' => 'Admin Cahya Rental',
            'email'        => 'admincahya@carent.com',
            'no_telp'      => '+6285711223344',
            'password'     => Hash::make('PasswordCahya1#'),
            'role'         => 'admin_rental',
        ]);

        User::create([
            'nama_lengkap' => 'Admin Mobilio Rental',
            'email'        => 'adminmobilio@carent.com',
            'no_telp'      => '+6281234567890',
            'password'     => Hash::make('PasswordMobilio1#'),
            'role'         => 'admin_rental',
        ]);

        User::create([
            'nama_lengkap' => 'Admin KeRental',
            'email'        => 'adminkerental@carent.com',
            'no_telp'      => '+6281122233344',
            'password'     => Hash::make('PasswordKeRental1#'),
            'role'         => 'admin_rental',
        ]);
        
        User::create([
            'nama_lengkap' => 'Miskah Indah',
            'email'        => 'miskah@gmail.com',
            'no_telp'      => '+6285711223344',
            'password'     => Hash::make('Customer1#'),
            'role'         => 'customer',
        ]);
    }
}