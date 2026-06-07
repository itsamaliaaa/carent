<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Carent</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-title.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/search-loading.js'])
</head>
<body class="font-inter flex flex-col min-h-screen">

    @include('components.header.customer')

    <main class="flex-grow">
    <div class="min-h-screen flex flex-col">
        <div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24 w-full flex-grow">

            {{-- Kembali --}}
            <a href="javascript:history.back()"
               class="inline-flex items-center text-sm gap-2 text-[var(--primary)] font-semibold mb-4 hover:underline">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round"><path d="M15 19L8 12L15 5"/></svg>
                Kembali
            </a>

            <div class="pt-4 border-t border-gray-400">
            {{-- Judul --}}
            <h1 class="text-2xl font-bold text-[var(--text-heading)] mb-8">Rating & Ulasan</h1>

            {{-- Card Mobil + Rating --}}
            <div class="bg-gray-100 rounded-xl p-6 border border-[var(--border-light)] mb-10">

                {{-- Info Mobil --}}
                <div class="flex items-center gap-6 mb-6 pb-6 border-b border-gray-200">
                    <div class="p-0">
                        @php $primaryImg = $mobil->fotoPrimary; @endphp
                        @if($primaryImg)
                            <img src="{{ asset('storage/' . $primaryImg->url_foto) }}"
                                alt="{{ $mobil->nama_mobil }}"
                                class="w-28 h-auto rounded-md object-cover">
                        @else
                            <img src="https://via.placeholder.com/150x100?text=No+Image"
                                alt="{{ $mobil->nama_mobil }}"
                                class="w-28 h-auto rounded-md object-cover">
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $mobil->nama_mobil }} {{ $mobil->tahun }}</h2>
                        <p class="text-xl font-bold text-[var(--primary)] mt-1">
                            Rp. {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}
                            <span class="text-gray-500 font-medium text-lg">/hari</span>
                        </p>
                    </div>
                </div>

                {{-- Rating Summary --}}
                <div class="flex items-center gap-10">

                    {{-- Angka & Bintang --}}
                    <div class="text-center flex-shrink-0 w-40">
                        <span class="text-[72px] font-bold leading-none">{{ number_format($averageRating, 1) }}</span>
                        <div class="flex items-center justify-center gap-1 my-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="22" height="22" viewBox="0 0 24 24"
                                     fill="{{ $i <= round($averageRating) ? '#F59E0B' : '#E5E7EB' }}">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500 font-medium">({{ $totalReviews }} Rating & Ulasan)</span>
                    </div>

                    {{-- Bar Grid: 3 kolom --}}
                    <div class="flex-1 grid grid-cols-3 gap-x-6 gap-y-3">
                        @php
                            $starOrder = [5, 3, 1, 4, 2]; 
                        @endphp
                        @foreach($starOrder as $star)
                        <div class="flex items-center gap-2 text-sm font-semibold">
                            <span class="w-5 text-right text-gray-700">{{ $star }}★</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-[var(--primary)] h-2.5 rounded-full"
                                     style="width: {{ $ratingPercentages[$star] }}%"></div>
                            </div>
                            <span class="w-8 text-gray-500">({{ $ratingCounts[$star] }})</span>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- Daftar Review --}}
            <div class="space-y-6">
                @forelse($reviews as $review)

                <div class="bg-white border border-gray-200 rounded-xl p-6">

                    {{-- Header: Avatar + Nama + Bintang --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0 overflow-hidden"
                                 style="background-color: black">
                                @if($review->user->foto_profile)
                                    <img src="{{ asset('storage/' . $review->user->foto_profile) }}"
                                         class="w-full h-full object-cover" alt="Avatar">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-gray-900">{{ $review->user->email }}</h4>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $review->tanggal_posting->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="18" height="18" viewBox="0 0 24 24"
                                     fill="{{ $i <= $review->rating ? '#F59E0B' : '#E5E7EB' }}">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <hr class="border-gray-100 mb-4">

                    {{-- Komentar --}}
                    <p class="text-sm text-gray-700 leading-relaxed mb-4">{{ $review->komentar }}</p>

                    {{-- Foto Review --}}
                    @if($review->foto_review)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $review->foto_review) }}"
                             alt="Foto Ulasan"
                             class="w-24 h-20 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition">
                    </div>
                    @endif

                    {{-- Balasan Admin --}}
                    @if($review->reply)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 font-medium mb-1">Balasan Admin:</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $review->reply->komentar }}</p>
                    </div>
                    @endif

                </div>

                @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-medium">Belum ada ulasan untuk mobil ini.</p>
                </div>
                @endforelse
            </div>

            {{-- Tampilkan Lebih Banyak --}}
            @if($totalReviews > 0)
            <div class="mt-12 text-right">
                <button class="carent-btn-secondary !text-white bg-[var(--primary)] border-[var(--primary)]">
                    Tampilkan Lebih Banyak
                </button>
            </div>
            @endif

        </div>
    </div>
    </main>

    @include('components.footer')
