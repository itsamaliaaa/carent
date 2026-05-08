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

public function index()
    {
        // 1. Fetch all cars along with their primary photos and rentals
        $mobils = Mobil::with(['fotoPrimary', 'rental'])->get();

        // 2. Return the view and pass the $mobils data to it
        return view('customer.katalog', compact('mobils'));
    }

    public function detail($id)
    {
        return view('customer.detail-mobil');
    }

    public function profileRental($id)
    {
        return view('customer.profil-rental');
    }
}
