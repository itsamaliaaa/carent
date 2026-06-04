<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('customer.profil.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        // UPLOAD FOTO PROFILE
        if($request->hasFile('foto_profile')){

            $path = $request->file('foto_profile')
                ->store('foto-profile', 'public');

            $user->foto_profile = $path;
        }

        // UPDATE DATA
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telp = $request->no_telepon;

        $user->save();

        return redirect()->back()->with('success', true);
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('password', [
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {

            return redirect()->back()
                ->withErrors([
                    'password_lama' => 'Password lama salah'
                ], 'password');
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->back()->with('success_password', true);
    }
}