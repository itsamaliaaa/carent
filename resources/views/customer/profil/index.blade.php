@extends('layouts.customer')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="bg-white rounded-2xl shadow p-8">

        <!-- HEADER -->
        <div class="flex items-center gap-5 mb-8">

            <div class="w-20 h-20 rounded-full
                        bg-gradient-to-r from-blue-400 to-indigo-500
                        flex items-center justify-center
                        text-white text-3xl font-semibold">

                {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
            </div>

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ auth()->user()->nama_lengkap }}
                </h1>

                <p class="text-gray-500">
                    {{ auth()->user()->email }}
                </p>
            </div>

        </div>

        <!-- FORM -->
        <form class="flex flex-col gap-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>

                <input type="text"
                       value="{{ auth()->user()->nama_lengkap }}"
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input type="email"
                       value="{{ auth()->user()->email }}"
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Telepon
                </label>

                <input type="text"
                       value="{{ auth()->user()->no_telp }}"
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            <button type="submit"
                    class="mt-3 bg-[#0B1F67] text-white px-6 py-3 rounded-xl w-fit hover:opacity-90 transition">

                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

@endsection