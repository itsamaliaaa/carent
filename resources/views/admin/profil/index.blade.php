@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-2 px-2 h-screen" x-data>

    <div class="bg-white p-14 rounded-[20px] shadow-sm border border-gray-50 flex flex-col flex-grow overflow-hidden max-h-[85vh]">

        <div class="overflow-y-auto pr-2 flex-grow">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center gap-4 mb-6">
                    <h1 class="text-[#1D2B6B] text-2xl font-bold">Informasi Rental</h1>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Rental</label>
                            <input type="text" value="Cahaya Rental" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#1D2B6B] focus:ring-1 focus:ring-[#1D2B6B] transition" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Perusahaan</label>
                            <input type="file" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer focus:outline-none 
                file:mr-4 file:py-2.5 file:px-4 
                file:border-0 file:text-sm file:font-medium 
                file:bg-gray-200 file:text-gray-700 
                hover:file:bg-gray-300" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Rental</label>
                            <input type="text" value="Jl. Amir Mahmud No. 21, Cigugur Tengah, Kec. Cimahi Tengah, Kota Cimahi, Jawa Barat 40522" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#1D2B6B] focus:ring-1 focus:ring-[#1D2B6B] transition" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                            <input type="text" value="https://maps.app.goo.gl/KxQ3Q1qbKM6Gtkt69" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#1D2B6B] focus:ring-1 focus:ring-[#1D2B6B] transition" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#1D2B6B] focus:ring-1 focus:ring-[#1D2B6B] transition">Aflah Jaya Rental hadir sejak 2024 melayani kebutuhan transportasi Anda dengan armada lengkap dan terawat. Kami menyediakan layanan rental harian, mingguan, dan bulanan dengan sopir maupun lepas kunci. Semua kendaraan rutin diservis dan diasuransikan. Tersedia layanan 24 jam dan antar-jemput bandara.</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                    <div class="flex flex-wrap gap-4 mb-5">
                        {{-- BCA --}}
                        <div onclick="selectBank(this)" class="bank-card w-[138px] h-[83px] bg-white border border-gray-200 rounded-xl flex items-center justify-center cursor-pointer transition-all hover:border-[#1D2B6B] p-3">
                            <img src="{{ asset('images/Bank/BCA.png') }}" alt="BCA" class="w-full h-full object-contain">
                        </div>

                        {{-- BNI --}}
                        <div onclick="selectBank(this)" class="bank-card w-[138px] h-[83px] bg-white border border-gray-200 rounded-xl flex items-center justify-center cursor-pointer transition-all hover:border-[#1D2B6B] p-3">
                            <img src="{{ asset('images/Bank/BNI.png') }}" alt="BNI" class="w-full h-full object-contain">
                        </div>

                        {{-- BRI --}}
                        <div onclick="selectBank(this)" class="bank-card w-[138px] h-[83px] bg-white border border-gray-200 rounded-xl flex items-center justify-center cursor-pointer transition-all hover:border-[#1D2B6B] p-3">
                            <img src="{{ asset('images/Bank/BRI.png') }}" alt="BRI" class="w-full h-full object-contain">
                        </div>

                        {{-- BSI --}}
                        <div onclick="selectBank(this)" class="bank-card w-[138px] h-[83px] bg-white border border-gray-200 rounded-xl flex items-center justify-center cursor-pointer transition-all hover:border-[#1D2B6B] p-3">
                            <img src="{{ asset('images/Bank/BSI.png') }}" alt="BSI" class="w-full h-full object-contain">
                        </div>

                        {{-- Mandiri --}}
                        <div onclick="selectBank(this)" class="bank-card w-[138px] h-[83px] bg-white border border-gray-200 rounded-xl flex items-center justify-center cursor-pointer transition-all hover:border-[#1D2B6B] p-3">
                            <img src="{{ asset('images/Bank/Mandiri.png') }}" alt="Mandiri" class="w-full h-full object-contain">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-slate-600 mb-1">Atas Nama</label>
                        <input type="text" placeholder="Sesuai Buku Tabungan" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md focus:outline-none focus:ring-1 focus:ring-slate-400">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-slate-600 mb-1">Nomor Rekening</label>
                            <input type="text" placeholder="Contoh: 1234567890" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md focus:outline-none focus:ring-1 focus:ring-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-600 mb-1">Gambar QRIS</label>
                            <input type="file" class="block w-full text-sm text-slate-500 border border-slate-300 rounded-md cursor-pointer file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#0b1f67] hover:bg-[#0e2781] text-white font-semibold py-3 rounded-xl text-sm transition-all duration-150 shadow-md">
                    Edit
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function selectBank(element) {
        document.querySelectorAll('.bank-card').forEach(card => {
            card.classList.remove('border-2', 'border-[#1D2B6B]');
            card.classList.add('border', 'border-gray-200');
        });
        element.classList.remove('border', 'border-gray-200');
        element.classList.add('border-2', 'border-[#1D2B6B]');
    }
</script>

@endsection