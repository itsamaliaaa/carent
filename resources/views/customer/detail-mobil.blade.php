@extends('layouts.customer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24">

     {{-- BACK --}}
    <a href="{{ session('detail_mobil_back', route('beranda')) }}"
    class="inline-flex items-center gap-2 text-sm font-medium text-[#08174D] hover:underline">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        Kembali
    </a>

    <div class="w-full h-[1px] bg-[#D9D9D9] mt-5"></div>

    {{-- GALLERY FULL --}}
    <div class="mt-8">

        <div class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory">

            @foreach($mobil->fotos as $foto)

            <img
                src="{{ asset('storage/' . $foto->url_foto) }}"
                class="min-w-full h-[500px] object-cover rounded-[18px] snap-center"
            >

            @endforeach

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_390px] gap-10 mt-10">

        {{-- LEFT --}}
        <div>

            {{-- TITLE --}}
            <div>

                <div class="inline-flex items-center px-4 py-1 rounded-full bg-[#62B33B] text-white text-xs font-medium">
                    Tersedia
                </div>

                <div class="flex items-center gap-5 mt-5 flex-wrap">

                    <h1 class="text-[34px] font-semibold text-[#111111] leading-none">
                        {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                    </h1>

                    <div class="flex items-center gap-2">

                        @php
                            $starRating = round($averageRating ?? 0);
                        @endphp

                        <div class="text-[#FFC107] text-sm">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $starRating ? '★' : '☆' }}
                            @endfor
                        </div>

                        <span class="text-sm font-medium text-[#545454]">
                            {{ number_format($averageRating ?? 0, 1) }}
                        </span>

                        <span class="text-sm font-medium text-[#545454]">
                            ({{ $reviews->count() }} ulasan)
                        </span>

                    </div>

                </div>
            </div>

            {{-- SPECS --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">

                <div class="border border-[#E5E7EB] rounded-[12px] p-4 flex items-center gap-3">
                        <img
                            src="{{ asset('images/icons/container-truck-01.svg') }}"
                            class="w-7 h-7 object-contain"
                        >
                    <div>
                        <p class="text-xs text-[#545454]">TRANSMISI</p>
                        <p class="text-sm font-semibold text-[#111111] mt-1">
                            {{ ucfirst($mobil->transmisi) }}
                        </p>
                    </div>

                </div>

                <div class="border border-[#E5E7EB] rounded-[12px] p-4 flex items-center gap-3">
                        <img
                            src="{{ asset('images/icons/calendar-03.svg') }}"
                            class="w-7 h-7 object-contain"
                        >
                    <div>
                        <p class="text-xs text-[#545454]">TAHUN</p>
                        <p class="text-sm font-semibold text-[#111111] mt-1">
                            {{ $mobil->tahun }}
                        </p>
                    </div>

                </div>

                <div class="border border-[#E5E7EB] rounded-[12px] p-4 flex items-center gap-3">
                        <img
                            src="{{ asset('images/icons/user-group.svg') }}"
                            class="w-7 h-7 object-contain"
                        >
                    <div>
                        <p class="text-xs text-[#545454]">KAPASITAS</p>
                        <p class="text-sm font-semibold text-[#111111] mt-1">
                            {{ $mobil->kapasitas_penumpang }} Orang
                        </p>
                    </div>

                </div>

                <div class="border border-[#E5E7EB] rounded-[12px] p-4 flex items-center gap-3">
                        <img
                            src="{{ asset('images/icons/location-06.svg') }}"
                            class="w-7 h-7 object-contain"
                        >
                    <div>
                        <p class="text-xs text-[#545454]">LOKASI</p>
                        <p class="text-sm font-semibold text-[#111111] mt-1">
                            {{ $mobil->rental->kota ?? 'Bandung' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- DESC --}}
            <div class="mt-8">

                <p class="text-[15px] leading-[32px] text-[#545454]">
                    {{ $mobil->deskripsi }}
                </p>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- HOST --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Hosted By
                </h3>

                @php

                    $totalRating = $reviews->count() > 0
                        ? number_format($reviews->avg('rating'), 1)
                        : '0.0';


                    $joinDate = $mobil->rental->created_at
                        ? \Carbon\Carbon::parse($mobil->rental->created_at)->translatedFormat('F Y')
                        : '-';

                @endphp

                <a
                    href="{{ route('rental.profil', ['id' => $mobil->rental->rental_id, 'back' => url()->current()]) }}"
                    class="flex items-center gap-5 mt-6 group"
                >

                    {{-- LOGO --}}
                    <div class="relative">

                        <img
                            src="{{ $mobil->rental->logo_perusahaan
                                ? asset('storage/' . $mobil->rental->logo_perusahaan)
                                : asset('images/rental.png') }}"
                            class="w-20 h-20 rounded-full object-cover border border-[#E5E7EB]"
                        >

                        {{-- BADGE RATING --}}
                        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2
                                    bg-[#0B1F67] text-white text-xs font-semibold
                                    px-3 py-1 rounded-full flex items-center gap-1 shadow-md">

                            <i class="fa-solid fa-star text-[10px] text-[#FFC107]"></i>

                            {{ $rentalRating }}

                        </div>

                    </div>

                    {{-- INFO --}}
                    <div>

                        <h4 class="text-[20px] font-semibold text-[#111111]">
                            {{ $mobil->rental->nama_rental }}
                        </h4>

                        <p class="text-sm text-[#545454] mt-2 leading-[26px]">

                            {{ number_format($totalTrip) }} trips
                            •

                            Bergabung {{ $joinDate }}

                        </p>

                    </div>
                </a>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- HARGA --}}
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
                        <p class="text-[#545454]">
                            Biaya Over Kilometer
                        </p>

                        <p class="font-semibold text-[#111111]">
                            Rp 5.000/km (>200km/hari)
                        </p>

                    </div>

                    <div class="w-full h-[1px] bg-[#E5E7EB]"></div>

                    <div class="flex justify-between font-semibold text-sm">
                        <p class="text-[#08174D]">
                            TOTAL (tanpa driver, 1 hari)
                        </p>

                        <p class="font-semibold text-[#08174D] text-base">
                            Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}
                        </p>

                    </div>

                    <div class="flex justify-between font-semibold text-sm">
                        <p class="text-[#08174D]">
                            TOTAL (dengan driver, 1 hari)
                        </p>

                        <p class="font-semibold text-[#08174D] text-base">
                            Rp {{ number_format($mobil->harga_per_hari + 250000,0,',','.') }}
                        </p>

                    </div>

                </div>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- PRASYARAT --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Prasyarat Kendaraan
                </h3>

                <ul class="mt-5 space-y-2 text-sm leading-[28px] text-[#545454] list-disc pl-5">

                    @foreach(explode("\n", $mobil->prasyarat_kendaraan ?? '') as $item)
                        @if(trim($item))
                            <li>{{ trim($item) }}</li>
                        @endif
                    @endforeach

                </ul>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- SYARAT --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Syarat & Ketentuan Umum
                </h3>

                <ul class="mt-5 space-y-2 text-sm leading-[28px] text-[#545454] list-disc pl-5">

                    @foreach(explode("\n", $syaratKetentuan->isi ?? '') as $item)
                        @if(trim($item))
                            <li>{{ trim($item) }}</li>
                        @endif
                    @endforeach

                </ul>

            </div>

            <div class="w-full h-[1px] bg-[#E5E7EB] mt-8"></div>

            {{-- REVIEW --}}
            <div class="mt-8">

                <h3 class="text-[24px] font-semibold text-[#111111]">
                    Rating & Ulasan
                </h3>

                <div class="border border-[#E5E7EB] rounded-[14px] p-6 mt-6">

                    <div class="flex flex-col lg:flex-row gap-10">

                        <div class="flex flex-col items-center justify-center min-w-[140px]">

                            <div class="flex items-center gap-2">

                                <h4 class="text-[40px] font-semibold text-[#111111] leading-none">
                                    {{ number_format($averageRating ?? 0, 1) }}
                                </h4>

                                <span class="text-[#FFC107] text-xl">
                                    ★
                                </span>

                            </div>

                            <p class="text-sm text-[#545454] mt-2">
                                {{ $reviews->count() }} Rating & Ulasan
                            </p>

                        </div>

                        <div class="flex-1 space-y-3">

                            @for($i = 5; $i >= 1; $i--)

                            @php
                                $count = $reviews->where('rating', $i)->count();
                                $percentage = $reviews->count() > 0
                                    ? ($count / $reviews->count()) * 100
                                    : 0;
                            @endphp

                            <div class="flex items-center gap-3">

                                <span class="text-sm text-[#545454] w-8">
                                    {{ $i }}★
                                </span>

                                <div class="flex-1 h-2 bg-[#ECECEC] rounded-full overflow-hidden">

                                    <div
                                        class="h-full bg-[#0B1F67] rounded-full"
                                        style="width: {{ $percentage }}%">
                                    </div>

                                </div>

                                <span class="text-xs text-[#545454]">
                                    ({{ $count }})
                                </span>

                            </div>

                            @endfor

                        </div>

                    </div>

                </div>

                {{-- REVIEW LIST --}}
                <div class="mt-8 space-y-6">

                    @foreach($reviews->take(3) as $review)

                    <div class="border-b border-[#E5E7EB] pb-6">

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 rounded-full bg-[#0B1F67] text-white flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($review->email ?? 'U', 0, 1)) }}
                            </div>

                            <div class="flex-1">

                                <div class="flex items-center gap-2 flex-wrap">

                                    <h4 class="font-semibold text-[#111111]">
                                        {{ $review->email ?? 'User' }}
                                    </h4>

                                    <span class="text-sm text-[#545454]">
                                        {{ \Carbon\Carbon::parse($review->tanggal_posting)->translatedFormat('d F Y') }}
                                    </span>

                                </div>

                                <div class="text-[#FFC107] mt-2">
                                    ★★★★★
                                </div>

                                <p class="text-sm text-[#545454] leading-[30px] mt-3">
                                    {{ $review->komentar }}
                                </p>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                <a href="{{ route('reviews.show', ['id' => $mobil->mobil_id]) }}"
                    class="mt-8 h-12 px-8 rounded-[10px] bg-[#0B1F67] text-white font-semibold hover:bg-[#08184f] transition inline-flex items-center gap-3 w-fit">
                    Lihat Semua Ulasan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>

        {{-- RIGHT --}}
        <div>

            <div class="sticky top-24 border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                <div class="flex items-center justify-between">

                    <p class="text-sm text-[#545454]">
                        HARGA SEWA
                    </p>

                    <h3 class="text-2xl font-bold text-[#111111]">
                        Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}/hari
                    </h3>

                </div>

                <form
                    class="mt-6 space-y-5"
                    id="bookingForm"
                    action="{{ auth()->check() ? route('customer.booking.create', $mobil->mobil_id) : route('login') }}"
                    method="GET"
                >

                    {{-- LOKASI --}}
                    <div>

                        <label class="block text-sm font-medium text-[#545454] mb-2">
                            Lokasi
                        </label>

                        <div class="relative">

                            <input
                                type="text"
                                id="lokasi"
                                name="lokasi"
                                value="{{ $mobil->rental->alamat }}"
                                readonly
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] bg-gray-100 px-4 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67] focus:border-[#0B1F67] transition" 
                            >

                            <img
                                src="{{ asset('images/icons/location-04.svg') }}"
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2"
                            >

                        </div>

                    </div>

                    {{-- TGL AMBIL --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Tanggal Pengambilan
                            </label>

                            <input
                                type="date"
                                id="tglAmbil"
                                name="tglAmbil"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67] focus:border-[#0B1F67] transition"
                            >

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Waktu
                            </label>

                            <input
                                type="time"
                                id="waktuAmbil"
                                name="waktuAmbil"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67] focus:border-[#0B1F67] transition"
                            >

                        </div>

                    </div>

                    {{-- TGL KEMBALI --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Tanggal Pengembalian
                            </label>

                            <input
                                type="date"
                                id="tglKembali"
                                name="tglKembali"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67] focus:border-[#0B1F67] transition"
                            >
                        </div>

                        <div>

                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Waktu
                            </label>

                            <input
                                type="time"
                                id="waktuKembali"
                                name="waktuKembali"
                                class="w-full h-12 rounded-[8px] border border-[#D9D9D9] px-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1F67] focus:border-[#0B1F67] transition"
                            >

                        </div>

                    </div>

                    <div class="pt-3 space-y-4">

                        <div class="flex justify-between text-sm">
                            <p class="text-[#545454]">
                                Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}
                                x
                                <span id="jumlah_hari_text">0</span> hari
                            </p>

                            <p class="font-semibold text-[#111111]">
                                Rp <span id="subtotal_harga">0</span>
                            </p>
                        </div>

                        <div class="flex justify-between text-sm">

                            <p class="text-[#545454]">
                                Deposit (dikembalikan)
                            </p>

                            <p class="font-semibold text-[#111111]">
                                Rp <span id="deposit_harga">200.000</span>
                            </p>

                        </div>

                        <div class="w-full h-[1px] bg-[#E5E7EB]"></div>
                        <div class="flex justify-between font-semibold text-base">
                            <p class="text-[#08174D]"> TOTAL </p>
                            <p class="font-semibold text-[#08174D] text-base">
                                Rp <span id="total_harga">0</span>
                            </p>
                        </div>

                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-[8px] bg-[#0B1F67] hover:bg-[#08184f] text-white font-semibold transition mt-2">

                        Lanjut Booking

                    </button>

                </form>

            </div>

         </div>

    </div>

    <hr class="border-gray-200 my-10">

    {{-- MAP --}}
    <div class="mt-14">

        <h3 class="text-[24px] font-semibold text-[#111111]">
            Lokasi Pengambilan Mobil
        </h3>

        <p class="text-sm text-[#545454] mt-3">
            {{ $mobil->rental->alamat ?? 'Bandung, Jawa Barat' }}
        </p>

        <div class="mt-5 overflow-hidden rounded-[18px]">

            <iframe
                src="{{ $mobil->rental->google_maps }}"
                class="w-full h-[500px]"
                allowfullscreen=""
                loading="lazy">
            </iframe>

        </div>

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const hargaPerHari = {{ $mobil->harga_per_hari }};
        const deposit = 200000;

        const form = document.getElementById("bookingForm");
        const lokasi = document.getElementById("lokasi");
        const tglAmbil = document.getElementById("tglAmbil");
        const waktuAmbil = document.getElementById("waktuAmbil");
        const tglKembali = document.getElementById("tglKembali");
        const waktuKembali = document.getElementById("waktuKembali");

        const jumlahHariText = document.getElementById("jumlah_hari_text");
        const subtotalHargaEl = document.getElementById("subtotal_harga");
        const totalHargaEl = document.getElementById("total_harga");

        const today = new Date().toISOString().split("T")[0];

        tglAmbil.min = today;
        tglKembali.min = today;

        function formatRupiah(angka) {
            return angka.toLocaleString("id-ID");
        }

        function resetTotal() {
            jumlahHariText.innerText = 0;
            subtotalHargaEl.innerText = 0;
            totalHargaEl.innerText = 0;
        }

        function showError(input, message) {
            removeError(input);

            const error = document.createElement("p");
            error.className = "text-red-500 text-xs mt-2 error-message";
            error.innerText = message;

            input.parentElement.appendChild(error);
            input.classList.add("border-red-500");
        }

        function removeError(input) {
            const existing = input.parentElement.querySelector(".error-message");
            if (existing) existing.remove();

            input.classList.remove("border-red-500");
        }

        function hitungTotal() {
            if (!tglAmbil.value || !tglKembali.value) {
                resetTotal();
                return;
            }

            const start = new Date(tglAmbil.value);
            const end = new Date(tglKembali.value);

            const diffTime = end - start;
            const diffDay = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDay <= 0) {
                showError(tglKembali, "Tanggal tidak bisa dipilih");
                resetTotal();
                return;
            }

            removeError(tglKembali);

            const subtotal = diffDay * hargaPerHari;
            const total = subtotal + deposit;

            jumlahHariText.innerText = diffDay;
            subtotalHargaEl.innerText = formatRupiah(subtotal);
            totalHargaEl.innerText = formatRupiah(total);
        }

        function validateForm(e) {
            let valid = true;

            [glAmbil, waktuAmbil, tglKembali, waktuKembali].forEach(removeError);

            if (!tglAmbil.value) {
                showError(tglAmbil, "Tanggal pengambilan wajib diisi");
                valid = false;
            }

            if (!waktuAmbil.value) {
                showError(waktuAmbil, "Waktu pengambilan wajib diisi");
                valid = false;
            }

            if (!tglKembali.value) {
                showError(tglKembali, "Tanggal pengembalian wajib diisi");
                valid = false;
            }

            if (!waktuKembali.value) {
                showError(waktuKembali, "Waktu pengembalian wajib diisi");
                valid = false;
            }

            if (tglAmbil.value && tglKembali.value) {
                const start = new Date(tglAmbil.value);
                const end = new Date(tglKembali.value);

                if (end <= start) {
                    showError(tglKembali, "Tanggal pengembalian harus setelah tanggal pengambilan");
                    valid = false;
                }
            }

            if (!valid) {
                e.preventDefault();
                return false;
            }

            return true;
        }

        tglAmbil.addEventListener("change", function () {
            removeError(tglAmbil);

            if (tglAmbil.value) {
                const nextDay = new Date(tglAmbil.value);
                nextDay.setDate(nextDay.getDate() + 1);

                tglKembali.min = nextDay.toISOString().split("T")[0];
            }

            if (tglKembali.value && tglKembali.value <= tglAmbil.value) {
                tglKembali.value = "";
            }

            hitungTotal();
        });

        tglKembali.addEventListener("change", function () {
            removeError(tglKembali);
            hitungTotal();
        });

        waktuAmbil.addEventListener("input", () => removeError(waktuAmbil));
        waktuKembali.addEventListener("input", () => removeError(waktuKembali));

        form.addEventListener("submit", validateForm);

    });
</script>

@endsection
