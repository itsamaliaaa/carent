@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4 py-5 px-5" x-data="{ popUpTambah: {{ $errors->any() ? 'true' : 'false' }} }">

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
        <form method="GET" action="{{ route('superadmin.rental.index') }}" class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search">
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari Rental"
                    class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-800">
            </div>
            <button type="submit"
                class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Modal Tambah Rental --}}
    <div x-show="popUpTambah"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         x-cloak style="display: none;">
        <div class="relative bg-white rounded-[20px] w-full max-w-2xl p-10 shadow-lg overflow-y-auto max-h-[90vh]"
             @click.away="popUpTambah = false">

            <button type="button" @click="popUpTambah = false"
                    class="absolute top-5 right-5 text-2xl text-gray-400 hover:text-gray-700">×</button>

            <h2 class="text-[#1D2B6B] text-2xl font-bold mb-6">Tambah Rental</h2>

            {{-- Tampilan Error Validasi --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-5 text-sm">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="tambahRentalForm" action="{{ route('superadmin.rental.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Nama Rental</label>
                        <input type="text" name="nama_rental" required
                               value="{{ old('nama_rental') }}"
                               placeholder="Masukkan Nama Rental"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Email</label>
                        <input type="email" name="email" required
                               value="{{ old('email') }}"
                               placeholder="Masukkan Email"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Nama Admin</label>
                        <input type="text" name="nama_admin" required
                               value="{{ old('nama_admin') }}"
                               placeholder="Masukkan Nama Admin"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">No Telepon</label>
                        <input type="text" name="no_telp" required
                               value="{{ old('no_telp') }}"
                               placeholder="Contoh: 08xx-xxxx-xxxx"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Logo Perusahaan</label>
                        <input type="file" name="logo_perusahaan" accept="image/*"
                               class="block w-full text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none">
                    </div>

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

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Alamat Rental</label>
                        <textarea name="alamat" required rows="3"
                                  placeholder="Masukkan Alamat"
                                  class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300 resize-none">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                                  placeholder="Masukkan Deskripsi"
                                  class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300 resize-none">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Kota</label>
                        <input type="text" name="kota" required
                               value="{{ old('kota') }}"
                               placeholder="Masukkan Kota"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-gray-600 text-sm">Link Google Maps</label>
                        <input type="text" name="maps_link"
                               value="{{ old('maps_link') }}"
                               placeholder="Masukkan Link Google Maps"
                               class="w-full border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] placeholder-gray-300">
                    </div>

                </div>

                {{-- Trigger konfirmasi tambah --}}
                <button type="button"
                        onclick="validateAndOpenTambahConfirm()"
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

                <div class="text-[14px] font-medium">{{ $rental->nama_rental }}</div>

                <div>
                    @if($rental->logo_perusahaan)
                        <img src="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                             class="w-[60px] h-[40px] object-contain rounded-lg">
                    @else
                        <span class="text-gray-400 text-xs">Tidak ada</span>
                    @endif
                </div>

                <div class="text-[14px]">{{ $rental->kota }}</div>
                <div class="text-[14px]">{{ $rental->no_telp }}</div>

                <span class="{{ $rental->status == 'aktif' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#F5E8E8] text-[#712A2A]' }}
                              w-fit inline-block whitespace-nowrap px-4 py-1 rounded-full text-[12px] font-bold">
                    {{ $rental->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                </span>

                <div class="flex justify-start gap-2">

                    {{-- Tombol Edit --}}
                    <button type="button" @click="openEdit = true"
                            class="w-9 h-9 bg-[#8BC34A] flex justify-center items-center rounded-lg">
                        <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                    </button>

                    {{-- Hapus --}}
                    <form id="hapusForm-{{ $rental->rental_id }}"
                          action="{{ route('superadmin.rental.destroy', $rental->rental_id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                onclick="openHapusConfirm('{{ $rental->rental_id }}')"
                                class="w-9 h-9 bg-[#B74A4A] flex justify-center items-center rounded-lg">
                            <img src="{{ asset('images/icons/delete-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                        </button>
                    </form>

                    {{-- Modal Edit --}}
                    <div x-show="openEdit"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-cloak style="display: none;">

                        <div class="relative bg-white rounded-[20px] w-full max-w-2xl p-10 shadow-lg overflow-y-auto max-h-[90vh]"
                             @click.away="openEdit = false">

                            <button type="button" @click="openEdit = false"
                                    class="absolute top-5 right-5 text-2xl text-gray-500 hover:text-gray-700">×</button>

                            <h2 class="text-[#1D2B6B] text-2xl font-bold mb-8">Edit Rental</h2>

                            <form id="rentalForm-{{ $rental->rental_id }}"
                                  action="{{ route('superadmin.rental.update', $rental->rental_id) }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-2 gap-4">

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Nama Rental</label>
                                        <input type="text" name="nama_rental"
                                               value="{{ $rental->nama_rental }}" disabled
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Email</label>
                                        <input type="email" name="email"
                                               value="{{ $rental->email }}" disabled
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">No Telepon</label>
                                        <input type="text" name="no_telp"
                                               value="{{ $rental->no_telp }}" disabled
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Kota</label>
                                        <input type="text" name="kota"
                                               value="{{ $rental->kota }}" disabled
                                               class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Alamat</label>
                                        <textarea name="alamat" disabled rows="3"
                                                  class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none resize-none">{{ $rental->alamat }}</textarea>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm text-gray-600">Deskripsi</label>
                                        <textarea name="deskripsi" disabled rows="3"
                                                  class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none resize-none">{{ $rental->deskripsi }}</textarea>
                                    </div>

                                    {{-- Logo + Status --}}
                                    <div class="flex flex-col gap-1 col-span-2">
                                        <label class="text-sm text-gray-600">Logo Perusahaan</label>

                                        @if($rental->logo_perusahaan)
                                            <img src="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                                                 class="w-20 h-12 object-contain mb-2 rounded">
                                        @endif

                                        <div class="flex gap-4 items-end">
                                            <input type="file" name="logo_perusahaan" disabled accept="image/*"
                                                   class="flex-1 block text-[14px] text-gray-400 border border-gray-200 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2 file:px-4 file:mr-4 cursor-pointer focus:outline-none">

                                            <div class="flex flex-col gap-1 min-w-[140px]">
                                                <label class="text-sm text-gray-600">Status</label>
                                                <select name="status"
                                                        class="w-full border rounded-lg p-2 text-sm focus:border-[#1D2B6B] outline-none">
                                                    <option value="aktif" {{ $rental->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="nonaktif" {{ $rental->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Simpan langsung submit form --}}
                                <button type="button"
                                        onclick="runLoading('rentalForm-{{ $rental->rental_id }}', 'Rental berhasil diperbarui')"
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

{{-- MODAL KONFIRMASI TAMBAH --}}
<div id="tambahConfirmModal"
     class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin menambahkan rental ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" id="confirmTambahBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" id="closeTambahConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="hapusConfirmModal"
     class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin menghapus rental ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" id="confirmHapusBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" id="closeHapusConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- LOADING --}}
<div id="rentalLoadingModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80] hidden items-center justify-center">
    <div class="relative w-32 h-32">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="50" fill="none" stroke="#E5E7EB" stroke-width="10"/>
            <circle id="rentalProgressCircle" cx="60" cy="60" r="50" fill="none"
                    stroke="#0B1F67" stroke-width="10" stroke-linecap="round"
                    stroke-dasharray="314" stroke-dashoffset="314"
                    style="transition: stroke-dashoffset 0.3s ease"/>
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
            <span id="rentalProgressText" class="text-2xl font-bold text-[#0B1F67]">0%</span>
        </div>
    </div>
</div>

{{-- SUCCESS MODAL --}}
<div id="rentalSuccessModal"
     class="fixed inset-0 z-[90] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]" id="successModalText">
            Berhasil
        </h2>
    </div>
</div>

<script>
    // TOGGLE PASSWORD
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

    // LOADING HELPER
    function runLoading(formId, successText) {
        const loadingModal = document.getElementById('rentalLoadingModal');
        const circle       = document.getElementById('rentalProgressCircle');
        const text         = document.getElementById('rentalProgressText');

        loadingModal.classList.remove('hidden');
        loadingModal.classList.add('flex');

        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            text.textContent = progress + '%';
            circle.style.strokeDashoffset = 314 - (314 * progress / 100);

            if (progress >= 100) {
                clearInterval(interval);
                document.getElementById(formId).submit();
            }
        }, 80);
    }

    // TAMBAH
    function validateAndOpenTambahConfirm() {
        const form = document.getElementById('tambahRentalForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        const modal = document.getElementById('tambahConfirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    document.getElementById('closeTambahConfirmModal')
        ?.addEventListener('click', () => {
            document.getElementById('tambahConfirmModal').classList.add('hidden');
            document.getElementById('tambahConfirmModal').classList.remove('flex');
        });

    document.getElementById('confirmTambahBtn')
        ?.addEventListener('click', () => {
            document.getElementById('tambahConfirmModal').classList.add('hidden');
            document.getElementById('tambahConfirmModal').classList.remove('flex');
            runLoading('tambahRentalForm', 'Rental berhasil ditambahkan');
        });

    // HAPUS
    let activeHapusFormId = null;

    function openHapusConfirm(rentalId) {
        activeHapusFormId = 'hapusForm-' + rentalId;
        const modal = document.getElementById('hapusConfirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    document.getElementById('closeHapusConfirmModal')
        ?.addEventListener('click', () => {
            document.getElementById('hapusConfirmModal').classList.add('hidden');
            document.getElementById('hapusConfirmModal').classList.remove('flex');
        });

    document.getElementById('confirmHapusBtn')
        ?.addEventListener('click', () => {
            document.getElementById('hapusConfirmModal').classList.add('hidden');
            document.getElementById('hapusConfirmModal').classList.remove('flex');
            document.getElementById(activeHapusFormId).submit();
        });

    // SUCCESS
    @if(session('rental_success'))
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('rentalSuccessModal');
            document.getElementById('successModalText').textContent = '{{ session("rental_success") }}';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 2000);
        });
    @endif
</script>

@endsection