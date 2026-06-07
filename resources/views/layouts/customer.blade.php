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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="font-inter flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('components.header.customer')

    {{-- Konten halaman --}}
    <main class="flex-grow">
        @yield('content')
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
