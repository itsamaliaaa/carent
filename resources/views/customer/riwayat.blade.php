<!-- memindahkan hasil kerja tariq ke riwayat. -->

@extends('layouts.customer')

@section('content')

<div class="p-6">
    <h1 class="text-2xl font-bold text-[#0B1F67]">
        Riwayat Booking
    </h1>
</div>
<main class="container mx-auto px-4 py-8 max-w-5xl">
    <section class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Cek Riwayat Booking Anda</h1>
        <p class="text-gray-500">Silakan masukkan email dan kode booking untuk melihat detail pemesanan.</p>
    </section>

    <!-- Search Card -->
    <section class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
        <h3 class="font-bold text-gray-900 mb-4">Lihat Detail Booking</h3>
        <div class="border-b border-gray-100 mb-6"></div>

        <form action="{{ route('booking.check') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 outline-none">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-xs font-medium text-gray-700 mb-1">Kode Booking</label>
                <input type="text" name="booking_code" placeholder="Masukkan Kode Booking" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 outline-none">
            </div>
            <button type="submit" class="w-full md:w-auto bg-[#0b1f67] hover:bg-[#0e2781] text-white px-6 py-2.5 rounded-lg font-semibold transition-all">
                Cek Booking
            </button>
        </form>
    </section>

    @if($booking)
    <section class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm relative">
        <!-- Header: Title & Status Tag -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Detail Booking Anda</h3>
                <p class="text-sm text-gray-500">Berikut informasi pemesanan Anda</p>
            </div>
            <!-- Status Badge (Menunggu Konfirmasi) -->
            <span class="px-6 py-2 rounded-full text-sm font-medium bg-[#fef9c3] text-[#713f12]">
                Menunggu Konfirmasi
            </span>
        </div>

        <div class="border-t border-gray-100 my-4"></div>

        <!-- Mobil & Driver Info -->
        <div class="flex justify-between items-center py-4 mb-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/images/car.png') }}" class="w-24 h-14 object-cover rounded-lg border" alt="car">
                <div>
                    <p class="text-xs text-gray-400">Nama Mobil:</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $booking->car_name }}</p>
                </div>
            </div>

            <!-- Driver Info (Sesuai gambar) -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/driver-placeholder.jpg') }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100" alt="driver">
                <div class="text-right">
                    <p class="text-xs text-gray-400">Nama Driver:</p>
                    <p class="font-bold text-gray-900 text-sm">Doki Marsel</p>
                </div>
            </div>
        </div>

        <!-- Info Grid (5 Columns sesuai image_86d53d.png) -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-y-8 gap-x-4 mb-8">
            <div>
                <label class="block text-xs text-gray-400 mb-1">Kode Booking:</label>
                <p class="font-bold text-gray-900">{{ $booking->booking_code }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Nama Penyewa:</label>
                <p class="font-bold text-gray-900">{{ $booking->customer_name }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Email:</label>
                <p class="font-bold text-gray-900 break-all">{{ $booking->email }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">No Telepon:</label>
                <p class="font-bold text-gray-900">{{ $booking->phone }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Durasi:</label>
                <p class="font-bold text-gray-900">{{ $booking->duration }} Hari</p>
            </div>

            <!-- Baris Kedua Grid -->
            <div>
                <label class="block text-xs text-gray-400 mb-1">Tanggal Pengambilan:</label>
                <p class="font-bold text-gray-900">{{ $booking->pickup_date }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Tanggal Pengembalian:</label>
                <p class="font-bold text-gray-900">{{ $booking->return_date }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Waktu Pengambilan:</label>
                <p class="font-bold text-gray-900">{{ $booking->pickup_time }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Waktu Pengembalian:</label>
                <p class="font-bold text-gray-900">{{ $booking->return_time }}</p>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Total Harga:</label>
                <p class="font-bold text-gray-900 text-lg">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="border-t border-gray-100 mb-6"></div>

        <!-- Action Button (Batalkan) -->
        <div class="flex justify-end">
            @if($booking->status == 'pending')
            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-[#a32a3e] hover:bg-[#852232] text-white px-8 py-2.5 rounded-lg font-semibold transition-colors">
                    Batalkan
                </button>
            </form>
            @endif
        </div>
    </section>
    @elseif(request()->has('booking_code'))
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <p class="text-gray-500">Data tidak ditemukan. Periksa kembali Email dan Kode Booking Anda.</p>
        </div>
    @endif
    <div x-data="{ showReview: true, rating: 0, hover: 0 }">

        <!-- MODAL 1: Form Rating & Ulasan -->
        <div x-show="showReview && !{{ session('review_success') ? 'true' : 'false' }}"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

            <div class="bg-white rounded-2xl w-full max-w-lg relative shadow-2xl overflow-hidden">
                <!-- Close Button -->
                <button @click="showReview = false" class="absolute top-4 right-6 text-gray-400 text-2xl hover:text-gray-600">✕</button>

                <!-- Header Title -->
                <div class="py-6 px-10 border-b border-blue-100">
                    <h2 class="text-center text-2xl font-extrabold text-[#0b1f67] italic tracking-tight">Perjalanan selesai!</h2>
                </div>

                <!-- Inner Card -->
                <div class="p-8">
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                        <form action="{{ route('review.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h3 class="text-center font-bold text-gray-800 mb-4">Bagaimana Pengalamanmu?</h3>

                            <!-- Star Rating System -->
                            <div class="flex justify-center gap-2 mb-6">
                                <input type="hidden" name="rating" :value="rating">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i" @mouseenter="hover = i" @mouseleave="hover = 0" class="transition-transform transform hover:scale-110">
                                        <svg class="w-10 h-10" :class="(hover || rating) >= i ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>

                            <!-- Comment Field -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 mb-2">Komentar *</label>
                                <textarea name="comment" required placeholder="Masukkan komentar"
                                    class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-900 outline-none h-24 resize-none bg-gray-50"></textarea>
                            </div>

                            <!-- Photo Upload Field -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-600 mb-2">Tambahkan Foto</label>
                                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                                    <label class="bg-gray-200 px-4 py-2.5 text-sm font-semibold cursor-pointer hover:bg-gray-300 transition">
                                        Choose File
                                        <input type="file" name="photo" class="hidden" @change="fileName = $event.target.files[0].name">
                                    </label>
                                    <span class="px-4 text-sm text-gray-500 italic" x-data="{ fileName: 'No file chosen' }" x-text="fileName"></span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-[#0b1f67] hover:bg-[#081647] text-white px-10 py-3 rounded-lg font-bold transition shadow-md">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL 2: Ulasan Berhasil Dikirim -->
        @if(session('review_success'))
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-3xl p-16 max-w-lg w-full text-center shadow-2xl mx-4">
                <!-- Green Checkmark Icon -->
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <div class="w-20 h-20 border-4 border-[#7ab356] rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-[#7ab356]" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <h3 class="text-3xl font-bold text-[#0b1f67] mb-3">Ulasan Berhasil Dikirim!</h3>
                <p class="text-gray-500 text-lg">Terima kasih telah memberikan ulasan.</p>

                <button @click="window.location.reload()" class="mt-10 text-gray-400 hover:text-gray-600 font-medium">Tutup</button>
            </div>
        </div>
        @endif

    </div>
</main>
@endsection