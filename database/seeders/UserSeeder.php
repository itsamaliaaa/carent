<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'superadmin@carent.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Super Admin',
                'email'        => 'superadmin@carent.com',
                'no_telp'      => '+6281234567890',
                'password'     => Hash::make('PasswordSuperAdmin1#'),
                'role'         => 'super_admin',
            ]);
        }

        if (!User::where('email', 'adminaflah@carent.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Admin Aflah Jaya Rental',
                'email'        => 'adminaflah@carent.com',
                'no_telp'      => '+6289876543210',
                'password'     => Hash::make('PasswordAdminAflah2#'),
                'role'         => 'admin_rental',
            ]);
        }

        if (!User::where('email', 'admincahya@carent.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Admin Cahya Rental',
                'email'        => 'admincahya@carent.com',
                'no_telp'      => '+6285711223344',
                'password'     => Hash::make('PasswordCahya1#'),
                'role'         => 'admin_rental',
            ]);
        }

        if (!User::where('email', 'adminmobilio@carent.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Admin Mobilio Rental',
                'email'        => 'adminmobilio@carent.com',
                'no_telp'      => '+6281234567890',
                'password'     => Hash::make('PasswordMobilio1#'),
                'role'         => 'admin_rental',
            ]);
        }

        if (!User::where('email', 'adminkerental@carent.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Admin KeRental',
                'email'        => 'adminkerental@carent.com',
                'no_telp'      => '+6281122233344',
                'password'     => Hash::make('PasswordKeRental1#'),
                'role'         => 'admin_rental',
            ]);
        }

        // Customer
        $customers = [
            ['nama_lengkap' => 'Miskah Indah',    'email' => 'miskah@gmail.com',   'no_telp' => '+6285711223344', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Budi Santoso',     'email' => 'budi@gmail.com',     'no_telp' => '+6281234500001', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Siti Rahayu',      'email' => 'siti@gmail.com',     'no_telp' => '+6281234500002', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Andi Firmansyah',  'email' => 'andi@gmail.com',     'no_telp' => '+6281234500003', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Dewi Anggraini',   'email' => 'dewi@gmail.com',     'no_telp' => '+6281234500004', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Rizky Pratama',    'email' => 'rizky@gmail.com',    'no_telp' => '+6281234500005', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Nurul Hidayah',    'email' => 'nurul@gmail.com',    'no_telp' => '+6281234500006', 'password' => 'Customer1#'],
            ['nama_lengkap' => 'Fajar Maulana',    'email' => 'fajar@gmail.com',    'no_telp' => '+6281234500007', 'password' => 'Customer1#'],
        ];

        foreach ($customers as $customer) {
            if (!User::where('email', $customer['email'])->exists()) {
                User::create([
                    'nama_lengkap' => $customer['nama_lengkap'],
                    'email'        => $customer['email'],
                    'no_telp'      => $customer['no_telp'],
                    'password'     => Hash::make($customer['password']),
                    'role'         => 'customer',
                ]);
            }
        }
    }
}