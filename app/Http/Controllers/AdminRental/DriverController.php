<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    // Untuk menampilkan halaman utama driver
    public function index()
    {
        return view('admin.driver.index');
    }

    // Fungsi ini KHUSUS untuk memproses penyimpanan data dari modal
    public function store(Request $request)
    {
        // 1. Cari data rental yang dimiliki oleh admin yang sedang login
        $rental = \App\Models\Rental::where('admin_id', auth()->id())->first();

        // 2. Pastikan rental ketemu supaya tidak error null
        if (!$rental) {
            return redirect()->back()->with('error', 'Anda belum memiliki data rental!');
        }

        $lokasiFoto = $request->file('foto')->store('drivers', 'public');

        // 3. Simpan data driver
        Driver::create([
            'nama_driver' => $request->nama_driver,
            'umur'        => $request->umur,
            'foto'        => $lokasiFoto, // pastikan variabel ini sudah ada dari proses upload
            'tarif_harian' => $request->tarif_harian,
            'status'      => 'tersedia',
            'rental_id'   => $rental->rental_id, // Ambil ID dari hasil pencarian di atas
        ]);

        return redirect()->back()->with('success', 'Driver berhasil ditambahkan');
    }
}
