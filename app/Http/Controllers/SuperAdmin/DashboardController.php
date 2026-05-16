<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\User;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransaksi  = Booking::where('status_booking', 'selesai')->count();
        $totalRental     = Rental::where('status', 'aktif')->count();
        $totalPendapatan = 
        $totalUser       = User::where('role', 'customer')->count();

        // Daftar rental dengan pendapatan
        $daftarRental = Rental::withCount('bookings')
            ->with(['bookings.pembayaran'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($rental) {
                $rental->total_pendapatan = $rental->bookings->sum(function ($booking) {
                    return optional($booking->pembayaran)->jumlah_bayar ?? 0;
                });
                return $rental;
            });

        return view('superadmin.dashboard', compact(
            'totalTransaksi',
            'totalRental',
            'totalPendapatan',
            'totalUser',
            'daftarRental'
        ));
    }
}