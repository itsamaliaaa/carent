<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function beranda(Request $request)
    {
        $query = Mobil::with(['fotoPrimary', 'rental'])
            ->where('status', 'tersedia');

        // Filter lokasi
        if ($request->filled('lokasi')) {
            $query->whereHas('rental', function ($q) use ($request) {
                $q->where('kota', 'like', '%' . $request->lokasi . '%');
            });
        }

        // Filter ketersediaan berdasarkan tanggal
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {
            $query->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereIn('status_booking', ['dikonfirmasi', 'berjalan'])
                  ->where('tanggal_sewa', '<=', $request->tanggal_kembali)
                  ->where('tanggal_kembali', '>=', $request->tanggal_sewa);
            });
        }

        $mobilTerbaru = $query->latest()->take(8)->get();

        $rentalAktif = Rental::where('status', 'aktif')
            ->withCount('mobils')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.beranda', compact(
            'mobilTerbaru',
            'rentalAktif'
        ));
    }

    public function index(Request $request)
    {
        $query = Mobil::with(['fotoPrimary', 'rental'])
            ->where('status', 'tersedia');

        // Filter lokasi
        if ($request->filled('lokasi')) {
            $query->whereHas('rental', function ($q) use ($request) {
                $q->where('kota', 'like', '%' . $request->lokasi . '%');
            });
        }

        // Filter ketersediaan berdasarkan tanggal
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {
            $query->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereIn('status_booking', ['dikonfirmasi', 'berjalan'])
                  ->where('tanggal_sewa', '<=', $request->tanggal_kembali)
                  ->where('tanggal_kembali', '>=', $request->tanggal_sewa);
            });
        }

        // Filter transmisi
        if ($request->filled('transmisi')) {
            $query->where('transmisi', $request->transmisi);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter kapasitas
        if ($request->filled('kapasitas')) {
            $query->where('kapasitas_penumpang', '>=', $request->kapasitas);
        }

        // Filter harga
        if ($request->filled('harga_min')) {
            $query->where('harga_per_hari', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_hari', '<=', $request->harga_max);
        }

        // Pencarian nama mobil
        if ($request->filled('cari')) {
            $query->where('nama_mobil', 'like', '%' . $request->cari . '%');
        }

        $mobils = $query->latest()->paginate(12)->withQueryString();

        return view('customer.katalog', compact('mobils'));
    }
}