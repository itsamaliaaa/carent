@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold">Detail Booking</h1>
<div class="flex min-h-screen bg-gray-100 font-inter">
    <!-- Sidebar (Hidden on mobile, usually integrated via @include) -->
    <aside class="w-72 bg-white border-r hidden lg:flex flex-col fixed h-full">
        <div class="p-6">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 text-gray-600">
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 text-blue-900 font-semibold">
                <span>Manajemen Booking</span>
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
            </form>
        </div>
    </main>
</div>
@endsection
