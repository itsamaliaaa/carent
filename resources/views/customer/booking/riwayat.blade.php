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
</main>
@endsection
