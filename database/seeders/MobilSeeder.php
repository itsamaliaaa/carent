<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobil;
use App\Models\FotoMobil;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        // Mobil Rental 1 - Aflah Jaya
        $mobil1 = Mobil::create([
            'rental_id'          => 1,
            'nama_mobil'         => 'Toyota Avanza',
            'tahun'              => 2022,
            'transmisi'          => 'manual',
            'kategori'           => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'  => 'bensin',
            'harga_per_hari'     => 350000,
            'biaya_admin'        => 25000,
            'biaya_over_km'      => 3000,
            'batas_km_per_hari'  => 200,
            'deskripsi'          => 'Mobil keluarga nyaman dan irit bahan bakar, cocok untuk perjalanan jauh.',
            'prasyarat_kendaraan' => 'KTP, SIM A aktif, lepas kunci minimal 24 jam.',
            'status'             => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil1->mobil_id,
            'url_foto'   => 'foto_mobil/avanza.jpg',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        $mobil2 = Mobil::create([
            'rental_id'          => 1,
            'nama_mobil'         => 'Honda Jazz',
            'tahun'              => 2021,
            'transmisi'          => 'matic',
            'kategori'           => 'harian',
            'kapasitas_penumpang' => 5,
            'jenis_bahan_bakar'  => 'bensin',
            'harga_per_hari'     => 400000,
            'biaya_admin'        => 25000,
            'biaya_over_km'      => 3500,
            'batas_km_per_hari'  => 200,
            'deskripsi'          => 'Mobil city car modern dengan fitur lengkap, cocok untuk perjalanan harian.',
            'prasyarat_kendaraan' => 'KTP, Kartu Mahasiswa/Karyawan, SIM A.',
            'status'             => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil2->mobil_id,
            'url_foto'   => 'foto_mobil/jazz.jpg',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        $mobil3 = Mobil::create([
            'rental_id'          => 1,
            'nama_mobil'         => 'Toyota Hiace',
            'tahun'              => 2020,
            'transmisi'          => 'manual',
            'kategori'           => 'rombongan',
            'kapasitas_penumpang' => 15,
            'jenis_bahan_bakar'  => 'solar',
            'harga_per_hari'     => 850000,
            'biaya_admin'        => 50000,
            'biaya_over_km'      => 5000,
            'batas_km_per_hari'  => 300,
            'deskripsi'          => 'Kendaraan rombongan kapasitas besar, ideal untuk wisata grup.',
            'prasyarat_kendaraan' => 'Wajib dengan sopir dari pihak rental, KTP penanggung jawab.',
            'status'             => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil3->mobil_id,
            'url_foto'   => 'foto_mobil/hiace.jpg',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Mobil Rental 2 - Berkah Rental
        $mobil4 = Mobil::create([
            'rental_id'          => 2,
            'nama_mobil'         => 'Daihatsu Xenia',
            'tahun'              => 2023,
            'transmisi'          => 'matic',
            'kategori'           => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'  => 'bensin',
            'harga_per_hari'     => 375000,
            'biaya_admin'        => 25000,
            'biaya_over_km'      => 3000,
            'batas_km_per_hari'  => 200,
            'deskripsi'          => 'Mobil keluarga terbaru dengan interior luas dan nyaman.',
            'prasyarat_kendaraan' => 'KTP asli, SIM A, jaminan sepeda motor + STNK asli.',
            'status'             => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil4->mobil_id,
            'url_foto'   => 'foto_mobil/xenia.jpg',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        $mobil5 = Mobil::create([
            'rental_id'          => 2,
            'nama_mobil'         => 'Suzuki Ertiga',
            'tahun'              => 2022,
            'transmisi'          => 'matic',
            'kategori'           => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'  => 'bensin',
            'harga_per_hari'     => 350000,
            'biaya_admin'        => 25000,
            'biaya_over_km'      => 3000,
            'batas_km_per_hari'  => 200,
            'deskripsi'          => 'MPV stylish dengan kabin lapang dan konsumsi bahan bakar efisien.',
            'prasyarat_kendaraan' => 'KTP, SIM A, bersedia difoto bersama kendaraan saat serah terima.',
            'status'             => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil5->mobil_id,
            'url_foto'   => 'foto_mobil/ertiga.jpg',
            'is_primary' => true,
            'urutan'     => 1,
        ]);
    }
}
