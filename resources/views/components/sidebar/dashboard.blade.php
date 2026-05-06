@php
    $role = 'admin_rental'; // atau 'super_admin'
    $active = request()->segment(2);

    $activeClass = 'bg-[#E7E9F2] text-[#0B1F67] font-semibold';
    $hoverClass  = 'text-gray-600 hover:bg-[#E7E9F2] hover:text-[#0B1F67] hover:font-semibold';

    $iconActive = 'brightness-0 saturate-100 invert-[13%] sepia-[61%] saturate-[1400%] hue-rotate-[210deg] brightness-[95%] contrast-[95%]';
    $iconHover = 'group-hover:brightness-0 group-hover:saturate-100 group-hover:invert-[13%] group-hover:sepia-[61%] group-hover:saturate-[1400%] group-hover:hue-rotate-[210deg] group-hover:brightness-[95%] group-hover:contrast-[95%]';
@endphp

<aside id="sidebar"
       class="w-64 h-screen overflow-y-auto
              bg-white border-r flex flex-col justify-between text-sm
              fixed md:static
              transform -translate-x-full md:translate-x-0
              transition duration-300 z-40">

    <!-- TOP -->
    <div class="p-5">
        <div class="flex flex-col gap-1">

            <!-- DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center gap-3 px-4 py-3 rounded-lg
               {{ $active == 'dashboard' ? $activeClass : $hoverClass }}">

                <img src="{{ asset('images/icons/menu-square.svg') }}"
                     class="w-5 h-5 transition
                     {{ $active == 'dashboard' ? $iconActive : $iconHover }}">
                Dashboard
            </a>

            {{-- ADMIN RENTAL --}}
            @if($role == 'admin_rental')

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
                    Kebijakan Pembatalan
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
        <form action="/settings" method="POST">
            @csrf
            <button class="group flex items-center gap-3 px-4 py-3 rounded-lg w-full text-left
                           {{ $hoverClass }}">

                <img src="{{ asset('images/icons/setting-01.svg') }}"
                     class="w-5 h-5 transition {{ $iconHover }}">
                Setting
            </button>
        </form>
        @endif

        <form action="/logout" method="POST">
            @csrf
            <button class="group flex items-center gap-3 px-4 py-3 rounded-lg w-full text-left text-red-700 hover:bg-red-50">
                <img src="{{ asset('images/icons/logout-04.svg') }}" class="w-5 h-5">
                Logout
            </button>
        </form>

    </div>

</aside>