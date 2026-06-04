@extends('layouts.admin')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .custom-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="flex flex-col gap-4 py-2 px-2">

    {{-- Card Filter & Search --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50 mb-3">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Moderasi Review</h1>
        </div>
        <hr class="border-t border-gray-200 mb-6">

        <form method="GET" action="{{ route('superadmin.review.index') }}">
            {{-- Date Filter --}}
            <div class="flex items-start gap-4 mb-5">
                {{-- Tanggal Mulai --}}
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
                    <span class="text-xs min-h-[16px]"></span> 
                </div>

                <span class="text-sm text-gray-500 mt-7">s/d</span>

                {{-- Tanggal Selesai --}}
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Tanggal</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
                    <span class="text-xs min-h-[16px]">
                        @error('sampai')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </span>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col flex-1">
                    <div class="h-[6px]"></div>
                    <label class="text-xs text-gray-400 font-medium opacity-0">Filter</label> 
                    <button type="submit" class="bg-[#1D2B6B] text-white px-5 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition">
                        Terapkan Filter
                    </button>
                    <span class="min-h-[16px]"></span> 
                </div>
            </div>

            {{-- Search --}}
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                    </div>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari User"
                        class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-800">
                </div>
                <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">Cari</button>
            </div>
        </form>
    </div>

    {{-- Daftar Review --}}
    <div class="flex flex-col gap-4">

        @forelse ($reviews as $review)
        <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col gap-4">

            {{-- Header Review --}}
            <div class="flex justify-between items-start">

                {{-- Avatar + Info User --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr($review->user->nama_lengkap, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $review->user->email }}</p>
                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($review->tanggal_posting)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                {{-- Rating Bintang --}}
                <div class="flex items-center gap-0.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                    @endfor
                </div>

            </div>

            <hr class="border-gray-100">

            {{-- Komentar --}}
            <p class="text-sm text-gray-700 leading-relaxed">
                {{ $review->komentar }}
            </p>

            {{-- Info Mobil --}}
            @if($review->booking && $review->booking->mobil)
            <p class="text-xs text-gray-400">
                {{ $review->booking->mobil->nama_mobil }}
                · {{ $review->booking->mobil->rental->nama_rental ?? '-' }}
            </p>
            @endif

            <hr class="border-gray-100">

            {{-- Status + Aksi --}}
            <div class="flex justify-end items-center gap-3">

                <p class="text-sm">
                    Status:
                    <span class="{{ $review->status_tampilkan ? 'text-green-600' : 'text-red-500' }} font-semibold">
                        {{ $review->status_tampilkan ? 'Tampil' : 'Hidden' }}
                    </span>
                </p>

                <form action="{{ route('superadmin.review.toggle', $review->review_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-2">
                        <button type="submit"
                                onclick="return confirm('Sembunyikan review ini?')"
                                {{ !$review->status_tampilkan ? 'disabled' : '' }}
                                class="px-5 py-2 rounded-lg text-sm font-semibold text-white transition
                                       {{ $review->status_tampilkan
                                           ? 'bg-red-500 hover:bg-red-600 cursor-pointer'
                                           : 'bg-red-200 cursor-not-allowed' }}">
                            Hide
                        </button>
                        <button type="submit"
                                onclick="return confirm('Tampilkan review ini?')"
                                {{ $review->status_tampilkan ? 'disabled' : '' }}
                                class="px-5 py-2 rounded-lg text-sm font-semibold transition
                                       {{ !$review->status_tampilkan
                                           ? 'bg-green-100 text-green-700 hover:bg-green-200 cursor-pointer'
                                           : 'bg-green-50 text-green-300 cursor-not-allowed' }}">
                            Show
                        </button>
                    </div>
                </form>

            </div>

        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border p-10 text-center text-gray-400">
            Belum ada review.
        </div>
        @endforelse

        {{-- Pagination --}}
        <div>
            {{ $reviews->links() }}
        </div>

    </div>

</div>
@endsection