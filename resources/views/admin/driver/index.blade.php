@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-5 py-5 px-5">

    {{-- Card Header --}}
    <div class="bg-white p-7 rounded-[25px] shadow-sm border border-gray-50">
        <div class="flex justify-between items-center mb-5">
            {{-- Judul tetap text-2xl sesuai kode awalmu --}}
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Driver</h1>

            <a href="#" class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </a>
        </div>

        {{-- Garis Pemisah --}}
        <hr class="border-t border-gray-200 mb-6">

        <div class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                </div>
                {{-- Placeholder & Input tetap text-sm (14px) sebagai patokan --}}
                <input type="text" placeholder="Cari Driver"
                    class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>

            {{-- Button Cari: Teks dibuat 11px --}}
            <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">
                Cari
            </button>
        </div>
    </div>

</div>
@endsection