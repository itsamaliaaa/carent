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
        <!-- Result Card -->
        <section class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-lg">Detail Booking Anda</h3>
                    <p class="text-sm text-gray-500">Berikut informasi pemesanan Anda</p>
                </div>
                <span class="px-4 py-1 rounded-full text-xs font-medium
                    {{ $booking->status == 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div class="flex items-center gap-4 py-4 border-t border-gray-100 mb-4">
                <img src="{{ asset('assets/images/car.png') }}" class="w-20 h-12 object-cover rounded-md" alt="car">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase">Nama Mobil:</p>
                    <p class="font-bold text-gray-900">{{ $booking->car_name }}</p>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-6 py-4">
                <div>
                    <label class="block text-[10px] text-gray-400 uppercase">Kode Booking</label>
                    <p class="font-semibold text-gray-800">{{ $booking->booking_code }}</p>
                </div>
                <div>
                    <label class="block text-[10px] text-gray-400 uppercase">Nama Penyewa</label>
                    <p class="font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                </div>
                <!-- ... Repeat for other fields ... -->
            </div>

            <div class="flex justify-between items-end border-t border-gray-100 pt-6 mt-4">
                <div>
                    <label class="block text-[10px] text-gray-400 uppercase">Durasi</label>
                    <p class="font-semibold text-gray-800">{{ $booking->duration }} Hari</p>
                </div>
                <div class="text-right">
                    <label class="block text-[10px] text-gray-400 uppercase">Total Harga</label>
                    <p class="text-xl font-bold text-gray-900 text-blue-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </section>
    @elseif(request()->has('booking_code'))
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <p class="text-gray-500">Data tidak ditemukan. Periksa kembali Email dan Kode Booking Anda.</p>
        </div>
    @endif
</main>
@endsection
