@extends('layouts.admin')

@section('content')
<div class="py-2 px-2">
    {{-- Header --}}
    <div class="bg-white p-12 rounded-[20px] shadow-sm border border-gray-50 mb-4">
        <h1 class="text-[#1D2B6B] text-2xl font-bold mb-8">Detail Booking</h1>

        <form action="{{ route('admin.booking.status', $booking->booking_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: Data Utama (Mengambil 2 kolom) --}}
                <div class="lg:col-span-2 space-y-4">
                    {{-- Baris 1 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Nama</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->nama_pengendara ?? $booking->user->name ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Kode Booking</label>
                            <div class="mt-1 p-3 bg-gray-200 rounded-lg text-sm font-bold border border-gray-300">{{ $booking->kode_booking }}</div>
                        </div>
                    </div>

                    {{-- Baris 2 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Email</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->user->email ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Nomor Telephone</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->no_telp_pengendara ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Baris 3 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Nomor SIM</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->no_sim_pengendara ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Tanggal Lahir</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tgl_lahir_pengendara ? \Carbon\Carbon::parse($booking->tgl_lahir_pengendara)->format('d/m/Y') : '-' }}</div>
                        </div>
                    </div>

                    {{-- Baris 4 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Tipe Unit</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->mobil->nama_mobil ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Lokasi</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->lokasi_penjemputan ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Baris 5 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Tanggal Pengambilan</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tanggal_sewa ? \Carbon\Carbon::parse($booking->tanggal_sewa)->translatedFormat('l, d F Y') : '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Tanggal Pengembalian</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->tanggal_kembali ? \Carbon\Carbon::parse($booking->tanggal_kembali)->translatedFormat('l, d F Y') : '-' }}</div>
                        </div>
                    </div>

                    {{-- Baris 6 --}}
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs text-gray-400">Waktu Pengambilan</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->waktu_ambil ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Waktu Pengembalian</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-sm border border-gray-100">{{ $booking->waktu_kembali ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Bukti Transfer & Status --}}
                <div class="lg:col-span-1 space-y-4">
                    <div>
                        <label class="text-xs text-gray-400">Bukti Transfer</label>
                        <div class="mt-1 min-h-[135px] bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 overflow-hidden">
                            @if ($booking->pembayaran?->bukti_pembayaran)
                            <img src="{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}" class="h-full object-contain">
                            @else
                            <span class="text-xs text-gray-400">Tidak ada bukti</span>
                            @endif
                        </div>
                        <a href="#" class="mt-11 block w-full text-center bg-[#1D2B6B] text-white py-3 rounded-lg text-sm font-semibold hover:bg-blue-900 transition">Download Bukti Transfer</a>
                    </div>

                    <div>
                        <label class="text-xs text-gray-400">Catatan</label>
                        <div class="mt-1 p-3 min-h-[133px] bg-gray-50 rounded-lg text-sm text-gray-600 border border-gray-100">{{ $booking->catatan ?? '-' }}</div>
                    </div>

                    <div>
                        <label class="text-xs text-gray-400">Status</label>
                        <select name="status_booking" class="w-full mt-2 p-3 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-[#1D2B6B] outline-none">
                            @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ $booking->status_booking === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- RINCIAN BIAYA (Full Width di bawah) --}}
            <div class="mt-6">
                <h2 class="text-sm font-bold text-gray-400 mb-2">Rincian Biaya</h2>

                <div class="border border-gray-200 rounded-xl p-5 space-y-3">
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

            <button type="submit" class="w-full mt-6 bg-[#1D2B6B] text-white py-4 rounded-[20px] font-bold">Konfirmasi</button>
        </form>
    </div>
</div>
@endsection