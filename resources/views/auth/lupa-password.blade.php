<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Carent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white overflow-y-auto">

<div class="flex flex-col lg:flex-row min-h-screen w-full">

    {{-- SISI KIRI / ATAS --}}
    <div class="w-full lg:w-1/2 min-h-[280px] lg:min-h-screen relative overflow-hidden flex flex-col lg:sticky lg:top-0"
        style='background-image: url("{{ asset("images/banner/bakcground.png") }}"); background-size: cover; background-position: center;'>

        <div class="absolute inset-0 bg-black opacity-20"></div>

        {{-- Tombol Kembali --}}
        <div class="absolute top-5 left-6 z-10 ">
            <a href="{{ route('beranda') }}"
            class="flex items-center gap-2 text-white text-sm font-medium hover:opacity-80 transition">
                <img src="{{ asset('images/icons/arrow-left.svg') }}" alt="Kembali" class="w-4 h-4">
                Kembali
            </a>
        </div>

        {{-- Logo --}}
        <div class="absolute top-14 left-6 z-10">
            <img src="{{ asset('images/logo/logo-white.png') }}" alt="Carent" class="h-8 w-auto">
        </div>

        {{-- Teks - Desktop (kiri bawah) --}}
        <div class="hidden lg:flex absolute bottom-40 left-10 right-10 flex-col gap-4 z-10">
            <div>
                <h1 class="text-white text-5xl font-semibold leading-tight">Halo!</h1>
                <h2 class="text-white text-2xl font-semibold">Selamat Datang di CARENT</h2>
            </div>
            <p class="text-white text-lg leading-relaxed">
                Siap untuk perjalananmu hari ini?<br>
                Masuk dan temukan mobil terbaik untuk kebutuhanmu.
            </p>
        </div>

        {{-- Teks - Mobile (kiri bawah banner) --}}
        <div class="flex lg:hidden absolute bottom-8 left-6 right-6 flex-col gap-1 z-10">
            <h1 class="text-white text-3xl font-semibold">Halo!</h1>
            <h2 class="text-white text-base font-semibold">Selamat Datang di CARENT</h2>
        </div>
    </div>

    {{-- SISI KANAN / BAWAH --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 lg:px-16">
        <div class="w-full max-w-md flex flex-col gap-5 py-10">

            {{-- Judul --}}
            <div class="flex flex-col gap-1.5 mb-2">
                <h2 class="text-3xl font-bold text-gray-900">Lupa Password</h2>
                <p class="text-gray-500 text-sm">Masukkan email Anda untuk reset password</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('password.email') }}" method="POST">                
                
            @csrf

                {{-- Email --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Masukkan Email"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 mb-10 text-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Kirim --}}
                <button type="submit"
                        class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold
                               py-3 rounded-lg transition duration-200 mt-2">
                    Kirim
                </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>