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

        // FILTER LOKASI
        if ($request->filled('lokasi')) {
            $query->whereHas('rental', function ($q) use ($request) {
                $q->where('kota', 'like', '%' . $request->lokasi . '%');
            });
        }

        // FILTER KETERSEDIAAN
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {

            $query->whereDoesntHave('bookings', function ($q) use ($request) {

                $q->whereIn('status_booking', ['menunggu', 'dikonfirmasi', 'berjalan'])

                    ->where(function ($query) use ($request) {

                        $query->whereBetween('tanggal_sewa', [
                            $request->tanggal_sewa,
                            $request->tanggal_kembali
                        ])

                        ->orWhereBetween('tanggal_kembali', [
                            $request->tanggal_sewa,
                            $request->tanggal_kembali
                        ])

                        ->orWhere(function ($q2) use ($request) {

                            $q2->where('tanggal_sewa', '<=', $request->tanggal_sewa)
                            ->where('tanggal_kembali', '>=', $request->tanggal_kembali);
                        });
                    });
            });
        }

        // CEK APAKAH SEDANG SEARCH
        $isSearch = $request->filled('lokasi')
            || $request->filled('tanggal_sewa')
            || $request->filled('tanggal_kembali');

        // HASIL SEARCH
        $mobilTersedia = [];

        if ($isSearch) {
            $mobilTersedia = $query->latest()->get();
        }

        // DATA DEFAULT BERANDA
        $mobilKeluarga = Mobil::with('fotoPrimary')
            ->where('kategori', 'keluarga')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        $mobilHarian = Mobil::with('fotoPrimary')
            ->where('kategori', 'harian')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        $mobilRombongan = Mobil::with('fotoPrimary')
            ->where('kategori', 'rombongan')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        $rentalAktif = Rental::where('status', 'aktif')
            ->take(4)
            ->get();

        return view('customer.beranda', compact(
            'mobilKeluarga',
            'mobilHarian',
            'mobilRombongan',
            'mobilTersedia',
            'isSearch',
            'rentalAktif'
        ));
    }

    public function index(Request $request)
    {
        $query = Mobil::with(['fotoPrimary', 'rental'])
            ->where('status', 'tersedia');

        // FILTER LOKASI
        if ($request->filled('lokasi')) {

            $query->whereHas('rental', function ($q) use ($request) {

                $q->where('kota', 'like', '%' . $request->lokasi . '%');

            });

        }

        // FILTER TANGGAL
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {

            $query->whereDoesntHave('bookings', function ($q) use ($request) {

                $q->whereIn('status_booking', ['menunggu', 'dikonfirmasi', 'berjalan'])

                    ->where(function ($query) use ($request) {

                        $query->whereBetween('tanggal_sewa', [
                            $request->tanggal_sewa,
                            $request->tanggal_kembali
                        ])

                        ->orWhereBetween('tanggal_kembali', [
                            $request->tanggal_sewa,
                            $request->tanggal_kembali
                        ])

                        ->orWhere(function ($q2) use ($request) {

                            $q2->where('tanggal_sewa', '<=', $request->tanggal_sewa)
                                ->where('tanggal_kembali', '>=', $request->tanggal_kembali);
                        });
                    });

            });

        }

        // FILTER TRANSMISI
        if ($request->filled('transmisi')) {

            $query->where('transmisi', $request->transmisi);

        }

        // FILTER KATEGORI
        if ($request->filled('kategori')) {

            $query->where('kategori', $request->kategori);

        }

        // FILTER KAPASITAS
        if ($request->filled('kapasitas')) {

            $query->where('kapasitas_penumpang', '>=', $request->kapasitas);

        }

        // SEARCH MOBIL
        if ($request->filled('cari')) {

            $query->where('nama_mobil', 'like', '%' . $request->cari . '%');

        }

        // CEK APAKAH SEDANG SEARCH
        $isSearch =
            $request->filled('lokasi') ||
            $request->filled('tanggal_sewa') ||
            $request->filled('tanggal_kembali') ||
            $request->filled('kategori') ||
            $request->filled('transmisi') ||
            $request->filled('kapasitas') ||
            $request->filled('cari');

        // HASIL SEARCH
        $mobilTersedia = [];

        if ($isSearch) {

            $mobilTersedia = $query->latest()->get();

        }

        // SECTION DEFAULT
        $mobilKeluarga = Mobil::with('fotoPrimary')
            ->where('kategori', 'keluarga')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        $mobilHarian = Mobil::with('fotoPrimary')
            ->where('kategori', 'harian')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        $mobilRombongan = Mobil::with('fotoPrimary')
            ->where('kategori', 'rombongan')
            ->where('status', 'tersedia')
            ->take(3)
            ->get();

        return view('customer.katalog', compact(
            'mobilKeluarga',
            'mobilHarian',
            'mobilRombongan',
            'mobilTersedia',
            'isSearch'
        ));
    }

    public function detail($id)
    {
        $mobil = Mobil::with([
            'fotoPrimary',
            'fotos',
            'rental'
        ])->findOrFail($id);

        // REVIEW DARI DATABASE
        $reviews = \DB::table('review')
            ->join('users', 'review.user_id', '=', 'users.user_id')
            ->join('booking', 'review.booking_id', '=', 'booking.booking_id')
            ->select(
                'review.*',
                'users.email'
            )
            ->where('booking.mobil_id', $mobil->mobil_id)
            ->where('review.status_tampilkan', true)
            ->latest('review.tanggal_posting')
            ->get();
        $averageRating = $reviews->avg('rating');

        // MOBIL TERKAIT
        $mobilTerkait = Mobil::with('fotoPrimary')
            ->where('kategori', $mobil->kategori)
            ->where('mobil_id', '!=', $mobil->mobil_id)
            ->take(3)
            ->get();

        return view('customer.detail-mobil', compact(
            'mobil',
            'reviews',
            'mobilTerkait'
        ));
    }

    public function profileRental(Request $request, $id)
    {
        $rental = Rental::with('mobils')->findOrFail($id);

        $query = Mobil::with('fotoPrimary')
            ->where('rental_id', $id)
            ->where('status', 'tersedia');

        if ($request->filled('cari')) {
            $query->where('nama_mobil', 'like', '%' . $request->cari . '%');
        }

        $mobils = $query->paginate(9);

        $rating = round($rental->rating_rata_rata ?? 0, 1);

        $totalTrip = $rental->bookings()
            ->where('status_booking', 'selesai')
            ->count();

        $totalMobil = $rental->mobils()
            ->where('status', 'tersedia')
            ->count();

        return view('customer.profil-rental', compact(
            'rental',
            'mobils',
            'rating',
            'totalTrip',
            'totalMobil'
        ));
    }
}
