<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function beranda()
    {
        $mobilTerbaru = Mobil::with(['fotoPrimary', 'rental'])
            ->where('status', 'tersedia')
            ->latest()
            ->take(8)
            ->get();

        $rentalAktif = Rental::where('status', 'aktif')
            ->withCount('mobils')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.beranda', compact('mobilTerbaru', 'rentalAktif'));
    }
}