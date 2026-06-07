@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-2 px-2 h-screen" x-data>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.mobil.index') }}"
            class="text-[#1D2B6B] hover:text-[#0b1f67] hover:underline text-sm font-medium rounded-lg transition">
            < Kembali</a>
    </div>

    <div class="bg-white p-14 rounded-[20px] shadow-sm border border-gray-50 flex flex-col flex-grow overflow-hidden max-h-[85vh]">

        <div class="flex items-center gap-4 mb-10">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Tambah Mobil</h1>
        </div>

        <div class="overflow-y-auto pr-2 flex-grow">
            <form id="formTambahMobil" action="{{ route('admin.mobil.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mobil</label>
                        <input type="text" name="nama_mobil" placeholder="Contoh: Toyota Avanza"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Detail</label>
                        <input type="text" name="detail" placeholder="Contoh: Mobil keluarga"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Over Kilometer</label>
                        <input type="text" name="biaya_over_km" placeholder="Contoh: 5000"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="text" name="tahun" placeholder="Contoh: 2023"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sewa Dasar (per hari)</label>
                        <input type="number" id="sewa_dasar_input" name="sewa_dasar" placeholder="Contoh: 350000"
                            oninput="hitungTotal()"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas KM</label>
                        <input type="text" name="batas_km" placeholder="Contoh: 200"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                        <input type="text" name="kapasitas_penumpang" placeholder="Contoh: 7"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <!-- Dropdown Asuransi -->
                    <div x-data="{ open: false, selected: 'Termasuk' }">
                        <input type="hidden" name="asuransi" :value="selected">
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Asuransi</label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                <span x-text="selected" class="flex-1 text-left text-gray-800 text-sm font-normal leading-6"></span>
                                <img src="{{ asset('images/icons/Vector.svg') }}" class="h-3 w-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" alt="arrow">
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                x-cloak>
                                <div x-show="selected !== 'Termasuk'" @click="selected = 'Termasuk'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Termasuk
                                </div>
                                <div x-show="selected !== 'Tidak Termasuk'" @click="selected = 'Tidak Termasuk'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Tidak Termasuk
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                        <input type="text" id="total_display" placeholder="Otomatis terisi" readonly
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 bg-gray-50 cursor-not-allowed focus:outline-none transition" />
                    </div>

                    <!-- Dropdown Transmisi -->
                    <div x-data="{ open: false, selected: 'Manual' }">
                        <input type="hidden" name="transmisi" :value="selected">
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Transmisi</label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                <span x-text="selected" class="flex-1 text-left text-gray-800 text-sm font-normal leading-6"></span>
                                <img src="{{ asset('images/icons/Vector.svg') }}" class="h-3 w-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" alt="arrow">
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                x-cloak>
                                <div x-show="selected !== 'Manual'" @click="selected = 'Manual'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Manual
                                </div>
                                <div x-show="selected !== 'Matic'" @click="selected = 'Matic'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Matic
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Bahan Bakar -->
                    <div x-data="{ open: false, selected: 'Ditanggung Penyewa' }">
                        <input type="hidden" name="bahan_bakar" :value="selected">
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Bahan Bakar</label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                <span x-text="selected" class="flex-1 text-left text-gray-800 text-sm font-normal leading-6"></span>
                                <img src="{{ asset('images/icons/Vector.svg') }}" class="h-3 w-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" alt="arrow">
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                x-cloak>
                                <div x-show="selected !== 'Ditanggung Penyewa'" @click="selected = 'Ditanggung Penyewa'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Ditanggung Penyewa
                                </div>
                                <div x-show="selected !== 'Sudah Termasuk'" @click="selected = 'Sudah Termasuk'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Sudah Termasuk
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total dengan driver --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">TOTAL (dengan driver, 1 hari)</label>
                        <input type="text" id="total_driver_display" placeholder="Otomatis terisi" readonly
                            class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 bg-gray-50 cursor-not-allowed focus:outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                        <input id="foto-input" type="file" name="foto[]" accept="image/*" multiple required
                            class="block w-full text-[14px] text-gray-400 border border-gray-300 rounded-lg overflow-hidden file:bg-[#F3F4F6] file:text-gray-600 file:border-0 file:py-2.5 file:px-4 file:mr-4 cursor-pointer focus:outline-none file:hover:bg-[#E5E7EB] file:transition-colors"
                            onchange="handleFotoPreview(event)" />
                    </div>

                    {{-- Driver (input angka tarif) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Driver (opsional)</label>
                        <input type="number" id="driver_input" name="driver" placeholder="Contoh: 150000"
                            oninput="hitungTotal()"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                    </div>

                    <!-- Dropdown Status -->
                    <div x-data="{ open: false, selected: 'Tersedia' }" class="relative z-20">
                        <input type="hidden" name="status" :value="selected">
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Status</label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                <span x-text="selected" class="flex-1 text-left text-gray-800 text-sm font-normal leading-6"></span>
                                <img src="{{ asset('images/icons/Vector.svg') }}" class="h-3 w-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" alt="arrow">
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                x-cloak>
                                <div x-show="selected !== 'Tersedia'" @click="selected = 'Tersedia'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Tersedia
                                </div>
                                <div x-show="selected !== 'Tidak Tersedia'" @click="selected = 'Tidak Tersedia'; open = false"
                                    style="background-color: white; color: #374151;"
                                    class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                    onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                    Tidak Tersedia
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="foto-preview-container"
                    class="hidden items-center gap-2 overflow-x-auto mt-3 p-2 pt-4 w-full rounded-lg"
                    style="white-space: nowrap;">
                </div>

                <div class="mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prasayarat Kendaraan</label>
                    <input type="text" name="prasayarat" placeholder="Contoh: SIM A aktif, usia min. 21 tahun"
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#1D2B6B] focus:ring-2 focus:ring-[#1D2B6B]/10 transition" />
                </div>

                <button type="button"
                    data-confirm="konfirmasiTambahMobil"
                    data-target-submit="formTambahMobil"
                    data-feedback="successTambahMobil"
                    class="mt-7 w-full bg-[#0b1f67] hover:bg-[#0e2781] text-white font-semibold py-3 rounded-xl text-sm transition-all duration-150 shadow-md">
                    Tambah
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    // ===== HITUNG TOTAL =====
    function hitungTotal() {
        const sewa = parseInt(document.getElementById('sewa_dasar_input')?.value) || 0;
        const driver = parseInt(document.getElementById('driver_input')?.value) || 0;

        document.getElementById('total_display').value = sewa > 0 ?
            'Rp ' + sewa.toLocaleString('id-ID') : '';

        document.getElementById('total_driver_display').value = sewa > 0 ?
            'Rp ' + (sewa + driver).toLocaleString('id-ID') : '';
    }

    // ===== FOTO PREVIEW =====
    let selectedFiles = [];

    function handleFotoPreview(event) {
        const newFiles = Array.from(event.target.files);
        if (newFiles.length === 0) return;

        newFiles.forEach(newFile => {
            const isDuplicate = selectedFiles.some(f => f.name === newFile.name && f.size === newFile.size);
            if (!isDuplicate) selectedFiles.push(newFile);
        });

        renderPreviews();
    }

    function renderPreviews() {
        const container = document.getElementById('foto-preview-container');
        container.innerHTML = '';

        if (selectedFiles.length === 0) {
            container.classList.add('hidden');
            container.classList.remove('flex');
            return;
        }

        container.classList.remove('hidden');
        container.classList.add('flex');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative flex-shrink-0 flex flex-col items-center';
                wrapper.innerHTML = `
                    <button type="button" onclick="removePhoto(${index})"
                        class="absolute -top-2.5 -right-2.5 z-10 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 transition-colors shadow-md">✕</button>
                    <img src="${e.target.result}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                    <span class="block text-center text-[10px] text-gray-400 mt-1 w-20 truncate">${file.name}</span>
                `;
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        syncFileInput();
    }

    function removePhoto(index) {
        selectedFiles.splice(index, 1);
        renderPreviews();
    }

    function syncFileInput() {
        try {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            document.getElementById('foto-input').files = dt.files;
        } catch (e) {}
    }
</script>

{{-- KONFIRMASI TAMBAH MOBIL --}}
<div id="konfirmasiEditMobil" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold text-[#050E2D]">
            Apakah kamu yakin ingin menyimpan perubahan ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button"
                onclick="document.getElementById('formEditMobil').submit()"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button"
                data-close="konfirmasiEditMobil"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- FEEDBACK TAMBAH MOBIL --}}
<div id="successTambahMobil" class="fixed inset-0 z-[110] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24" alt="Success">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Mobil berhasil ditambahkan</h2>
    </div>
</div>

@endsection