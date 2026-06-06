<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();
        $query = Driver::where('rental_id', $rental ? $rental->rental_id : 0);

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_driver', 'like', '%' . $keyword . '%')
                    ->orWhere('umur', 'like', '%' . $keyword . '%')
                    ->orWhere('tarif_harian', 'like', '%' . $keyword . '%')
                    ->orWhere('status', 'like', '%' . $keyword . '%');
            });
        }

        $drivers = $query->paginate(3)->withQueryString();

        return view('admin.driver.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'nama_driver' => 'required',
            'umur' => 'required|numeric',
            'foto' => 'required|image|max:2048',
            'no_telepon' => 'required|regex:/^[+]?[0-9\s\-]+$/',
            'tarif_harian' => 'required|numeric'
        ]);

        // Cari data rental milik admin yang sedang login
        $rental = Rental::where('admin_id', auth()->id())->first();

        // Kalau rental tidak ditemukan
        if (!$rental) {
            return redirect()->back()->with('error', 'Data rental tidak ditemukan!');
        }

        // Upload foto ke folder drivers
        $lokasiFoto = $request->file('foto')->store('drivers', 'public');

        // Simpan data driver ke database
        Driver::create([
            'nama_driver' => $request->nama_driver,
            'umur'         => $request->umur,
            'foto'         => $lokasiFoto,
            'no_telepon'  => $request->no_telepon,
            'tarif_harian' => $request->tarif_harian,
            'status'      => 'tersedia',
            'rental_id'   => $rental->rental_id,
        ]);

        // Kalau rental berhasil ditambahkan
        return redirect()->back()->with('success', 'Driver berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Cari driver berdasarkan id
        $driver = Driver::find($id);

        if ($request->hasFile('foto')) {
            // Kalau ada foto baru, hapus foto lama lalu upload yang baru
            $path = $request->file('foto')->store('drivers');
            $driver->foto = $path;
        }

        $request->validate([
            'nama_driver' => 'required',
            'umur' => 'required|numeric',
            'foto' => 'nullable|image|max:2048',
            'no_telepon' => 'required|regex:/^[+]?[0-9\s\-]+$/',
            'tarif_harian' => 'required|numeric',
            'status' => 'required'
        ]);

        // Update data driver
        $driver->nama_driver = $request->nama_driver;
        $driver->umur = $request->umur;
        $driver->no_telepon = $request->no_telepon;
        $driver->tarif_harian = $request->tarif_harian;
        $driver->status = $request->status;

        $driver->save();

        return redirect()->back()->with('success', 'Data driver berhasil diperbarui');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        // Hapus foto
        if ($driver->foto) {
            Storage::disk('public')->delete($driver->foto);
        }

        // Hapus data driver
        $driver->delete();

        return redirect()->back()->with('success', 'Driver berhasil dihapus');
    }
}
