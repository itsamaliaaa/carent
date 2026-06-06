<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\FotoMobil;
use App\Models\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();

        $query = Mobil::with(['fotoPrimary', 'rental'])
            ->where('rental_id', $rental ? $rental->rental_id : 0);

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_mobil', 'like', '%' . $keyword . '%')
                    ->orWhere('transmisi', 'like', '%' . $keyword . '%')
                    ->orWhere('kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('tahun', 'like', '%' . $keyword . '%')
                    ->orWhere('status', 'like', '%' . $keyword . '%');
            });
        }

        $mobils = $query->paginate(3);

        return view('admin.mobil.index', compact('mobils'));
    }

    public function create()
    {
        $rental = Rental::where('admin_id', auth()->id())->first();

        $drivers = Driver::where('rental_id', $rental ? $rental->rental_id : 0)
            ->where('status', 'tersedia')
            ->get();

        return view('admin.mobil.tambah', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil'    => 'required|string',
            'tahun'         => 'required|digits:4',
            'transmisi'     => 'required|in:Manual,Matic',
            'sewa_dasar'    => 'required|numeric',
            'status'        => 'required|in:Tersedia,Tidak Tersedia',
            'foto'          => 'required|array|min:1',
            'batas_km'      => 'nullable|numeric',
            'kapasitas'     => 'nullable|numeric',
            'asuransi'      => 'nullable|in:Termasuk,Tidak Termasuk',
            'detail'        => 'nullable|string',
            'biaya_over_km' => 'nullable|numeric',
            'bahan_bakar'   => 'nullable|string',
            'prasayarat'    => 'nullable|string',
            'driver'        => 'nullable|numeric',
            'prasayarat'    => 'nullable|string'
        ]);

        $rental = Rental::where('admin_id', auth()->id())->first();

        DB::transaction(function () use ($request, $rental) {
            $mobil = Mobil::create([
                'rental_id'           => $rental->rental_id,
                'nama_mobil'          => $request->nama_mobil,
                'tahun'               => $request->tahun,
                'transmisi'           => $request->transmisi,
                'harga_per_hari'      => $request->sewa_dasar,
                'status'              => $request->status,
                'kapasitas_penumpang' => $request->kapasitas,
                'batas_km_per_hari'   => $request->batas_km,      
                'deskripsi'           => $request->detail,         
                'prasyarat_kendaraan' => $request->prasayarat,     
                'jenis_bahan_bakar'   => $request->bahan_bakar,    
                'biaya_over_km'       => $request->biaya_over_km,  
                'asuransi'            => $request->asuransi,       
                'tarif_driver'        => $request->driver,   
                'prasyarat_kendaraan' => $request->prasayarat    
            ]);

            foreach ($request->file('foto') as $index => $foto) {
                $path = $foto->store('mobil', 'public');
                FotoMobil::create([
                    'mobil_id'   => $mobil->mobil_id,
                    'url_foto'   => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        });

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil ditambahkan');
    }

    public function edit($id)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();
        $mobil  = Mobil::with('fotos')->where('rental_id', $rental->rental_id)->findOrFail($id);

        return view('admin.mobil.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mobil'    => 'required|string',
            'tahun'         => 'required|digits:4',
            'status'        => 'required|in:Tersedia,Tidak Tersedia',
            'transmisi'     => 'required|in:Manual,Matic',
            'sewa_dasar'    => 'required|numeric',
            'batas_km'      => 'required|numeric',
            'kapasitas'     => 'required|numeric',
            'asuransi'      => 'required|in:Termasuk,Tidak Termasuk',
            'driver'        => 'nullable|string',
            'prasayarat'    => 'nullable|string',
            'detail'        => 'nullable|string',
            'biaya_over_km' => 'nullable|numeric',
            'bahan_bakar'   => 'nullable|string',
            'prasayarat'    => 'nullable|string'
        ]);

        $rental = Rental::where('admin_id', auth()->id())->first();
        $mobil  = Mobil::where('rental_id', $rental->rental_id)->findOrFail($id);

        $mobil->update([
            'nama_mobil'          => $request->nama_mobil,
            'tahun'               => $request->tahun,
            'transmisi'           => $request->transmisi,
            'harga_per_hari'      => $request->sewa_dasar,
            'status'              => $request->status,
            'kapasitas_penumpang' => $request->kapasitas,
            'batas_km_per_hari'   => $request->batas_km,
            'deskripsi'           => $request->detail,
            'prasyarat_kendaraan' => $request->prasayarat,
            'jenis_bahan_bakar'   => $request->bahan_bakar,
            'biaya_over_km'       => $request->biaya_over_km,
            'asuransi'            => $request->asuransi,
            'tarif_driver'        => $request->driver,
            'prasyarat_kendaraan' => $request->prasayarat
        ]);
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();
        $mobil  = Mobil::where('rental_id', $rental->rental_id)->findOrFail($id);

        foreach ($mobil->fotos as $foto) {
            Storage::disk('public')->delete($foto->url_foto);
        }

        $mobil->delete();
        return redirect()->back()->with('success', 'Mobil berhasil dihapus');
    }
}
