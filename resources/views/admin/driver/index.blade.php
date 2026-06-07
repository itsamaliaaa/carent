@extends('layouts.admin')

@section('content')

@php $editErrorId = session('edit_error_driver_id'); @endphp

<div class="flex flex-col gap-4 py-2 px-2" x-data="{ popUpTambah: {{ ($errors->any() && !$editErrorId) ? 'true' : 'false' }} }">

    {{-- Card --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Manajemen Driver</h1>
            <button @click="popUpTambah = true" class="bg-[#0b1f67] hover:bg-[#0e2781] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <img src="{{ asset('images/icons/add-01.svg') }}" class="w-3 h-3 brightness-0 invert" alt="Add">
                <span class="font-semibold text-[11px]">Tambah</span>
            </button>
        </div>
        <hr class="border-t border-gray-200 mb-6">
        {{-- Search --}}
        <form method="GET" action="{{ route('admin.driver.index') }}">
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                    </div>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Driver" class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-800">
                </div>
                <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">Cari</button>
            </div>
        </form>
    </div>

    {{-- Form Tambah Driver --}}
    <div x-show="popUpTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="display: none;">
        <div class="bg-white rounded-[20px] w-full max-w-lg p-10 shadow-lg">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-[#1D2B6B] text-3xl font-bold">Tambah Driver</h2>
                <button type="button" @click="popUpTambah = false" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>
            <form id="formTambahDriver" action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Nama Driver</label>
                    <input type="text" name="nama_driver" value="{{ old('nama_driver') }}" required placeholder="Masukkan Nama Driver" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    @error('nama_driver')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Umur Driver</label>
                    <input type="number" name="umur" value="{{ old('umur') }}" required placeholder="Harus Angka" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    @error('umur')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">No. Telepon</label>
                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="Contoh: 08xx-xxxx-xxxx" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    @error('no_telepon')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="text-gray-600 text-sm mb-2">Foto</label>
                    <input type="file" name="foto" required class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none file:hover:bg-[#E5E7EB] file:hover:text-gray-800 file:transition-colors file:duration-200">
                    @error('foto')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="text-gray-600 text-sm mb-2">Tarif</label>
                    <input type="number" name="tarif_harian" value="{{ old('tarif_harian') }}" required placeholder="Contoh: 250000" class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    @error('tarif_harian')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" onclick="cekLaluKonfirmasi('formTambahDriver', 'tambahConfirmDriver')"
                    class="bg-[#0b1f67] w-full text-white py-2 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781]">Tambah</button>
            </form>
        </div>
    </div>

    {{-- Tabel Driver --}}
    <div class="bg-white rounded-[20px] p-7 shadow-sm border border-gray-50">
        <div class="overflow-x-auto">
            <div class="min-w-[1050px]">

                <div class="grid grid-cols-[1.3fr_1fr_0.9fr_1.5fr_1.1fr_1.5fr_0.8fr] bg-[#E8EAF6] rounded-xl py-3 px-5 mb-3 items-center gap-x-4 font-bold text-[13px]">
                    <div>Nama Driver</div>
                    <div>Foto</div>
                    <div>Umur</div>
                    <div>No. Telepon</div>
                    <div>Tarif</div>
                    <div>Status</div>
                    <div>Aksi</div>
                </div>

                <div class="flex flex-col gap-3">
                    @foreach ($drivers as $driver)
                    <div class="grid grid-cols-[1.3fr_1fr_0.9fr_1.5fr_1.1fr_1.5fr_0.8fr] items-center border border-[#E0E4EC] rounded-2xl p-4 px-6 gap-x-4">
                        <div class="text-[14px] truncate">{{ $driver->nama_driver }}</div>
                        <div class="flex justify-start">
                            <img src="{{ asset('storage/' . $driver->foto) }}" class="w-[60px] h-[40px] object-cover rounded-lg">
                        </div>
                        <div class="text-[14px]">{{ $driver->umur }} tahun</div>
                        <div class="text-[13px] font-normal break-all">{{ implode(' ', str_split($driver->no_telepon, 4)) }}</div>
                        <div class="text-[14px]">Rp {{ number_format($driver->tarif_harian, 0, ',', '.') }}</div>

                        <div>
                            <span class="{{ $driver->status == 'tersedia' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#F5E8E8] text-[#712A2A]' }} w-fit inline-block whitespace-nowrap px-4 py-1 rounded-full text-[12px] font-bold">
                                {{ $driver->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex justify-start gap-2" x-data="{ openEdit: {{ ($editErrorId == $driver->driver_id && $errors->any()) ? 'true' : 'false' }} }">

                            {{-- Tombol Edit --}}
                            <button type="button" @click="openEdit = true" class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg shrink-0">
                                <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                            </button>

                            {{-- Form Edit (Modal) --}}
                            <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="display: none;">
                                <div class="bg-white rounded-[20px] w-full max-w-lg p-10 shadow-lg">
                                    <div class="flex justify-between items-center mb-8">
                                        <h2 class="text-[#1D2B6B] text-3xl font-bold">Edit Driver</h2>
                                        <button type="button" @click="openEdit = false" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                                    </div>

                                    {{-- Form Edit Driver --}}
                                    <form id="formEditDriver{{ $driver->driver_id }}" action="{{ route('admin.driver.update', $driver) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4 text-left">
                                            <label class="text-sm text-gray-600 block mb-1">Nama</label>
                                            <input type="text" name="nama_driver" value="{{ old('nama_driver', $driver->nama_driver) }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                            @error('nama_driver')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4 text-left">
                                            <label class="text-sm text-gray-600 block mb-1">Umur</label>
                                            <input type="number" name="umur" value="{{ old('umur', $driver->umur) }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                            @error('umur')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4 text-left">
                                            <label class="text-sm text-gray-600 block mb-1">No. Telepon</label>
                                            <input type="tel" name="no_telepon" value="{{ old('no_telepon', $driver->no_telepon) }}" required placeholder="Contoh: +62 xx-xxxx-xxxx" class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                            @error('no_telepon')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4" x-data="{ fileName: '{{ $driver->foto ? basename($driver->foto) : 'Tidak ada file yang dipilih' }}' }">
                                            <label class="text-gray-600 text-sm mb-2 block">Foto</label>
                                            <div class="relative flex items-center border border-gray-200 rounded-lg overflow-hidden h-[40px] group transition-all duration-200 focus-within:ring-2 focus-within:ring-blue-100">
                                                <div class="bg-[#F3F4F6] text-gray-600 px-4 h-full flex items-center border-r border-gray-200 text-[14px] transition-colors duration-200 group-hover:bg-[#E5E7EB] group-hover:text-gray-800">
                                                    Pilih File
                                                </div>
                                                <div class="px-4 text-gray-400 text-[14px] truncate flex-1 bg-white" x-text="fileName"></div>
                                                <input type="file" name="foto"
                                                    @change="fileName = $event.target.files[0].name"
                                                    class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                            </div>
                                            @error('foto')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4 text-left">
                                            <label class="text-sm text-gray-600 block mb-1">Tarif</label>
                                            <input type="number" name="tarif_harian" value="{{ old('tarif_harian', $driver->tarif_harian) }}" required class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                            @error('tarif_harian')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Dropdown status driver --}}
                                        <div class="mb-6 text-left" x-data="{ open: false, selected: '{{ old('status', $driver->status) }}' }">
                                            <input type="hidden" name="status" :value="selected">
                                            <div class="text-sm text-gray-600 mb-2">Status</div>
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
                                                    class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                                    style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                                    x-cloak>
                                                    <div x-show="selected != 'tersedia'"
                                                        @click="selected = 'tersedia'; open = false"
                                                        style="background-color: white; color: #374151;"
                                                        class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                                        onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B';"
                                                        onmouseout="this.style.backgroundColor='white'; this.style.color='#374151';">
                                                        Tersedia
                                                    </div>
                                                    <div x-show="selected != 'tidak_tersedia'"
                                                        @click="selected = 'tidak_tersedia'; open = false"
                                                        style="background-color: white; color: #374151;"
                                                        class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                                        onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B';"
                                                        onmouseout="this.style.backgroundColor='white'; this.style.color='#374151';">
                                                        Tidak Tersedia
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" onclick="cekLaluKonfirmasi('formEditDriver{{ $driver->driver_id }}', 'editConfirmDriver')"
                                            class="bg-[#0b1f67] w-full text-white py-2 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781]">Edit</button>
                                    </form>
                                </div>
                            </div>

                            {{-- Tombol Hapus --}}
                            <form id="formHapusDriver{{ $driver->driver_id }}" action="{{ route('admin.driver.destroy', $driver) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="cekLaluKonfirmasi('formHapusDriver{{ $driver->driver_id }}', 'hapusConfirmDriver')"
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
            {{ $drivers->links() }}
        </div>
    </div>
</div>

{{-- CONFIRM TAMBAH --}}
<div id="tambahConfirmDriver" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin menambahkan driver ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" data-submit="" data-feedback="successTambahDriver"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">Ya</button>
            <button type="button" data-close="tambahConfirmDriver"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">Tidak</button>
        </div>
    </div>
</div>

{{-- CONFIRM EDIT --}}
<div id="editConfirmDriver" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin mengedit driver ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" data-submit="" data-feedback="successEditDriver"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">Ya</button>
            <button type="button" data-close="editConfirmDriver"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">Tidak</button>
        </div>
    </div>
</div>

{{-- CONFIRM HAPUS --}}
<div id="hapusConfirmDriver" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin menghapus driver ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" data-submit="" data-feedback="successHapusDriver"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">Ya</button>
            <button type="button" data-close="hapusConfirmDriver"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">Tidak</button>
        </div>
    </div>
</div>

{{-- FEEDBACK TAMBAH --}}
<div id="successTambahDriver" class="fixed inset-0 z-[110] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24" alt="Success">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Driver berhasil ditambahkan</h2>
    </div>
</div>

{{-- FEEDBACK EDIT --}}
<div id="successEditDriver" class="fixed inset-0 z-[110] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24" alt="Success">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Driver berhasil diedit</h2>
    </div>
</div>

{{-- FEEDBACK HAPUS --}}
<div id="successHapusDriver" class="fixed inset-0 z-[110] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24" alt="Success">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Driver berhasil dihapus</h2>
    </div>
</div>

<script>
function cekLaluKonfirmasi(formId, confirmId) {
    const form = document.getElementById(formId);
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    const modal = document.getElementById(confirmId);
    modal.querySelector('[data-submit]').dataset.submit = formId;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

document.addEventListener('click', function (e) {
    // Tombol "Ya"
    const yaBtn = e.target.closest('[data-submit]');
    if (yaBtn && yaBtn.dataset.submit) {
        const modal = yaBtn.closest('.fixed');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.getElementById(yaBtn.dataset.submit)?.submit();
        return;
    }

    // Tombol "Tidak"
    const closeBtn = e.target.closest('[data-close]');
    if (closeBtn) {
        const modal = document.getElementById(closeBtn.dataset.close);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
});
</script>

@endsection