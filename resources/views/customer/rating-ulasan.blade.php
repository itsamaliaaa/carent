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

    {{-- Navbar --}}
    @include('components.header.customer')

    {{-- Konten halaman --}}
    <main class="flex-grow">
    <div class="min-h-screen flex flex-col">
        <div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-8 pt-6 pb-24 w-full flex-grow">

            <a href="javascript:history.back()" class="inline-flex items-center text-sm gap-2 text-[var(--primary)] font-semibold mb-8 hover:underline">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19L8 12L15 5"/></svg>
                Kembali
            </a>

            <div class="block items-start gap-12 mb-12 pb-12">
                <div class="w-[300px]">
                    <h1 class="text-3xl font-bold text-[var(--text-heading)]">Rating & Ulasan</h1>
                </div>

                <div class="flex-1 bg-gray-100 rounded-xl p-8 border border-[var(--border-light)] mt-8">
                    <div class="flex items-center gap-10 mb-8 pb-8 border-b border-[var(--border-light)]">
                        <div class="p-2 border border-dashed border-gray-300 rounded-lg bg-white">
                            {{-- Check if car has a primary image, otherwise show placeholder --}}
                            @php
                                $primaryImg = $mobil->fotoMobil?->first();
                            @endphp
                            @if($primaryImg)
                                <img src="{{ asset('storage/' . $primaryImg->url_foto) }}" alt="{{ $mobil->nama_mobil }}" class="w-28 h-auto rounded-md object-cover">
                            @else
                                <img src="https://via.placeholder.com/150x100?text=No+Image" alt="{{ $mobil->nama_mobil }}" class="w-28 h-auto rounded-md object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold">{{ $mobil->nama_mobil }} {{ $mobil->tahun }}</h2>
                            <p class="text-xl font-bold text-[var(--primary)] mt-1">Rp. {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}<span class="text-gray-500 font-medium text-lg">/hari</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 items-center">
                        <div class="text-center">
                            <span class="text-[80px] font-bold leading-none">{{ number_format($averageRating, 1) }}</span>
                            <div class="flex items-center justify-center gap-1.5 my-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= round($averageRating) ? 'var(--star-gold)' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-[var(--text-body)] font-medium">({{ $totalReviews }} Rating & Ulasan)</span>
                        </div>
                        <div class="space-y-2.5">
                            @for($star = 5; $star >= 1; $star--)
                            <div class="flex items-center gap-4 text-sm font-semibold {{ $ratingCounts[$star] == 0 ? 'text-gray-400' : '' }}">
                                <span class="w-6 text-right">{{ $star }}</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-[var(--primary)] h-3 rounded-full {{ $ratingPercentages[$star] < 100 && $ratingPercentages[$star] > 0 ? 'opacity-70' : '' }}" style="width: {{ $ratingPercentages[$star] }}%"></div>
                                </div>
                                <span class="w-6 text-left">{{ $ratingCounts[$star] }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-12 border-gray-600">
                @forelse($reviews as $review)
                <div class="flex gap-10 border-gray-600 border-b border-[var(--border-light)] pb-12 last:border-0 last:pb-0">

                    <div class="relative w-16 h-16 rounded-full flex items-center justify-center font-bold text-white text-lg bg-gray-300 overflow-hidden">
                        @if($review->user->foto_profile)
                            <img src="{{ asset('storage/' . $review->user->foto_profile) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($review->user->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>

                    <div class="flex-1 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-lg">{{ $review->user->nama_lengkap }}</h4>
                                <p class="text-sm text-[var(--text-body)] mt-0.5">{{ $review->tanggal_posting->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'var(--star-gold)' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="text-[var(--text-body)] leading-relaxed">
                            {{ $review->komentar }}
                        </p>

                        {{-- Balasan Section (From reply_review table) --}}
                        @if($review->reply)
                        <div class="bg-gray-100 rounded-lg p-6 border border-gray-200">
                            <h5 class="font-semibold text-[var(--primary)] mb-1">Balasan Admin:</h5>
                            <p class="text-sm text-[var(--text-body)] leading-relaxed">
                                {{ $review->reply->komentar }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500 font-medium">Belum ada ulasan untuk mobil ini.</p>
                    </div>
                @endforelse
            </div>

            @if($totalReviews > 0)
            <div class="mt-16 text-right">
                <button class="carent-btn-secondary !text-white bg-[var(--primary)] border-[var(--primary)]">
                    Tampilkan Lebih Banyak
                </button>
            </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    @include('components.footer')

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
