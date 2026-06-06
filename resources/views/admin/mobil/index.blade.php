@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-2 px-2" x-data="{ popUpTambah: false }">

    {{-- Card Header & Search --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Mobil</h1>
            <a href="{{ route('admin.mobil.create') }}" class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </a>
        </div>
        <hr class="border-t border-gray-200 mb-6">
        <form method="GET" action="{{ route('admin.mobil.index') }}" class="flex gap-4">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                </div>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Mobil"
                    class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>

            <button type="submit" class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition whitespace-nowrap">
                Cari
            </button>
        </form>
    </div>

    {{-- Tabel Mobil --}}
    <div class="bg-white rounded-[20px] p-7 shadow-sm border border-gray-50">
        <div class="overflow-x-auto">
            <div class="min-w-[1100px]"> {{-- Sedikit diperlebar untuk mengakomodasi teks panjang --}}

                {{-- Header dengan kolom yang disesuaikan --}}
                <div class="grid grid-cols-[1.5fr_0.8fr_0.6fr_0.8fr_1.2fr_1.2fr_0.9fr_0.8fr] bg-[#E8EAF6] rounded-xl py-3 px-5 mb-3 items-center gap-x-4 font-bold text-[13px]">
                    <div>Nama Mobil</div>
                    <div>Foto</div>
                    <div>Tahun</div>
                    <div>Transmisi</div>
                    <div>Sewa Dasar (per hari)</div>
                    <div>Kapasitas penumpang</div>
                    <div>Status</div>
                    <div class="text-center">Aksi</div>
                </div>

                {{-- Baris Data --}}
                <div class="flex flex-col gap-3">
                    @foreach ($mobils as $mobil)
                    <div class="grid grid-cols-[1.5fr_0.8fr_0.6fr_0.8fr_1.2fr_1.2fr_0.9fr_0.8fr] items-center border border-[#E0E4EC] rounded-2xl p-4 px-6 gap-x-4">

                        <div class="text-[14px] font-semibold truncate">{{ $mobil->nama_mobil }}</div>

                        <div class="flex justify-start">
                            @if($mobil->fotoPrimary)
                            <img src="{{ asset('storage/' . $mobil->fotoPrimary->url_foto) }}" class="w-[60px] h-[40px] object-cover rounded-lg">
                            @else
                            <div class="w-[60px] h-[40px] bg-gray-100 rounded-lg"></div>
                            @endif
                        </div>

                        <div class="text-[14px] font-semibold">{{ $mobil->tahun }}</div>
                        <div class="text-[14px] font-semibold capitalize">{{ $mobil->transmisi }}</div>
                        <div class="text-[14px] font-semibold">Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}</div>
                        <div class="text-[14px] font-semibold">{{ $mobil->kapasitas_penumpang }} Orang</div>

                        <div>
                            <span class="{{ $mobil->status == 'tersedia' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#FFF3E0] text-[#EF6C00]' }} w-fit inline-block whitespace-nowrap px-4 py-1 rounded-full text-[12px] font-bold">
                                {{ ucfirst($mobil->status) }}
                            </span>
                        </div>

                        <div class="flex justify-center gap-2" x-data="{ openEdit: false }">
                            <a href="{{ route('admin.mobil.edit', $mobil->mobil_id) }}" class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg shrink-0">
                                <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                            </a>

                            <form id="formHapusMobil{{ $mobil->mobil_id }}" action="{{ route('admin.mobil.destroy', $mobil->mobil_id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button"
                                    data-confirm="hapusConfirmMobil"
                                    data-target-submit="formHapusMobil{{ $mobil->mobil_id }}"
                                    data-feedback="successHapusMobil"
                                    class="w-9 h-9 bg-[#B74A4A] flex justify-center items-center rounded-lg shrink-0">
                                    <img src="{{ asset('images/icons/delete-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            {{ $mobils->links() }}
        </div>
    </div>
</div>

{{-- LOADING --}}
<div id="loadingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80] hidden items-center justify-center">
    <div class="relative w-32 h-32">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="50" fill="none" stroke="#E5E7EB" stroke-width="10" />
            <circle id="progressCircle" cx="60" cy="60" r="50" fill="none" stroke="#0B1F67" stroke-width="10" stroke-linecap="round" stroke-dasharray="314" stroke-dashoffset="314" style="transition: stroke-dashoffset 0.3s ease" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
            <span id="progressText" class="text-2xl font-bold text-[#0B1F67]">0%</span>
        </div>
    </div>
</div>

<div
    id="hapusConfirmMobil"
    class="fixed inset-0 z-[70] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin menghapus mobil ini?
        </p>

        <div class="flex gap-4 mt-8">

            <button
                type="button"
                data-submit=""
                data-feedback="successHapusMobil"
                class="flex-1 bg-[#62B33B] hover:bg-green-600
                    text-white py-3 rounded-xl font-semibold">
                Ya
            </button>

            <button
                type="button"
                data-close="hapusConfirmMobil"
                class="flex-1 bg-[#B92A44] hover:bg-red-600
                    text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>

        </div>

    </div>

</div>

<!-- feedback hapus mobil -->
<div
    id="successHapusMobil"
    class="fixed inset-0 z-[90] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">

        <div class="flex justify-center">

            <div class="w-24 h-24 flex items-center justify-center">

                <img
                    src="{{ asset('images/icons/check-circle.svg') }}"
                    alt="Success">

            </div>

        </div>

        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Mobil berhasil dihapus</h2>

    </div>

</div>

@endsection