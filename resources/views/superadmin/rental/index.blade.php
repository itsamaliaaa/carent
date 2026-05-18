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
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Rental</h1>
            <button @click="popUpTambah = true"
                    class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </button>
        </div>
        <hr class="border-t border-gray-200 mb-6">
        <div class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search">
                </div>
                <input type="text" placeholder="Cari Rental"
                       class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
            </div>
            <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">
                Cari
            </button>
        </div>
    </div>

    {{-- Modal Tambah Rental --}}
    <div x-show="popUpTambah"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         x-cloak style="display: none;">
        <div class="bg-white rounded-[20px] w-full max-w-2xl p-10 shadow-lg overflow-y-auto max-h-[90vh]"
             @click.away="popUpTambah = false">
            <h2 class="text-[#1D2B6B] text-3xl font-bold mb-8">Tambah Rental</h2>

            <form action="{{ route('superadmin.rental.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    {{-- Nama Rental --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Nama Rental</label>
                        <input type="text" name="nama_rental" required
                               placeholder="Masukkan Nama Rental"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Email</label>
                        <input type="email" name="email" required
                               placeholder="Masukkan Email"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    {{-- Nama Admin --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Nama Admin</label>
                        <input type="text" name="nama_admin" required
                               placeholder="Masukkan Nama Admin"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    {{-- No Telepon --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">No Telepon</label>
                        <input type="text" name="no_telp" required
                               placeholder="Contoh: 08xx-xxxx-xxxx"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    {{-- Logo Perusahaan --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Logo Perusahaan</label>
                        <input type="file" name="logo_perusahaan" accept="image/*"
                               class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none">
                    </div>

                    {{-- Password --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="passwordTambah" required
                                   placeholder="Masukkan Password"
                                   class="w-full border border-gray-200 rounded-lg py-2 px-4 pr-10 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                            <button type="button" onclick="togglePass('passwordTambah', 'eyeTambah')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <img id="eyeTambah" src="{{ asset('images/icons/eye.svg') }}" class="w-4 h-4">
                            </button>
                        </div>
                    </div>

                    {{-- Alamat Rental --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Alamat Rental</label>
                        <textarea name="alamat" required rows="3"
                                  placeholder="Masukkan Alamat"
                                  class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300 resize-none"></textarea>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                                  placeholder="Masukkan Deskripsi"
                                  class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300 resize-none"></textarea>
                    </div>

                    {{-- Kota --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Kota</label>
                        <input type="text" name="kota" required
                               placeholder="Masukkan Kota"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    {{-- Link Google Maps --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Link Google Maps</label>
                        <input type="text" name="maps_link"
                               placeholder="Masukkan Link Google Maps"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                </div>

                <button type="submit"
                        class="bg-[#0b1f67] w-full text-white py-2.5 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] mt-6">
                    Tambah
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-[20px] p-7 shadow-sm border border-gray-50">
        <div class="grid grid-cols-[1.5fr_1fr_1fr_1fr_1fr_0.8fr] bg-[#E8EAF6] rounded-xl py-3 px-6 mb-4 items-center gap-x-4 font-bold text-[13px]">
            <div>Nama Rental</div>
            <div>Logo</div>
            <div>Kota</div>
            <div>No Telepon</div>
            <div>Status</div>
            <div>Aksi</div>
        </div>

        <div class="flex flex-col gap-3">
            @forelse ($rentals as $rental)
            <div class="grid grid-cols-[1.5fr_1fr_1fr_1fr_1fr_0.8fr] items-center border border-[#E0E4EC] rounded-2xl p-4 px-6 gap-x-4"
                 x-data="{ openEdit: false }">

                {{-- Nama Rental --}}
                <div class="text-[14px] font-medium">{{ $rental->nama_rental }}</div>

                {{-- Logo --}}
                <div>
                    @if($rental->logo_perusahaan)
                        <img src="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                             class="w-[60px] h-[40px] object-contain rounded-lg">
                    @else
                        <span class="text-gray-400 text-xs">Tidak ada</span>
                    @endif
                </div>

                {{-- Kota --}}
                <div class="text-[14px]">{{ $rental->kota }}</div>

                {{-- No Telepon --}}
                <div class="text-[14px]">{{ $rental->no_telp }}</div>

                {{-- Status --}}
                <span class="{{ $rental->status == 'aktif' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#F5E8E8] text-[#712A2A]' }}
                              w-fit inline-block whitespace-nowrap px-4 py-1 rounded-full text-[12px] font-bold">
                    {{ $rental->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                </span>

                {{-- Aksi --}}
                <div class="flex justify-start gap-2">

                    {{-- Tombol Edit --}}
                    <button type="button" @click="openEdit = true"
                            class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg">
                        <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                    </button>

                    {{-- Hapus --}}
                    <form action="{{ route('superadmin.rental.destroy', $rental->rental_id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus rental ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-9 h-9 bg-[#B74A4A] flex justify-center items-center rounded-lg">
                            <img src="{{ asset('images/icons/delete-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                        </button>
                    </form>

                    {{-- Modal Edit --}}
                    <div x-show="openEdit"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-cloak style="display: none;">
                        <div class="bg-white rounded-[20px] w-full max-w-2xl p-10 shadow-lg overflow-y-auto max-h-[90vh]"
                             @click.away="openEdit = false">
                            <h2 class="text-[#1D2B6B] text-3xl font-bold mb-8">Edit Rental</h2>

                            <form action="{{ route('superadmin.rental.update', $rental->rental_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-2 gap-4">

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Nama Rental</label>
                                        <input type="text" name="nama_rental" value="{{ $rental->nama_rental }}" required
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Email</label>
                                        <input type="email" name="email" value="{{ $rental->email }}" required
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">No Telepon</label>
                                        <input type="text" name="no_telp" value="{{ $rental->no_telp }}" required
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Kota</label>
                                        <input type="text" name="kota" value="{{ $rental->kota }}" required
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Alamat</label>
                                        <textarea name="alamat" required rows="3"
                                                  class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none resize-none">{{ $rental->alamat }}</textarea>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Deskripsi</label>
                                        <textarea name="deskripsi" rows="3"
                                                  class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none resize-none">{{ $rental->deskripsi }}</textarea>
                                    </div>

                                    <div class="flex flex-col gap-1 col-span-2">
                                        <label class="text-sm text-gray-600">Logo Perusahaan</label>
                                        @if($rental->logo_perusahaan)
                                            <img src="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                                                 class="w-20 h-12 object-contain mb-2 rounded">
                                        @endif
                                        <input type="file" name="logo_perusahaan" accept="image/*"
                                               class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none">
                                    </div>

                                </div>

                                <button type="submit"
                                        class="bg-[#0b1f67] w-full text-white py-2.5 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] mt-6">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-8">Belum ada data rental.</div>
            @endforelse
        </div>
    </div>

</div>

<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.src   = '{{ asset("images/icons/eye-off.svg") }}';
        } else {
            input.type = 'password';
            icon.src   = '{{ asset("images/icons/eye.svg") }}';
        }
    }
</script>

@endsection