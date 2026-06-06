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
                    id="progressCircleProfRent"
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

                <span id="progressTextProfRent" class="text-2xl font-bold text-[#0B1F67]">
                    0%
                </span>

            </div>

        </div>

    </div>

     {{-- BACK --}}
    <a href="{{ url()->previous() }}"
        class="inline-flex items-center gap-2 text-sm font-medium text-[#08174D] hover:underline">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        Kembali
    </a>

    {{-- PROFILE RENTAL --}}
    <div class="mt-8 flex flex-col lg:flex-row justify-between gap-8">

        {{-- KIRI --}}
        <div class="flex items-center gap-5">

            <img
                src="{{ $rental->logo_perusahaan
                    ? asset('storage/' . $rental->logo_perusahaan)
                    : asset('images/rental.png') }}"
                class="w-24 h-24 rounded-full object-cover border border-[#E5E7EB]">

            <div>
                <h1 class="text-2xl font-semibold text-[#111111]">
                    {{ $rental->nama_rental }}
                </h1>

                <div class="flex items-center gap-2 mt-2">
                    <span class="text-[#FFC107]">
                        ★★★★★
                    </span>

                    <span class="font-semibold">
                        {{ $rating }}
                    </span>
                </div>
            </div>

        </div>

        {{-- KANAN --}}
        <div class="grid grid-cols-3 gap-4">

            <div class="bg-[#F5F7FB] rounded-[16px] px-8 py-5 text-center">
                <p class="text-[28px] font-semibold text-[#08174D]">
                    {{ $totalMobil }}
                </p>

                <p class="text-sm text-[#545454]">
                    Mobil tersedia
                </p>
            </div>

            <div class="bg-[#F5F7FB] rounded-[16px] px-8 py-5 text-center">
                <p class="text-[28px] font-semibold text-[#08174D]">
                    {{ $totalTrip }}
                </p>

                <p class="text-sm text-[#545454]">
                    Total trip
                </p>
            </div>

            <div class="bg-[#F5F7FB] rounded-[16px] px-8 py-5 text-center">
                <p class="text-[22px] font-semibold text-[#08174D]">
                    {{ \Carbon\Carbon::parse($rental->created_at)->translatedFormat('M Y') }}
                </p>

                <p class="text-sm text-[#545454]">
                    Bergabung sejak
                </p>
            </div>
        </div>

    </div>

    {{-- INFO --}}
    <div class="mt-10 border border-[#E5E7EB] rounded-[20px] p-8 bg-white">

        <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-10">

            {{-- ALAMAT --}}
            <div class="flex items-start gap-3">

                <div class="w-10 h-10 rounded-[10px] bg-[#08174D] flex items-center justify-center flex-shrink-0">
                    <img
                        src="{{ asset('images/icons/location-04 (2).svg') }}"
                        class="w-5 h-5">
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-[#111111]">
                        Alamat
                    </h3>

                    <p class="text-sm text-[#545454] mt-1 leading-6">
                        {{ $rental->alamat }}
                    </p>
                </div>

            </div>

            {{-- HUBUNGI --}}
            <div class="flex items-start gap-3 lg:justify-self-end">

                <div class="w-10 h-10 rounded-[10px] bg-[#08174D] flex items-center justify-center flex-shrink-0">
                    <img
                        src="{{ asset('images/icons/call (1).svg') }}"
                        class="w-5 h-5">
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-[#111111]">
                        Hubungi Kami
                    </h3>

                    <div class="mt-1 space-y-1">
                        <p class="text-sm text-[#545454]">
                            WhatsApp: {{ $rental->no_telp }}
                        </p>

                        <p class="text-sm text-[#545454]">
                            Email: {{ $rental->email }}
                        </p>
                    </div>
                </div>

            </div>

        </div>

        <div class="w-full h-[1px] bg-[#E5E7EB] my-8"></div>

        {{-- DESKRIPSI --}}
        <p class="text-[#545454] leading-[32px]">
            {{ $rental->deskripsi }}
        </p>

    </div>

    {{-- SEARCH --}}
    <form
        id="searchFormProfRent"
        method="GET"
        action="{{ route('rental.profil', $rental->rental_id) }}"
        class="mt-12">

        <div class="flex flex-col sm:flex-row gap-4">

            <div class="relative flex-1">
                <img
                    src="{{ asset('images/icons/search.svg') }}"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5">
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
                class="flex w-full sm:w-[166px] h-12 justify-center items-center rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white text-sm font-semibold transition">
                Cari
            </button>

        </div>

    </form>

    {{-- MOBIL --}}
    <section class="mt-12">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 justify-items-start">
            
            @foreach($mobils as $mobil)
            <a
                href="{{ route('mobil.detail', $mobil->mobil_id) }}"
                class="flex flex-col w-full sm:max-w-[344px] rounded-[25px] border border-[#D9D9D9] bg-[#FEFEFE] overflow-hidden transition duration-200 hover:ring-2 hover:ring-[#0B1F67] hover:border-transparent">
                
                <div class="relative">
                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[220px] sm:h-[210px] object-cover">

                    <div class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full">
                        Tersedia
                    </div>
                </div>

                <div class="flex flex-col flex-1 p-5">
                    <h3 class="text-black text-lg font-semibold">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h3>

                    <div class="flex items-center gap-2 mt-2">
                        <div class="text-yellow-400 text-sm">
                            ★★★★★
                        </div>

                        <span class="text-sm font-medium text-gray-700">
                            4.9
                        </span>

                        <span class="text-sm text-gray-400">
                            (50 Ulasan)
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mt-4 text-sm text-gray-500">
                        <span>
                            {{ ucfirst($mobil->transmisi) }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $mobil->kapasitas_penumpang }} Kursi
                        </span>
                    </div>

                    <div class="w-full h-[1px] bg-[#E5E7EB] mt-4"></div>

                    <div class="flex items-end justify-between mt-4">
                        <p class="text-[#545454] text-sm">
                            Mulai dari
                        </p>

                        <p class="text-[#06123A] text-lg font-semibold">
                            Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}/hari
                        </p>
                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </section>

    {{-- PAGINATION --}}
    <div class="mt-16 flex justify-end">

        @if(method_exists($mobils,'links'))
            {{ $mobils->links() }}
        @endif

    </div>

</div>

<script>

    const searchForm = document.getElementById('searchFormProfRent');
    const loadingOverlay = document.getElementById('loadingOverlay');

    if (searchForm && loadingOverlay) {

        searchForm.addEventListener('submit', function () {

            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');

            let progress = 0;

            const circle = document.getElementById('progressCircleProfRent');
            const text = document.getElementById('progressTextProfRent');

            const interval = setInterval(() => {

                progress += 10;

                text.innerText = progress + '%';

                const offset = 314 - (314 * progress / 100);

                circle.style.strokeDashoffset = offset;

                if (progress >= 100) {
                    clearInterval(interval);
                }

            }, 80);

        });

    }

</script>

@endsection