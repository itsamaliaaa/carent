@extends('layouts.admin')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="min-h-screen bg-[#F0F2F5] p-6 text-[#2D3748]">

    {{-- Header Greeting --}}
    <h1 class="text-[20px] font-bold mb-5">Selamat datang, Admin!</h1>

    {{-- Rental Info Card --}}
    <div class="bg-white rounded-2xl flex items-center justify-between p-4 mb-5 shadow-sm border border-gray-100">
        <div class="flex items-center gap-4">
            <div class="w-120">
                <img src="{{ asset('images/logo/logo-dashboard.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="flex items-center mr-4 gap-2">
            <span class="text-yellow-400 text-lg">★</span>
            <span class="font-bold text-lg">{{ number_format($avgRating, 1) }}</span>
            <div class="h-6 w-px bg-gray-200 mx-2"></div>
            <span class="text-[#2D3748] font-bold text-base">{{ $totalReview }}</span>
            <span class="text-gray-400 text-sm">Penilaian</span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        @php
            $statsData = [
                ['label' => 'Total Pendapatan Hari Ini',      'value' => $pendapatanHariIni      ?? 0, 'is_currency' => true],
                ['label' => 'Total Pendapatan Bulan Ini',     'value' => $pendapatanBulanIni     ?? 0, 'is_currency' => true],
                ['label' => 'Total Pendapatan Keseluruhan',   'value' => $pendapatanKeseluruhan  ?? 0, 'is_currency' => true],
                ['label' => 'Jumlah Transaksi Berhasil',      'value' => $transaksiBerhasil      ?? 0, 'is_currency' => false],
            ];
        @endphp

        @foreach($statsData as $stat)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-[150px] flex flex-col justify-between">
            <p class="text-sm text-gray-400 leading-tight w-3/4">{{ $stat['label'] }}</p>
            <p class="text-[32px] font-bold text-[#2D3748] text-right">
                @if($stat['is_currency'])
                    @php $val = $stat['value']; @endphp
                    @if($val >= 1000000000)
                        Rp {{ number_format($val / 1000000000, 1, ',', '.') }} M
                    @elseif($val >= 1000000)
                        Rp {{ number_format($val / 1000000, 1, ',', '.') }} jt
                    @elseif($val >= 1000)
                        Rp {{ number_format($val / 1000, 0, ',', '.') }} rb
                    @else
                        Rp {{ number_format($val, 0, ',', '.') }}
                    @endif
                @else
                    {{ number_format($stat['value'], 0, ',', '.') }}
                @endif
            </p>
        </div>
        @endforeach
    </div>

    {{-- Laporan Total Pendapatan --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-5 border border-gray-100">
        <div class="flex flex-col gap-1 mb-5">
            <h2 class="font-bold text-gray-800 text-lg">Laporan Total Pendapatan</h2>
            <p class="text-xs text-gray-400">Saring data berdasarkan periode rental</p>
        </div>
        <hr class="border-gray-100 mb-5">

        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="flex items-end gap-4 mb-5">

                <div class="flex flex-1 flex-col gap-1">
                    <label class="text-sm font-semibold text-gray-600">Tanggal Mulai</label>
                    <div class="relative">
                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-3 text-sm focus:ring-1 focus:ring-[#1D2B6B] focus:border-[#1D2B6B] text-gray-500 bg-white">
                    </div>
                </div>

                <span class="text-sm text-gray-400 pb-3">s/d</span>

                <div class="flex flex-1 flex-col gap-1">
                    <label class="text-sm font-semibold text-gray-600">Tanggal Akhir</label>
                    <div class="relative">
                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-3 text-sm focus:ring-1 focus:ring-[#1D2B6B] focus:border-[#1D2B6B] text-gray-500 bg-white">
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-[#1D2B6B] text-white px-8 py-3 rounded-xl font-bold text-sm hover:bg-[#152050] transition duration-150 whitespace-nowrap">
                    Terapkan Filter
                </button>
            </div>

            {{-- Hasil Filter --}}
            @php
                $displayPendapatan = $pendapatanFilter ?? 0;
                $displayTransaksi  = $jumlahTransaksiFilter ?? 0;
                $displayPeriodeStr = request('start_date') && request('end_date')
                    ? request('start_date') . ' s/d ' . request('end_date')
                    : 'dd/mm/tttt s/d dd/mm/tttt';
                $displayRata = $displayTransaksi > 0 ? $displayPendapatan / $displayTransaksi : 0;
            @endphp

            <div class="flex gap-3 mt-2">

                <div class="bg-[#F0F2F5] rounded-xl p-4 min-h-[80px] flex flex-col justify-between flex-1">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide leading-tight whitespace-nowrap">TOTAL PENDAPATAN</p>
                    <p class="text-base font-extrabold text-[#2D3748] mt-2">
                        Rp {{ number_format($displayPendapatan, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-[#F0F2F5] rounded-xl p-4 min-h-[80px] flex flex-col justify-between flex-1">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide leading-tight whitespace-nowrap">JUMLAH TRANSAKSI</p>
                    <p class="text-base font-extrabold text-[#2D3748] mt-2">
                        {{ number_format($displayTransaksi, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-[#F0F2F5] rounded-xl p-4 min-h-[80px] flex flex-col justify-between flex-[2]">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide leading-tight">PERIODE</p>
                    <p class="text-base font-extrabold text-[#2D3748] mt-2 whitespace-nowrap">
                        {{ $displayPeriodeStr }}
                    </p>
                </div>

                <div class="bg-[#F0F2F5] rounded-xl p-4 min-h-[80px] flex flex-col justify-between flex-1">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide leading-tight whitespace-nowrap">RATA - RATA PER TRANSAKSI</p>
                    <p class="text-base font-extrabold text-[#2D3748] mt-2">
                        Rp {{ number_format($displayRata, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        </form>
    </div>

    {{-- Bottom Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">

        {{-- Top 5 Mobil --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-800 text-lg mb-1">Top 5 Mobil Paling Laris</h2>
            <p class="text-xs text-gray-400 mb-5">Berdasarkan total transaksi berhasil</p>

            <div class="flex flex-col gap-4">
                @forelse($topMobil as $index => $mobil)
                <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-2 h-[80px]">
                    <div class="w-[50px] h-full flex items-center justify-center rounded-lg @if($index+1 == 1) bg-[#F1F3F9] text-[#1D2B6B] @else bg-[#E2E8F0] text-gray-500 @endif text-xl font-extrabold">
                        {{ $index + 1 }}.
                    </div>
                    <div class="w-20 h-14 rounded-lg bg-gray-100 overflow-hidden">
                        <img src="{{ Storage::url($mobil->url_foto) }}" alt="{{ $mobil->nama_mobil }}" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-extrabold text-[#2D3748]">{{ $mobil->nama_mobil }}</p>
                        <p class="text-xs text-gray-400 font-medium">{{ $mobil->total_booking }}x disewa</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada data</p>
                @endforelse
            </div>
        </div>

        {{-- Jumlah Penyewaan Per Mobil --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-800 text-lg text-center mb-1">Jumlah Penyewaan Per Mobil</h2>
            <p class="text-xs text-gray-400 text-center mb-5">Bulan Ini</p>
            <hr class="border-gray-100 mb-5">

            <div class="flex flex-col gap-3">
                @php
                    $collection = collect($penyewaanPerMobil ?? []);
                    $max = $collection->max('total_booking') > 0 ? $collection->max('total_booking') : 1;
                @endphp

                @forelse($collection as $item)
                <div class="flex items-center gap-4">
                    <p class="text-xs font-semibold text-gray-700 w-40 truncate">{{ $item->nama_mobil }}</p>
                    <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden relative">
                        <div class="h-4 rounded-full bg-[#5C7CFA]" style="width: {{ ($item->total_booking / $max) * 100 }}%"></div>
                    </div>
                    <span class="text-xs font-semibold w-10 text-right text-gray-400">({{ $item->total_booking }})</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection