<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('admin')->latest()->get();
        return view('superadmin.rental.index', compact('rentals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rental' => 'required|string',
            'email'       => 'required|email|unique:users,email',
            'nama_admin'  => 'required|string',
            'no_telp'     => 'required',
            'password'    => 'required|min:8',
            'alamat'      => 'required',
            'kota'        => 'required',
        ]);

        // Buat akun admin rental
        $admin = User::create([
            'nama_lengkap' => $request->nama_admin,
            'email'        => $request->email,
            'no_telp'      => $request->no_telp,
            'password'     => Hash::make($request->password),
            'role'         => 'admin_rental',
        ]);

        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo_perusahaan')) {
            $logoPath = $request->file('logo_perusahaan')->store('logo_rental', 'public');
        }

        Rental::create([
            'admin_id'        => $admin->user_id,
            'nama_rental'     => $request->nama_rental,
            'email'           => $request->email,
            'no_telp'         => $request->no_telp,
            'alamat'          => $request->alamat,
            'kota'            => $request->kota,
            'deskripsi'       => $request->deskripsi,
            'logo_perusahaan' => $logoPath,
            'status'          => 'aktif',
        ]);

        return redirect()->route('superadmin.rental.index')
            ->with('success', 'Rental berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $rental->update($request->only('nama_rental', 'email', 'no_telp', 'alamat', 'kota', 'deskripsi'));

        if ($request->hasFile('logo_perusahaan')) {
            if ($rental->logo_perusahaan) {
                Storage::disk('public')->delete($rental->logo_perusahaan);
            }
            $rental->logo_perusahaan = $request->file('logo_perusahaan')->store('logo_rental', 'public');
            $rental->save();
        }

        return redirect()->route('superadmin.rental.index')
            ->with('success', 'Rental berhasil diupdate.');
    }

    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        if ($rental->logo_perusahaan) {
            Storage::disk('public')->delete($rental->logo_perusahaan);
        }
        $rental->delete();

        return redirect()->route('superadmin.rental.index')
            ->with('success', 'Rental berhasil dihapus.');
    }
}