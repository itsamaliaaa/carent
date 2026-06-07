<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kebijakan;
use Illuminate\Http\Request;

class KebijakanController extends Controller
{
    public function index()
    {
        $pembatalan       = Kebijakan::where('tipe', 'pembatalan')->first();
        $pengembalianDana = Kebijakan::where('tipe', 'pengembalian_dana')->first();
        $syaratKetentuan  = Kebijakan::where('tipe', 'syarat_ketentuan_umum')->first();

        return view('superadmin.kebijakan.index', compact(
            'pembatalan',
            'pengembalianDana',
            'syaratKetentuan'
        ));
    }

    public function save(Request $request)
    {
        $fields = [
            'pembatalan'            => 'Syarat Pembatalan',
            'pengembalian_dana'     => 'Kebijakan Pengembalian Dana',
            'syarat_ketentuan_umum' => 'Syarat dan Ketentuan Umum',
        ];

        foreach ($fields as $tipe => $judul) {
            $isi = implode("\n", array_filter(
                array_map('trim', $request->input($tipe, []))
            ));

            Kebijakan::updateOrCreate(
                ['tipe' => $tipe],
                [
                    'judul'       => $judul,
                    'isi'         => $isi,
                    'status'      => 'aktif',
                    'dibuat_oleh' => auth()->user()->user_id,
                ]
            );
        }

        return redirect()
            ->route('superadmin.kebijakan.index')
            ->with('kebijakan_success', true);
    }
}