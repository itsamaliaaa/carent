<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Import Carbon untuk menghitung umur secara real-time

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();
        $query  = Driver::where('rental_id', $rental ? $rental->rental_id : 0);

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_driver', 'like', '%' . $keyword . '%')
                  ->orWhere('tarif_harian', 'like', '%' . $keyword . '%')
                  ->orWhere('status', 'like', '%' . $keyword . '%');
            });
        }

        $drivers = $query->paginate(3)->withQueryString();

        return view('admin.driver.index', compact('drivers'));
    }

    public function show($id)
    {
        return redirect()->route('admin.driver.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver'  => 'required|string',
            'tgl_lahir'    => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'no_telp'      => 'required|regex:/^[+]?[0-9\s\-]+$/',
            'foto'         => 'required|image|max:2048',
            'tarif_harian' => 'required|numeric|min:0',
        ], [
            'tgl_lahir.before_or_equal' => 'Driver minimal berusia 18 tahun.',
            'tgl_lahir.required'        => 'Tanggal lahir wajib diisi.',
            'no_telp.regex'             => 'Format nomor telepon tidak valid.',
        ]);

        $rental = Rental::where('admin_id', auth()->id())->first();

        if (!$rental) {
            return redirect()->back()->withErrors(['msg' => 'Rental tidak ditemukan.']);
        }

        $lokasiFoto = $request->file('foto')->store('drivers', 'public');

        // OTOMASI: Hitung umur berdasarkan tgl_lahir yang dikirim form
        $umur = Carbon::parse($request->tgl_lahir)->age;

        Driver::create([
            'nama_driver'  => $request->nama_driver,
            'tgl_lahir'    => $request->tgl_lahir,
            'umur'         => $umur, // Mengisi field 'umur' agar terhindar dari Error 1364
            'foto'         => $lokasiFoto,
            'no_telp'      => $request->no_telp,
            'tarif_harian' => $request->tarif_harian,
            'status'       => 'tersedia',
            'rental_id'    => $rental->rental_id,
            'points'       => 0, // Menginisialisasi default point awal untuk sistem Round Robin Anda
        ]);

        return redirect()->back()->with('driver_success', 'Driver berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        session()->flash('edit_error_driver_id', $id);

        $request->validate([
            'nama_driver'  => 'required|string',
            'tgl_lahir'    => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'no_telp'      => 'required|regex:/^[+]?[0-9\s\-]+$/',
            'foto'         => 'nullable|image|max:2048',
            'tarif_harian' => 'required|numeric|min:0',
            'status'       => 'required|in:tersedia,tidak_tersedia',
        ], [
            'tgl_lahir.before_or_equal' => 'Driver minimal berusia 18 tahun.',
            'tgl_lahir.required'        => 'Tanggal lahir wajib diisi.',
            'no_telp.regex'             => 'Format nomor telepon tidak valid.',
        ]);

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($driver->foto);
            $driver->foto = $request->file('foto')->store('drivers', 'public');
        }

        // OTOMASI: Hitung ulang umur jika admin mengubah tanggal lahir driver
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $driver->nama_driver  = $request->nama_driver;
        $driver->tgl_lahir    = $request->tgl_lahir;
        $driver->umur         = $umur; // Selalu sinkronkan perubahan umur
        $driver->no_telp      = $request->no_telp;
        $driver->tarif_harian = $request->tarif_harian;
        $driver->status       = $request->status;
        $driver->save();

        return redirect()->back()->with('driver_success', 'Driver berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        if ($driver->foto) {
            Storage::disk('public')->delete($driver->foto);
        }

        $driver->delete();

        return redirect()->back()->with('driver_success', 'Driver berhasil dihapus.');
    }
}
