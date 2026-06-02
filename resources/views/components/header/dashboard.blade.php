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
            {{ (auth()->user()->nama_lengkap) }}
        </span>

        @auth
            <div class="relative">

                <!-- BUTTON PROFILE -->
                <button id="profileBtn"
                    class="w-10 h-10 rounded-full overflow-hidden
                            bg-gradient-to-r from-blue-400 to-indigo-500
                            flex items-center justify-center text-white font-semibold">

                    @if(auth()->user()->foto_profile)

                        <img
                            src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                            class="w-full h-full object-cover">

                    @else

                        {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}

                    @endif

                </button>

                <!-- OVERLAY -->
                <div id="profileOverlay"
                    class="fixed inset-0 bg-black/30 z-40 hidden">
                </div>

                <!-- DROPDOWN -->
                <div id="profileDropdown"
                    class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border z-50 overflow-hidden hidden">

                    <!-- TOP PROFILE -->
                    <div class="flex items-center gap-4 p-5">

                        <div class="w-14 h-14 min-w-[56px] min-h-[56px] rounded-full overflow-hidden
                                    bg-gradient-to-r from-blue-400 to-indigo-500
                                    flex items-center justify-center text-white text-xl font-semibold">

                            @if(auth()->user()->foto_profile)

                                <img
                                    src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                                    class="w-full h-full object-cover">

                            @else

                                {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}

                            @endif

                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900">
                                {{ auth()->user()->nama_lengkap }}
                            </h3>

                            <p class="text-xs text-gray-500">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                    </div>

                    <div class="border-t"></div>

                    <!-- MENU -->
                    <div class="py-2">

                        <button id="editProfileBtn"
                            class="group w-full flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition text-left">

                            <img src="{{ asset('images/icons/user.svg') }}" class="w-5 h-5">

                            <span class="text-gray-700 group-hover:text-[#0B1F67] group-hover:font-medium transition">
                                Edit Profile
                            </span>

                        </button>

                        <button
                            id="changePasswordBtn"
                            class="group w-full flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition text-left">

                            <img src="{{ asset('images/icons/security-lock.svg') }}" class="w-5 h-5">

                            <span class="text-gray-700 group-hover:text-[#0B1F67] group-hover:font-medium transition">
                                Ubah Password
                            </span>

                        </button>

                        <button
                            type="button"
                            id="openLogoutModal"
                            class="group w-full flex items-center gap-3 px-5 py-4 hover:bg-red-50 transition text-left">

                            <img src="{{ asset('images/icons/logout-04.svg') }}" class="w-5 h-5">

                            <span class="text-red-500 group-hover:text-red-700 group-hover:font-medium transition">
                                Keluar
                            </span>

                        </button>

                    </div>

                </div>

            </div>
            @endauth

    </div>

    @auth
    <!-- MODAL EDIT PROFILE -->
    <div id="editModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <!-- Modal -->
        <div class="relative bg-white rounded-3xl w-full max-w-md p-8 z-10">

            <!-- Close -->
            <button
                id="closeEditModal"
                class="absolute top-5 right-5 text-2xl text-gray-500">
                ×
            </button>

            <!-- Avatar -->
            <div class="flex flex-col items-center">
                
            <div class="relative"> 

                <!-- FOTO -->
                @if(auth()->user()->foto_profile)

                    <img
                        id="previewFoto"
                        src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                        class="w-28 h-28 rounded-full object-cover">

                @else

                    <div
                        id="previewDefault"
                        class="w-28 h-28 rounded-full overflow-hidden
                        bg-gradient-to-r from-blue-400 to-indigo-500
                        flex items-center justify-center
                        text-white text-5xl font-semibold">

                        {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}

                    </div>

                @endif

                <!-- BUTTON EDIT -->
                <button
                    type="button"
                    onclick="document.getElementById('fotoProfilInput').click()"
                    class="absolute bottom-1 right-1
                    bg-[#0B1F67] text-white
                    w-8 h-8 rounded-full flex items-center justify-center">

                    ✎

                </button>

            </div>

                <h2 class="mt-5 text-2xl font-bold text-[#0B1F67]">
                    Profile Kamu
                </h2>

            </div>

            <!-- FORM -->
            <form
                id="editProfileForm"
                action="{{ route('superadmin.profil.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="mt-8 space-y-5">

                @csrf
                @method('PUT')

                <!-- INPUT FILE -->
                <input
                    type="file"
                    name="foto_profile"
                    id="fotoProfilInput"
                    accept="image/*"
                    class="hidden">

                <div>
                    <label class="text-sm text-gray-600">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ auth()->user()->nama_lengkap }}"
                        class="w-full border rounded-xl px-4 py-3 mt-1">
                </div>

                <div>
                    <label class="text-sm text-gray-600">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ auth()->user()->email }}"
                        class="w-full border rounded-xl px-4 py-3 mt-1">
                </div>

                <div>
                    <label class="text-sm text-gray-600">
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        name="no_telepon"
                        value="{{ auth()->user()->no_telp }}"
                        class="w-full border rounded-xl px-4 py-3 mt-1">
                </div>

                <!-- BUTTON -->
                <button
                    type="button"
                    id="openConfirmModal"
                    class="w-full bg-[#0B1F67] hover:bg-[#08184f]
                    text-white font-semibold py-3 rounded-xl transition">

                    Edit Profile

                </button>

            </form>

        </div>
    </div>

    <!-- MODAL KONFIRMASI -->
    <div
        id="confirmModal"
        class="fixed inset-0 z-[70] hidden items-center justify-center">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

            <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
                Apakah kamu yakin ingin mengedit profile ini?
            </p>

            <div class="flex gap-4 mt-8">

                <!-- Ya -->
                <button
                    type="button"
                    id="confirmEditBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600
                    text-white py-3 rounded-xl font-semibold">

                    Ya

                </button>

                <!-- Tidak -->
                <button
                    type="button"
                    id="closeConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600
                    text-white py-3 rounded-xl font-semibold">

                    Tidak

                </button>

            </div>

        </div>
    </div>

    <!-- LOADING -->
    <div
        id="loadingModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80]
        hidden items-center justify-center">

        <div class="relative w-32 h-32">

            <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">

                <!-- Background -->
                <circle
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#E5E7EB"
                    stroke-width="10"
                />

                <!-- Progress -->
                <circle
                    id="progressCircle"
                    cx="60"
                    cy="60"
                    r="50"
                    fill="none"
                    stroke="#0B1F67"
                    stroke-width="10"
                    stroke-linecap="round"
                    stroke-dasharray="314"
                    stroke-dashoffset="314"
                    style="transition: stroke-dashoffset 0.3s ease"
                />

            </svg>

            <div class="absolute inset-0 flex items-center justify-center">

                <span
                    id="progressText"
                    class="text-2xl font-bold text-[#0B1F67]">

                    0%

                </span>

            </div>

        </div>

    </div>

    <!-- SUCCESS MODAL -->
    <div
        id="successModal"
        class="fixed inset-0 z-[90] hidden items-center justify-center">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">

            <div class="flex justify-center">

                <div class="w-24 h-24 flex items-center justify-center">

                    <img
                        src="{{ asset('images/icons/check-circle.svg') }}"
                        alt="Success">

                </div>

            </div>

            <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">
                Profile berhasil diperbarui
            </h2>

        </div>

    </div>

    <!-- MODAL UBAH PASSWORD -->
    <div
        id="passwordModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center"
    >

        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <div class="relative bg-white rounded-3xl w-full max-w-md p-8 z-10">

            <!-- CLOSE -->
            <button
                id="closePasswordModal"
                class="absolute top-5 right-5 text-2xl text-gray-500"
            >
                ×
            </button>

            <h2 class="text-2xl font-bold text-center text-[#0B1F67]">
                Ubah Password
            </h2>

            <form
                id="passwordForm"
                action="{{ route('superadmin.profil.password') }}"
                method="POST"
                class="mt-10 space-y-5"
            >

                @csrf
                @method('PUT')

                <!-- PASSWORD LAMA -->
                <div>

                    <label class="text-sm text-gray-600">
                        Password lama
                    </label>

                    <div class="relative mt-1">

                        <input
                            type="password"
                            name="password_lama"
                            id="passwordLama"
                            placeholder="Masukkan password lama"
                            class="w-full border rounded-xl px-4 py-3 pr-12"
                            autocomplete="new-password"
                            value=""
                            >

                        <button
                            type="button"
                            onclick="togglePassword('passwordLama', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2">

                            <img
                                src="{{ asset('images/icons/eye.svg') }}"
                                class="w-5 h-5 eyeIcon">

                        </button>
                    </div>
                    @error('password_lama')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- PASSWORD BARU -->
                <div>

                    <label class="text-sm text-gray-600">
                        Password baru
                    </label>

                    <div class="relative mt-1">

                        <input
                            type="password"
                            name="password_baru"
                            id="passwordBaru"
                            placeholder="Masukkan password baru"
                            class="w-full border rounded-xl px-4 py-3 pr-12"
                            autocomplete="new-password">

                        <button
                            type="button"
                            onclick="togglePassword('passwordBaru', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2">

                            <img
                                src="{{ asset('images/icons/eye.svg') }}"
                                class="w-5 h-5 eyeIcon">
                        </button>
                        @error('password_baru')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <!-- KONFIRMASI -->
                <div>

                    <label class="text-sm text-gray-600">
                        Konfirmasi password baru
                    </label>

                    <div class="relative mt-1">

                        <input
                            type="password"
                            name="password_baru_confirmation"
                            id="konfirmasiPassword"
                            placeholder="Masukkan password baru"
                            class="w-full border rounded-xl px-4 py-3 pr-12"
                            autocomplete="new-password">

                        <button
                            type="button"
                            onclick="togglePassword('konfirmasiPassword', this)"
                            class="absolute right-4 top-1/2 -translate-y-1/2">

                            <img
                                src="{{ asset('images/icons/eye.svg') }}"
                                class="w-5 h-5 eyeIcon">

                        </button>
                    </div>
                    @error('password_baru_confirmation')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror


                </div>

                @if(session('error_password'))

                <p class="text-red-500 text-sm">
                    {{ session('error_password') }}
                </p>

                @endif

                <button
                    type="button"
                    id="openPasswordConfirmModal"
                    class="w-full bg-[#0B1F67] hover:bg-[#08184f]
                    text-white font-semibold py-3 rounded-xl transition"
                >

                    Ubah

                </button>

            </form>

        </div>

    </div>

    <!-- CONFIRM PASSWORD -->
    <div
        id="passwordConfirmModal"
        class="fixed inset-0 z-[70] hidden items-center justify-center"
    >

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

            <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
                Apakah kamu yakin ingin mengubah password?
            </p>

            <div class="flex gap-4 mt-8">

                <button
                    type="button"
                    id="confirmPasswordBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600
                    text-white py-3 rounded-xl font-semibold"
                >
                    Ya
                </button>

                <button
                    type="button"
                    id="closePasswordConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600
                    text-white py-3 rounded-xl font-semibold"
                >
                    Tidak
                </button>

            </div>

        </div>

    </div>

    <!-- SUCCESS PASSWORD -->
    <div
        id="successPasswordModal"
        class="fixed inset-0 z-[90] hidden items-center justify-center"
    >

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">

            <div class="flex justify-center">

                <img
                    src="{{ asset('images/icons/check-circle.svg') }}"
                    class="w-24 h-24"
                >

            </div>

            <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">
                Password berhasil diperbarui
            </h2>

        </div>

    </div>

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


    @endauth
</nav>