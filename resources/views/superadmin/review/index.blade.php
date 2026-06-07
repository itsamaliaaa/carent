@extends('layouts.admin')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar { display: none; }
    .custom-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="flex flex-col gap-4 py-2 px-2">

    {{-- Card Filter & Search --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50 mb-3">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Moderasi Review</h1>
        </div>
        <hr class="border-t border-gray-200 mb-6">

        <form method="GET" action="{{ route('superadmin.review.index') }}">
            <div class="flex items-start gap-4 mb-5">
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
                    <span class="text-xs min-h-[16px]"></span>
                </div>

                <span class="text-sm text-gray-500 mt-7">s/d</span>

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

                <div class="flex flex-col flex-1">
                    <div class="h-[6px]"></div>
                    <label class="text-xs text-gray-400 font-medium opacity-0">Filter</label>
                    <button type="submit" class="bg-[#1D2B6B] text-white px-5 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition">
                        Terapkan Filter
                    </button>
                    <span class="min-h-[16px]"></span>
                </div>
            </div>

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

                <div class="flex items-center gap-0.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                    @endfor
                </div>
            </div>

            <hr class="border-gray-100">

            <p class="text-sm text-gray-700 leading-relaxed">{{ $review->komentar }}</p>
            
            {{-- Foto Review --}}
            @if($review->foto_review)
                <img src="{{ asset('storage/' . $review->foto_review) }}"
                    alt="Foto Review"
                    class="w-32 h-32 object-cover rounded-xl border border-gray-200 cursor-pointer"
                    onclick="document.getElementById('fotoModal-{{ $review->review_id }}').classList.remove('hidden')">

                <div id="fotoModal-{{ $review->review_id }}"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4"
                    onclick="this.classList.add('hidden')">
                    <img src="{{ asset('storage/' . $review->foto_review) }}"
                        class="max-w-2xl max-h-[80vh] rounded-2xl object-contain shadow-2xl">
                </div>
            @endif

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

                {{-- Form hide --}}
                <form id="reviewForm-{{ $review->review_id }}"
                      action="{{ route('superadmin.review.toggle', $review->review_id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-2">
                        {{-- Tombol Hide --}}
                        <button type="button"
                                {{ !$review->status_tampilkan ? 'disabled' : '' }}
                                onclick="openReviewConfirm('{{ $review->review_id }}', 'hide')"
                                class="px-5 py-2 rounded-lg text-sm font-semibold text-white transition
                                       {{ $review->status_tampilkan
                                           ? 'bg-red-500 hover:bg-red-600 cursor-pointer'
                                           : 'bg-red-200 cursor-not-allowed' }}">
                            Hide
                        </button>
                        {{-- Tombol Show --}}
                        <button type="button"
                                {{ $review->status_tampilkan ? 'disabled' : '' }}
                                onclick="openReviewConfirm('{{ $review->review_id }}', 'show')"
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

        <div>{{ $reviews->links() }}</div>
    </div>
</div>

{{-- MODAL KONFIRMASI REVIEW --}}
<div id="reviewConfirmModal" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p id="reviewConfirmText" class="text-[22px] font-semibold leading-[34px] text-[#050E2D]">
            Apakah kamu yakin?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" id="confirmReviewBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" id="closeReviewConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- SUCCESS MODAL REVIEW --}}
<div id="reviewSuccessModal" class="fixed inset-0 z-[90] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]" id="reviewSuccessText">Berhasil</h2>
    </div>
</div>

<script>
    // KONFIRMASI REVIEW
    let activeReviewFormId = null;

    function openReviewConfirm(reviewId, aksi) {
        activeReviewFormId = 'reviewForm-' + reviewId;
        const text = aksi === 'hide'
            ? 'Apakah kamu yakin ingin menyembunyikan review ini?'
            : 'Apakah kamu yakin ingin menampilkan review ini?';
        document.getElementById('reviewConfirmText').textContent = text;

        const modal = document.getElementById('reviewConfirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    document.getElementById('closeReviewConfirmModal')
        ?.addEventListener('click', () => {
            document.getElementById('reviewConfirmModal').classList.add('hidden');
            document.getElementById('reviewConfirmModal').classList.remove('flex');
        });

    document.getElementById('confirmReviewBtn')
        ?.addEventListener('click', () => {
            document.getElementById('reviewConfirmModal').classList.add('hidden');
            document.getElementById('reviewConfirmModal').classList.remove('flex');
            document.getElementById(activeReviewFormId).submit();
        });

    // SUCCESS
    @if(session('review_success'))
        window.addEventListener('load', function () {
            const modal = document.getElementById('reviewSuccessModal');
            document.getElementById('reviewSuccessText').textContent = '{{ session("review_success") }}';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 2500);
        });
    @endif
</script>

@endsection