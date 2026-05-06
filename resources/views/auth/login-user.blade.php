<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body class="bg-white">

<div class="flex h-screen w-full">
    <div class="w-1/2 relative overflow-hidden flex flex-col"
         style="background: linear-gradient(135deg, #0f1f6e 0%, #1a3a8f 40%, #2d5be3 100%);">
        <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] rounded-full opacity-20"
             style="background: radial-gradient(circle, #4f7fff, transparent)"></div>
        <div class="absolute top-1/3 -right-24 w-[350px] h-[350px] rounded-full opacity-20"
             style="background: radial-gradient(circle, #7fa8ff, transparent)"></div>

        <div class="absolute bottom-40 left-10 right-10 flex flex-col gap-4">
            <div>
                <h1 class="text-white text-5xl font-semibold leading-tight">Halo!</h1>
                <h2 class="text-white text-2xl font-semibold">Selamat Datang di CARENT</h2>
            </div>
            <p class="text-blue-200 text-lg font-medium leading-relaxed">
                Siap untuk perjalananmu hari ini?<br>
                Masuk dan temukan mobil terbaik untuk kebutuhanmu.
            </p>
        </div>
    </div>
    <div class="w-1/2 flex items-center justify-center px-16">
        <div class="w-full max-w-md flex flex-col gap-5">
            <div class="flex flex-col gap-1.5 mb-4">
                <h2 class="text-3xl font-bold text-gray-900">Login</h2>
                <p class="text-gray-500 text-sm">Masuk untuk melanjutkan ke akun kamu</p>
            </div>
            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Masukkan Email"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               @error('email') border-red-400 @enderror"
                    >
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan Password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm pr-12
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold
                               py-3 rounded-lg transition duration-200 mt-2">
                    Login
                </button>
            </form>
            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-900 font-bold hover:underline">Daftar</a>
            </p>

        </div>
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>