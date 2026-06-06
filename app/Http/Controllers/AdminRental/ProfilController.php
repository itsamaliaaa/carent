<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Rental;
use App\Models\RekeningRental;
use Illuminate\Http\Request;


class ProfilController extends Controller
{
    public function index()
    {
        $rental = Rental::with('rekenings')
            ->where('admin_id', auth()->id())
            ->first();

        return view('admin.profil.index', compact('rental'));
    }

    public function updateRental(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();

        $request->validate([
            'nama_rental' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'google_maps' => [
                'nullable',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(maps\.app\.goo\.gl|google\.com\/maps)/'
            ],

            'deskripsi' => 'nullable|string|max:1000',
            'logo_perusahaan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_bank' => 'required|in:BSI,BRI,BNI,BCA,Mandiri',
            'atas_nama' => 'required|string|max:100',
            'nomor_rekening' => 'required|numeric',
            'qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_rental.required' => 'Nama rental wajib diisi.',
            'alamat.required' => 'Alamat rental wajib diisi.',
            'google_maps.url' => 'Link Google Maps tidak valid.',
            'atas_nama.required' => 'Atas nama wajib diisi.',
            'nomor_rekening.required' => 'Nomor rekening wajib diisi.',
            'nomor_rekening.numeric' => 'Nomor rekening hanya boleh berisi angka.',
            'nama_bank.required' => 'Silakan pilih bank.',
        ]);

        $panjangRekening = [
            'BCA' => 10,
            'BNI' => 10,
            'BSI' => 10,
            'Mandiri' => 13,
            'BRI' => 15,
        ];

        $bank = $request->nama_bank;
        $nomorRekening = $request->nomor_rekening;

        if (
            isset($panjangRekening[$bank]) &&
            strlen($nomorRekening) != $panjangRekening[$bank]
        ) {
            return back()
                ->withErrors([
                    'nomor_rekening' =>
                        "Nomor rekening {$bank} harus {$panjangRekening[$bank]} digit."
                ])
                ->withInput();
        }

        if ($request->hasFile('logo_perusahaan')) {

            $path = $request->file('logo_perusahaan')
                ->store('logo-rental', 'public');

            $rental->logo_perusahaan = $path;
        }

        $rental->nama_rental = $request->nama_rental;
        $rental->alamat = $request->alamat;
        $rental->google_maps = $request->google_maps;
        $rental->deskripsi = $request->deskripsi;

        $rental->save();

        $rekening = $rental->rekenings()->first();

            if (!$rekening) {
                $rekening = $rental->rekenings()->create([
                    'tipe' => 'transfer',
                ]);
            }

            $rekening->nama_bank = $request->nama_bank;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->nomor_rekening = $request->nomor_rekening;

            if ($request->hasFile('qris')) {

                $pathQris = $request->file('qris')
                    ->store('qris', 'public');

                $rekening->url_qris = $pathQris;
            }

            $rekening->save();

        return back()->with('success_rental', true);
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