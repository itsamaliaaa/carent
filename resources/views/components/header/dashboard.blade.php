@php
    $role = auth()->user()->role;
    $active = request()->segment(2);

    $activeClass = 'bg-[#E7E9F2] text-[#0B1F67] font-semibold';
    $hoverClass  = 'text-gray-600 hover:bg-[#E7E9F2] hover:text-[#0B1F67] hover:font-semibold';

    $iconActive = 'brightness-0 saturate-100 invert-[13%] sepia-[61%] saturate-[1400%] hue-rotate-[210deg] brightness-[95%] contrast-[95%]';
    $iconHover = 'group-hover:brightness-0 group-hover:saturate-100 group-hover:invert-[13%] group-hover:sepia-[61%] group-hover:saturate-[1400%] group-hover:hue-rotate-[210deg] group-hover:brightness-[95%] contrast-[95%]';
@endphp

<nav class="bg-white border-b px-6 md:px-8 py-3 flex justify-between items-center 
            sticky top-0 z-50">
            
    <!-- LEFT -->
    <div class="flex items-center gap-3">

        <!-- HAMBURGER (MOBILE ONLY) -->
        <button id="openSidebar" class="md:hidden text-2xl text-gray-700">
            ☰
        </button>

        <!-- LOGO -->
        @if($role == 'super_admin')
        <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="h-9">
        </a>
        @endif

        @if($role == 'admin_rental')
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="h-9">
        </a>
        @endif


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