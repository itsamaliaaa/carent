@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-[30px] p-10 h-[calc(100vh-120px)] overflow-y-auto">

    <h1 class="text-3xl font-bold text-[#0B1F67] mb-10">
        Informasi Rental
    </h1>

    @php
        $rekening = $rental->rekenings->first();
    @endphp

    <form
        action="{{ route('admin.profil.rental.update') }}"
        id="rentalForm"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8">

        @csrf
        @method('PUT')

        {{-- INFORMASI RENTAL --}}
        <div class="border border-[#D9D9D9] rounded-[18px] p-6">

            <div class="grid grid-cols-2 gap-5">

                {{-- NAMA RENTAL --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Nama Rental
                    </label>

                <input type="text"
                        name="nama_rental"
                        value="{{ old('nama_rental', $rental->nama_rental ?? '') }}"
                        class="w-full h-11 border border-[#BDBDBD] rounded-[10px] px-4 text-sm">

                        @error('nama_rental')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                </div>

                {{-- LOGO --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Logo Perusahaan
                    </label>

                    <input
                        type="file"
                        name="logo_perusahaan"
                        class="w-full border border-[#BDBDBD] rounded-[10px] text-sm
                        file:py-3 file:px-4 file:border-0 file:bg-gray-100 file:text-gray-600">

                        @error('logo_perusahaan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                        @if($rental?->logo_perusahaan)
                            <a
                                href="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 mt-2
                                text-xs text-[#0B1F67] hover:underline">

                                File saat ini:
                                <span class="font-medium">
                                    {{ basename($rental->logo_perusahaan) }}
                                </span>

                            </a>
                        @endif
                </div>

            </div>

            {{-- ALAMAT --}}
            <div class="mt-5">

                <label class="block text-sm text-gray-600 mb-2">
                    Alamat Rental
                </label>

                <input
                    type="text"
                    name="alamat"
                    value="{{ old('alamat', $rental->alamat ?? '') }}"
                    class="w-full h-11 border border-[#BDBDBD] rounded-[10px] px-4 text-sm">

                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror                

            </div>

            {{-- GOOGLE MAPS --}}
            <div class="mt-5">

                <label class="block text-sm text-gray-600 mb-2">
                    Link Google Maps
                </label>

                <input
                    type="text"
                    name="google_maps"
                    value="{{ old('google_maps', $rental->google_maps ?? '') }}"
                    placeholder="https://maps.app.goo.gl/..."
                    class="w-full h-11 border border-[#BDBDBD] rounded-[10px] px-4 text-sm">

                    @error('google_maps')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror   
            </div>

            {{-- DESKRIPSI --}}
            <div class="mt-5">

                <label class="block text-sm text-gray-600 mb-2">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="w-full h-24 border border-[#BDBDBD] rounded-[10px] p-4 resize-none text-sm">{{ old('deskripsi', $rental->deskripsi ?? '') }}</textarea>

                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

            </div>

        </div>

        {{-- INFORMASI PEMBAYARAN --}}
        <div class="border border-[#D9D9D9] rounded-[18px] p-6">

            <h2 class="text-lg font-semibold text-[#0B1F67] mb-6">
                Informasi Pembayaran
            </h2>

            {{-- PILIHAN BANK --}}
            <div>

                <label class="block text-sm font-medium text-[#0B1F67] mb-3">
                    Pilihan Bank
                </label>

                <div class="flex flex-wrap gap-6">

                    @php
                        $banks = ['BSI', 'BRI', 'BNI', 'BCA', 'Mandiri'];
                    @endphp

                    @foreach($banks as $namaBank)

                        <label class="flex items-center gap-2 cursor-pointer">

                            <input
                                type="radio"
                                name="nama_bank"
                                value="{{ $namaBank }}"
                                {{ ($rekening->nama_bank ?? '') == $namaBank ? 'checked' : '' }}>

                                @error('nama_bank')
                                    <p class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            <span class="text-sm text-gray-700">
                                {{ $namaBank }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>

            {{-- DETAIL REKENING --}}
            <div class="mt-6">

                <label class="block text-sm font-medium text-[#0B1F67] mb-3">
                    Detail Rekening
                </label>

                <div class="grid grid-cols-2 gap-6">

                    {{-- ATAS NAMA --}}
                    <div>

                        <label class="block text-sm text-gray-600 mb-2">
                            Atas Nama
                        </label>

                        <input
                            type="text"
                            name="atas_nama"
                            value="{{ old('atas_nama', $rekening->atas_nama ?? '') }}"
                            placeholder="Sesuai Buku Tabungan"
                            class="w-full h-11 border border-[#BDBDBD] rounded-[10px] px-4 text-sm">

                            @error('atas_nama')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                    </div>

                    {{-- NOMOR REKENING --}}
                    <div>

                        <label class="block text-sm text-gray-600 mb-2">
                            Nomor Rekening
                        </label>

                        <input
                            type="text"
                            name="nomor_rekening"
                            value="{{ old('nomor_rekening', $rekening->nomor_rekening ?? '') }}"
                            placeholder="Contoh: 1234567890"
                            class="w-full h-11 border border-[#BDBDBD] rounded-[10px] px-4 text-sm">

                            @error('nomor_rekening')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                    </div>

                </div>

            </div>

            {{-- QRIS --}}
            <div class="mt-6">

                <label class="block text-sm font-medium text-[#0B1F67] mb-3">
                    Pembayaran QRIS
                </label>

                <input
                    type="file"
                    name="qris"
                    class="w-full border border-[#BDBDBD] rounded-[10px] text-sm
                    file:py-3 file:px-4 file:border-0 file:bg-gray-100 file:text-gray-600">

                    @error('qris')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    @if($rekening?->url_qris)
                        <a
                            href="{{ asset('storage/' . $rekening->url_qris) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1 mt-2
                            text-xs text-[#0B1F67] hover:underline">

                            File saat ini:
                            <span class="font-medium">
                                {{ basename($rekening->url_qris) }}
                            </span>

                        </a>
                    @endif

            </div>

        </div>

        {{-- BUTTON --}}
        <button
            type="button"
            id="openRentalConfirmModal"
            class="w-full h-12 bg-[#0B1F67]
            hover:bg-[#08184f]
            text-white font-semibold
            rounded-[10px]">

            Edit

        </button>

    </form>

</div>

<!-- MODAL KONFIRMASI -->
<div
    id="rentalConfirmModal"
    class="fixed inset-0 z-[70] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin mengubah informasi rental?
        </p>

        <div class="flex gap-4 mt-8">

            <button
                type="button"
                id="confirmRentalBtn"
                class="flex-1 bg-[#62B33B] hover:bg-green-600
                text-white py-3 rounded-xl font-semibold">

                Ya

            </button>

            <button
                type="button"
                id="closeRentalConfirmModal"
                class="flex-1 bg-[#B92A44] hover:bg-red-600
                text-white py-3 rounded-xl font-semibold">

                Tidak

            </button>

        </div>

    </div>

</div>

<!-- LOADING -->
<div
    id="rentalLoadingModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80]
    hidden items-center justify-center">

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
                id="rentalProgressCircle"
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

            <span
                id="rentalProgressText"
                class="text-2xl font-bold text-[#0B1F67]">

                0%

            </span>

        </div>

    </div>

</div>

<!-- SUCCESS MODAL -->
<div
    id="rentalSuccessModal"
    class="fixed inset-0 z-[90] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">

        <div class="flex justify-center">

            <img
                src="{{ asset('images/icons/check-circle.svg') }}"
                class="w-24 h-24">

        </div>

        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">
            Informasi rental berhasil diperbarui
        </h2>

    </div>

</div>

<script>

    const rentalForm = document.getElementById('rentalForm');

    const rentalConfirmModal =
        document.getElementById('rentalConfirmModal');

    const rentalLoadingModal =
        document.getElementById('rentalLoadingModal');

    document.getElementById('openRentalConfirmModal')
    ?.addEventListener('click', () => {

        rentalConfirmModal.classList.remove('hidden');
        rentalConfirmModal.classList.add('flex');

    });

    document.getElementById('closeRentalConfirmModal')
    ?.addEventListener('click', () => {

        rentalConfirmModal.classList.add('hidden');
        rentalConfirmModal.classList.remove('flex');

    });

    document.getElementById('confirmRentalBtn')
    ?.addEventListener('click', () => {

        rentalConfirmModal.classList.add('hidden');
        rentalConfirmModal.classList.remove('flex');

        rentalLoadingModal.classList.remove('hidden');
        rentalLoadingModal.classList.add('flex');

        const circle =
            document.getElementById('rentalProgressCircle');

        const text =
            document.getElementById('rentalProgressText');

        let progress = 0;

        const interval = setInterval(() => {

            progress += 10;

            text.textContent = progress + '%';

            const offset = 314 - (314 * progress / 100);

            circle.style.strokeDashoffset = offset;

            if (progress >= 100) {

                clearInterval(interval);

                rentalForm.submit();

            }

        }, 80);

    });

</script>

@if(session('success_rental'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const modal =
            document.getElementById('rentalSuccessModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        }, 2000);

    });
    </script>
@endif

@endsection