<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Rental;

class DriverController extends Controller
{
    public function index()
    {
        // Cari rental yang dimiliki admin yang login
        $rental = Rental::where('admin_id', auth()->id())->first();

        // Ambil driver khusus milik rental tersebut
        $drivers = $rental ? Driver::where('rental_id', $rental->rental_id)->get() : collect();

        return view('admin.driver.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver' => 'required',
            'umur' => 'required|numeric',
            'foto' => 'required|image|max:2048',
            'tarif_harian' => 'required|numeric',
        ]);

        $rental = Rental::where('admin_id', auth()->id())->first();

        if (!$rental) {
            return redirect()->back()->with('error', 'Data rental tidak ditemukan!');
        }

        $lokasiFoto = $request->file('foto')->store('drivers', 'public');

        Driver::create([
            'nama_driver' => $request->nama_driver,
            'umur'        => $request->umur,
            'foto'        => $lokasiFoto,
            'tarif_harian'=> $request->tarif_harian,
            'status'      => 'tersedia',
            'rental_id'   => $rental->rental_id,
        ]);

        return redirect()->back()->with('success', 'Driver berhasil ditambahkan');
    }
}