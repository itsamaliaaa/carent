@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-5 px-5">

@if(session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';

                setTimeout(() => {
                    alert.remove();
                }, 500);
            }
        }, 2000); 
    </script>
    @endif

    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">

        <h1 class="text-[#1D2B6B] text-2xl font-bold mb-8">
            Kebijakan
        </h1>

        <form action="{{ route('superadmin.kebijakan.save') }}" method="POST">
            @csrf

            {{-- Syarat Pembatalan --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">
                    Syarat Pembatalan
                </label>

                <textarea
                    name="pembatalan"
                    rows="5"
                    placeholder="Masukkan Syarat Pembatalan"
                    class="w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none">{{ old('pembatalan', $pembatalan->isi ?? '') }}</textarea>
            </div>

            {{-- Pengembalian Dana --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">
                    Kebijakan Pengembalian Dana
                </label>

                <textarea
                    name="pengembalian_dana"
                    rows="5"
                    placeholder="Masukkan Kebijakan Pengembalian Dana"
                    class="w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none">{{ old('pengembalian_dana', $pengembalianDana->isi ?? '') }}</textarea>
            </div>

            {{-- Syarat dan Ketentuan --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">
                    Syarat dan Ketentuan Umum
                </label>

                <textarea
                    name="syarat_ketentuan_umum"
                    rows="5"
                    placeholder="Masukkan Syarat dan Ketentuan Umum"
                    class="w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none">{{ old('syarat_ketentuan_umum', $syaratKetentuan->isi ?? '') }}</textarea>
            </div>

            <button
                type="submit"
                class="bg-[#0b1f67] w-full text-white py-2.5 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] transition">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection