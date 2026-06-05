@extends('layouts.customer')

@section('content')

@if(!$bookings)

<section class="min-h-[60vh] flex items-center justify-center">

    <div class="text-center">

        <h2 class="text-2xl font-bold text-[#111827]">
            Belum ada riwayat booking
        </h2>

        <p class="text-gray-500 text-base text-m mt-1">
            Kamu belum melakukan pemesanan mobil.
        </p>

        <p class="text-gray-500 text-base text-m mt-1">
            Yuk mulai cari mobil untuk perjalananmu!
        </p>

        <a href="{{ route('katalog') }}"
            class="inline-flex items-center justify-center
                   mt-10 px-8 py-3
                   bg-[#0B1F67] hover:bg-[#081647]
                   text-white font-semibold
                   rounded-lg transition">

            Cari Mobil

        </a>

    </div>

</section>

@else

@foreach($bookings as $booking)

{{-- Header --}}
<section class="text-center pt-12 pb-8">

    <h1 class="text-2xl font-bold text-[#111827]">
        Riwayat Booking
    </h1>

    <p class="text-gray-500 text-base text-sm mt-1">
        Lihat dan kelola semua pemesanan mobil kamu
    </p>

</section>


<div class="bg-white border border-gray-200 rounded-[24px] p-10 mb-10 mx-auto max-w-6xl">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

        <div>
            <h2 class="text-xl font-bold text-black">
                Detail Booking Anda
            </h2>

            <p class="text-gray-500 text-base text-sm mt-1">
                Berikut informasi pemesanan Anda
            </p>
        </div>

        @php
            $statusColor = match($booking->status_booking){

                'menunggu_konfirmasi' => 'bg-[#F5E9B3] text-[#5E4D00]',

                'dikonfirmasi' => 'bg-blue-100 text-blue-700',

                'berjalan' => 'bg-green-100 text-green-700',

                'selesai' => 'bg-emerald-100 text-emerald-700',

                'dibatalkan' => 'bg-red-100 text-red-700',

                default => 'bg-gray-100 text-gray-700'
            };
        @endphp

        <span class="{{ $statusColor }} px-4 py-1 rounded-full font-medium">
            {{ ucwords(str_replace('_',' ', $booking->status_booking)) }}
        </span>

    </div>

    <hr class="my-4">

    {{-- MOBIL & DRIVER --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-8 mb-10">

        {{-- Mobil --}}
        <div class="flex items-center gap-5">

            <img
                src="{{ asset('assets/images/car.png') }}"
                class="w-24 h-16 object-cover rounded-lg border"
                alt="mobil">

            <div>

                <p class="text-gray-500 text-base">
                    Nama Mobil:
                </p>

                <h4 class="font-semibold text-base text-black">
                    {{ $booking->mobil->nama_mobil ?? '-' }}
                </h4>

            </div>

        </div>

        {{-- Driver --}}
        <div class="flex items-center gap-4">

            <img
                src="{{ asset('assets/images/driver-placeholder.jpg') }}"
                class="w-14 h-14 rounded-full object-cover"
                alt="driver">

            <div>

                <p class="text-gray-500 text-base">
                    Nama Driver:
                </p>

                <h4 class="font-medium text-base">
                    {{ $booking->driver->nama_driver ?? 'Tanpa Driver' }}
                </h4>

            </div>

        </div>

    </div>

    {{-- DETAIL BOOKING --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-y-10 gap-x-8">

        <div>
            <p class="text-gray-500 text-base">Kode Booking:</p>
            <p class="font-semibold text-base">
                {{ $booking->kode_booking }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Nama Penyewa:</p>
            <p class="font-semibold text-base">
                {{ $booking->nama_pengendara }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">No Telepon:</p>
            <p class="font-semibold text-base">
                {{ $booking->no_telp_pengendara }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Lokasi Penjemputan:</p>
            <p class="font-semibold text-base">
                {{ $booking->lokasi_penjemputan }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Durasi:</p>

            <p class="font-semibold text-base">
                {{ \Carbon\Carbon::parse($booking->tanggal_sewa)
                    ->diffInDays(\Carbon\Carbon::parse($booking->tanggal_kembali)) }}
                Hari
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Tanggal Pengambilan:</p>
            <p class="font-semibold text-base">
                {{ \Carbon\Carbon::parse($booking->tanggal_sewa)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Tanggal Pengembalian:</p>
            <p class="font-semibold text-base">
                {{ \Carbon\Carbon::parse($booking->tanggal_kembali)->translatedFormat('d F Y') }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Waktu Pengambilan:</p>
            <p class="font-semibold text-base">
                {{ $booking->waktu_ambil }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Waktu Pengembalian:</p>
            <p class="font-semibold text-base">
                {{ $booking->waktu_kembali }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Total Harga:</p>

            <p class="font-bold text-base text-black">
                Rp {{ number_format($booking->total_harga,0,',','.') }}
            </p>
        </div>

    </div>

    {{-- CATATAN --}}
    @if($booking->catatan)

        <div class="mt-10">

            <p class="text-gray-500 text-base mb-2">
                Catatan:
            </p>

            <p class="font-medium">
                {{ $booking->catatan }}
            </p>

        </div>

    @endif

    {{-- TOMBOL BATAL --}}
    @if($booking->status_booking == 'menunggu_konfirmasi')
        <hr class="my-10">
        <div class="flex justify-end">
            {{-- Trigger Button --}}
            <button
                type="button"
                onclick="document.getElementById('modalBatalBooking').classList.remove('hidden')"
                class="bg-[#B22B43] hover:bg-[#97253A] text-white font-semibold px-10 py-3 rounded-xl transition">
                Batalkan
            </button>
        </div>
    @endif

    {{-- MODAL BATAL BOOKING --}}
    <div
        id="modalBatalBooking"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-8 relative">

            {{-- Tombol Close --}}
            <button
                type="button"
                onclick="document.getElementById('modalBatalBooking').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition text-xl font-light">
                ✕
            </button>

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-[#1a2f5a] text-center leading-snug mb-3">
                Yakin ingin membatalkan<br>booking ini?
            </h2>

            {{-- Deskripsi --}}
            <p class="text-gray-500 text-sm text-center mb-6 leading-relaxed">
                Pembatalan akan diproses sesuai kebijakan rental.
                Biaya mungkin dipotong tergantung waktu pembatalan.
            </p>

            {{-- Form --}}
            <form
                action="{{-- route('booking.batal', $booking->booking_id) --}}"
                method="POST">
                @csrf

                {{-- Input Alasan --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Pembatalan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="alasan_pembatalan"
                        required
                        placeholder="Masukkan alasan pembatalan"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1a2f5a] transition">
                </div>

                {{-- Tombol Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#1a2f5a] hover:bg-[#162549] text-white font-semibold py-3 mb-6 rounded-xl transition text-sm">
                    Batalkan Booking
                </button>
            </form>

            {{-- Link Kebijakan --}}
            <div class="text-left mt-4">
                <a href="#" class="text-[#1a2f5a] text-sm font-semibold hover:underline">
                    Lihat kebijakan pembatalan
                </a>
            </div>

        </div>
    </div>

</div>

@endforeach

@endif


<!-- {{-- @if($booking && $booking->status_booking == 'selesai') --}}

<div
    x-data="{
        showReview: true,
        rating: {{ old('rating', 0) }},
        hover: 0,
        fileName: 'Belum ada file dipilih'
    }">

    {{-- MODAL REVIEW --}}
    {{-- 
    <div
        x-show="showReview && !{{ session('review_success') ? 'true' : 'false' }}"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        x-cloak>

        <div class="bg-white rounded-2xl w-full max-w-lg relative shadow-2xl overflow-hidden">

            {{-- Tombol Tutup --}}
            <button
                @click="showReview = false"
                class="absolute top-4 right-6 text-gray-400 text-2xl hover:text-gray-600">

                ✕

            </button>

            {{-- Header --}}
            <div class="py-6 px-10 border-b border-blue-100">

                <h2 class="text-center text-2xl font-extrabold text-[#0b1f67]">
                    Perjalanan Selesai!
                </h2>

            </div>

            <div class="p-8">

                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">

                    <form
                        action="{{-- route('review.store', $booking->booking_id) --}}"
                        
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <h3 class="text-center font-bold text-gray-800 mb-4">
                            Bagaimana Pengalamanmu?
                        </h3>

                        {{-- Rating --}}
                        <div class="flex justify-center gap-2 mb-2">

                            <input
                                type="hidden"
                                name="rating"
                                :value="rating">

                            <template x-for="i in 5">

                                <button
                                    type="button"
                                    @click="rating = i"
                                    @mouseenter="hover = i"
                                    @mouseleave="hover = 0"
                                    class="transition-transform hover:scale-110">

                                    <svg
                                        class="w-10 h-10"
                                        :class="(hover || rating) >= i
                                            ? 'text-yellow-400 fill-current'
                                            : 'text-gray-300 fill-current'"
                                        viewBox="0 0 24 24">

                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>

                                    </svg>

                                </button>

                            </template>

                        </div>

                        @error('rating')
                            <p class="text-red-500 text-sm text-center mb-4">
                                {{ $message }}
                            </p>
                        @enderror

                        {{-- Komentar --}}
                        <div class="mb-4">

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Komentar *
                            </label>

                            <textarea
                                name="komentar"
                                required
                                placeholder="Masukkan komentar"
                                class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#0b1f67] outline-none h-24 resize-none bg-gray-50">{{ old('komentar') }}</textarea>

                            @error('komentar')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-6">

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Tambahkan Foto
                            </label>

                            <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">

                                <label class="bg-gray-200 px-4 py-2.5 text-sm font-semibold cursor-pointer hover:bg-gray-300 transition">

                                    Pilih File

                                    <input
                                        type="file"
                                        name="foto"
                                        accept="image/*"
                                        class="hidden"
                                        @change="fileName = $event.target.files[0]?.name || 'Belum ada file dipilih'">

                                </label>

                                <span
                                    class="px-4 text-sm text-gray-500 text-base truncate"
                                    x-text="fileName">
                                </span>

                            </div>

                            @error('foto')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Error Review Ganda --}}
                        @error('review')
                            <div class="mb-4">

                                <p class="text-red-500 text-sm text-center">
                                    {{ $message }}
                                </p>

                            </div>
                        @enderror

                        {{-- Tombol Submit --}}
                        <div class="flex justify-end">

                            <button
                                type="submit"
                                class="bg-[#0b1f67] hover:bg-[#081647] text-white px-10 py-3 rounded-lg font-bold transition shadow-md">

                                Kirim Ulasan

                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>

    {{-- MODAL SUKSES --}}
    @if(session('review_success'))

    <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50">

        <div class="bg-white rounded-3xl p-12 max-w-md w-full text-center shadow-2xl mx-4">

            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">

                <div class="w-20 h-20 border-4 border-[#7ab356] rounded-full flex items-center justify-center">

                    <svg
                        class="w-12 h-12 text-[#7ab356]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="4"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7">
                        </path>

                    </svg>

                </div>

            </div>

            <h3 class="text-2xl font-bold text-[#0b1f67] mb-2">
                Ulasan Berhasil Dikirim!
            </h3>

            <p class="text-gray-500 text-base">
                Terima kasih telah memberikan ulasan.
            </p>

            <button
                onclick="window.location.reload()"
                class="mt-8 text-gray-400 hover:text-gray-600 font-medium">

                Tutup

            </button>

        </div>

    </div>
    --}}

    @endif

</div>

{{-- @endif --}} -->


@endsection