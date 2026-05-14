@extends('layouts.customer')

@section('content')
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="m-8 flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium transition">
            <img src="{{ asset('images/icons/logout-04.svg') }}" alt="Logout" class="w-4 h-4">
            Logout
        </button>
    </form>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="relative w-32 h-32">
            <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="50" fill="none" stroke="#E5E7EB" stroke-width="10"/>
                <circle
                    id="progressCircle"
                    cx="60" cy="60" r="50"
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
                <span id="progressText" class="text-2xl font-bold text-[#0B1F67]">0%</span>
            </div>
        </div>
    </div>

    {{-- Hasil Pencarian --}}
    <div id="hasilPencarian">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
            @foreach ($mobilTerbaru as $mobil)
                {{-- card mobil --}}
            @endforeach
        </div>
    </div>

    {{-- SECTION HERO --}}
    <div class="relative w-full h-[340px] overflow-hidden">

        {{-- Background Image --}}
        <img
            src="{{ asset('images/banner/bg-input.png') }}"
            alt="Hero Background"
            class="absolute inset-0 w-full h-full object-cover"
        >
        
        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

        {{-- Konten --}}
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-6 gap-6">

            {{-- Teks --}}
            <div class="text-center">
                <h1 class="text-white text-3xl font-bold">Temukan Mobilmu Sekarang</h1>
                <p class="text-gray-200 text-sm mt-1">Sewa Mobil dengan Mudah dari Berbagai Rental Terpercaya</p>
            </div>

            {{-- Form Ketersediaan --}}
            <form id="searchForm" action="{{ route('beranda') }}" method="GET"
                class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg px-6 py-4 w-full max-w-4xl">

                <div class="flex flex-col lg:flex-row items-end gap-4">

                    {{-- Lokasi --}}
                    <div class="flex flex-col gap-1 w-full lg:w-1/4">
                        <label class="text-xs text-gray-500 font-medium">Lokasi</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="lokasi"
                                placeholder="Pilih lokasi"
                                value="{{ request('lokasi') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 pr-9 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal Pengambilan --}}
                    <div class="flex flex-col gap-1 w-full lg:w-1/5">
                        <label class="text-xs text-gray-500 font-medium">Tanggal Pengambilan</label>
                        <div class="relative">
                            <input
                                type="date"
                                name="tanggal_sewa"
                                value="{{ request('tanggal_sewa') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Waktu Pengambilan --}}
                    <div class="flex flex-col gap-1 w-full lg:w-1/6">
                        <label class="text-xs text-gray-500 font-medium">Waktu</label>
                        <div class="relative">
                            <input
                                type="time"
                                name="waktu_ambil"
                                value="{{ request('waktu_ambil') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Tanggal Pengembalian --}}
                    <div class="flex flex-col gap-1 w-full lg:w-1/5">
                        <label class="text-xs text-gray-500 font-medium">Tanggal Pengembalian</label>
                        <div class="relative">
                            <input
                                type="date"
                                name="tanggal_kembali"
                                value="{{ request('tanggal_kembali') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Waktu Pengembalian --}}
                    <div class="flex flex-col gap-1 w-full lg:w-1/6">
                        <label class="text-xs text-gray-500 font-medium">Waktu</label>
                        <div class="relative">
                            <input
                                type="time"
                                name="waktu_kembali"
                                value="{{ request('waktu_kembali') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Tombol Cek --}}
                    <div class="w-full lg:w-auto">
                        <button type="submit"
                                class="w-full lg:w-auto bg-blue-900 hover:bg-blue-800 text-white
                                    font-semibold px-6 py-2.5 rounded-lg transition duration-200 text-sm">
                            Cek
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- Header --}}
    <div class="m-8">
        <h1 class="text-2xl font-bold text-[#0B1F67]">
            Mobil Keluarga
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Nyaman untuk perjalanan bersama keluarga
        </p>
    </div>

{{-- Card List --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">    
    
@foreach ($mobilTerbaru as $mobil)

        {{-- CARD MOBIL --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 w-full max-w-[260px]">

            {{-- Gambar Mobil --}}
            <div class="relative">
                <img
                src="{{ $mobil->fotoPrimary 
                ? asset('storage/' . $mobil->fotoPrimary->url_foto) 
                : asset('images/avanza.jpg') }}"
                alt="{{ $mobil->nama_mobil }}"
                class="w-full h-[160px] object-cover"
                >
            </div>
          
            {{-- Content --}}
            <div class="p-4">

                {{-- Nama Mobil --}}
                <h2 class="font-semibold text-[15px] text-gray-900 leading-tight line-clamp-1">
                    {{ $mobil->nama_mobil }} {{ $mobil->tahun }} 
                </h2>

                {{-- Rating --}}
                <div class="flex items-center gap-1 mt-1">

                    <div class="flex text-yellow-400 text-[11px]">
                        ★★★★★
                    </div>

                    <span class="text-[11px] font-medium text-gray-700">
                        4.9
                    </span>

                    <span class="text-[11px] text-gray-400">
                        (50 Ulasan)
                    </span>

                </div>

                {{-- Info --}}
                <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">

                    <span>
                        {{ ucfirst($mobil->transmisi) }}
                    </span>

                    <span>•</span>

                    <span>
                    {{ $mobil->kapasitas_penumpang }} Kursi
                    </span>

                </div>

                {{-- Harga --}}
                <div class="flex justify-between items-end mt-5">

                    <div>
                        <p class="text-[11px] text-gray-400">
                            Mulai dari
                        </p>
                    </div>

                    <p class="text-[17px] font-bold text-[#0B1F67]">
                        Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                    </p>

                </div>

                {{-- Button --}}
                <div class="flex gap-2 mt-4">

                    {{-- Detail --}}
                    <a href=""
                       class="flex-1 border border-[#0B1F67] text-[#0B1F67] text-[12px] font-semibold py-2 rounded-lg text-center hover:bg-blue-50 transition">
                        Lihat Detail
                    </a>

                    {{-- Booking --}}
                    @auth
                        <a href=""
                           class="flex-1 bg-[#0B1F67] text-white text-[12px] font-semibold py-2 rounded-lg text-center hover:bg-[#08184f] transition">
                            Booking
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                           class="flex-1 bg-[#0B1F67] text-white text-[12px] font-semibold py-2 rounded-lg text-center hover:bg-[#08184f] transition">
                            Booking
                        </a>
                    @endguest

                </div>

            </div>

        </div>

    @endforeach

</div>

@endsection