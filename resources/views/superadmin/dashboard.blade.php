@extends('layouts.admin')

@section('content')
<div class="p-6 flex flex-col gap-6">

{{-- Kartu Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    {{-- Total Transaksi --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border flex flex-col gap-1">
        <p class="text-xs text-gray-400 text-right">Total Transaksi</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
        <p class="text-xs flex items-center gap-1 {{ $persenTransaksi >= 0 ? 'text-green-500' : 'text-red-500' }}">
            <span>{{ $persenTransaksi >= 0 ? '↑' : '↓' }}</span>
            {{ abs($persenTransaksi) }}% dari bulan lalu
        </p>
    </div>

    {{-- Jumlah Rental --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border flex flex-col gap-1">
        <p class="text-xs text-gray-400 text-right">Jumlah Rental</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalRental, 0, ',', '.') }}</p>
        <p class="text-xs text-green-500 flex items-center gap-1">
            <span>↑</span> {{ $rentalBaru }} rental baru bulan ini
        </p>
    </div>

    {{-- Total Pendapatan --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border flex flex-col gap-1">
        <p class="text-xs text-gray-400 text-right">Total Pendapatan</p>
        <p class="text-3xl font-bold text-gray-900">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>
        <p class="text-xs flex items-center gap-1 {{ $persenPendapatan >= 0 ? 'text-green-500' : 'text-red-500' }}">
            <span>{{ $persenPendapatan >= 0 ? '↑' : '↓' }}</span>
            {{ abs($persenPendapatan) }}% dari bulan lalu
        </p>
    </div>

    {{-- Jumlah Pengguna --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border flex flex-col gap-1">
        <p class="text-xs text-gray-400 text-right">Jumlah Pengguna</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalUser, 0, ',', '.') }}</p>
        <p class="text-xs text-green-500 flex items-center gap-1">
            <span>↑</span> {{ $userBaru }} pengguna baru bulan ini
        </p>
    </div>

</div>

    {{-- Laporan Total Pendapatan --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col gap-5">

        {{-- Header Laporan --}}
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-base font-bold text-gray-900">Laporan Total Pendapatan</h2>
                <p class="text-xs text-gray-400 mt-0.5">Saring data berdasarkan periode, rental, dan kota</p>
            </div>
            <button form="formFilter" type="submit"
                    class="bg-[#0B1F67] hover:bg-[#0e2781] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                Terapkan Filter
            </button>
        </div>

        {{-- Form Filter --}}
        <form id="formFilter" action="{{ route('superadmin.dashboard') }}" method="GET">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Tanggal Mulai --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs text-gray-500">Tanggal Mulai</label>
                    <input type="date" name="dari"
                        value="{{ request('dari') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#0B1F67]
                                {{ $errors->has('dari') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    @error('dari')
                        <span class="text-red-500 text-[11px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Akhir --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs text-gray-500">Tanggal Akhir</label>
                    <input type="date" name="sampai"
                        value="{{ request('sampai') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#0B1F67]
                                {{ $errors->has('sampai') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    @error('sampai')
                        <span class="text-red-500 text-[11px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Filter Perusahaan --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs text-gray-500">Perusahaan</label>
                    <select name="rental_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#0B1F67] appearance-none bg-white">
                        <option value="">Semua</option>
                        @foreach($semuaRental as $r)
                            <option value="{{ $r->rental_id }}" {{ request('rental_id') == $r->rental_id ? 'selected' : '' }}>
                                {{ $r->nama_rental }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kota --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs text-gray-500">Kota</label>
                    <select name="kota"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#0B1F67] appearance-none bg-white">
                        <option value="">Semua Kota</option>
                        @foreach($semuaKota as $kota)
                            <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>
                                {{ $kota }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </form>
    </div>

    {{-- Wrapper utama --}}
    <div class="flex flex-col lg:flex-row gap-4">

        {{-- Tabel Rental --}}
        <div class="flex-1 bg-white rounded-2xl shadow-sm border p-6 overflow-x-auto">

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3 font-semibold">Perusahaan</th>
                        <th class="pb-3 font-semibold">Kota</th>
                        <th class="pb-3 font-semibold">Transaksi</th>
                        <th class="pb-3 font-semibold">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftarRental as $rental)
                    <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                        <td class="py-3.5 font-medium text-gray-800">{{ $rental->nama_rental }}</td>
                        <td class="py-3.5 text-gray-600">{{ $rental->kota }}</td>
                        <td class="py-3.5 text-gray-600">{{ $rental->bookings_count }}</td>
                        <td class="py-3.5 text-gray-800 font-semibold">
                            Rp {{ number_format($rental->total_pendapatan, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-gray-400">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-5">
                {{ $daftarRental->links() }}
            </div>

        </div>

    {{-- Summary Kanan (4 card) --}}
    <div class="w-full lg:w-[240px] shrink-0 flex flex-col gap-3">

        {{-- Total Pendapatan --}}
        <div class="bg-blue-50 rounded-2xl px-5 py-4">
            <p class="text-[10px] text-gray-800 uppercase tracking-widest font-semibold mb-1">
                Total Pendapatan
            </p>
            <p class="text-xl font-bold text-black-800">
                Rp {{ number_format($summaryPendapatan, 0, ',', '.') }}
            </p>
        </div>

        {{-- Jumlah Transaksi --}}
        <div class="bg-blue-50 rounded-2xl px-5 py-4">
            <p class="text-[10px] text-gray-800 uppercase tracking-widest font-semibold mb-1">
                Jumlah Transaksi
            </p>
            <p class="text-xl font-bold text-black-800">
                {{ $summaryTransaksi }}
            </p>
        </div>

        {{-- Rata-rata Per Transaksi --}}
        <div class="bg-blue-50 rounded-2xl px-5 py-4">
            <p class="text-[10px] text-gray-800 uppercase tracking-widest font-semibold mb-1">
                Rata - Rata Per Transaksi
            </p>
            <p class="text-xl font-bold text-black-800">
                Rp {{ $summaryTransaksi > 0
                    ? number_format($summaryPendapatan / $summaryTransaksi, 0, ',', '.')
                    : 0 }}
            </p>
        </div>

        {{-- Periode --}}
        <div class="bg-blue-50 rounded-2xl px-5 py-4">
            <p class="text-[10px] text-gray-800 uppercase tracking-widest font-semibold mb-1">
                Periode
            </p>
            <p class="text-sm font-bold text-black-800">
                {{ request('dari')
                    ? \Carbon\Carbon::parse(request('dari'))->format('Y-m-d')
                    : '-' }}
                s/d
                {{ request('sampai')
                    ? \Carbon\Carbon::parse(request('sampai'))->format('Y-m-d')
                    : '-' }}
            </p>
        </div>

    </div>

</div>

</div>
@endsection