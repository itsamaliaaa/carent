@extends('layouts.admin')

@section('content')
{{-- 1. Bungkus seluruh konten dengan x-data agar tombol bisa akses modal --}}
<div class="flex flex-col gap-5 py-5 px-5" x-data="{ showModal: false }">

    {{-- Card Header --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Driver</h1>

            {{-- 2. Ubah tag <a> menjadi <button> dan tambahkan @click --}}
            <button @click="showModal = true" class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </button>
        </div>

        {{-- Garis Pemisah --}}
        <hr class="border-t border-gray-200 mb-6">

        <div class="flex gap-4">
            {{-- Bagian Search tetap sama --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                </div>
                <input type="text" placeholder="Cari Driver"
                    class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>

            <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">
                Cari
            </button>
        </div>
    </div>

    {{-- Modal Layout --}}
    <div x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-cloak
        style="display: none;">
        <div class="bg-white rounded-[20px] w-full max-w-lg p-10 shadow-lg" @click.away="showModal = false">
            <h2 class="text-[#1D2B6B] text-3xl font-bold mb-8">Tambah Driver</h2>

            <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Driver --}}
                <div class="mb-4">
                    <label class=" text-gray-600 text-sm mb-2">Nama Driver</label>
                    <input type="text" name="nama_driver" required placeholder="Masukkan Nama Driver"
                        class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>

                {{-- Umur Driver --}}
                <div class="mb-4">
                    <label class=" text-gray-600 text-sm mb-2">Umur Driver</label>
                    <input type="number" name="umur" required placeholder="Harus Angka"
                        class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>

                {{-- Foto --}}
                <div class="mb-4">
                    <label class=" text-gray-600 text-sm mb-2">Foto</label>
                    <input type="file" name="foto" required class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:border-gray-200 file:py-2 file:px-4 file:mr-4 file:text-[14px] file:font-normal cursor-pointer hover:file:bg-gray-200 focus:outline-none">
                </div>

                {{-- Tarif --}}
                <div class="mb-6">
                    <label class=" text-gray-600 text-sm mb-2">Tarif</label>
                    <input type="number" name="tarif_harian" required placeholder="Contoh: 250000"
                        class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>

                {{-- Button Submit Full Width --}}
                <button type="submit" class="bg-[#0b1f67] w-full  text-white py-2 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] ransition">
                    Tambah
                </button>
            </form>
        </div>
    </div>

</div>

{{-- Bagian Tabel (Ditaruh di luar div header) --}}
<div class="bg-white rounded-[32px] px-7 py-6 shadow-sm border border-gray-100 max-w-full mx-5 mt-5">
    
    {{-- Header Tabel --}}
    <div class="grid grid-cols-6 bg-[#E8EAF6] rounded-xl py-3 px-6 mb-4 items-center">
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Nama Driver</div>
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Foto</div>
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Umur</div>
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Tarif</div>
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Status</div>
        <div class="text-[13px] font-bold text-black font-['Inter'] text-left">Aksi</div>
    </div>

    @foreach ($drivers as $driver)
    <div class="grid grid-cols-6 items-center border border-[#E0E4EC] rounded-2xl p-4 mb-4 transition-none">
        <div class="text-[14px] font-bold text-black font-['Inter'] text-left">
            {{ $driver->nama_driver }}
        </div>
        
        <div class="flex justify-start">
            <img src="{{ asset('storage/' . $driver->foto) }}" class="w-[60px] h-[40px] object-cover rounded-lg shadow-sm">
        </div>

        <div class="text-[14px] font-bold text-black font-['Inter'] text-left">
            {{ $driver->umur }} tahun
        </div>

        <div class="text-[14px] font-bold text-black font-['Inter'] text-left">
            Rp {{ number_format($driver->tarif_harian, 0, ',', '.') }}
        </div>

        <div class="flex justify-start text-left">
            <span class="{{ $driver->status == 'tersedia' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#F5E8E8] text-[#712A2A]' }} px-4 py-1 rounded-full text-[12px] font-bold">
                {{ $driver->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
            </span>
        </div>

        <div class="flex justify-start gap-2">
            <a href="#" class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg">
                <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
            </a>
            <button class="w-9 h-9 bg-[#B74A4A] flex justify-center items-center rounded-lg">
                <img src="{{ asset('images/icons/delete-01.svg') }}" class="w-5 h-5 brightness-0 invert">
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection