<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Carent</title>
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
                <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
                <p class="text-gray-500 text-sm">Masukkan email dan password baru Anda</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Password Baru --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-gray-700">Password Baru</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan Password Baru"
                            class="w-full border border-gray-300 rounded-lg px-4 pr-12 py-3 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                @error('password') border-red-400 bg-red-50 @enderror">
                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon1')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <img id="eyeIcon1" src="{{ asset('images/icons/eye.svg') }}" class="w-5 h-5">
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="passwordConfirmInput"
                            placeholder="Ulangi Password Baru"
                            class="w-full border border-gray-300 rounded-lg px-4 pr-12 py-3 mb-10 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('passwordConfirmInput', 'eyeIcon2')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <img id="eyeIcon2" src="{{ asset('images/icons/eye.svg') }}" class="w-5 h-5">
                        </button>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <button type="submit"
                        class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold
                            py-3 rounded-lg transition duration-200 mt-2">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
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
</script>
</body>
</html>