</body>
</html>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // SUCCESS MODAL (EDIT PROFILE)
        @if(session('success'))

            const successModal = document.getElementById('successModal');

            if (successModal) {

                successModal.classList.remove('hidden');
                successModal.classList.add('flex');

                setTimeout(() => {

                    successModal.classList.add('hidden');
                    successModal.classList.remove('flex');

                }, 3500);

            }

        @endif


        // SUCCESS MODAL (CHANGE PASSWORD)
        @if(session('success_password'))

            const successPasswordModal = document.getElementById('successPasswordModal');

            if (successPasswordModal) {

                successPasswordModal.classList.remove('hidden');
                successPasswordModal.classList.add('flex');

                setTimeout(() => {

                    successPasswordModal.classList.add('hidden');
                    successPasswordModal.classList.remove('flex');

                }, 3500);

            }

        @endif


        // OPEN PASSWORD MODAL IF VALIDATION ERROR
        @if($errors->password->any())

            const passwordModal = document.getElementById('passwordModal');

            if (passwordModal) {

                passwordModal.classList.remove('hidden');
                passwordModal.classList.add('flex');

            }

        @endif


        // MOBILE MENU
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (menuBtn && mobileMenu) {

            menuBtn.addEventListener('click', () => {

                mobileMenu.classList.toggle('hidden');

            });

        }


        // MOBILE PROFILE DROPDOWN
        const mobileProfileBtn = document.getElementById('mobileProfileBtn');
        const mobileProfileMenu = document.getElementById('mobileProfileMenu');

        if (mobileProfileBtn && mobileProfileMenu) {

            mobileProfileBtn.addEventListener('click', () => {

                mobileProfileMenu.classList.toggle('hidden');

            });

        }


        // EDIT PROFILE CONFIRMATION
        const confirmEditBtn = document.getElementById('confirmEditBtn');
        const editProfileForm = document.getElementById('editProfileForm');
        const loadingModal = document.getElementById('loadingModal');

        if (confirmEditBtn && editProfileForm && loadingModal) {

            confirmEditBtn.addEventListener('click', () => {

                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');

                const progressCircle = document.getElementById('progressCircle');
                const progressText = document.getElementById('progressText');

                let progress = 0;

                const interval = setInterval(() => {

                    progress += 10;

                    const offset = 314 - (314 * progress / 100);

                    if (progressCircle) {
                        progressCircle.style.strokeDashoffset = offset;
                    }

                    if (progressText) {
                        progressText.innerText = progress + '%';
                    }

                    if (progress >= 100) {

                        clearInterval(interval);
                        editProfileForm.submit();

                    }

                }, 300);

            });

        }


        // CHANGE PASSWORD CONFIRMATION
        const confirmPasswordBtn = document.getElementById('confirmPasswordBtn');
        const passwordForm = document.getElementById('passwordForm');
        const passwordConfirmModal = document.getElementById('passwordConfirmModal');

        if (
            confirmPasswordBtn &&
            passwordForm &&
            loadingModal &&
            passwordConfirmModal
        ) {

            confirmPasswordBtn.addEventListener('click', () => {

                passwordConfirmModal.classList.add('hidden');
                passwordConfirmModal.classList.remove('flex');

                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');

                const progressCircle = document.getElementById('progressCircle');
                const progressText = document.getElementById('progressText');

                let progress = 0;

                const interval = setInterval(() => {

                    progress += 10;

                    const offset = 314 - (314 * progress / 100);

                    if (progressCircle) {
                        progressCircle.style.strokeDashoffset = offset;
                    }

                    if (progressText) {
                        progressText.innerText = progress + '%';
                    }

                    if (progress >= 100) {

                        clearInterval(interval);
                        passwordForm.submit();

                    }

                }, 300);

            });

        }


        // OPEN CONFIRM MODAL
        const openConfirmModal = document.getElementById('openConfirmModal');
        const confirmModal = document.getElementById('confirmModal');

        if (openConfirmModal && confirmModal) {

            openConfirmModal.addEventListener('click', () => {

                confirmModal.classList.remove('hidden');
                confirmModal.classList.add('flex');

            });

        }


        // CLOSE CONFIRM MODAL
        const closeConfirmModal = document.getElementById('closeConfirmModal');

        if (closeConfirmModal && confirmModal) {

            closeConfirmModal.addEventListener('click', () => {

                confirmModal.classList.add('hidden');
                confirmModal.classList.remove('flex');

            });

        }
    });

        // TOGGLE PASSWORD
        function togglePassword(id, button){
            const input = document.getElementById(id);
            const icon = button.querySelector('.eyeIcon');

            if(input.type === 'password'){
                input.type = 'text';
                icon.src = "{{ asset('images/icons/eye-off.svg') }}";

            } else {
                input.type = 'password';
                icon.src = "{{ asset('images/icons/eye.svg') }}";
            }

        }

        // LOGOUT MODAL

        const openLogoutModal = document.getElementById('openLogoutModal');
        const closeLogoutModal = document.getElementById('closeLogoutModal');
        const logoutModal = document.getElementById('logoutModal');

        if (openLogoutModal && logoutModal) {

            openLogoutModal.addEventListener('click', () => {

                logoutModal.classList.remove('hidden');
                logoutModal.classList.add('flex');

            });

        }

        if (closeLogoutModal && logoutModal) {

            closeLogoutModal.addEventListener('click', () => {

                logoutModal.classList.add('hidden');
                logoutModal.classList.remove('flex');

            });

        }
    </script>
</body>
</html>
