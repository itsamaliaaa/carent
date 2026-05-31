@extends('layouts.customer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24">

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">

        <div class="relative w-32 h-32">

            <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">

                <circle
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#E5E7EB"
                    stroke-width="10"
                />

                <circle
                    id="progressCircle"
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#0B1F67"
                    stroke-width="10"
                    stroke-linecap="round"
                    stroke-dasharray="314"
                    stroke-dashoffset="314"
                    style="transition: stroke-dashoffset 0.3s ease"
                />

            </svg>

            <div class="absolute inset-0 flex items-center justify-center">

                <span id="progressText" class="text-2xl font-bold text-[#0B1F67]">
                    0%
                </span>

            </div>

        </div>

    </div>

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden rounded-[10px] max-w-[1258px] min-h-[520px] lg:min-h-[349px] mx-auto">

        {{-- BACKGROUND --}}
        <img
            src="{{ asset('images/banner/bg-input.png') }}"
            alt="Hero"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-black/45"></div>

        {{-- CONTENT --}}
        <div class="relative z-10 flex flex-col justify-center items-center h-full px-4 sm:px-6 py-10">

            {{-- TEXT --}}
            <div class="text-center">

                <h1 class="text-white text-2xl sm:text-3xl font-bold leading-tight text-center">
                    Temukan Mobilmu Sekarang
                </h1>

                <p class="text-white text-sm sm:text-lg font-medium leading-relaxed text-center mt-2">
                    Sewa Mobil dengan Mudah dari Berbagai Rental Terpercaya
                </p>

            </div>

            {{-- FORM --}}
            <form
                id="searchForm"
                action="{{ route('beranda') }}"
                method="GET"
                class="w-full max-w-[1174px] bg-white/80 backdrop-blur-sm mt-8 rounded-[10px] px-4 sm:px-6 py-5"
            >

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">

                    {{-- LOKASI --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Lokasi
                        </label>

                        <div class="relative">
                            <input
                                type="text"
                                name="lokasi"
                                placeholder="Pilih lokasi"
                                value="{{ request('lokasi') }}"
                                class="w-full h-12 border border-gray-300 rounded-[8px] px-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                            >

                            <img
                                src="{{ asset('images/icons/location-04.svg') }}"
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2"
                            >
                        </div>
                    </div>

                    {{-- TANGGAL SEWA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Tanggal Pengambilan
                        </label>

                        <input
                            type="date"
                            name="tanggal_sewa"
                            value="{{ request('tanggal_sewa') }}"
                            class="w-full h-12 border border-gray-300 rounded-[8px] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                        >
                    </div>

                    {{-- WAKTU --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Waktu 
                        </label>

                        <input
                            type="time"
                            name="waktu_ambil"
                            value="{{ request('waktu_ambil') }}"
                            class="w-full h-12 border border-gray-300 rounded-[8px] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                        >
                    </div>

                    {{-- TANGGAL KEMBALI --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Tanggal Pengembalian
                        </label>

                        <input
                            type="date"
                            name="tanggal_kembali"
                            value="{{ request('tanggal_kembali') }}"
                            class="w-full h-12 border border-gray-300 rounded-[8px] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                        >
                    </div>

                    {{-- WAKTU PENGEMBALIAN --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Waktu 
                        </label>

                        <input
                            type="time"
                            name="waktu_kembali"
                            value="{{ request('waktu_kembali') }}"
                            class="w-full h-12 border border-gray-300 rounded-[8px] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                        >
                    </div>

                    {{-- BUTTON --}}
                    <div class="sm:col-span-2 lg:col-span-1">
                        <button
                            type="submit"
                            class="w-full h-12 rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white font-semibold transition"
                        >
                            Cek
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </section>

    @if($isSearch)
    <section class="mt-14 lg:mt-20">

        <div class="mb-8">

            <h2 class="text-black text-2xl font-semibold leading-[36px]">
                {{ $mobilTersedia->count() }} Mobil Yang Tersedia
            </h2>

            <p class="text-[#545454] text-base font-medium leading-[28px]">
                Pilih mobil yang paling cocok buat perjalananmu
            </p>

        </div>

        @if($mobilTersedia->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

            @foreach($mobilTersedia as $mobil)

            {{-- CARD MOBIL --}}
            <a
                href="{{ route('mobil.detail', $mobil->mobil_id) }}"
                class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent"
            >
                {{-- IMAGE --}}
                <div class="relative">

                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[190px] sm:h-[210px] object-cover"
                    >

                    <div class="absolute top-4 left-4 bg-[#0B1F67] text-white text-xs font-medium px-3 py-1 rounded-full">
                        Tersedia
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="flex flex-col flex-1 p-5">

                    <h3 class="text-black text-base font-semibold leading-[28px] w-full">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h3>

                    {{-- RATING --}}
                    <div class="flex items-center gap-2 mt-2">

                        <div class="text-yellow-400 text-sm">
                            ★★★★★
                        </div>

                        <span class="text-sm font-medium text-gray-700">
                            4.9
                        </span>

                        <span class="text-sm text-gray-400">
                            (50 Ulasan)
                        </span>

                    </div>

                    {{-- INFO --}}
                    <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">

                        <span>
                            {{ ucfirst($mobil->transmisi) }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $mobil->kapasitas_penumpang }} Kursi
                        </span>

                    </div>

                    <div class="w-full h-[1px] bg-[#C1C1C1] mt-3"></div>

                    {{-- PRICE --}}
                    <div class="flex items-end justify-between mt-3">

                        <p class="text-[#545454] text-sm font-normal leading-6">
                            Mulai dari
                        </p>

                        <p class="text-[#06123A] text-base font-semibold leading-6">
                            Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                        </p>

                    </div>

                </div>
            </a>

            @endforeach

        </div>

        @else

        <div class="text-center py-20">

            <h3 class="text-xl font-semibold text-gray-700">
                Mobil tidak ditemukan
            </h3>

            <p class="text-gray-500 mt-2">
                Coba ubah lokasi atau tanggal pencarianmu
            </p>

        </div>

        @endif

    </section>

    @endif

    @if(!$isSearch)
    {{-- RENTAL TERPERCAYA --}}
    <section class="mt-14 lg:mt-20">

        <div class="text-center">

            <h2 class="text-black text-2xl font-semibold leading-[36px] text-center w-full">
                Rental Terpercaya
            </h2>

            <p class="text-[#545454] text-base font-medium leading-[28px] text-center w-full">
                Pilih dari berbagai mitra rental terbaik di platform kami
            </p>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">

            @foreach($rentalAktif as $rental)

            <div class="flex items-center justify-center">

                @if($rental->logo_perusahaan)

                    <img
                        src="{{ asset($rental->logo_perusahaan) }}"
                        alt="{{ $rental->nama_rental }}"
                        class="w-full h-full object-contain"
                    >

                @else

                    <p class="text-[#0B1F67] font-semibold text-center px-4">
                        {{ $rental->nama_rental }}
                    </p>

                @endif

            </div>

            @endforeach

        </div>

    </section>


    {{-- MOBIL KELUARGA --}}
    <section class="mt-14 lg:mt-20">

        <div class="mb-8">

            <h2 class="text-black text-2xl font-semibold leading-[36px] w-full">
                Mobil Keluarga
            </h2>

            <p class="text-[#545454] text-base font-medium leading-[28px] w-full">
                Nyaman untuk perjalanan bersama keluarga
            </p>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($mobilKeluarga as $mobil)

            <a
                href="{{ route('mobil.detail', $mobil->mobil_id) }}"
                class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent"
            >

                {{-- IMAGE --}}
                <div class="relative">

                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[190px] sm:h-[210px] object-cover"
                    >

                    <div class="absolute top-4 left-4 bg-[#0B1F67] text-white text-xs font-medium px-3 py-1 rounded-full">
                        Terlaris
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="flex flex-col flex-1 p-5">

                    <h3 class="text-black text-base font-semibold leading-[28px] w-full">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h3>

                    {{-- RATING --}}
                    <div class="flex items-center gap-2 mt-2">

                        <div class="text-yellow-400 text-sm">
                            ★★★★★
                        </div>

                        <span class="text-sm font-medium text-gray-700">
                            4.9
                        </span>

                        <span class="text-sm text-gray-400">
                            (50 Ulasan)
                        </span>

                    </div>

                    {{-- INFO --}}
                    <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">

                        <span>
                            {{ ucfirst($mobil->transmisi) }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $mobil->kapasitas_penumpang }} Kursi
                        </span>

                    </div>

                    <div class="w-full h-[1px] bg-[#C1C1C1] mt-3"></div>

                    {{-- PRICE --}}
                    <div class="flex items-end justify-between mt-3">
                        
                        <p class="text-[#545454] text-sm font-normal leading-6">
                            Mulai dari
                        </p>

                        <p class="text-[#06123A] text-base font-semibold leading-6">
                            Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                        </p>

                    </div>

                </div>
            </a>

            @endforeach

        </div>

    </section>


    {{-- MOBIL HARIAN --}}
    <section class="mt-14 lg:mt-20">

        <div class="mb-8">

            <h2 class="text-black text-2xl font-semibold leading-[36px] w-full">
                Mobil Harian
            </h2>

            <p class="text-[#545454] text-base font-medium leading-[28px] w-full">
                Praktis dan irit untuk kebutuhan sehari-hari
            </p>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($mobilHarian as $mobil)

            <a
                href="{{ route('mobil.detail', $mobil->mobil_id) }}"
                class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent"
            >

                {{-- IMAGE --}}
                <div class="relative">

                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[190px] sm:h-[210px] object-cover"
                    >

                    <div class="absolute top-4 left-4 bg-[#0B1F67] text-white text-xs font-medium px-3 py-1 rounded-full">
                        Terlaris
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="flex flex-col flex-1 p-5">

                    <h3 class="text-black text-base font-semibold leading-[28px] w-full">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h3>

                    {{-- RATING --}}
                    <div class="flex items-center gap-2 mt-2">

                        <div class="text-yellow-400 text-sm">
                            ★★★★★
                        </div>

                        <span class="text-sm font-medium text-gray-700">
                            4.9
                        </span>

                        <span class="text-sm text-gray-400">
                            (50 Ulasan)
                        </span>

                    </div>

                    {{-- INFO --}}
                    <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">

                        <span>
                            {{ ucfirst($mobil->transmisi) }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $mobil->kapasitas_penumpang }} Kursi
                        </span>
    
                    </div>

                    <div class="w-full h-[1px] bg-[#C1C1C1] mt-3"></div>

                    {{-- PRICE --}}
                    <div class="flex items-end justify-between mt-3">
                        
                        <p class="text-[#545454] text-sm font-normal leading-6">
                            Mulai dari
                        </p>

                        <p class="text-[#06123A] text-base font-semibold leading-6">
                            Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                        </p>

                    </div>

                </div>
            </a>

            @endforeach

        </div>

    </section>


    {{-- MOBIL ROMBONGAN --}}
    <section class="mt-14 lg:mt-20">

        <div class="mb-8">

            <h2 class="text-black text-2xl font-semibold leading-[36px] w-full">
                Mobil Rombongan
            </h2>

            <p class="text-[#545454] text-base font-medium leading-[28px] w-full">
                Cocok untuk perjalanan grup atau wisata
            </p>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

            @foreach($mobilRombongan as $mobil)

            <a
                href="{{ route('mobil.detail', $mobil->mobil_id) }}"
                class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent"
            >

                {{-- IMAGE --}}
                <div class="relative">

                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[190px] sm:h-[210px] object-cover"
                    >

                    <div class="absolute top-4 left-4 bg-[#0B1F67] text-white text-xs font-medium px-3 py-1 rounded-full">
                        Terlaris
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="flex flex-col flex-1 p-5">

                    <h3 class="text-black text-base font-semibold leading-[28px] w-full">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h3>

                    {{-- RATING --}}
                    <div class="flex items-center gap-2 mt-2">

                        <div class="text-yellow-400 text-sm">
                            ★★★★★
                        </div>

                        <span class="text-sm font-medium text-gray-700">
                            4.9
                        </span>

                        <span class="text-sm text-gray-400">
                            (50 Ulasan)
                        </span>

                    </div>

                    {{-- INFO --}}
                    <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">

                        <span>
                            {{ ucfirst($mobil->transmisi) }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $mobil->kapasitas_penumpang }} Kursi
                        </span>

                    </div>

                    <div class="w-full h-[1px] bg-[#C1C1C1] mt-3"></div>

                    {{-- PRICE --}}
                    <div class="flex items-end justify-between mt-3">
                        
                        <p class="text-[#545454] text-sm font-normal leading-6">
                            Mulai dari
                        </p>

                        <p class="text-[#06123A] text-base font-semibold leading-6">
                            Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                        </p>

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </section>


    {{-- MOBIL LAINNYA --}}
    <section class="mt-14 lg:mt-20">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div>

                <h2 class="text-black text-2xl font-semibold leading-[36px] w-full">
                    Mobil Lainnya
                </h2>

                <p class="text-[#545454] text-base font-medium leading-[28px] w-full">
                    Jelajahi semua pilihan mobil dari berbagai rental terpercaya
                </p>

            </div>

            <a
                href="{{ route('katalog') }}"
                class="flex items-center gap-2 text-[#0B1F67] font-semibold hover:underline"
            >
                Lihat Semua
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>
     
    </section>
    @endif

</div>

@endsection