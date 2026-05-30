<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kebijakan;
use Illuminate\Http\Request;

class KebijakanController extends Controller
{
    public function index()
    {
        $pembatalan = Kebijakan::where('tipe', 'pembatalan')->first();

        $pengembalianDana = Kebijakan::where(
            'tipe',
            'pengembalian_dana'
        )->first();

        $syaratKetentuan = Kebijakan::where(
            'tipe',
            'syarat_ketentuan_umum'
        )->first();

        return view('superadmin.kebijakan.index', compact(
            'pembatalan',
            'pengembalianDana',
            'syaratKetentuan'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'pembatalan' => 'nullable|string',
            'pengembalian_dana' => 'nullable|string',
            'syarat_ketentuan_umum' => 'nullable|string',
        ]);

        Kebijakan::updateOrCreate(
            ['tipe' => 'pembatalan'],
            [
                'judul' => 'Syarat Pembatalan',
                'isi' => $request->pembatalan,
                'status' => 'aktif',
                'dibuat_oleh' => auth()->user()->user_id,
            ]
        );

        Kebijakan::updateOrCreate(
            ['tipe' => 'pengembalian_dana'],
            [
                'judul' => 'Kebijakan Pengembalian Dana',
                'isi' => $request->pengembalian_dana,
                'status' => 'aktif',
                'dibuat_oleh' => auth()->user()->user_id,
            ]
        );

        Kebijakan::updateOrCreate(
            ['tipe' => 'syarat_ketentuan_umum'],
            [
                'judul' => 'Syarat dan Ketentuan Umum',
                'isi' => $request->syarat_ketentuan_umum,
                'status' => 'aktif',
                'dibuat_oleh' => auth()->user()->user_id,
            ]
        );

        return redirect()
            ->route('superadmin.kebijakan.index')
            ->with('success', 'Kebijakan berhasil disimpan.');
    }
}