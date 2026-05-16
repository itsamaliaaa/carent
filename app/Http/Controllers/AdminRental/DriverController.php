<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Tampilkan daftar driver
     */
    public function index()
    {
        // Cari rental yang dimiliki admin yang login
        $rental = Rental::where('admin_id', auth()->id())->first();

        // Ambil driver milik rental 
        $drivers = $rental ? Driver::where('rental_id', $rental->rental_id)->get() : collect();

        return view('admin.driver.index', compact('drivers'));
    }

    /**
     * Simpan driver baru (Ubah dari 'lihat' ke 'store')
     */
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
            'umur'         => $request->umur,
            'foto'         => $lokasiFoto,
            'tarif_harian'=> $request->tarif_harian,
            'status'      => 'tersedia',
            'rental_id'   => $rental->rental_id,
        ]);

        return redirect()->back()->with('success', 'Driver berhasil ditambahkan');
    }

    /**
     * Perbarui data driver (Edit)
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_driver' => 'required',
            'umur' => 'required|numeric',
            'foto' => 'nullable|image|max:2048',
            'tarif_harian' => 'required|numeric',
            'status' => 'required'
        ]);

        $driver = Driver::findOrFail($id);
        
        $driver->nama_driver = $request->nama_driver;
        $driver->umur = $request->umur;
        $driver->tarif_harian = $request->tarif_harian;
        $driver->status = $request->status;

        if ($request->hasFile('foto')) {
            if ($driver->foto) {
                Storage::disk('public')->delete($driver->foto);
            }
            $driver->foto = $request->file('foto')->store('drivers', 'public');
        }

        $driver->save();

        return redirect()->back()->with('success', 'Data driver berhasil diperbarui');
    }

    /**
     * Hapus data driver (Ubah dari 'hapus' ke 'destroy')
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        if ($driver->foto) {
            Storage::disk('public')->delete($driver->foto);
        }

        $driver->delete();

        return redirect()->back()->with('success', 'Driver berhasil dihapus');
    }
}