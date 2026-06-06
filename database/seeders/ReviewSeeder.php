<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $existing = DB::table('booking')->first();

        if (!$existing) {
            $this->command->warn('Tidak ada data booking. Seeder dibatalkan.');
            return;
        }

        $komentar = [
            ['rating' => 5, 'status' => 1, 'komen' => 'Mobilnya sangat bersih dan terawat, pelayanan ramah dan responsif. Sangat puas!'],
            ['rating' => 4, 'status' => 1, 'komen' => 'Pengalaman sewa yang menyenangkan, mobil nyaman dan harga terjangkau.'],
            ['rating' => 5, 'status' => 0, 'komen' => 'Proses pemesanan mudah, mobil datang tepat waktu. Akan sewa lagi!'],
            ['rating' => 2, 'status' => 0, 'komen' => 'Kondisi mobil kurang memuaskan, ada beberapa goresan yang tidak dilaporkan.'],
            ['rating' => 5, 'status' => 1, 'komen' => 'Pelayanan luar biasa! Admin sangat membantu dan ramah.'],
            ['rating' => 3, 'status' => 1, 'komen' => 'Mobil AC-nya kurang dingin, tapi secara keseluruhan oke.'],
            ['rating' => 5, 'status' => 0, 'komen' => 'Sangat rekomendasikan! Mobil bersih, harga bersaing, dan proses cepat.'],
            ['rating' => 4, 'status' => 1, 'komen' => 'Pengiriman tepat waktu, kondisi mobil prima. Terima kasih!'],
        ];

        $bookingIds = [];

        // Pakai booking yang sudah ada
        $bookingIds[] = $existing->booking_id;

        // Buat 7 booking dummy tambahan dengan semua kolom wajib
        for ($i = 1; $i <= 7; $i++) {
            $prefix = 'DUMMY-' . now()->format('Ymd') . '-';
            $bookingIds[] = DB::table('booking')->insertGetId([
                'kode_booking'           => $prefix . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id'                => $existing->user_id,
                'rental_id'              => $existing->rental_id,
                'mobil_id'               => $existing->mobil_id,
                'driver_id'              => null,
                'pakai_driver'           => 0,
                'nama_pengendara'        => $existing->nama_pengendara        ?? 'Dummy User',
                'no_telp_pengendara'     => $existing->no_telp_pengendara     ?? '08000000000',
                'no_sim_pengendara'      => $existing->no_sim_pengendara      ?? '1234567890123456',
                'tgl_lahir_pengendara'   => $existing->tgl_lahir_pengendara   ?? '1990-01-01',
                'tanggal_sewa'           => $existing->tanggal_sewa           ?? now()->format('Y-m-d'),
                'tanggal_kembali'        => $existing->tanggal_kembali        ?? now()->addDays(2)->format('Y-m-d'),
                'waktu_ambil'            => $existing->waktu_ambil            ?? '08:00:00',
                'waktu_kembali'          => $existing->waktu_kembali          ?? '08:00:00',
                'lokasi_penjemputan'     => $existing->lokasi_penjemputan     ?? 'Lokasi Dummy',
                'latitude_penjemputan'   => $existing->latitude_penjemputan   ?? null,
                'longitude_penjemputan'  => $existing->longitude_penjemputan  ?? null,
                'total_harga'            => $existing->total_harga            ?? 0,
                'rincian_harga'          => $existing->rincian_harga          ?? null,
                'setuju_syarat'          => 1,
                'waktu_setuju_syarat'    => now(),
                'status_booking'         => $existing->status_booking         ?? 'selesai',
                'catatan'                => null,
                'alasan_pembatalan'      => null,
                'tanggal_pembatalan'     => null,
                'dibatalkan_oleh'        => null,
                'status_deposit'         => $existing->status_deposit         ?? null,
                'tanggal_deposit_dikembalikan' => null,
            ]);
        }

        // Insert review, satu per booking
        $reviews = [];
        foreach ($komentar as $i => $data) {
            $reviews[] = [
                'booking_id'       => $bookingIds[$i],
                'user_id'          => $existing->user_id,
                'rating'           => $data['rating'],
                'komentar'         => $data['komen'],
                'status_tampilkan' => $data['status'],
                'tanggal_posting'  => Carbon::now()->subDays(($i + 1) * 3),
            ];
        }

        DB::table('review')->insert($reviews);

        $this->command->info('8 review dummy berhasil ditambahkan.');
    }
}