@extends('layouts.customer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24">

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">

        <div class="relative w-32 h-32">

            <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">

                <circle
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#E5E7EB"
                    stroke-width="10"
                />

                <circle
                    id="progressCircleKatalog"
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#0B1F67"
                    stroke-width="10"
                    stroke-linecap="round"
                    stroke-dasharray="314"
                    stroke-dashoffset="314"
                    style="transition: stroke-dashoffset 0.3s ease"
                />

            </svg>

            <div class="absolute inset-0 flex items-center justify-center">

                <span id="progressTextKatalog" class="text-2xl font-bold text-[#0B1F67]">
                    0%
                </span>

            </div>

        </div>

    </div>

    {{-- HERO SECTION --}}
    <section class="bg-[#0B1F67] rounded-[10px] p-4 sm:p-6">

        <div class="mb-6">

            <h1 class="text-white text-2xl sm:text-[32px] font-semibold leading-tight">
                Cek Ketersediaan Mobil
            </h1>

        </div>

        {{-- FORM --}}
        <form
            id="searchFormKatalog"
            action="{{ route('katalog') }}"
            method="GET"
            class="bg-[#ECECF3] rounded-[10px] p-4"
        >

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4 items-end">

                {{-- LOKASI --}}
                <div class="lg:col-span-2">

                    <label class="block text-sm font-medium text-[#545454] mb-2">
                        Lokasi
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            name="lokasi"
                            placeholder="Pilih lokasi"
                            value="{{ request('lokasi') }}"
                            class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                        >

                        <img
                            src="{{ asset('images/icons/location-04.svg') }}"
                            class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2"
                        >

                    </div>

                </div>

                {{-- TANGGAL PENGAMBILAN --}}
                <div>

                    <label class="block text-sm font-medium text-[#545454] mb-2">
                        Tanggal Pengambilan
                    </label>

                    <input
                        type="date"
                        name="tanggal_sewa"
                        value="{{ request('tanggal_sewa') }}"
                        class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                    >

                </div>

                {{-- WAKTU --}}
                <div>

                    <label class="block text-sm font-medium text-[#545454] mb-2">
                        Waktu
                    </label>

                    <input
                        type="time"
                        name="waktu_ambil"
                        value="{{ request('waktu_ambil') }}"
                        class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                    >

                </div>

                {{-- TANGGAL PENGEMBALIAN --}}
                <div>

                    <label class="block text-sm font-medium text-[#545454] mb-2 whitespace-nowrap">
                        Tanggal Pengembalian
                    </label>

                    <input
                        type="date"
                        name="tanggal_kembali"
                        value="{{ request('tanggal_kembali') }}"
                        class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                    >

                </div>

                {{-- WAKTU PENGEMBALIAN --}}
                <div>

                    <label class="block text-sm font-medium text-[#545454] mb-2">
                        Waktu
                    </label>

                    <input
                        type="time"
                        name="waktu_kembali"
                        value="{{ request('waktu_kembali') }}"
                        class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                    >

                </div>
                {{-- BUTTON --}}
                <div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white font-semibold transition"
                    >
                        Cek
                    </button>

                </div>

            </div>

        </form>

    </section>


    <form id="filterForm" action="{{ route('katalog') }}" method="GET">
        
        {{-- FILTER --}}
        <section class="mt-6 bg-[#E7E9F2] rounded-[10px] px-10 py-4">
        
            {{-- FILTER --}}
            <input type="hidden" name="kategori" id="kategoriInput" value="{{ request('kategori') }}">
            <input type="hidden" name="transmisi" id="transmisiInput" value="{{ request('transmisi') }}">
            <input type="hidden" name="kapasitas" id="kapasitasInput" value="{{ request('kapasitas') }}">

            {{-- SEARCH & CEK KETERSEDIAAN --}}
            <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
            <input type="hidden" name="tanggal_sewa" value="{{ request('tanggal_sewa') }}">
            <input type="hidden" name="waktu_ambil" value="{{ request('waktu_ambil') }}">
            <input type="hidden" name="tanggal_kembali" value="{{ request('tanggal_kembali') }}">
            <input type="hidden" name="waktu_kembali" value="{{ request('waktu_kembali') }}">
            <input type="hidden" name="cari" value="{{ request('cari') }}">

            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-center gap-12">

                {{-- KATEGORI --}}
                <div class="flex flex-col gap-3 lg:w-[42%]">

                    <p class="text-xs font-semibold text-[#545454] uppercase">
                        Kategori
                    </p>

                    <div class="flex flex-wrap items-center gap-2">

                        <button type="button"
                            onclick="setFilter('kategori','')"
                            class="filter-btn px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kategori') == '' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Semua
                        </button>

                        <button type="button"
                            onclick="setFilter('kategori','keluarga')"
                            class="filter-btn px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kategori') == 'keluarga' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Keluarga
                        </button>

                        <button type="button"
                            onclick="setFilter('kategori','harian')"
                            class="filter-btn px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kategori') == 'harian' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Harian
                        </button>

                        <button type="button"
                            onclick="setFilter('kategori','rombongan')"
                            class="filter-btn px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kategori') == 'rombongan' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Rombongan
                        </button>

                    </div>

                </div>

                {{-- TRANSMISI --}}
                <div class="flex flex-col gap-3 lg:w-[24%]">

                    <p class="text-xs font-semibold text-[#545454] uppercase">
                        Transmisi
                    </p>

                    <div class="flex flex-wrap gap-2">

                        <button type="button"
                            onclick="setFilter('transmisi','')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('transmisi') == '' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Semua
                        </button>

                        <button type="button"
                            onclick="setFilter('transmisi','matic')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('transmisi') == 'matic' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Matic
                        </button>

                        <button type="button"
                            onclick="setFilter('transmisi','manual')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('transmisi') == 'manual' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            Manual
                        </button>

                    </div>

                </div>

                {{-- KAPASITAS --}}
                <div class="flex flex-col gap-3 lg:w-[26%]">

                    <p class="text-xs font-semibold text-[#545454] uppercase">
                        Kapasitas
                    </p>

                    <div class="flex flex-wrap gap-2">
                        
                        <button type="button"
                            onclick="setFilter('kapasitas','5')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kapasitas') == '5' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            5 kursi
                        </button>

                        <button type="button"
                            onclick="setFilter('kapasitas','7')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kapasitas') == '7' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            7 kursi
                        </button>

                        <button type="button"
                            onclick="setFilter('kapasitas','12')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium
                            {{ request('kapasitas') == '12' ? 'bg-[#0B1F67] text-white' : 'bg-white border border-[#D9D9D9]' }}">
                            12+ kursi
                        </button>

                    </div>

                </div>

            </div>

        </section>

        {{-- SEARCH --}}
        <section class="mt-6">

            <div class="flex flex-col sm:flex-row gap-4">

                <div class="relative flex-1">

                    <img
                        src="{{ asset('images/icons/search.svg') }}"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5"
                    >

                    <input
                        type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Cari Tipe Mobil"
                        class="w-full h-12 rounded-[8px] border border-[#D9D9D9] bg-white pl-12 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67]"
                    >

                </div>

                <button
                    type="submit"
                    class="flex w-full sm:w-[166px] h-12 px-7 py-[14px] justify-center items-center rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white text-sm font-semibold transition"
                >
                    Cari
                </button>
        
            </div>
        </section>
    </form>


    <section class="mt-14">

        <div class="mb-8">

            @if($isFilter)

                <h2 class="text-black text-2xl font-semibold leading-[36px]">
                    {{ $mobils->total() }} Mobil Yang Tersedia
                </h2>

                <p class="text-[#545454] text-base font-medium leading-[28px]">
                    Pilih mobil yang paling cocok buat perjalananmu
                </p>

            @else

                <h2 class="text-black text-2xl font-semibold leading-[36px]">
                    Daftar Mobil
                </h2>

                <p class="text-[#545454] text-base font-medium leading-[28px]">
                    Temukan mobil yang sesuai kebutuhanmu
                </p>

            @endif

        </div>
        
        @if($mobils->count())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                @foreach($mobils as $mobil)

                    {{-- CARD MOBIL --}}
                    <a
                        href="{{ route('mobil.detail', ['id' => $mobil->mobil_id,'from' => 'katalog']) }}"
                        class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent"
                    >

                        {{-- IMAGE --}}
                        <div class="relative">

                            <img
                                src="{{ $mobil->fotoPrimary
                                    ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                                    : asset('images/default-car.png') }}"
                                alt="{{ $mobil->nama_mobil }}"
                                class="w-full h-[190px] sm:h-[210px] object-cover"
                            >

                            <div class="absolute top-4 left-4 bg-green-600 text-white text-xs font-medium px-3 py-1 rounded-full">
                                Tersedia
                            </div>

                        </div>

                        {{-- CONTENT --}}
                        <div class="flex flex-col flex-1 p-5">

                            <h3 class="text-black text-base font-semibold leading-[28px] w-full">
                                {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                            </h3>

                            {{-- RATING --}}
                            <div class="flex items-center gap-2 mt-2">

                                @php
                                    $rating = round($mobil->reviews_avg_rating ?? 0);
                                @endphp

                                <div class="text-yellow-400 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rating ? '★' : '☆' }}
                                    @endfor
                                </div>

                                <span class="text-sm font-medium text-gray-700">
                                    {{ number_format($mobil->reviews_avg_rating ?? 0, 1) }}
                                </span>

                                <span class="text-sm text-gray-400">
                                    ({{ $mobil->reviews_count }} Ulasan)
                                </span>

                            </div>

                            {{-- INFO --}}
                            <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">

                                <span>
                                    {{ ucfirst($mobil->transmisi) }}
                                </span>

                                <span>•</span>

                                <span>
                                    {{ $mobil->kapasitas_penumpang }} Kursi
                                </span>

                            </div>

                            <div class="w-full h-[1px] bg-[#C1C1C1] mt-3"></div>

                            {{-- PRICE --}}
                            <div class="flex items-end justify-between mt-3">

                                <p class="text-[#545454] text-sm font-normal leading-6">
                                    Mulai dari
                                </p>

                                <p class="text-[#06123A] text-base font-semibold leading-6">
                                    Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                                </p>

                            </div>
                        </div>
                    </a>

                 @endforeach

            </div>

        @else

            <div class="text-center py-20">
                <h3 class="text-xl font-semibold text-gray-700">
                    Mobil tidak ditemukan
                </h3>

                <p class="text-gray-500 mt-2">
                    Coba ubah filter pencarianmu
                </p>
            </div>

        @endif
    </section>

    <!-- PAGINATION -->
    @if($mobils->hasPages())

        <section class="mt-16 flex justify-end">
            {{ $mobils->links() }}
        </section>

    @endif

</div>

<script>

    function setFilter(type, value) {
        document.getElementById(type + 'Input').value = value;
        document.getElementById('filterForm').submit();
    }

    // LOADING
    const searchForm = document.getElementById('searchFormKatalog');
    const filterForm = document.getElementById('filterForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    function showLoading() {

        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        let progress = 0;

        const circle = document.getElementById('progressCircleKatalog');
        const text = document.getElementById('progressTextKatalog');

        const interval = setInterval(() => {

            progress += 10;

            text.innerText = progress + '%';

            const offset = 314 - (314 * progress / 100);

            circle.style.strokeDashoffset = offset;

            if (progress >= 100) {

                clearInterval(interval);

            }

        }, 80);
    }

    searchForm.addEventListener('submit', showLoading);
    filterForm.addEventListener('submit', showLoading);
</script>

@endsection