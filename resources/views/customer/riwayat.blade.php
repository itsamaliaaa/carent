@extends('layouts.customer')

@section('content')

@if(empty($bookings) || (is_object($bookings) && method_exists($bookings, 'isEmpty') && $bookings->isEmpty()))

<section class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-24">

    <div class="text-center px-5">

        <h2 class="text-3xl sm:text-4xl font-semibold text-[#0B1F67]">
            Belum ada riwayat booking
        </h2>

        <p class="text-gray-500 text-base sm:text-lg mt-4 max-w-xl mx-auto leading-relaxed">
            Kamu belum melakukan pemesanan mobil. Yuk mulai cari mobil untuk perjalananmu!
        </p>

        <a href="{{ route('katalog') }}"
            class="inline-flex items-center justify-center mt-10 bg-[#0B1F67] hover:bg-[#081647] text-white font-semibold rounded-xl px-8 py-3 transition">

            Cari Mobil

        </a>

    </div>

</section>

@else

{{-- Header Dipindah ke luar foreach agar tidak terulang berkali-kali --}}
<section class="text-center pt-12 pb-8">
    <h1 class="text-2xl font-bold text-[#111827]">
        Riwayat Booking
    </h1>
    <p class="text-gray-500 text-base text-sm mt-1">
        Lihat dan kelola semua pemesanan mobil kamu
    </p>
</section>

@foreach($bookings as $booking)

