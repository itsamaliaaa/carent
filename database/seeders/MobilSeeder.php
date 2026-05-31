<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobil;
use App\Models\FotoMobil;

class MobilSeeder extends Seeder
{
    public function run(): void
    {

        // Toyota Avanza 2023
        $mobil1 = Mobil::create([
            'rental_id'           => 1,
            'nama_mobil'          => 'Toyota Avanza',
            'tahun'               => 2023,
            'transmisi'           => 'manual',
            'kategori'            => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 350000,
            'biaya_admin'         => 25000,
            'biaya_over_km'       => 3000,
            'batas_km_per_hari'   => 200,
            'deskripsi'           => 'Toyota Avanza 2023 merupakan pilihan ideal untuk perjalanan keluarga maupun kebutuhan harian. Dikenal sebagai mobil yang nyaman dan efisien, Avanza hadir dengan desain modern serta kabin yang luas sehingga memberikan pengalaman berkendara yang menyenangkan.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil1->mobil_id,
            'url_foto'   => 'uploads/mobil/toyota-avanza-2023.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        FotoMobil::create([
            'mobil_id' => 1,
            'url_foto' => 'uploads/mobil/toyota-avanza-2023(1).png',
            'is_primary' => false
        ]);

        FotoMobil::create([
            'mobil_id' => 1,
            'url_foto' => 'uploads/mobil/toyota-avanza-2023(2).png',
            'is_primary' => false
        ]);

        FotoMobil::create([
            'mobil_id' => 1,
            'url_foto' => 'uploads/mobil/toyota-avanza-2023(3).png',
            'is_primary' => false
        ]);

        // Daihatsu Xenia 2023
        $mobil2 = Mobil::create([
            'rental_id'           => 2,
            'nama_mobil'          => 'Daihatsu Xenia',
            'tahun'               => 2023,
            'transmisi'           => 'matic',
            'kategori'            => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 375000,
            'biaya_admin'         => 25000,
            'biaya_over_km'       => 3000,
            'batas_km_per_hari'   => 200,
            'deskripsi'           => 'Mobil keluarga terbaru dengan interior luas.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil2->mobil_id,
            'url_foto'   => 'uploads/mobil/daihatsu-xenia-2023.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Toyota Innova Reborn 2023
        $mobil3 = Mobil::create([
            'rental_id'           => 1,
            'nama_mobil'          => 'Toyota Innova Reborn',
            'tahun'               => 2023,
            'transmisi'           => 'matic',
            'kategori'            => 'keluarga',
            'kapasitas_penumpang' => 7,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 550000,
            'biaya_admin'         => 30000,
            'biaya_over_km'       => 4000,
            'batas_km_per_hari'   => 250,
            'deskripsi'           => 'Mobil premium keluarga yang nyaman untuk perjalanan jauh.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil3->mobil_id,
            'url_foto'   => 'uploads/mobil/toyota-innova-reborn.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);


        // Honda Brio 2022
        $mobil4 = Mobil::create([
            'rental_id'           => 1,
            'nama_mobil'          => 'Honda Brio',
            'tahun'               => 2022,
            'transmisi'           => 'matic',
            'kategori'            => 'harian',
            'kapasitas_penumpang' => 5,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 300000,
            'biaya_admin'         => 20000,
            'biaya_over_km'       => 3000,
            'batas_km_per_hari'   => 200,
            'deskripsi'           => 'Mobil compact dan irit untuk penggunaan harian.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil4->mobil_id,
            'url_foto'   => 'uploads/mobil/honda-brio-2022.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Toyota Agya 2021
        $mobil5 = Mobil::create([
            'rental_id'           => 2,
            'nama_mobil'          => 'Toyota Agya',
            'tahun'               => 2021,
            'transmisi'           => 'matic',
            'kategori'            => 'harian',
            'kapasitas_penumpang' => 5,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 280000,
            'biaya_admin'         => 20000,
            'biaya_over_km'       => 3000,
            'batas_km_per_hari'   => 200,
            'deskripsi'           => 'Mobil kecil praktis untuk perjalanan dalam kota.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil5->mobil_id,
            'url_foto'   => 'uploads/mobil/toyota-agya-2021.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Daihatsu Ayla 2022
        $mobil6 = Mobil::create([
            'rental_id'           => 2,
            'nama_mobil'          => 'Daihatsu Ayla',
            'tahun'               => 2022,
            'transmisi'           => 'matic',
            'kategori'            => 'harian',
            'kapasitas_penumpang' => 5,
            'jenis_bahan_bakar'   => 'bensin',
            'harga_per_hari'      => 275000,
            'biaya_admin'         => 20000,
            'biaya_over_km'       => 3000,
            'batas_km_per_hari'   => 200,
            'deskripsi'           => 'Mobil ekonomis dan nyaman untuk kebutuhan harian.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil6->mobil_id,
            'url_foto'   => 'uploads/mobil/daihatsu-ayla-2022.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Toyota Hiace Commuter
        $mobil7 = Mobil::create([
            'rental_id'           => 1,
            'nama_mobil'          => 'Toyota Hiace Commuter',
            'tahun'               => 2023,
            'transmisi'           => 'manual',
            'kategori'            => 'rombongan',
            'kapasitas_penumpang' => 15,
            'jenis_bahan_bakar'   => 'solar',
            'harga_per_hari'      => 950000,
            'biaya_admin'         => 50000,
            'biaya_over_km'       => 5000,
            'batas_km_per_hari'   => 300,
            'deskripsi'           => 'Mobil rombongan nyaman untuk wisata keluarga.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil7->mobil_id,
            'url_foto'   => 'uploads/mobil/toyota-hiace-commuter.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Isuzu Elf Long
        $mobil8 = Mobil::create([
            'rental_id'           => 2,
            'nama_mobil'          => 'Isuzu Elf Long',
            'tahun'               => 2022,
            'transmisi'           => 'manual',
            'kategori'            => 'rombongan',
            'kapasitas_penumpang' => 19,
            'jenis_bahan_bakar'   => 'solar',
            'harga_per_hari'      => 1200000,
            'biaya_admin'         => 60000,
            'biaya_over_km'       => 6000,
            'batas_km_per_hari'   => 350,
            'deskripsi'           => 'Kapasitas besar untuk kebutuhan rombongan.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil8->mobil_id,
            'url_foto'   => 'uploads/mobil/isuzu-elf-long.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);

        // Toyota Hiace Premio
        $mobil9 = Mobil::create([
            'rental_id'           => 2,
            'nama_mobil'          => 'Toyota Hiace Premio',
            'tahun'               => 2023,
            'transmisi'           => 'manual',
            'kategori'            => 'rombongan',
            'kapasitas_penumpang' => 14,
            'jenis_bahan_bakar'   => 'solar',
            'harga_per_hari'      => 1100000,
            'biaya_admin'         => 50000,
            'biaya_over_km'       => 6000,
            'batas_km_per_hari'   => 300,
            'deskripsi'           => 'Hiace premium dengan kabin lebih nyaman.',
            'status'              => 'tersedia',
        ]);

        FotoMobil::create([
            'mobil_id'   => $mobil9->mobil_id,
            'url_foto'   => 'uploads/mobil/toyota-hiace-premio.png',
            'is_primary' => true,
            'urutan'     => 1,
        ]);
    }
}