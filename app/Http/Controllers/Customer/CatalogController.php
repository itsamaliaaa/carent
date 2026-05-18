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
        // Berdasarkan ERD: kolom status di tabel mobil bernama 'status_ketersediaan'
        // Relasi foto di ERD bernama 'foto_mobil' (bukan fotoPrimary)
        $query = Mobil::with(['fotoMobil', 'rental'])
            ->where('status_ketersediaan', 'tersedia');

        // Filter lokasi (Berdasarkan ERD: tabel rental menggunakan kolom 'alamat', bukan 'kota')
        if ($request->filled('lokasi')) {
            $query->whereHas('rental', function ($q) use ($request) {
                $q->where('alamat', 'like', '%' . $request->lokasi . '%');
            });
        }

        // Filter ketersediaan berdasarkan tanggal booking
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {
            $query->whereDoesntHave('booking', function ($q) use ($request) {
                // Di ERD: typo 'dkonfirmasi' atau 'dikonfirmasi' disesuaikan dengan isi ENUM database
                $q->whereIn('status_booking', ['dkonfirmasi', 'berjalan'])
                  ->where('tanggal_sewa', '<=', $request->tanggal_kembali)
                  ->where('tanggal_kembali', '>=', $request->tanggal_sewa);
            });
        }

        $mobilTerbaru = $query->latest()->take(8)->get();

        // Berdasarkan ERD: Tabel rental tidak memiliki kolom status_ketersediaan.
        // Jadi kita hanya mengambil rental aktif dan menghitung jumlah mobilnya menggunakan relasi 'mobils'.
        $rentalAktif = Rental::withCount('mobils')
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
        // Menyesuaikan kolom 'status_ketersediaan' sesuai ERD
        $query = Mobil::with(['fotoMobil', 'rental'])
            ->where('status_ketersediaan', 'tersedia');

        // Filter lokasi (kolom 'alamat' di tabel rental)
        if ($request->filled('lokasi')) {
            $query->whereHas('rental', function ($q) use ($request) {
                $q->where('alamat', 'like', '%' . $request->lokasi . '%');
            });
        }

        // Filter ketersediaan berdasarkan tanggal booking
        if ($request->filled('tanggal_sewa') && $request->filled('tanggal_kembali')) {
            $query->whereDoesntHave('booking', function ($q) use ($request) {
                $q->whereIn('status_booking', ['dkonfirmasi', 'berjalan'])
                  ->where('tanggal_sewa', '<=', $request->tanggal_kembali)
                  ->where('tanggal_kembali', '>=', $request->tanggal_sewa);
            });
        }

        // Filter transmisi (ENUM di ERD: 'manual', 'matic')
        if ($request->filled('transmisi')) {
            $query->where('transmisi', $request->transmisi);
        }

        /*
           CATATAN: Filter Kategori dihapus karena di ERD tabel `mobil`
           tidak memiliki kolom `kategori`. Jika ingin dipakai, kolom `kategori`
           harus ditambahkan terlebih dahulu ke skema SQL tabel `mobil`.
        */

        // Filter kapasitas (Berdasarkan ERD: nama kolomnya 'kapasitas_penumpang')
        if ($request->filled('kapasitas')) {
            $query->where('kapasitas_penumpang', '>=', $request->kapasitas);
        }

        // Filter harga (Berdasarkan ERD: nama kolomnya 'harga_per_hari')
        if ($request->filled('harga_min')) {
            $query->where('harga_per_hari', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_hari', '<=', $request->harga_max);
        }

        // Pencarian nama mobil (Berdasarkan ERD: 'nama_mobil')
        if ($request->filled('cari')) {
            $query->where('nama_mobil', 'like', '%' . $request->cari . '%');
        }

        $mobils = $query->latest()->paginate(12)->withQueryString();

        return view('customer.katalog', compact('mobils'));
    }
}
