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
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Reply Review</h1>
        </div>
        <hr class="border-t border-gray-200 mb-6">

        {{-- Date Filter --}}
        <div class="flex items-end gap-4 mb-5">
            {{-- Tanggal Mulai --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-xs text-gray-400 font-medium">Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
            </div>

            <span class="text-sm text-gray-500 mb-2">s/d</span>

            {{-- Tanggal Selesai --}}
            <div class="flex flex-col gap-1 flex-1">
                <label class="text-xs text-gray-400 font-medium">Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
            </div>

            <button type="submit" class="bg-[#1D2B6B] flex-1 text-white px-5 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition mb-[1px]">
                Terapkan Filter
            </button>
        </div>

        {{-- Search --}}
        <div class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                </div>
                <input type="text" placeholder="Cari Driver" class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>
            <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">Cari</button>
        </div>
    </div>

    {{-- List Cards Review --}}
    <div class="bg-white p-8 rounded-[20px] shadow-sm border border-gray-50 max-h-[330px] custom-scrollbar overflow-y-auto custom-scrollbar">
        @forelse($reviews as $review)
        <div class="bg-white p-7 rounded-[20px] border border-gray-150 flex flex-col gap-5 {{ $loop->last ? '' : 'mb-6' }}">

            {{-- Header Card: Profil User & Bintang --}}
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-3">
                    {{-- Avatar Bulat --}}
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold text-sm uppercase">
                        {{ substr($review->user->email ?? 'US', 0, 2) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-700">{{ $review->user->email ?? 'User Unknown' }}</span>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($review->tanggal_posting)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>

                {{-- Rating Bintang Dinamis --}}
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endfor
                </div>
            </div>

            <hr class="border-t border-gray-100">

            {{-- Isi Komentar Ulasan --}}
            <div class="text-sm text-gray-600 leading-relaxed">
                {{ $review->komentar }}
            </div>

            {{-- JIKA SUDAH ADA BALASAN ADMIN --}}
            @if($review->reply)
            <div>
                <hr class="border-t border-gray-200 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-600">Balasan:</span>
                </div>
                <p class="text-sm text-gray-600">{{ $review->reply->komentar }}</p>
            </div>
            @else
            {{-- JIKA BELUM DIBALAS: Interaksi Dinamis dengan Alpine.js --}}
            <div x-data="{ isOpen: false }" class="mt-2">

                {{-- Tombol Balas (Sembunyi jika form terbuka) --}}
                <div class="flex justify-end" x-show="!isOpen">
                    <button type="button" @click="isOpen = true"
                        class="bg-[#1D2B6B] text-white px-6 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition">
                        Balas
                    </button>
                </div>

                {{-- Form Input Balasan (Muncul jika isOpen = true) --}}
                <form action="{{ route('admin.review.reply', $review->review_id) }}" method="POST"
                    x-show="isOpen" x-transition
                    class="flex flex-col gap-3" style="display: none;">
                    @csrf
                    <div class="w-full bg-white border border-gray-200 rounded-[20px] p-5 shadow-sm transition-all duration-200 focus-within:ring-0.7 focus-within:ring-[#c1c1c1] focus-within:border-[#c1c1c1]">
                        <textarea name="komentar" rows="4" required
                            placeholder="Tulis balasan Anda di sini..."
                            class="w-full p-0 bg-transparent text-sm text-gray-700 placeholder-gray-400 border-none outline-none focus:ring-0 focus:outline-none resize-none m-0 appearance-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="submit"
                            class="bg-[#1D2B6B] text-white px-6 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition">
                            Balas
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>
        @empty
        {{-- Kondisi Jika pencarian atau filter tidak menghasilkan data --}}
        <div class="bg-white p-10 rounded-[20px] border border-gray-50 text-center text-gray-400 text-sm">
            Tidak ada ulasan yang ditemukan.
        </div>
        @endforelse
    </div>
</div>
@endsection