@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-2 px-2 h-screen" x-data>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.booking.index') }}"
            class="text-[#1D2B6B] hover:text-[#0b1f67] hover:underline text-sm font-medium rounded-lg transition">
            &lt; Kembali</a>
    </div>

    <div class="bg-white p-14 rounded-[20px] shadow-sm border border-gray-50 flex flex-col flex-grow overflow-hidden max-h-[85vh]">
        <div class="overflow-y-auto pr-2 flex-grow">
            <form id="formUpdateStatus" action="{{ route('admin.booking.status', $booking->kode_booking) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-4 mb-10">
                    <h1 class="text-[#1D2B6B] text-2xl font-bold">Detail Booking</h1>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Nama</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->nama_pengendara ?? $booking->user->name ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Kode Booking</label>
                                <div class="mt-2 p-3 bg-gray-200 rounded-lg text-sm font-bold border border-gray-300">{{ $booking->kode_booking }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Email</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->user->email ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Nomor Telephone</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->no_telp_pengendara ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Nomor SIM</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->no_sim_pengendara ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Tanggal Lahir</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tgl_lahir_pengendara ? \Carbon\Carbon::parse($booking->tgl_lahir_pengendara)->format('d/m/Y') : '-' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Tipe Unit</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->mobil->nama_mobil ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Lokasi</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->lokasi_penjemputan ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Tanggal Pengambilan</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tanggal_sewa ? \Carbon\Carbon::parse($booking->tanggal_sewa)->translatedFormat('l, d F Y') : '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Tanggal Pengembalian</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tanggal_kembali ? \Carbon\Carbon::parse($booking->tanggal_kembali)->translatedFormat('l, d F Y') : '-' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs text-gray-400">Waktu Pengambilan</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->waktu_ambil ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Waktu Pengembalian</label>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->waktu_kembali ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="lg:col-span-1 space-y-4">
                        <div>
                            <label class="text-xs text-gray-400">Bukti Transfer</label>
                            <div class="mt-2 min-h-[135px] max-h-[140px] bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 overflow-hidden">
                                @if ($booking->pembayaran?->bukti_pembayaran)
                                    <img src="{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}" class="h-full object-contain">
                                @else
                                    <span class="text-xs text-gray-400">Tidak ada bukti</span>
                                @endif
                            </div>
                            <a href="{{ route('admin.booking.bukti-transfer', $booking->kode_booking) }}" class="mt-12 block w-full text-center bg-[#1D2B6B] text-white py-3 rounded-lg text-sm font-semibold hover:bg-blue-900 transition">Download Bukti Transfer</a>
                        </div>

                        <div>
                            <label class="text-xs text-gray-400">Catatan</label>
                            <div class="mt-2 mb-8 p-3 min-h-[138px] bg-gray-50 rounded-lg text-sm text-gray-600 border border-gray-100">{{ $booking->catatan ?? '-' }}</div>
                        </div>

                        <div class="text-left" x-data="{ open: false, selected: '{{ $booking->status_booking }}' }">
                            <input type="hidden" name="status_booking" :value="selected">
                            <label class="block text-xs text-gray-400 mb-1 mt-2">Status</label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-3.5 bg-white border border-gray-200 rounded-lg inline-flex justify-between items-center h-10 relative z-20">
                                    <span class="flex-1 text-left text-gray-800 text-sm font-normal leading-6">
                                        @foreach ($statusOptions as $value => $label)
                                            <span x-show="selected === '{{ $value }}'" x-cloak>{{ $label }}</span>
                                        @endforeach
                                    </span>
                                    <img src="{{ asset('images/icons/Vector.svg') }}" class="h-3 w-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" alt="arrow">
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute left-0 z-10 w-full overflow-hidden pt-4"
                                    style="top: 50%; background-color: white; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; border-radius: 0 0 8px 8px;"
                                    x-cloak>
                                    @foreach ($statusOptions as $value => $label)
                                        <div x-show="selected !== '{{ $value }}'"
                                            @click="selected = '{{ $value }}'; open = false"
                                            style="background-color: white; color: #374151;"
                                            class="px-3.5 py-3 text-sm font-normal cursor-pointer transition-all duration-150 leading-6"
                                            onmouseover="this.style.backgroundColor='#EEF2FF'; this.style.color='#1D2B6B'; this.parentElement.style.borderColor='#1D2B6B';"
                                            onmouseout="this.style.backgroundColor='white'; this.style.color='#374151'; this.parentElement.style.borderColor='#d1d5db';">
                                            {{ $label }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RINCIAN BIAYA --}}
                <div class="mt-6">
                    <h2 class="text-xs text-gray-400">Rincian Biaya</h2>
                    <div class="border border-gray-200 rounded-xl p-5 space-y-3 mt-2">
                        @php $rincian = $booking->rincian_harga ?? []; @endphp
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sewa dasar (1 hari)</span>
                            <span>Rp {{ number_format($booking->mobil->harga_per_hari ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Driver</span>
                            <span>{{ !empty($rincian['harga_driver']) ? 'Rp '.number_format($rincian['harga_driver'], 0, ',', '.') : '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Deposit (dikembalikan)</span>
                            <span>Rp {{ number_format($rincian['deposit'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between font-bold text-black text-sm">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD PEMBATALAN --}}
                @if ($booking->status_booking === 'dibatalkan' && $booking->alasan_pembatalan)
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-sm font-semibold text-red-900">Booking Dibatalkan</h2>
                        <span class="text-sm text-red-900">
                            {{ $booking->tanggal_pembatalan ? \Carbon\Carbon::parse($booking->tanggal_pembatalan)->format('d/m/Y | H:i') : '-' }}
                        </span>
                    </div>
                    <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                        <p class="text-sm text-red-800">{{ $booking->alasan_pembatalan }}</p>
                    </div>
                </div>
                @endif

                {{-- CARD DRIVER --}}
                @if ($booking->pakai_driver && $booking->driver)
                <div class="mt-6">
                    <h2 class="text-xs font-medium text-gray-400 mb-2">Informasi Driver</h2>
                    <div class="border border-gray-200 rounded-xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                            @if ($booking->driver->foto)
                                <img src="{{ asset('storage/' . $booking->driver->foto) }}" class="w-full h-full object-cover" alt="{{ $booking->driver->nama_driver }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-xs">N/A</div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $booking->driver->nama_driver ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->driver->umur ? $booking->driver->umur . ' tahun' : '-' }}
                                <span class="mx-1">•</span>
                                {{ $booking->driver->no_telepon ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- TOMBOL KONFIRMASI --}}
                <button type="button"
                    data-confirm="confirmUbahStatus"
                    data-feedback="successUbahStatus"
                    data-target-submit="formUpdateStatus"
                    class="mt-7 w-full bg-[#0b1f67] hover:bg-[#0e2781] text-white font-semibold py-3 rounded-xl text-sm transition-all duration-150 shadow-md">
                    Konfirmasi
                </button>

            </form>
        </div>
    </div>
</div>

{{-- KONFIRMASI --}}
<div id="confirmUbahStatus" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin mengubah status ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" data-submit=""
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" data-close="confirmUbahStatus"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- FEEDBACK SUKSES --}}
<div id="successUbahStatus" class="fixed inset-0 z-[90] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <div class="w-24 h-24 flex items-center justify-center">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="Success">
            </div>
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Status berhasil diubah</h2>
    </div>
</div>

@endsection