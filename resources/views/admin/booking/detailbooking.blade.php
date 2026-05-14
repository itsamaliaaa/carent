@extends('layouts.admin')

@section('content')
<script defer src="[https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js](https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js)"></script>
    <h1 class="text-2xl font-semibold">Detail Booking</h1>
<div class="flex min-h-screen bg-gray-100 font-inter">
    <aside class="w-72 bg-white border-r hidden lg:flex flex-col fixed h-full">
        <div class="p-6">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 text-gray-600">
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 text-blue-900 font-semibold">
                <span>Riwayat Booking</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 flex-1 p-4 lg:p-12 mt-16 lg:mt-0">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-[#0b1f67] mb-8">Detail Booking</h1>

            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left Column: Inputs -->
                    <div class="lg:col-span-2 space-y-4">
                        <div>
                            <label class="text-xs text-gray-400 uppercase font-medium">Nama</label>
                            <div class="mt-1 p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">{{ $booking->customer_name }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-400 uppercase font-medium">Email</label>
                                <div class="mt-1 p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">{{ $booking->email }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 uppercase font-medium">Nomor Telepon</label>
                                <div class="mt-1 p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">{{ $booking->phone }}</div>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs text-gray-400 uppercase font-medium">Tipe Unit</label>
                            <div class="mt-1 p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">{{ $booking->car->name }}</div>
                        </div>

                        <div>
                            <label class="text-xs text-gray-700 font-semibold">Update Status</label>
                            <div class="relative mt-1">
                                <select name="status" class="w-full p-3 border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-blue-900 outline-none cursor-pointer">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="success" {{ $booking->status == 'success' ? 'selected' : '' }}>Success</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Media & Actions -->
                    <div class="space-y-6">
                        <div class="rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ asset('storage/'.$booking->car->image) }}" class="w-full h-40 object-cover" alt="Car">
                        </div>

                        <a href="{{ asset('storage/'.$booking->payment_proof) }}" download class="block w-full text-center bg-[#0b1f67] text-white py-3 rounded-lg font-semibold hover:bg-[#0e2781] transition">
                            Download Bukti
                        </a>

                        <div>
                            <label class="text-xs text-gray-400 uppercase font-medium">Catatan</label>
                            <div class="mt-1 p-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 min-h-[100px]">
                                {{ $booking->notes ?? 'Tidak ada catatan' }}
                            </div>
                        </div>

                        <div class="p-3 bg-gray-200 text-center rounded-lg font-mono text-sm font-bold text-gray-700">
                            {{ $booking->booking_code }}
                        </div>
                    </div>
                </div>

                <!-- Confirmation Button -->
                <button type="submit" class="w-full mt-10 bg-[#0b1f67] text-white py-4 rounded-lg font-bold text-lg hover:shadow-lg transition-all">
                    Simpan Perubahan
                </button>
                <div x-data="{ showForm: false, showConfirm: false, showPolicy: false }">

                    <!-- Tombol Batalkan di Card Detail -->
                    <div class="flex justify-end">
                        <button @click="showForm = true" class="bg-[#a32a3e] hover:bg-[#852232] text-white px-8 py-2.5 rounded-lg font-semibold transition">
                            Batalkan
                        </button>
                    </div>

                    <!-- MODAL 1: Form Batal Pesanan -->
                    <div x-show="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
                        <div class="bg-white rounded-2xl p-8 max-w-md w-full relative shadow-xl">
                            <button @click="showForm = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>

                            <div class="text-center mb-6">
                                <h3 class="text-xl font-bold text-[#0b1f67] mb-2">Yakin ingin membatalkan booking ini?</h3>
                                <p class="text-xs text-gray-500 px-4">Pembatalan akan diproses sesuai kebijakan rental. Biaya mungkin dipotong tergantung waktu pembatalan.</p>
                            </div>

                            <div class="mb-6 text-left">
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Alasan Pembatalan *</label>
                                <textarea id="cancelReason" placeholder="Masukkan alasan pembatalan" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-900 outline-none h-24"></textarea>
                            </div>

                            <div class="space-y-4">
                                <button @click="showForm = false; showConfirm = true" class="w-full bg-[#0b1f67] text-white py-3 rounded-lg font-bold">
                                    Batalkan Booking
                                </button>
                                <button @click="showPolicy = true" class="block w-full text-center text-xs font-bold text-blue-900 underline">
                                    Lihat kebijakan pembatalan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 2: Konfirmasi (Ya/Tidak) -->
                    <div x-show="showConfirm" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50" x-cloak>
                        <div class="bg-white rounded-2xl p-10 max-w-sm w-full text-center shadow-2xl">
                            <h3 class="text-lg font-bold text-[#0b1f67] mb-8 px-4">Apakah kamu yakin ingin membatalkan booking ini?</h3>
                            <div class="flex gap-4">
                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="reason" x-ref="finalReason">
                                    <button type="submit" @click="$refs.finalReason.value = document.getElementById('cancelReason').value" class="w-full bg-[#7ab356] text-white py-2.5 rounded-lg font-bold">Ya</button>
                                </form>
                                <button @click="showConfirm = false" class="flex-1 bg-[#be2e44] text-white py-2.5 rounded-lg font-bold">Tidak</button>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 3: Kebijakan Pembatalan -->
                    <div x-show="showPolicy" class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50" x-cloak>
                        <div class="bg-white rounded-2xl p-8 max-w-lg w-full relative max-h-[90vh] overflow-y-auto">
                            <button @click="showPolicy = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>
                            <h2 class="text-center text-2xl font-bold text-[#0b1f67] mb-6">Kebijakan Pembatalan</h2>

                            <div class="space-y-6 text-sm text-gray-800">
                                <section>
                                    <h4 class="font-bold mb-2 text-base">Syarat Pembatalan</h4>
                                    <ul class="list-disc ml-5 space-y-1 text-gray-600">
                                        <li>Pembatalan hanya dapat dilakukan jika status booking belum selesai.</li>
                                        <li>Pengguna wajib mengisi alasan pembatalan pada form yang tersedia.</li>
                                        <li>Pembatalan tidak dapat dilakukan setelah waktu sewa dimulai.</li>
                                    </ul>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL 4: Sukses (Muncul via Session Laravel) -->
                @if(session('success_cancel'))
                <div class="fixed inset-0 z-[80] flex items-center justify-center bg-black/50">
                    <div class="bg-white rounded-2xl p-12 max-w-md w-full text-center shadow-2xl">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-600">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#0b1f67] mb-2">Pembatalan Berhasil!</h3>
                        <p class="text-gray-500">Permintaan pembatalan Anda sedang diproses.</p>
                        <button onclick="window.location.reload()" class="mt-8 text-blue-900 font-bold underline">Tutup</button>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </main>
</div>
@endsection
