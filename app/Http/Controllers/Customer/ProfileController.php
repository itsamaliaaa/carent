<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Rental;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index()
    {
        $rental = Rental::with('rekenings')
            ->where('admin_id', auth()->id())
            ->first();

        return view('admin.profil.index', compact('rental'));
    }

    public function update(Request $request)
    {
        $request->validateWithBag('profile', [
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'nama_lengkap.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
        ]);

        $user = auth()->user();

        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('foto-profile', 'public');
            $user->foto_profile = $path;
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telp = $request->no_telepon;

        $user->save();

        return back()->with('success', true);
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('password', [
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama salah'])
                ->withInput()
                ->with('open_password_modal', true);
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return back()->with('success_password', true);
    }
}