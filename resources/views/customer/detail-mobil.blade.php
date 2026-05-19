@extends('layouts.customer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24">

    {{-- BACK --}}
    <a href="{{ route('katalog') }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-[#08174D] hover:text-[#0B1F67] transition">

        <i class="fa-solid fa-chevron-left text-xs"></i>
        Kembali

    </a>

    <div class="w-full h-[1px] bg-[#D9D9D9] mt-5"></div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_390px] gap-8 mt-10">

        {{-- LEFT CONTENT --}}
        <div>

            {{-- GALLERY --}}
            <div class="grid grid-cols-[1fr_120px] gap-4">

                {{-- MAIN IMAGE --}}
                <div>

                    <img
                        src="{{ $mobil->fotoPrimary
                            ? asset('storage/' . $mobil->fotoPrimary->url_foto)
                            : asset('images/default-car.png') }}"
                        alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-[420px] object-cover rounded-[12px]"
                    >

                </div>

                {{-- SIDE IMAGE --}}
                <div class="flex flex-col gap-4">

                    @foreach($mobil->fotos->take(2) as $foto)

                    <img
                        src="{{ asset('storage/' . $foto->url_foto) }}"
                        class="w-full h-[202px] object-cover rounded-[12px]"
                    >

                    @endforeach

                </div>

            </div>

            {{-- TITLE --}}
            <div class="mt-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>

                    {{-- STATUS --}}
                    <div class="inline-flex items-center px-4 py-1 rounded-full bg-[#62B33B] text-white text-xs font-medium">
                        Tersedia
                    </div>

                    <div class="flex items-center gap-4 mt-5 flex-wrap">

                        <h1 class="text-[34px] font-semibold text-[#111111] leading-none">
                            {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                        </h1>

                        <div class="flex items-center gap-2">

                            <div class="text-[#FFC107] text-sm">
                                ★★★★★
                            </div>

                            <span class="text-sm font-medium text-[#545454]">
                                (52 ulasan)
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- SPECS --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">

                <div class="border border-[#E5E7EB] rounded-[10px] p-4">
                    <p class="text-xs text-[#545454]">TRANSMISI</p>
                    <p class="mt-2 text-sm font-semibold text-[#111111]">
                        {{ ucfirst($mobil->transmisi) }}
                    </p>
                </div>

                <div class="border border-[#E5E7EB] rounded-[10px] p-4">
                    <p class="text-xs text-[#545454]">TAHUN</p>
                    <p class="mt-2 text-sm font-semibold text-[#111111]">
                        {{ $mobil->tahun }}
                    </p>
                </div>

                <div class="border border-[#E5E7EB] rounded-[10px] p-4">
                    <p class="text-xs text-[#545454]">KAPASITAS</p>
                    <p class="mt-2 text-sm font-semibold text-[#111111]">
                        {{ $mobil->kapasitas_penumpang }} Orang
                    </p>
                </div>

                <div class="border border-[#E5E7EB] rounded-[10px] p-4">
                    <p class="text-xs text-[#545454]">LOKASI</p>
                    <p class="mt-2 text-sm font-semibold text-[#111111]">
                        Bandung
                    </p>
                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-8">

                <p class="text-[15px] leading-[30px] text-[#545454]">
                    {{ $mobil->deskripsi }}
                </p>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- HOST --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Hosted By
                </h3>

                <div class="flex items-center gap-4 mt-5">

                    <img
                        src="{{ asset('images/rental.png') }}"
                        class="w-16 h-16 rounded-full object-cover"
                    >

                    <div>

                        <h4 class="text-lg font-semibold text-[#111111]">
                            {{ $mobil->rental->nama_rental }}
                        </h4>

                        <p class="text-sm text-[#545454] mt-1">
                            333 trips • Bergabung Dec 2024
                        </p>

                    </div>

                </div>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- PRICE DETAIL --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Transparasi Harga
                </h3>

                <div class="mt-6 space-y-5">

                    <div class="flex justify-between text-sm">
                        <p class="text-[#545454]">Sewa Dasar (per hari)</p>
                        <p class="font-semibold text-[#111111]">
                            Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}
                        </p>
                    </div>

                    <div class="flex justify-between text-sm">
                        <p class="text-[#545454]">Bahan Bakar</p>
                        <p class="font-semibold text-[#111111]">
                            Ditanggung Penyewa
                        </p>
                    </div>

                    <div class="flex justify-between text-sm">
                        <p class="text-[#545454]">Asuransi Kendaraan</p>
                        <p class="font-semibold text-[#111111]">
                            Tidak Termasuk
                        </p>
                    </div>

                    <div class="flex justify-between text-sm">
                        <p class="text-[#545454]">Driver (opsional)</p>
                        <p class="font-semibold text-[#111111]">
                            Rp 250.000/hari
                        </p>
                    </div>

                    <div class="flex justify-between text-sm">
                        <p class="text-[#545454]">Biaya Over Kilometer</p>
                        <p class="font-semibold text-[#111111]">
                            Rp 5.000/km
                        </p>
                    </div>

                </div>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- SYARAT --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Persyaratan Kendaraan
                </h3>

                <ul class="mt-5 space-y-3 text-sm leading-[28px] text-[#545454] list-disc pl-5">

                    <li>
                        Penyewa wajib melakukan pemeriksaan kendaraan sebelum digunakan.
                    </li>

                    <li>
                        STNK dan kelengkapan kendaraan wajib dijaga selama masa sewa.
                    </li>

                    <li>
                        Kendaraan harus dikembalikan dalam kondisi baik.
                    </li>

                    <li>
                        Seluruh kelengkapan kendaraan harus lengkap saat pengembalian.
                    </li>

                </ul>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- REVIEW --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Rating & Ulasan
                </h3>

                {{-- REVIEW BOX --}}
                <div class="border border-[#E5E7EB] rounded-[14px] p-6 mt-6">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-10">

                        <div>

                            <div class="flex items-center gap-2">

                                <h4 class="text-[40px] font-semibold text-[#111111] leading-none">
                                    5.0
                                </h4>

                                <span class="text-[#FFC107] text-xl">
                                    ★
                                </span>

                            </div>

                            <p class="text-sm text-[#545454] mt-2">
                                75 Rating & Ulasan
                            </p>

                        </div>

                        <div class="flex-1 space-y-3">

                            @for($i = 5; $i >= 1; $i--)

                            <div class="flex items-center gap-3">

                                <span class="text-sm text-[#545454]">
                                    {{ $i }}★
                                </span>

                                <div class="flex-1 h-2 bg-[#ECECEC] rounded-full overflow-hidden">

                                    <div class="h-full bg-[#0B1F67] rounded-full w-[90%]"></div>

                                </div>

                                <span class="text-xs text-[#545454]">
                                    (75)
                                </span>

                            </div>

                            @endfor

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <div>

            <div class="sticky top-24 border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                <div class="flex items-center justify-between">

                    <p class="text-sm text-[#545454]">
                        HARGA SEWA
                    </p>

                    <h3 class="text-[28px] font-semibold text-[#111111]">
                        Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}/hari
                    </h3>

                </div>

                {{-- FORM --}}
                <form class="mt-6 space-y-5">

                    <div>

                        <label class="block text-sm font-medium text-[#545454] mb-2">
                            Lokasi
                        </label>

                        <input
                            type="text"
                            placeholder="Pilih lokasi"
                            class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none"
                        >

                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Tanggal Pengambilan
                            </label>

                            <input
                                type="date"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none"
                            >

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Waktu
                            </label>

                            <input
                                type="time"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none"
                            >

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Tanggal Pengembalian
                            </label>

                            <input
                                type="date"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none"
                            >

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Waktu
                            </label>

                            <input
                                type="time"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none"
                            >

                        </div>

                    </div>

                    <div class="pt-3 space-y-4">

                        <div class="flex justify-between text-sm">

                            <p class="text-[#545454]">
                                Rp {{ number_format($mobil->harga_per_hari,0,',','.') }} x 1 hari
                            </p>

                            <p class="font-semibold text-[#111111]">
                                Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}
                            </p>

                        </div>

                        <div class="flex justify-between text-sm">

                            <p class="text-[#545454]">
                                Deposit
                            </p>

                            <p class="font-semibold text-[#111111]">
                                Rp 250.000
                            </p>

                        </div>

                        <div class="w-full h-[1px] bg-[#E5E7EB]"></div>

                        <div class="flex justify-between">

                            <p class="text-lg font-semibold text-[#111111]">
                                TOTAL
                            </p>

                            <p class="text-xl font-semibold text-[#0B1F67]">
                                Rp 550.000
                            </p>

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white font-semibold transition mt-2"
                    >
                        Lanjut Booking
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection