<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->id();
        $rental = Rental::where('admin_id', $adminId)->first();

        if (!$rental) {
            abort(403, 'Rental tidak ditemukan');
        }

        $today = Carbon::today();

        // Helper
        $queryPembayaran = Pembayaran::whereHas('booking', function ($q) use ($rental) {
            $q->where('rental_id', $rental->rental_id);
        })->where('status_pembayaran', 'lunas');

        $pendapatanHariIni = (clone $queryPembayaran)->whereDate('tanggal_bayar', $today)->sum('jumlah_bayar');
        $pendapatanBulanIni = (clone $queryPembayaran)->whereMonth('tanggal_bayar', now()->month)->whereYear('tanggal_bayar', now()->year)->sum('jumlah_bayar');
        $pendapatanKeseluruhan = (clone $queryPembayaran)->sum('jumlah_bayar');

        // Transaksi berhasil
        $transaksiBerhasil = Booking::where('rental_id', $rental->rental_id)
            ->where('status_booking', 'selesai')
            ->count();

        // Top 5 mobil paling laris
        $topMobil = DB::table('mobil')
            ->join('booking', 'mobil.mobil_id', '=', 'booking.mobil_id')
            ->leftJoin('foto_mobil', function ($join) {
                $join->on('mobil.mobil_id', '=', 'foto_mobil.mobil_id')
                    ->where('foto_mobil.is_primary', '=', 1);
            })
            ->where('booking.rental_id', $rental->rental_id)
            ->where('booking.status_booking', 'selesai')
            ->select(
                'mobil.nama_mobil',
                'foto_mobil.url_foto',
                DB::raw('COUNT(booking.booking_id) as total_booking')
            )
            ->groupBy('mobil.mobil_id', 'mobil.nama_mobil', 'foto_mobil.url_foto')
            ->orderByDesc('total_booking')
            ->limit(5)
            ->get();

        // Penyewaan per mobil bulan ini
        $penyewaanPerMobil = DB::table('mobil')
            ->join('booking', 'mobil.mobil_id', '=', 'booking.mobil_id')
            ->where('booking.rental_id', $rental->rental_id)
            ->where('booking.status_booking', 'selesai')
            ->whereMonth('booking.created_at', now()->month)
            ->whereYear('booking.created_at', now()->year)
            ->select('mobil.nama_mobil', DB::raw('COUNT(booking.booking_id) as total_booking'))
            ->groupBy('mobil.mobil_id', 'mobil.nama_mobil')
            ->orderByDesc('total_booking')
            ->get();

        // Filter pendapatan berdasarkan tanggal
        $pendapatanFilter = 0; 
        $jumlahTransaksiFilter = 0;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $pendapatanFilter = (clone $queryPembayaran)
                ->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date])
                ->sum('jumlah_bayar');

            $jumlahTransaksiFilter = (clone $queryPembayaran)
                ->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date])
                ->count();
        }

        $displayPeriodeStr = ($request->filled('start_date') && $request->filled('end_date'))
            ? $request->start_date . ' s/d ' . $request->end_date
            : 'Pilih periode';

        $displayRata = $jumlahTransaksiFilter > 0
            ? $pendapatanFilter / $jumlahTransaksiFilter
            : 0;

        return view('admin.dashboard', compact(
            'rental',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanKeseluruhan',
            'transaksiBerhasil',
            'topMobil',
            'penyewaanPerMobil',
            'pendapatanFilter',
            'jumlahTransaksiFilter',
            'displayPeriodeStr',
            'displayRata' 
        ));
    }
}
