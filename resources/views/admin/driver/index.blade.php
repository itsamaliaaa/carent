@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4 py-5 px-5" x-data="{ popUpTambah: false }">

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

    {{-- Card Header & Search --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Driver</h1>
            <button @click="popUpTambah = true" class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </button>
        </div>
        <hr class="border-t border-gray-200 mb-6">
        <div class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                </div>
                <input type="text" placeholder="Cari Driver" class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>
            <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">Cari</button>
        </div>
    </div>

    {{-- Tambah Driver --}}
    <div x-show="popUpTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="display: none;">
        <div class="bg-white rounded-[20px] w-full max-w-lg p-10 shadow-lg" @click.away="popUpTambah = false">
            <h2 class="text-[#1D2B6B] text-3xl font-bold mb-8">Tambah Driver</h2>
            <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Nama Driver</label>
                    <input type="text" name="nama_driver" required placeholder="Masukkan Nama Driver" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>
                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Umur Driver</label>
                    <input type="number" name="umur" required placeholder="Harus Angka" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>
                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Foto</label>
                    <input type="file" name="foto" required class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none">
                </div>
                <div class="mb-6">
                    <label class="text-gray-600 text-sm mb-2">Tarif</label>
                    <input type="number" name="tarif_harian" required placeholder="Contoh: 250000" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                </div>
                <button type="submit" class="bg-[#0b1f67] w-full text-white py-2 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781]">Tambah</button>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-[20px] p-7 shadow-sm border border-gray-50">
        <div class="grid grid-cols-[1.1fr_0.9fr_0.9fr_1fr_1.3fr_0.8fr] bg-[#E8EAF6] rounded-xl py-3 px-6 mb-4 items-center gap-x-4 font-bold text-[13px]">
            <div>Nama Driver</div>
            <div>Foto</div>
            <div>Umur</div>
            <div>Tarif</div>
            <div>Status</div>
            <div>Aksi</div>
        </div>
        <div class="flex flex-col gap-3">
            @foreach ($drivers as $driver)
            <div class="grid grid-cols-[1.1fr_0.9fr_0.9fr_1fr_1.3fr_0.8fr] items-center border border-[#E0E4EC] rounded-2xl p-4 px-6 gap-x-4">
                <div class="text-[14px]">{{ $driver->nama_driver }}</div>
                <div class="flex justify-start">
                    <img src="{{ asset('storage/' . $driver->foto) }}" class="w-[60px] h-[40px] object-cover rounded-lg">
                </div>
                <div class="text-[14px]">{{ $driver->umur }} tahun</div>
                <div class="text-[14px]">Rp {{ number_format($driver->tarif_harian, 0, ',', '.') }}</div>
                <span class="{{ $driver->status == 'tersedia' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#F5E8E8] text-[#712A2A]' }} w-fit inline-block whitespace-nowrap px-4 py-1 rounded-full text-[12px] font-bold">
                    {{ $driver->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>

                {{-- AREA AKSI --}}
                <div class="flex justify-start gap-2" x-data="{ openEdit: false }">

                    {{-- Tombol Edit --}}
                    <button type="button" @click="openEdit = true" class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg">
                        <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                    </button>

                    {{-- Form Hapus --}}
                    <form action="{{ route('admin.driver.destroy', $driver) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 bg-[#B74A4A] flex justify-center items-center rounded-lg">
                            <img src="{{ asset('images/icons/delete-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                        </button>
                    </form>

                    {{-- Modal Edit --}}
                    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="display: none;">
                        <div class="bg-white rounded-[20px] w-full max-w-lg p-10 shadow-lg" @click.away="openEdit = false">
                            <h2 class="text-[#1D2B6B] text-3xl font-bold mb-8">Edit Driver</h2>

                            <form action="{{ route('admin.driver.update', $driver) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4 text-left">
                                    <label class="text-sm text-gray-600 block mb-1">Nama</label>
                                    <input type="text" name="nama_driver" value="{{ $driver->nama_driver }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                </div>
                                <div class="mb-4 text-left">
                                    <label class="text-sm text-gray-600 block mb-1">Umur</label>
                                    <input type="number" name="umur" value="{{ $driver->umur }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                </div>
                                <div class="mb-4 text-left">
                                    <label class="text-sm text-gray-600 block mb-1">Tarif</label>
                                    <input type="number" name="tarif_harian" value="{{ $driver->tarif_harian }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                </div>
                                <div class="mb-4 text-left">
                                    <div class="mb-6 text-left" x-data="{ open: false, selected: '{{ $driver->status }}' }">
                                        <input type="hidden" name="status" :value="selected">

                                        <div class="self-stretch text-sm text-gray-600 font-normal font-['Inter'] leading-6 mb-2">Status</div>

                                        <div class="relative">
                                            <button type="button" @click="open = !open"
                                                class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                                <span x-text="selected == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia'"
                                                    class="flex-1 text-left text-gray-800 text-sm font-normal leading-6"></span>
                                                <img src="{{ asset('images/icons/Vector.svg') }}"
                                                    class="h-3 w-3 transition-transform duration-200"
                                                    :class="open ? 'rotate-180' : ''" alt="arrow">
                                            </button>

                                            <div x-show="open" @click.away="open = false"
                                                class="absolute left-0 z-10 w-full rounded-b-lg overflow-hidden"
                                                style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;"
                                                x-cloak>
                                                <div style="height: 20px; background-color: white;"></div>
                                                <div x-show="selected != 'tersedia'"
                                                    @click="selected = 'tersedia'; open = false"
                                                    style="background-color: white;"
                                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                                    onmouseover="this.style.backgroundColor='#E8EAF6'; this.style.color='#1D2B6B'; this.closest('.absolute').style.borderColor='#1D2B6B';"
                                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#6b7280'; this.closest('.absolute').style.borderColor='#d1d5db';">
                                                    Tersedia
                                                </div>
                                                <div x-show="selected != 'tidak_tersedia'"
                                                    @click="selected = 'tidak_tersedia'; open = false"
                                                    style="background-color: white;"
                                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                                    onmouseover="this.style.backgroundColor='#E8EAF6'; this.style.color='#1D2B6B'; this.closest('.absolute').style.borderColor='#1D2B6B';"
                                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#6b7280'; this.closest('.absolute').style.borderColor='#d1d5db';">
                                                    Tidak Tersedia
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="bg-[#0b1f67] w-full text-white py-2 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781]">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection