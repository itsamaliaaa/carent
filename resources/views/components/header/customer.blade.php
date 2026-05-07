<nav class="bg-white border-b sticky top-0 z-50"
     x-data="{ open: false }">

    <!-- CONTAINER -->
    <div class="px-8 py-4 flex justify-between items-center">

        <!-- LEFT: LOGO -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="h-9">
        </div>

        <!-- MENU DESKTOP -->
        <div class="hidden md:flex items-center gap-10 text-sm font-medium">

            <a href="/"
               class="{{ request()->is('/') ? 'text-[#0B1F67] border-b-2 border-[#0B1F67]' : 'text-gray-600' }}
                      hover:text-[#0B1F67] pb-1 transition">
                Beranda
            </a>

            <a href="/katalog"
               class="{{ request()->is('katalog') ? 'text-[#0B1F67] border-b-2 border-[#0B1F67]' : 'text-gray-600' }}
                      hover:text-[#0B1F67] pb-1 transition">
                Katalog Mobil
            </a>

            @auth
                <a href="/customer/riwayat"
                   class="{{ request()->is('customer/riwayat') ? 'text-[#0B1F67] border-b-2 border-[#0B1F67]' : 'text-gray-600' }}
                          hover:text-[#0B1F67] pb-1 transition">
                    Riwayat Booking
                </a>
            @endauth

        </div>

        <!-- RIGHT DESKTOP -->
        <div class="hidden md:flex items-center gap-3">

            @guest
                <a href="/register"
                   class="px-5 h-10 flex items-center justify-center border border-[#0B1F67] text-[#0B1F67] rounded-md text-sm font-medium
                          hover:bg-[#0B1F67] hover:text-white transition">
                    Daftar
                </a>

                <a href="/login"
                   class="px-5 h-10 flex items-center justify-center bg-[#0B1F67] text-white rounded-md text-sm font-medium
                          hover:opacity-90 transition">
                    Masuk
                </a>
            @endguest

            @auth
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endauth

        </div>

        <!-- HAMBURGER (MOBILE) -->
        <button id="menuBtn" class="md:hidden text-2xl text-[#0B1F67]">
            ☰
        </button>

    </div>

    <!-- MOBILE MENU -->

    <div id="mobileMenu" class="hidden md:hidden bg-white border-t px-8 py-4">

    <div class="flex flex-col gap-4 text-base font-medium">

        <!-- MENU -->
        <a href="/" class="text-gray-700 hover:text-[#0B1F67]">
            Beranda
        </a>

        <a href="/katalog" class="text-gray-700 hover:text-[#0B1F67]">
            Katalog Mobil
        </a>

        @auth
            <a href="/customer/riwayat" class="text-gray-700 hover:text-[#0B1F67]">
                Riwayat Booking
            </a>
        @endauth

        <div class="border-t border-gray-400 my-2"></div>

        <!-- AUTH -->
        @guest
            <a href="/register"
               class="px-5 h-10 flex items-center justify-center border border-[#0B1F67] text-[#0B1F67] hover:bg-[#0B1F67] hover:text-white transition rounded-md">
                Daftar
            </a>

            <a href="/login"
               class="px-5 h-10 flex items-center justify-center bg-[#0B1F67] text-white rounded-md hover:opacity-90 transition">
                Masuk
            </a>
        @endguest

        @auth
            <a href="/customer/profil" class="text-gray-700 hover:text-[#0B1F67]">
                Profile
            </a>
        @endauth

        </div>

    </div>

</nav>