<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // KARTU STATISTIK
        $totalTransaksi  = Booking::where('status_booking', 'selesai')->count();
        $totalRental     = Rental::where('status', 'aktif')->count();
        $totalPendapatan = Pembayaran::where('status_pembayaran', 'lunas')->sum('jumlah_bayar');
        $totalUser       = User::where('role', 'customer')->count();
        $rentalBaru      = Rental::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $userBaru        = User::where('role', 'customer')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        // Validasi tanggal
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ], [
            'dari.date'                => 'Tanggal mulai tidak valid.',
            'sampai.date'              => 'Tanggal akhir tidak valid.',
            'sampai.after_or_equal'    => 'Tanggal akhir tidak boleh lebih awal dari tanggal mulai.',
        ]);

        // FILTER LAPORAN
        $query = Rental::withCount(['bookings' => function ($q) use ($request) {
                $q->where('status_booking', 'selesai');
                if ($request->filled('dari'))   $q->whereDate('created_at', '>=', $request->dari);
                if ($request->filled('sampai')) $q->whereDate('created_at', '<=', $request->sampai);
            }])
            ->with(['bookings' => function ($q) use ($request) {
                $q->where('status_booking', 'selesai');
                if ($request->filled('dari'))   $q->whereDate('created_at', '>=', $request->dari);
                if ($request->filled('sampai')) $q->whereDate('created_at', '<=', $request->sampai);
            }, 'bookings.pembayaran']);

        if ($request->filled('rental_id')) {
            $query->where('rental_id', $request->rental_id);
        }

        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        $daftarRental = $query->paginate(10)->withQueryString();

        $daftarRental->each(function ($rental) {
            $rental->total_pendapatan = $rental->bookings->sum(function ($booking) {
                return optional($booking->pembayaran)->jumlah_bayar ?? 0;
            });
        });

        // SUMMARY KANAN
        $summaryPendapatan = $daftarRental->sum('total_pendapatan');
        $summaryTransaksi  = $daftarRental->sum('bookings_count');

        // DATA FILTER DROPDOWN
        $semuaRental = Rental::select('rental_id', 'nama_rental')->get();
        $semuaKota   = Rental::distinct()->pluck('kota');

        return view('superadmin.dashboard', compact(
            'totalTransaksi',
            'totalRental',
            'totalPendapatan',
            'totalUser',
            'rentalBaru',
            'userBaru',
            'daftarRental',
            'summaryPendapatan',
            'summaryTransaksi',
            'semuaRental',
            'semuaKota'
        ));
    }
}