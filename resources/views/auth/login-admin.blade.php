<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Carent</title>
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
                <h1 class="text-white text-5xl font-semibold leading-tight">Halo Admin!</h1>
                <h2 class="text-white text-2xl font-semibold">Selamat Datang di CARENT</h2>
            </div>
            <p class="text-white text-lg leading-relaxed">
                Siap mengelola rental hari ini?<br>
                Pantau data mobil, booking, dan aktivitas penyewa dengan mudah.
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
                <h2 class="text-3xl font-bold text-gray-900">Login</h2>
                <p class="text-gray-500 text-sm">Masuk untuk melanjutkan ke akun kamu</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.login') }}" method="POST" class="flex flex-col gap-4">               
             @csrf

                {{-- Email --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Masukkan Email"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan Password"
                            class="w-full border border-gray-300 rounded-lg px-4 pr-12 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   @error('password') border-red-400 bg-red-50 @enderror">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <img id="eyeIcon" src="{{ asset('images/icons/eye.svg') }}" alt="Toggle Password" class="w-5 h-5">
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember & Lupa Password --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        Ingat Saya
                    </label>
                    <a href=""
                       class="text-sm text-blue-700 font-medium hover:underline">
                        Lupa Password?
                    </a>
                </div>

                {{-- Tombol Login --}}
                <button type="submit"
                        class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold
                               py-3 rounded-lg transition duration-200 mt-2">
                    Login
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('eyeIcon');

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