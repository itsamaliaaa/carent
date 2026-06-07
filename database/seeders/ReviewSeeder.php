<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $komentar = [
            ['rating' => 5, 'status' => true,  'komen' => 'Mobilnya sangat bersih dan terawat, pelayanan ramah dan responsif. Sangat puas!'],
            ['rating' => 4, 'status' => true,  'komen' => 'Pengalaman sewa yang menyenangkan, mobil nyaman dan harga terjangkau.'],
            ['rating' => 5, 'status' => false, 'komen' => 'Proses pemesanan mudah, mobil datang tepat waktu. Akan sewa lagi!'],
            ['rating' => 2, 'status' => false, 'komen' => 'Kondisi mobil kurang memuaskan, ada beberapa goresan yang tidak dilaporkan.'],
            ['rating' => 5, 'status' => true,  'komen' => 'Pelayanan luar biasa! Admin sangat membantu dan ramah.'],
            ['rating' => 3, 'status' => true,  'komen' => 'Mobil AC-nya kurang dingin, tapi secara keseluruhan oke.'],
            ['rating' => 5, 'status' => false, 'komen' => 'Sangat rekomendasikan! Mobil bersih, harga bersaing, dan proses cepat.'],
            ['rating' => 4, 'status' => true,  'komen' => 'Pengiriman tepat waktu, kondisi mobil prima. Terima kasih!'],
        ];

        $bookings = Booking::where('status_booking', 'selesai')
            ->doesntHave('review')
            ->take(8)
            ->get();

        if ($bookings->isEmpty()) {
            $this->command->warn('Tidak ada booking selesai tanpa review. Seeder dibatalkan.');
            return;
        }

        foreach ($bookings as $i => $booking) {
            if (!isset($komentar[$i])) break;

            Review::create([
                'booking_id'       => $booking->booking_id,
                'user_id'          => $booking->user_id,
                'rating'           => $komentar[$i]['rating'],
                'komentar'         => $komentar[$i]['komen'],
                'foto_review'      => null,
                'status_tampilkan' => $komentar[$i]['status'],
                'tanggal_posting'  => Carbon::now()->subDays(($i + 1) * 3),
            ]);
        }

        $this->command->info($bookings->count() . ' review berhasil ditambahkan.');
    }
}