{{-- Bungkus card dengan x-data Alpine.js agar status modal spesifik untuk tiap card --}}
<div x-data="{
        showReview: false,
        rating: {{ old('rating', 0) }},
        hover: 0,
        fileName: 'Belum ada file dipilih'
    }"
    class="bg-white border border-gray-200 rounded-[24px] p-10 mb-10 mx-auto max-w-6xl relative">

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
                <p class="text-gray-500 text-base">Nama Mobil:</p>
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
                <p class="text-gray-500 text-base">Nama Driver:</p>
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
            <p class="font-semibold text-base">{{ $booking->kode_booking }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Nama Penyewa:</p>
            <p class="font-semibold text-base">{{ $booking->nama_pengendara }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-base">No Telepon:</p>
            <p class="font-semibold text-base">{{ $booking->no_telp_pengendara }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Lokasi Penjemputan:</p>
            <p class="font-semibold text-base">{{ $booking->lokasi_penjemputan }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Durasi:</p>
            <p class="font-semibold text-base">
                {{ \Carbon\Carbon::parse($booking->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($booking->tanggal_kembali)) }} Hari
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
            <p class="font-semibold text-base">{{ $booking->waktu_ambil }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-base">Waktu Pengembalian:</p>
            <p class="font-semibold text-base">{{ $booking->waktu_kembali }}</p>
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
            <p class="text-gray-500 text-base mb-2">Catatan:</p>
            <p class="font-medium">{{ $booking->catatan }}</p>
        </div>
    @endif

    {{-- TOMBOL BATAL --}}
    @if($booking->status_booking == 'menunggu_konfirmasi')
        <hr class="my-10">
        <div class="flex justify-end">
            <button
                type="button"
                onclick="document.getElementById('modalBatalBooking-{{ $booking->booking_id }}').classList.remove('hidden')"
                class="bg-[#B22B43] hover:bg-[#97253A] text-white font-semibold px-10 py-3 rounded-xl transition">
                Batalkan
            </button>
        </div>

        {{-- MODAL BATAL BOOKING (Pastikan ID unik agar tidak tertukar modal pesanan lain) --}}
        <div id="modalBatalBooking-{{ $booking->booking_id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-8 relative">
                <button type="button" onclick="document.getElementById('modalBatalBooking-{{ $booking->booking_id }}').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition text-xl font-light">✕</button>
                <h2 class="text-2xl font-bold text-[#1a2f5a] text-center leading-snug mb-3">Yakin ingin membatalkan<br>booking ini?</h2>
                <p class="text-gray-500 text-sm text-center mb-6 leading-relaxed">Pembatalan akan diproses sesuai kebijakan rental. Biaya mungkin dipotong tergantung waktu pembatalan.</p>

                <form id="formBatalBooking-{{ $booking->booking_id }}" action="{{ route('customer.booking.batal', $booking->booking_id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan <span class="text-red-500">*</span></label>
                        <input type="text" name="alasan_pembatalan" required placeholder="Masukkan alasan pembatalan" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1a2f5a] transition">
                    </div>
                    <button type="button" onclick="document.getElementById('modalConfirmBatal-{{ $booking->booking_id }}').classList.remove('hidden')" class="w-full bg-[#1a2f5a] hover:bg-[#162549] text-white font-semibold py-3 mb-6 rounded-xl transition text-sm">Batalkan Booking</button>
                </form>

                {{-- CONFIRMATION MODAL --}}
                <div id="modalConfirmBatal-{{ $booking->booking_id }}" class="hidden fixed inset-0 z-60 flex items-center justify-center bg-black/40 px-4">
                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 relative">
                        <h3 class="text-xl font-semibold text-[#141B34] text-center mb-3">Apakah kamu yakin ingin membatalkan booking ini?</h3>
                        <div class="flex gap-3 mt-8">
                            <button type="button" onclick="document.getElementById('formBatalBooking-{{ $booking->booking_id }}').submit()" class="flex-1 bg-[#52B33B] hover:bg-[#429a2e] border border-gray-200 text-[#141B34] font-semibold py-2 rounded-lg">Ya</button>
                            <button type="button" onclick="document.getElementById('modalConfirmBatal-{{ $booking->booking_id }}').classList.add('hidden')" class="flex-1 bg-[#B22B43] hover:bg-[#97253A] text-white font-semibold py-2 rounded-lg">Tidak</button>
                        </div>
                    </div>
                </div>

                <div class="text-left mt-4">
                    <button type="button" onclick="document.getElementById('modalKebijakan-{{ $booking->booking_id }}').classList.remove('hidden')" class="text-[#1a2f5a] text-sm font-semibold hover:underline">Lihat kebijakan pembatalan</button>
                </div>
            </div>
        </div>

        {{-- MODAL KEBIJAKAN PEMBATALAN --}}
        <div id="modalKebijakan-{{ $booking->booking_id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 ">
            <div class="bg-white rounded-xl shadow-xl max-w-3xl p-8 relative w-622 h-718">
                <button type="button" onclick="document.getElementById('modalKebijakan-{{ $booking->booking_id }}').classList.add('hidden')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition text-xl font-light">✕</button>
                <h2 class="text-3xl font-bold text-[#141B34] text-center mb-8">Kebijakan Pembatalan</h2>
                <div class="space-y-10 text-gray-800">
                    <div class="space-y-4">
                        <h3 class="text-2xl font-semibold text-[#141B34]">Syarat Pembatalan</h3>
                        <ul class="space-y-2 list-disc list-inside text-base leading-7">
                            <li>Pembatalan hanya dapat dilakukan jika status booking belum selesai.</li>
                            <li>Pengguna wajib mengisi alasan pembatalan pada form yang tersedia.</li>
                            <li>Pembatalan tidak dapat dilakukan setelah waktu sewa dimulai.</li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-2xl font-semibold text-[#141B34] mt-6">Kebijakan Pengembalian Dana</h3>
                        <p class="text-base leading-7">Pengembalian dana akan diproses berdasarkan waktu pembatalan sebagai berikut:</p>
                        <ul class="space-y-4 list-disc list-inside text-base leading-7">
                            <li><span class="font-semibold">Lebih dari 48 jam sebelum waktu sewa:</span> Pengguna berhak mendapatkan pengembalian dana 100%.</li>
                            <li><span class="font-semibold">24–48 jam sebelum waktu sewa:</span> Pengguna berhak mendapatkan pengembalian dana 75%.</li>
                            <li><span class="font-semibold">Kurang dari 24 jam sebelum waktu sewa:</span> Pengguna berhak mendapatkan pengembalian dana 50%.</li>
                            <li><span class="font-semibold">Pada hari H atau setelah waktu sewa dimulai:</span> Pengguna tidak mendapatkan pengembalian dana (0%).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- TOMBOL & MODAL BERI ULASAN --}}
    @if($booking->status_booking == 'selesai')
        <hr class="my-10">
        <div class="flex justify-end">
            {{-- Tombol Beri Ulasan yang Mengubah State showReview Alpine --}}
            <button
                type="button"
                @click="showReview = true"
                class="bg-[#0b1f67] hover:bg-[#081647] text-white font-semibold px-10 py-3 rounded-xl transition shadow-md">
                Beri Ulasan
            </button>
        </div>

        {{-- MODAL REVIEW (Diintegrasikan langsung dengan card) --}}
        <div
            x-show="showReview && !{{ session('review_success') ? 'true' : 'false' }}"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
            x-cloak>

            <div class="bg-white rounded-[36px] w-full max-w-md relative shadow-2xl overflow-hidden" @click.outside="showReview = false">

                {{-- Tombol Tutup --}}
                <button
                    @click="showReview = false"
                    class="absolute top-4 right-4 text-gray-400 text-2xl hover:text-gray-600">
                    ✕
                </button>

                <div class="p-8">

                    <h2 class="text-center text-3xl font-bold text-[#0b1f67] mb-8">
                        Perjalanan selesai!
                    </h2>

                    <div class="bg-white border border-gray-200 rounded-[32px] p-6 shadow-sm">

                        <h3 class="text-center text-lg font-semibold text-gray-900 mb-6">
                            Bagaimana Pengalamanmu?
                        </h3>

                        {{-- Rating --}}
                        <div class="flex flex-col items-center mb-6">
                            <div class="flex justify-center gap-1 mb-2">
                                <template x-for="i in 5" :key="i">
                                    <button
                                        type="button"
                                        @click="rating = i"
                                        @mouseenter="hover = i"
                                        @mouseleave="hover = 0"
                                        class="focus:outline-none transition-transform duration-150"
                                        :class="(hover || rating) >= i ? 'scale-110' : 'scale-100'"
                                        :aria-label="'Beri bintang ' + i">
                                        <svg
                                            class="w-10 h-10 transition-colors duration-150"
                                            :style="(hover || rating) >= i
                                                ? 'fill: #F59E0B; color: #F59E0B; filter: drop-shadow(0 0 4px rgba(245,158,11,0.5));'
                                                : 'fill: #D1D5DB; color: #D1D5DB;'"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                            {{-- Rating label --}}
                            <p class="text-sm font-medium h-5 transition-all duration-200"
                                :class="(hover || rating) > 0 ? 'text-amber-500' : 'text-transparent'"
                                x-text="['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'][hover || rating] || ''">
                            </p>
                        </div>

                        @error('rating')
                            <p class="text-red-500 text-sm text-center mb-4">
                                {{ $message }}
                            </p>
                        @enderror

                        {{-- Form --}}
                        <form
                            action="{{ route('customer.review.store', $booking->booking_id) }}"
                            method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="rating" :value="rating">

                            {{-- Komentar --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 mb-2">
                                    Komentar *
                                </label>
                                <input
                                    type="text"
                                    name="komentar"
                                    required
                                    placeholder="Masukkan komentar"
                                    value="{{ old('komentar') }}"
                                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-700 focus:ring-2 focus:ring-[#0b1f67] outline-none bg-gray-50" />
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
                                <div class="flex items-center border border-gray-200 rounded-2xl overflow-hidden bg-gray-50">
                                    <label class="bg-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-300 transition">
                                        Pilih File
                                        <input
                                            type="file"
                                            name="foto"
                                            accept="image/*"
                                            class="hidden"
                                            @change="fileName = $event.target.files[0]?.name || 'Belum ada file dipilih'" />
                                    </label>
                                    <span class="flex-1 px-4 py-3 text-sm text-gray-500 truncate" x-text="fileName"></span>
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
                            <button
                                type="submit"
                                class="w-full bg-[#0b1f67] hover:bg-[#081647] text-white px-10 py-3 rounded-xl font-bold transition shadow-md">
                                Kirim Ulasan
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@endforeach

{{-- MODAL SUKSES (Diletakkan di luar perulangan) --}}
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

@endif

@endif

@endsection
