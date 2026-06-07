@extends('layouts.customer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24">

    {{-- BACK --}}
    <a href="{{ route('mobil.detail', $mobil->mobil_id) }}"
    class="inline-flex items-center gap-2 text-sm font-medium text-[#08174D] hover:underline">
        <i class="fa-solid fa-chevron-left text-xs"></i>
        Kembali
    </a>

    <div class="w-full h-[1px] bg-[#D9D9D9] mt-5"></div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_420px] gap-10 mt-8">

        {{-- LEFT --}}
        <div class="order-2 lg:order-1">

            <form
                id="bookingForm"
                action="{{ route('customer.booking.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-3">

                @csrf
                <input type="hidden" name="lokasi" value="{{ $lokasi }}">
                <input type="hidden" name="tglAmbil" value="{{ $tglAmbil }}">
                <input type="hidden" name="tglKembali" value="{{ $tglKembali }}">
                <input type="hidden" name="waktuAmbil" value="{{ $waktuAmbil }}">
                <input type="hidden" name="waktuKembali" value="{{ $waktuKembali }}">
                <input type="hidden" name="mobil_id" value="{{ $mobil->mobil_id }}">
                <input type="hidden" name="driver_id" id="driver_id">
                <input type="hidden" name="total_harga" id="totalHargaInput" value="{{ $total }}">

                {{-- IDENTITAS PENGENDARA --}}
                <div class="border border-[#E5E7EB] rounded-[16px] p-6 bg-white">
                    <h3 id="judulIdentitas" class="text-xl font-semibold text-[#111111] mb-4">
                        Identitas Pengendara
                    </h3>
                    <div class="w-full h-[1px] bg-[#D9D9D9] mb-4"></div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Nama Lengkap*
                            </label>

                            <input
                                id="namaPengendara"
                                type="text"
                                name="nama"
                                value="{{ old('nama') }}"
                                maxlength="100"
                                class="w-full h-12 border border-[#D9D9D9] rounded-[8px] px-4 text-sm"
                                placeholder="Masukkan nama lengkap">
                            
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                No. Telepon*
                            </label>

                            <input
                                id="teleponPengendara"
                                type="text"
                                name="telepon"
                                value="{{ old('telepon') }}"
                                maxlength="15"
                                class="w-full h-12 border border-[#D9D9D9] rounded-[8px] px-4 text-sm"
                                placeholder="+62 8xx xxxx xxxx">
                            
                                @error('telepon')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Nomor SIM*
                            </label>

                            <input
                                id="simPengendara"
                                type="text"
                                name="sim"
                                value="{{ old('sim') }}"
                                maxlength="16"
                                class="w-full h-12 border border-[#D9D9D9] rounded-[8px] px-4 text-sm"
                                placeholder="Masukkan nomor SIM">
                            
                            @error('sim')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#545454] mb-2">
                                Tanggal Lahir*
                            </label>

                            <input
                                id="tglLahirPengendara"
                                type="date"
                                name="tgl_lahir"
                                value="{{ old('tgl_lahir') }}"
                                max="{{ now()->subYears(17)->format('Y-m-d') }}"
                                class="w-full h-12 border border-[#D9D9D9] rounded-[8px] px-4 text-sm">

                            @error('tgl_lahir')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div>

                {{-- LAYANAN TAMBAHAN --}}
                <div class="border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                <h3 class="text-xl font-semibold text-[#111111] mb-6">
                    Layanan Tambahan
                    <span class="text-sm font-normal text-[#777777]">
                        (Opsional)
                    </span>
                </h3>

                    <div class="w-full h-[1px] bg-[#D9D9D9] mt-4 mb-6"></div>

                    <div class="space-y-5">

                        <div class="flex items-start justify-between">
                            
                            <div>
                                <h4 class="font-medium text-[#111111]">
                                    Driver
                                </h4>
                                <p class="text-sm text-[#545454]">
                                    Tidak termasuk biaya Tol
                                </p>

                                @if(!$driverTersedia)
                                    <p class="text-sm text-red-500 mt-1">
                                        Driver sedang tidak tersedia
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <p class="font-semibold text-[#111111]">
                                    Rp 250.000/hari
                                </p>

                                <input
                                    type="checkbox"
                                    name="driver"
                                    value="1"
                                    {{ !$driverTersedia ? 'disabled' : '' }}
                                    class="w-5 h-5 disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>
                        </div>

                        <div class="w-full h-[1px] bg-[#E5E7EB]"></div>

                        <div class="flex items-start justify-between">

                            <div>
                                <h4 class="font-medium text-[#111111]">
                                    Bahan Bakar
                                </h4>

                                <p class="text-sm text-[#545454]">
                                    Isi ulang saat pengambilan
                                </p>
                            </div>

                            <p class="font-medium text-[#545454]">
                                Ditanggung Penyewa
                            </p>

                        </div>

                    </div>
                </div>

                {{-- CATATAN --}}
                <div class="border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                <h3 class="text-xl font-semibold text-[#111111] mb-6">
                    Catatan
                    <span class="text-sm font-normal text-[#777777]">
                        (Opsional)
                    </span>
                </h3>

                    <div class="w-full h-[1px] bg-[#D9D9D9] mt-4 mb-6"></div>

                    <textarea
                        name="catatan"
                        rows="5"
                        placeholder="Contoh: keperluan khusus dan kondisi khusus, dll..."
                        class="w-full border border-[#D9D9D9] rounded-[8px] p-4 text-sm resize-none"
                    >{{ old('catatan') }}</textarea>

                </div>

                @php
                    $rekening = $mobil->rental->rekenings
                                    ->where('is_aktif', true)
                                    ->first();
                @endphp

                {{-- METODE PEMBAYARAN --}}
                <div class="border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                    <h3 class="text-xl font-semibold text-[#111111] mb-6">
                        Metode Pembayaran
                    </h3>

                    <div class="w-full h-[1px] bg-[#D9D9D9] mt-4 mb-6"></div>

                    <div class="flex flex-col md:flex-row items-start gap-20">

                        <div class="shrink-0">
                                <p class="text-sm text-[#545454] mb-3">
                                    Scan untuk membayar via QRIS
                                </p>

                                <div class="w-[140px] h-[140px]" >

                                    @if($rekening && $rekening->url_qris)
                                        <img
                                            src="{{ asset('storage/' . $rekening->url_qris) }}"
                                            class="w-full h-full object-contain">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">
                                            QRIS belum tersedia
                                        </div>
                                    @endif

                                </div>
                        </div>
                        
                        <div class="space-y-5 md:text-left">
                            
                            <div class="mb-5">
                                <p class="text-[13px] text-[#777777] uppercase mb-1">
                                    BANK TUJUAN
                                </p>

                                <p class="font-semibold text-[#111111]">
                                    {{ $rekening->nama_bank ?? '-' }}
                                </p>
                            </div>

                            <div class="mb-5">
                                <p class="text-[13px] text-[#777777] uppercase mb-1">
                                    NOMOR REKENING
                                </p>

                                <p class="font-semibold text-[#111111]">
                                    {{ $rekening->nomor_rekening ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[13px] text-[#777777] uppercase mb-1">
                                    ATAS NAMA
                                </p>

                                <p class="font-semibold text-[#111111]">
                                    {{ $rekening->atas_nama ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>
                
                {{-- BUKTI PEMBAYARAN --}}
                <div class="border border-[#E5E7EB] rounded-[16px] p-6 bg-white">

                    <h3 class="text-xl font-semibold text-[#111111] mb-6">
                        Bukti Pembayaran
                    </h3>

                    <div class="w-full h-[1px] bg-[#D9D9D9] mt-4 mb-6"></div>

                    <p class="text-sm font-medium text-[#111111] mb-4">
                        Upload Bukti Pembayaran *
                    </p>

                    <label
                        class="border-2 border-dashed border-[#D9D9D9]
                            rounded-[12px]
                            h-40
                            relative
                            overflow-hidden
                            flex flex-col
                            justify-center
                            items-center
                            cursor-pointer">

                        <input
                            type="file"
                            name="bukti"
                            id="bukti"
                            class="hidden"
                            accept=".jpg,.jpeg,.png,.pdf">

                        <img
                            id="previewBukti"
                            class="hidden absolute inset-0 w-full h-full object-contain bg-white rounded-[12px] cursor-pointer">

                        <div id="uploadText">
                            <p class="text-sm font-medium mt-3">
                                Klik untuk upload atau drag file ke sini
                            </p>

                            <p class="text-xs text-[#777777] mt-1">
                                JPG, PNG, PDF maks. 5MB
                            </p>
                        </div>

                        <button
                            type="button"
                            id="hapusBukti"
                            class="hidden absolute top-2 right-2 z-20
                                w-8 h-8 rounded-full
                                bg-white shadow-md
                                flex items-center justify-center
                                text-red-500 hover:bg-red-50">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                    </label>

                    @error('bukti')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- CHECKLIST --}}
                <div class="space-y-6">

                    <label class="flex items-start gap-3 cursor-pointer">

                        <input
                            type="checkbox"
                            name="syarat_ketentuan"
                            {{ old('syarat_ketentuan') ? 'checked' : '' }}
                            class="mt-1 w-5 h-5">

                        <div>
                            <p class="font-semibold text-[#111111]">
                                Syarat & Ketentuan *
                            </p>

                            <p class="text-sm text-[#545454] mt-1">
                                Saya telah membaca dan menyetujui syarat & ketentuan yang berlaku di platform CARENT.
                            </p>
                        </div>

                    </label>

                    @error('syarat_ketentuan')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                    <label class="flex items-start gap-3 cursor-pointer">

                        <input
                            type="checkbox"
                            name="tanggung_jawab"
                            {{ old('tanggung_jawab') ? 'checked' : '' }}
                            class="mt-1 w-5 h-5">

                        <div>
                            <p class="font-semibold text-[#111111]">
                                Tanggung Jawab Pengemudi *
                            </p>

                            <p class="text-sm text-[#545454] mt-1">
                                Saya bertanggung jawab atas kondisi kendaraan selama masa sewa dan wajib mengembalikan tepat waktu.
                            </p>
                        </div>

                    </label>

                    @error('tanggung_jawab')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <button
                    type="button"
                    id="openBookingConfirmModal"
                    class="w-full h-12 rounded-[8px] bg-[#0B1F67] text-white font-semibold">

                    Booking Mobil

                </button>

            </form>

        </div>

        {{-- RIGHT --}}
        <div class="order-1 lg:order-2">

            <div class="border border-[#E5E7EB] rounded-[16px] p-6 sticky top-24 bg-white">

                {{-- HEADER MOBIL --}}
                <div class="flex justify-between items-start gap-4">

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-[#111111]">
                            {{ $mobil->nama_mobil }} {{ $mobil->tahun }}
                        </h3>

                        <p class="text-sm text-[#545454] mt-1">
                            {{ $mobil->tahun }}
                            •
                            <span class="text-[#F5B301]">★</span>
                            {{ number_format($mobil->reviews_avg_rating ?? 0, 1) }}
                            ({{ $mobil->reviews_count ?? 0 }} Ulasan)
                        </p>

                {{-- TANGGAL --}}
                <div class="mt-4 flex items-start gap-3">
                    <img
                        src="{{ asset('images/icons/calendar-03.svg') }}"
                        class="w-5 h-5 mt-1 flex-shrink-0">

                    <div class="text-sm text-[#545454]">
                        <p>
                            {{ \Carbon\Carbon::parse($tglAmbil)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>

                        <p>
                            {{ \Carbon\Carbon::parse($tglKembali)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                {{-- LOKASI --}}
                <div class="mt-3 flex items-center gap-3">
                    <img
                        src="{{ asset('images/icons/location-04.svg') }}"
                        class="w-5 h-5 flex-shrink-0"
                    >

                    <p class="text-sm text-[#545454]">
                        {{ $lokasi }}
                    </p>
                </div>

            </div>

            <img
                src="{{ asset('storage/' . $mobil->fotos->first()->url_foto) }}"
                class="w-[115px] h-[85px] rounded-[10px] object-cover flex-shrink-0">

        </div>
        
            <div class="w-full h-[1px] bg-[#D9D9D9] my-6"></div>

                {{-- RINCIAN BIAYA --}}
                <div>
                    <h3 class="text-lg font-medium text-[#111111] mb-5">
                        Rincian Biaya
                    </h3>

                    {{-- SEWA DASAR --}}
                    <div class="flex justify-between items-start text-sm mb-4">
                        <p class="text-[#545454]">
                            Sewa dasar
                        </p>

                        <p class="text-[#545454] text-right">
                            Rp {{ number_format($mobil->harga_per_hari,0,',','.') }}
                            x
                            {{ $jumlahHari }} hari
                        </p>
                    </div>

                    {{-- DRIVER --}}
                    <div class="flex justify-between items-center text-sm mb-4">
                        <p class="text-[#545454]">
                            Driver
                        </p>

                        <p
                            id="driverBiaya"
                            class="text-[#545454]"
                        >
                            -
                        </p>
                    </div>

                    {{-- DEPOSIT --}}
                    <div class="flex justify-between items-center text-sm">
                        <p class="text-[#545454]">
                            Deposit (dikembalikan)
                        </p>

                        <p class="text-[#545454]">
                            Rp {{ number_format($deposit,0,',','.') }}
                        </p>
                    </div>

                </div>

            <div class="w-full h-[1px] bg-[#D9D9D9] my-6"></div>

                {{-- TOTAL --}}
                <div class="flex justify-between items-center">
                    <p class="text-lg font-semibold text-[#111111]">
                        Total Pembayaran
                    </p>

                    <p
                        id="totalPembayaran"
                        class="text-2xl font-bold text-[#0B1F67]"
                    >
                        Rp {{ number_format($total,0,',','.') }}
                    </p>
                </div>

            </div>

        </div>
    </div>

    </div>

</div>

<!-- POP UP DRIVER -->
<div id="modalDriver" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">

    <div class="bg-white rounded-[16px] w-full max-w-md p-6 relative">

        <button
            type="button"
            id="closeDriverModal"
            class="absolute top-4 right-4 text-gray-500">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-xl font-semibold text-[#111111] mb-6 text-center">
            Identitas Driver
        </h3>

        <div class="flex flex-col items-center">
            <img
                id="driverFoto"
                src=""
                class="w-28 h-28 rounded-full object-cover border mb-4">
            <h4
                id="driverNama"
                class="text-lg font-semibold text-[#111111]">
            </h4>
            <div class="mt-4 space-y-2 text-center">
                <p>
                    Umur:
                    <span id="driverUmur"></span>
                    Tahun
                </p>

                <p>
                    Telepon:
                    <span id="driverTelepon"></span>
                </p>
            </div>

        </div>

    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const driverCheckbox = document.querySelector('input[name="driver"]');
        const driverBiaya = document.getElementById('driverBiaya');
        const totalPembayaran = document.getElementById('totalPembayaran');

        const modalDriver = document.getElementById('modalDriver');
        const closeDriverModal = document.getElementById('closeDriverModal');

        const driverFoto = document.getElementById('driverFoto');
        const driverNama = document.getElementById('driverNama');
        const driverUmur = document.getElementById('driverUmur');
        const driverTelepon = document.getElementById('driverTelepon');

        const namaPengendara = document.getElementById('namaPengendara');
        const teleponPengendara = document.getElementById('teleponPengendara');
        const simPengendara = document.getElementById('simPengendara');
        const tglLahirPengendara = document.getElementById('tglLahirPengendara');

        const jumlahHari = {{ $jumlahHari }};
        const driverPerHari = 250000;
        const totalAwal = {{ $total }};

        // FUNGSI UNTUK MENGHITUNG ULANG TOTAL PEMBAYARAN KETIKA USER PAKAI ATAU TIDAK DRIVERNYA
        function updateBiaya() {
            if (driverCheckbox.checked) {
                const biayaDriver = driverPerHari * jumlahHari;
                const totalBaru = totalAwal + biayaDriver;

                document.getElementById('totalHargaInput').value = totalBaru;
                document.getElementById('totalHargaInput').value = totalAwal;

                driverBiaya.innerText =
                    'Rp ' + biayaDriver.toLocaleString('id-ID');

                totalPembayaran.innerText =
                    'Rp ' + totalBaru.toLocaleString('id-ID');
            } else {
                driverBiaya.innerText = '-';
                totalPembayaran.innerText =
                    'Rp ' + totalAwal.toLocaleString('id-ID');
                document.getElementById('driver_id').value = '';
            }
        }

        // MENONAKTIFKAN IDENTITTAS PENGENDARA KALAU USER PAKAI DRIVER
        function toggleIdentitasPengendara() {
            const isDriver = driverCheckbox.checked;
            [
                namaPengendara,
                teleponPengendara,
                simPengendara,
                tglLahirPengendara
            ].forEach(input => {
                input.readOnly = isDriver;

                if (isDriver) {
                    input.classList.add(
                        'bg-gray-100',
                        'text-gray-500',
                        'cursor-not-allowed'
                    );
                } else {
                    input.classList.remove(
                        'bg-gray-100',
                        'text-gray-500',
                        'cursor-not-allowed'
                    );
                }
            });

            // MENGUBAH JUDUL SECTION BUAT INFORMASI TAMBAHAN
            if (judulIdentitas) {
                if (isDriver) {
                    judulIdentitas.innerHTML =
                        'Identitas Pengendara <span class="text-sm text-gray-500">(Tidak diperlukan karena menggunakan driver)</span>';
                } else {
                    judulIdentitas.innerText =
                        'Identitas Pengendara';
                }
            }
        }
        
        // EVENT SAAT USER MEMILIH DRIVER
        if (driverCheckbox) {
            driverCheckbox.addEventListener('change', async function () {
                toggleIdentitasPengendara();
                updateBiaya();

                if (this.checked) {
                    try {
                        console.log('{{ route("customer.booking.driver-random", $mobil->mobil_id) }}');
                        const response = await fetch('{{ route("customer.booking.driver-random", $mobil->mobil_id) }}');
                        const result = await response.json();
                        console.log(result);

                        if (result.driver) {
                            document.getElementById('driver_id').value = result.driver.driver_id;
                            driverFoto.src = result.driver.foto ? '/storage/' + result.driver.foto : '/images/default-driver.png';
                            driverNama.innerText = result.driver.nama_driver ?? '-';
                            driverUmur.innerText = result.driver.umur ?? '-';
                            driverTelepon.innerText = result.driver.no_telp ?? '-';
                            modalDriver.classList.remove('hidden');
                        } else {
                            alert('Driver tidak tersedia untuk mobil ini.');
                            driverCheckbox.checked = false;
                            document.getElementById('driver_id').value = '';
                            updateBiaya();
                        }

                    } catch (error) {
                        console.error(error);
                    }
                }
            });

            updateBiaya();
        }

        if (closeDriverModal) {
            closeDriverModal.addEventListener('click', function () {
                modalDriver.classList.add('hidden');
            });
        }

        if (modalDriver) {
            modalDriver.addEventListener('click', function (e) {
                if (e.target === modalDriver) {
                    modalDriver.classList.add('hidden');
                }
            });
        }

        // UPLOAD BUKTI PEMBAYARAN
        const buktiInput = document.getElementById('bukti');
        const preview = document.getElementById('previewBukti');
        const uploadText = document.getElementById('uploadText');
        const hapusBukti = document.getElementById('hapusBukti');

        let fileUrl = null;
        if (buktiInput) {

            buktiInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                    fileUrl = URL.createObjectURL(file);
                    hapusBukti.classList.remove('hidden');

                if (file.type.includes('image')) {
                    preview.src = fileUrl;
                    preview.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                    preview.onclick = function () {
                        window.open(fileUrl, '_blank');
                    };

                } else {
                    preview.classList.add('hidden');
                    uploadText.classList.remove('hidden');
                    uploadText.innerHTML = `
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-file text-red-500 text-4xl"></i>
                            <p class="text-sm font-medium mt-3">
                                ${file.name}
                            </p>
                            <p class="text-xs text-[#777777] mt-1">
                                Klik untuk melihat PDF
                            </p>
                        </div> `;

                    uploadText.onclick = function () {
                        window.open(fileUrl, '_blank');
                    };
                }
            });

            hapusBukti.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                buktiInput.value = '';
                preview.src = '';
                preview.classList.add('hidden');
                uploadText.classList.remove('hidden');
                uploadText.innerHTML = `
                    <p class="text-sm font-medium mt-3">
                        Klik untuk upload atau drag file ke sini
                    </p>
                    <p class="text-xs text-[#777777] mt-1">
                        JPG, PNG, PDF maks. 5MB
                    </p> `;

                hapusBukti.classList.add('hidden');
                uploadText.onclick = null;
            });
        }

        // MODAL KONFIRMASI BOOKING DAN LOADING
        const bookingForm = document.getElementById('bookingForm');
        const openModalBtn = document.getElementById('openBookingConfirmModal');
        const confirmModal = document.getElementById('bookingConfirmModal');
        const closeModalBtn = document.getElementById('closeBookingConfirmModal');
        const confirmBookingBtn = document.getElementById('confirmBookingBtn');
        const loadingModal = document.getElementById('bookingLoadingModal');
        const progressCircle = document.getElementById('bookingProgressCircle');
        const progressText = document.getElementById('bookingProgressText');
        const circleLength = 314;

        if (openModalBtn) {
            openModalBtn.addEventListener('click', function () {
                confirmModal.classList.remove('hidden');
                confirmModal.classList.add('flex');
            });
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                confirmModal.classList.add('hidden');
                confirmModal.classList.remove('flex');
            });
        }

        if (confirmBookingBtn) {
            confirmBookingBtn.addEventListener('click', function () {
                confirmModal.classList.add('hidden');
                confirmModal.classList.remove('flex');
                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');

                let progress = 0;
                const interval = setInterval(() => {
                    progress++;
                    progressText.innerText = progress + '%';
                    const offset =
                        circleLength - (circleLength * progress / 100);
                    progressCircle.style.strokeDashoffset = offset;

                    if (progress >= 100) {
                        clearInterval(interval);
                        bookingForm.submit();
                    }

                }, 15);

            });
        }

        // MODAL SUKSES BOOKING
        @if(session('success_booking'))
            const successModal =
                document.getElementById('bookingSuccessModal');

            successModal.classList.remove('hidden');
            successModal.classList.add('flex');

            setTimeout(() => {
                window.location.href =
                    "{{ route('customer.booking.riwayat') }}";
            }, 3500);
        @endif
    });

</script>

<!-- ======== POP UP MESSAGE ======= -->

<!-- KONFIRMASI -->
<div id="bookingConfirmModal" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin booking mobil ini?
        </p>

        <div class="flex gap-4 mt-8">
            <button
                type="button"
                id="confirmBookingBtn"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>

            <button
                type="button"
                id="closeBookingConfirmModal"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>


<!-- LOADING -->
<div id="bookingLoadingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80] hidden items-center justify-center">

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
                id="bookingProgressCircle"
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
                id="bookingProgressText"
                class="text-2xl font-bold text-[#0B1F67]">
                0%
            </span>
        </div>
    </div>
</div>

<!-- PESAN SUKSES -->
<div id="bookingSuccessModal" class="fixed inset-0 z-[90] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img
                src="{{ asset('images/icons/check-circle.svg') }}"
                class="w-24 h-24"
                alt="Success">
        </div>

        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">
            Pesanan Berhasil Dibuat
        </h2>

        <p class="mt-3 text-gray-500 text-sm leading-relaxed">
            Pesananmu sedang menunggu konfirmasi admin. Anda akan dialihkan ke halaman Riwayat Booking.
        </p>
    </div>
</div>

@endsection