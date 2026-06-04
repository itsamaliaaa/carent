@php
    $role = auth()->user()->role;
    $active = request()->segment(2);

    $activeClass = 'bg-[#E7E9F2] text-[#0B1F67] font-semibold';
    $hoverClass  = 'text-gray-600 hover:bg-[#E7E9F2] hover:text-[#0B1F67] hover:font-semibold';

    $iconActive = 'brightness-0 saturate-100 invert-[13%] sepia-[61%] saturate-[1400%] hue-rotate-[210deg] brightness-[95%] contrast-[95%]';
    $iconHover = 'group-hover:brightness-0 group-hover:saturate-100 group-hover:invert-[13%] group-hover:sepia-[61%] group-hover:saturate-[1400%] group-hover:hue-rotate-[210deg] group-hover:brightness-[95%] contrast-[95%]';
@endphp

<aside id="sidebar"
       class="w-64 h-[calc(100vh-4rem)] md:h-screen overflow-y-auto
              bg-white border-r flex flex-col justify-between text-sm
              fixed md:sticky top-16 md:top-0
              transform -translate-x-full md:translate-x-0
              transition duration-300 z-40">

    <!-- TOP -->
    <div class="p-5">
        <div class="flex flex-col gap-1">

            {{-- ADMIN RENTAL --}}
            @if($role == 'admin_rental')

                <!-- DASHBOARD -->
                <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg
                {{ $active == 'dashboard' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/menu-square.svg') }}"
                        class="w-5 h-5 transition
                        {{ $active == 'dashboard' ? $iconActive : $iconHover }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.driver.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'driver' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/user-group.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'driver' ? $iconActive : $iconHover }}">
                    Manajemen Driver
                </a>

                <a href="{{ route('admin.mobil.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'mobil' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/mobil.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'mobil' ? $iconActive : $iconHover }}">
                    Manajemen Mobil
                </a>

                <a href="{{ route('admin.booking.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'booking' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/booking.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'booking' ? $iconActive : $iconHover }}">
                    Manajemen Booking
                </a>

                <a href="{{ route('admin.review.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'review' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/star.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'review' ? $iconActive : $iconHover }}">
                    Reply Review
                </a>

            @endif


            {{-- SUPER ADMIN --}}
            @if($role == 'super_admin')

                <!-- DASHBOARD -->
                <a href="{{ route('superadmin.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-lg
                {{ $active == 'dashboard' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/menu-square.svg') }}"
                        class="w-5 h-5 transition
                        {{ $active == 'dashboard' ? $iconActive : $iconHover }}">
                    Dashboard
                </a>

                <a href="{{ route('superadmin.rental.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'rental' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/mobil.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'rental' ? $iconActive : $iconHover }}">
                    Manajemen Rental
                </a>

                <a href="{{ route('superadmin.kebijakan.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'kebijakan' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/task-01.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'kebijakan' ? $iconActive : $iconHover }}">
                    Kebijakan
                </a>

                <a href="{{ route('superadmin.review.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ $active == 'review' ? $activeClass : $hoverClass }}">

                    <img src="{{ asset('images/icons/star.svg') }}"
                         class="w-5 h-5 transition
                         {{ $active == 'review' ? $iconActive : $iconHover }}">
                    Moderasi Review
                </a>

            @endif

        </div>
    </div>

    <!-- BOTTOM -->
    <div class="p-5 border-t flex flex-col gap-2">

        @if($role == 'admin_rental')
        <a href="{{ route('admin.profil') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-lg
            {{ $active == 'profil' ? $activeClass : $hoverClass }}">

                <img src="{{ asset('images/icons/setting-01.svg') }}"
                    class="w-5 h-5 transition
                    {{ $active == 'profil' ? $iconActive : $iconHover }}">

                Setting
        </a>
        @endif

        <button
            type="button"
            class="openLogoutModal group flex items-center gap-3 px-4 py-3 rounded-lg w-full text-left text-red-700 hover:bg-red-50">
            <img src="{{ asset('images/icons/logout-04.svg') }}" class="w-5 h-5">
            Logout
        </button>

    </div>

</aside>

    <!-- MODAL KONFIRMASI LOGOUT -->
    <div
        id="logoutModal"
        class="fixed inset-0 z-[70] hidden items-center justify-center">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

            <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
                Apakah kamu yakin ingin keluar dari akun ini?
            </p>

            <div class="flex gap-4 mt-8">

                <!-- Ya -->
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf

                    <button
                        type="submit"
                        class="w-full bg-[#62B33B] hover:bg-green-600
                        text-white py-3 rounded-xl font-semibold">

                        Ya

                    </button>
                </form>

                <!-- Tidak -->
                <button
                    type="button"
                    id="closeLogoutModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600
                    text-white py-3 rounded-xl font-semibold">

                    Tidak

                </button>

            </div>

        </div>

    </div>

