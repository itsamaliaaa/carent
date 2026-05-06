<nav class="bg-white border-b px-6 md:px-8 py-3 flex justify-between items-center 
            sticky top-0 z-50">
            
    <!-- LEFT -->
    <div class="flex items-center gap-3">

        <!-- HAMBURGER (MOBILE ONLY) -->
        <button id="openSidebar" class="md:hidden text-2xl text-gray-700">
            ☰
        </button>

        <!-- LOGO -->
        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="h-9">
    </div>

    <!-- RIGHT: USER -->
    <div class="flex items-center gap-3">

        <!-- NAMA -->
        <span class="text-sm text-gray-700 hidden sm:block">
            {{ 'Admin' }}
        </span>

        <!-- AVATAR -->
        <div class="w-9 h-9 rounded-full bg-gray-300 overflow-hidden">
            <img src="https://i.pravatar.cc/100" class="w-full h-full object-cover">
        </div>

    </div>

</nav>