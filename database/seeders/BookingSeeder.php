<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $mobils    = Mobil::with('rental')->get();

        $data = [
            ['nama' => 'Miskah Indah',   'email' => 'miskah@gmail.com',  'sim' => '1234567890123456', 'tgl_lahir' => '1995-03-12', 'telp' => '+6285711223344'],
            ['nama' => 'Budi Santoso',   'email' => 'budi@gmail.com',    'sim' => '2345678901234567', 'tgl_lahir' => '1993-07-21', 'telp' => '+6281234500001'],
            ['nama' => 'Siti Rahayu',    'email' => 'siti@gmail.com',    'sim' => '3456789012345678', 'tgl_lahir' => '1997-01-05', 'telp' => '+6281234500002'],
            ['nama' => 'Andi Firmansyah','email' => 'andi@gmail.com',    'sim' => '4567890123456789', 'tgl_lahir' => '1990-11-15', 'telp' => '+6281234500003'],
            ['nama' => 'Dewi Anggraini', 'email' => 'dewi@gmail.com',    'sim' => '5678901234567890', 'tgl_lahir' => '1994-06-30', 'telp' => '+6281234500004'],
            ['nama' => 'Rizky Pratama',  'email' => 'rizky@gmail.com',   'sim' => '6789012345678901', 'tgl_lahir' => '1996-09-18', 'telp' => '+6281234500005'],
            ['nama' => 'Nurul Hidayah',  'email' => 'nurul@gmail.com',   'sim' => '7890123456789012', 'tgl_lahir' => '1998-04-22', 'telp' => '+6281234500006'],
            ['nama' => 'Fajar Maulana',  'email' => 'fajar@gmail.com',   'sim' => '8901234567890123', 'tgl_lahir' => '1992-12-10', 'telp' => '+6281234500007'],
        ];

        foreach ($data as $i => $d) {
            $user  = $customers->firstWhere('email', $d['email']);
            $mobil = $mobils[$i % $mobils->count()];

            if (!$user) continue;

            $tglSewa    = Carbon::now()->subDays(($i + 1) * 10);
            $tglKembali = $tglSewa->copy()->addDays(2);
            $jumlahHari = 2;
            $total      = ($mobil->harga_per_hari * $jumlahHari) + 200000;

            if (!Booking::where('user_id', $user->user_id)
                ->where('mobil_id', $mobil->mobil_id)
                ->exists()) {

                Booking::create([
                    'kode_booking'         => 'CAR-' . now()->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'user_id'              => $user->user_id,
                    'rental_id'            => $mobil->rental_id,
                    'mobil_id'             => $mobil->mobil_id,
                    'driver_id'            => null,
                    'pakai_driver'         => false,
                    'nama_pengendara'      => $d['nama'],
                    'no_telp_pengendara'   => $d['telp'],
                    'no_sim_pengendara'    => $d['sim'],
                    'tgl_lahir_pengendara' => $d['tgl_lahir'],
                    'tanggal_sewa'         => $tglSewa->format('Y-m-d'),
                    'tanggal_kembali'      => $tglKembali->format('Y-m-d'),
                    'waktu_ambil'          => '08:00:00',
                    'waktu_kembali'        => '08:00:00',
                    'lokasi_penjemputan'   => 'Bandung',
                    'total_harga'          => $total,
                    'setuju_syarat'        => true,
                    'waktu_setuju_syarat'  => now(),
                    'status_booking'       => 'selesai',
                ]);
            }
        }
    }
}