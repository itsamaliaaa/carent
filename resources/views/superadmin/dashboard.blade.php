@extends('layouts.admin')

@section('content')
<div class="p-6 flex flex-col gap-6">

    {{-- Header --}}
    <h1 class="text-2xl font-bold text-[#0B1F67]">Dashboard Super Admin</h1>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <p class="text-sm text-gray-500">Total Transaksi</p>
            <p class="text-2xl font-bold text-[#0B1F67] mt-1">{{ $totalTransaksi }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <p class="text-sm text-gray-500">Total Rental Aktif</p>
            <p class="text-2xl font-bold text-[#0B1F67] mt-1">{{ $totalRental }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <p class="text-2xl font-bold text-[#0B1F67] mt-1">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <p class="text-sm text-gray-500">Total Customer</p>
            <p class="text-2xl font-bold text-[#0B1F67] mt-1">{{ $totalUser }}</p>
        </div>

    </div>

    {{-- Daftar Rental --}}
    <div class="bg-white rounded-xl shadow-sm border p-5">
        <h2 class="text-base font-semibold text-[#0B1F67] mb-4">Daftar Rental</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="pb-3">Nama Rental</th>
                    <th class="pb-3">Kota</th>
                    <th class="pb-3">Total Booking</th>
                    <th class="pb-3">Total Pendapatan</th>
                    <th class="pb-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarRental as $rental)
                <tr class="border-b last:border-0">
                    <td class="py-3 font-medium">{{ $rental->nama_rental }}</td>
                    <td class="py-3">{{ $rental->kota }}</td>
                    <td class="py-3">{{ $rental->bookings_count }}</td>
                    <td class="py-3">Rp {{ number_format($rental->total_pendapatan, 0, ',', '.') }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $rental->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($rental->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-400">Belum ada rental</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection