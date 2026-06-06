@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-2 px-2">

    {{-- Card Filter & Search --}}
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50 mb-3">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Management Booking</h1>
        </div>
        <hr class="border-t border-gray-200 mb-6">

        <form method="GET" action="{{ route('admin.booking.index') }}">
            {{-- Date Filter --}}
            <div class="flex items-end gap-4 mb-5">
                {{-- Tanggal Mulai --}}
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
                </div>

                <span class="text-sm text-gray-500 mb-2">s/d</span>

                {{-- Tanggal Selesai --}}
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] uppercase">
                </div>

                <button type="submit" class="bg-[#1D2B6B] flex-1 text-white px-5 py-2 rounded-lg font-semibold text-xs hover:bg-[#152052] transition mb-[1px]">
                    Terapkan Filter
                </button>
            </div>

            {{-- Search — name="cari" sesuai controller --}}
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4 opacity-40" alt="Search Icon">
                    </div>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari nama penyewa / kode booking"
                        class="w-full pl-10 pr-4 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1D2B6B] text-sm text-gray-400">
                </div>
                <button class="bg-[#0b1f67] text-white px-5 py-1.5 rounded-lg font-semibold text-[11px] hover:bg-[#0e2781] transition">Cari</button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Booking --}}
<div class="bg-white rounded-[20px] p-7 shadow-sm border border-gray-50">
    <div class="overflow-x-auto">
        <div class="min-w-[1100px]">

            {{-- Header Tabel --}}
            <div class="grid grid-cols-[1fr_1fr_1.2fr_1.3fr_1.3fr_0.8fr] bg-[#F8F9FB] rounded-xl py-4 px-6 mb-4 items-center gap-x-4 font-bold text-[13px] text-gray-600">
                <div>Nama Penyewa</div>
                <div>Tipe Unit</div>
                <div>Tanggal Pengambilan</div>
                <div>Tanggal Pengembalian</div>
                <div>Status</div>
                <div class="text-center">Aksi</div>
            </div>

            {{-- Body Tabel --}}
            <div class="flex flex-col gap-2">
                @forelse ($bookings as $booking)
                <div class="grid grid-cols-[1fr_1fr_1.2fr_1.3fr_1.3fr_0.8fr] items-center border border-[#E0E4EC] rounded-2xl py-3 px-6 gap-x-4">

                    {{-- Nama Penyewa: user->name atau nama_pengendara --}}
                    <div class="text-[14px] font-semibold text-gray-800">
                        {{ $booking->user->name ?? $booking->nama_pengendara ?? 'Tanpa Nama' }}
                    </div>

                    {{-- Tipe Unit: dari relasi mobil --}}
                    <div class="text-[14px] font-medium text-gray-600">
                        {{ $booking->mobil->nama_mobil ?? '-' }}
                    </div>

                    {{-- Tanggal Pengambilan: tanggal_sewa --}}
                    <div class="text-[13px] text-gray-500">
                        {{ $booking->tanggal_sewa
                            ? \Carbon\Carbon::parse($booking->tanggal_sewa)->translatedFormat('l, d F Y')
                            : '-' }}
                    </div>

                    {{-- Tanggal Pengembalian: tanggal_kembali --}}
                    <div class="text-[13px] text-gray-500">
                        {{ $booking->tanggal_kembali
                            ? \Carbon\Carbon::parse($booking->tanggal_kembali)->translatedFormat('l, d F Y')
                            : '-' }}
                    </div>

                    {{-- Status Badge — status_booking --}}
                    <div>
                        @php
                        $statusClass = match($booking->status_booking) {
                        'menunggu_konfirmasi' => 'bg-[#FFFDE7] text-[#FBC02D]',
                        'dikonfirmasi' => 'bg-[#E8F5E9] text-[#388E3C]',
                        'sedang_berlangsung' => 'bg-[#EDE7F6] text-[#5E35B1]',
                        'deposit_kembali' => 'bg-[#FFF3E0] text-[#E65100]',
                        'selesai' => 'bg-[#E3F2FD] text-[#1565C0]',
                        'dibatalkan' => 'bg-[#FCE4EC] text-[#C62828]',
                        'ditolak' => 'bg-[#F3E5F5] text-[#6A1B9A]',
                        default => 'bg-gray-100 text-gray-500',
                        };
                        $statusLabel = $statusOptions[$booking->status_booking] ?? $booking->status_booking;
                        @endphp
                        <span class="{{ $statusClass }} w-fit inline-block whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-bold">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('admin.booking.show', $booking->booking_id) }}"
                            class="bg-[#1D2B6B] text-white text-[11px] font-bold px-5 py-2 rounded-lg hover:bg-[#152052] transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-gray-400 text-sm">Tidak ada data booking.</div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-end">
        {{ $bookings->links() }}
    </div>
</div>

{{-- Modal Konfirmasi Ubah Status --}}
<div id="confirmUbahStatus" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin mengubah status ini?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" id="confirmUbahStatusBtn"
                class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" id="closeUbahStatusConfirmModal"
                class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- Feedback Ubah Status Berhasil --}}
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