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

<body class="font-inter">

    {{-- Navbar --}}
    @include('components.header.customer')

    {{-- Konten halaman --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

   <script>
    document.addEventListener('DOMContentLoaded', function () {

        // MOBILE MENU
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        // MOBILE PROFILE DROPDOWN
        const mobileProfileBtn = document.getElementById('mobileProfileBtn');
        const mobileProfileMenu = document.getElementById('mobileProfileMenu');

        if(menuBtn && mobileMenu){

            menuBtn.addEventListener('click', () => {

                mobileMenu.classList.toggle('hidden');

            });

        }

        // TOGGLE PROFILE MOBILE
        if(mobileProfileBtn && mobileProfileMenu){

            mobileProfileBtn.addEventListener('click', () => {

                mobileProfileMenu.classList.toggle('hidden');

            });

        }

        // PROFILE DROPDOWN
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const profileOverlay = document.getElementById('profileOverlay');

        if(profileBtn){

            profileBtn.addEventListener('click', () => {

                profileDropdown.classList.toggle('hidden');
                profileOverlay.classList.toggle('hidden');

            });

        }

        if(profileOverlay){

            profileOverlay.addEventListener('click', () => {

                profileDropdown.classList.add('hidden');
                profileOverlay.classList.add('hidden');

            });

        }

        // EDIT PROFILE MODAL
        const editProfileBtn = document.getElementById('editProfileBtn');
        const editModal = document.getElementById('editModal');
        const closeEditModal = document.getElementById('closeEditModal');

        if(editProfileBtn){

            editProfileBtn.addEventListener('click', () => {

                profileDropdown.classList.add('hidden');
                profileOverlay.classList.add('hidden');

                editModal.classList.remove('hidden');
                editModal.classList.add('flex');

            });

        }

        if(closeEditModal){

            closeEditModal.addEventListener('click', () => {

                editModal.classList.add('hidden');
                editModal.classList.remove('flex');

            });

        }

        // CONFIRM MODAL
        const openConfirmModal = document.getElementById('openConfirmModal');
        const confirmModal = document.getElementById('confirmModal');
        const closeConfirmModal = document.getElementById('closeConfirmModal');

        if(openConfirmModal){

            openConfirmModal.addEventListener('click', () => {

                confirmModal.classList.remove('hidden');
                confirmModal.classList.add('flex');

            });

        }

        if(closeConfirmModal){

            closeConfirmModal.addEventListener('click', () => {

                confirmModal.classList.add('hidden');
                confirmModal.classList.remove('flex');

            });

        }

        // SUBMIT PROFILE
        const confirmEditBtn = document.getElementById('confirmEditBtn');
        const editProfileForm = document.getElementById('editProfileForm');
        const loadingModal = document.getElementById('loadingModal');

        if(confirmEditBtn){

            confirmEditBtn.addEventListener('click', () => {

                confirmModal.classList.add('hidden');
                confirmModal.classList.remove('flex');

                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');

                const progressCircle = document.getElementById('progressCircle');
                const progressText = document.getElementById('progressText');

                let progress = 0;

                const interval = setInterval(() => {

                    progress += 10;

                    const offset = 314 - (314 * progress / 100);

                    progressCircle.style.strokeDashoffset = offset;

                    progressText.innerText = progress + '%';

                    if(progress >= 100){

                        clearInterval(interval);

                        editProfileForm.submit();

                    }

                }, 300);

            });

        }

        // SUCCESS MODAL
        @if(session('success'))

            const successModal = document.getElementById('successModal');

            if(successModal){

                successModal.classList.remove('hidden');
                successModal.classList.add('flex');

                setTimeout(() => {

                    successModal.classList.add('hidden');
                    successModal.classList.remove('flex');

                }, 3500);

            }

        @endif

        // PASSWORD MODAL
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const editProfileBtnMobile = document.getElementById('editProfileBtnMobile');
        const changePasswordBtnMobile = document.getElementById('changePasswordBtnMobile');
        const passwordModal = document.getElementById('passwordModal');
        const closePasswordModal = document.getElementById('closePasswordModal');

        if(editProfileBtnMobile){
            editProfileBtnMobile.addEventListener('click', () => {

                mobileMenu.classList.add('hidden');

                editModal.classList.remove('hidden');
                editModal.classList.add('flex');

            });

        }

        if(changePasswordBtnMobile){
            changePasswordBtnMobile.addEventListener('click', () => {

                mobileMenu.classList.add('hidden');

                passwordModal.classList.remove('hidden');
                passwordModal.classList.add('flex');

            });

        }

        if(changePasswordBtn){
            changePasswordBtn.addEventListener('click', () => {

                profileDropdown.classList.add('hidden');
                profileOverlay.classList.add('hidden');

                passwordModal.classList.remove('hidden');
                passwordModal.classList.add('flex');

                // RESET INPUT
                passwordForm.reset();

                // BALIKIN TYPE PASSWORD
                document.getElementById('passwordLama').type = 'password';
                document.getElementById('passwordBaru').type = 'password';
                document.getElementById('konfirmasiPassword').type = 'password';

            });

        }

        if(closePasswordModal){

            closePasswordModal.addEventListener('click', () => {

                passwordModal.classList.add('hidden');
                passwordModal.classList.remove('flex');

                passwordForm.reset();
            });
        }

        // OPEN CONFIRM PASSWORD
        const openPasswordConfirmModal = document.getElementById('openPasswordConfirmModal');
        const passwordConfirmModal = document.getElementById('passwordConfirmModal');

        if(openPasswordConfirmModal){

            openPasswordConfirmModal.addEventListener('click', () => {

                passwordConfirmModal.classList.remove('hidden');
                passwordConfirmModal.classList.add('flex');

            });

        }

        // CLOSE CONFIRM PASSWORD
        const closePasswordConfirmModal = document.getElementById('closePasswordConfirmModal');

        if(closePasswordConfirmModal){

            closePasswordConfirmModal.addEventListener('click', () => {

                passwordConfirmModal.classList.add('hidden');
                passwordConfirmModal.classList.remove('flex');

            });
        }

        const confirmPasswordBtn = document.getElementById('confirmPasswordBtn');
        const passwordForm = document.getElementById('passwordForm');

        if(confirmPasswordBtn){

            confirmPasswordBtn.addEventListener('click', () => {

                passwordConfirmModal.classList.add('hidden');

                loadingModal.classList.remove('hidden');
                loadingModal.classList.add('flex');

                let progress = 0;

                const progressCircle = document.getElementById('progressCircle');
                const progressText = document.getElementById('progressText');

                const interval = setInterval(() => {

                    progress += 10;

                    const offset = 314 - (314 * progress / 100);

                    progressCircle.style.strokeDashoffset = offset;

                    progressText.innerText = progress + '%';

                    if(progress >= 100){

                        clearInterval(interval);

                        passwordForm.submit();

                    }

                }, 300);

            });
        }

        // PREVIEW FOTO PROFILE
        const fotoProfilInput = document.getElementById('fotoProfilInput');

        if(fotoProfilInput){

            fotoProfilInput.addEventListener('change', function(e){

                const file = e.target.files[0];

                if(file){

                    const reader = new FileReader();

                    reader.onload = function(event){

                        let previewFoto = document.getElementById('previewFoto');
                        if(!previewFoto){

                            const previewDefault = document.getElementById('previewDefault');

                            previewDefault.outerHTML = `
                                <img
                                    id="previewFoto"
                                    src="${event.target.result}"
                                    class="w-28 h-28 rounded-full object-cover"
                                >
                            `;

                        } else {

                            previewFoto.src = event.target.result;

                        }

                    }

                    reader.readAsDataURL(file);

                }

            });

        }

        @if($errors->any())

            const passwordModalError = document.getElementById('passwordModal');

            if(passwordModalError){

                passwordModalError.classList.remove('hidden');
                passwordModalError.classList.add('flex');

            }

        @endif

    @if(session('success_password'))
        const successPasswordModal = document.getElementById('successPasswordModal');

        if(successPasswordModal){

            successPasswordModal.classList.remove('hidden');
            successPasswordModal.classList.add('flex');

            setTimeout(() => {

                successPasswordModal.classList.add('hidden');
                successPasswordModal.classList.remove('flex');

            }, 3500);

        }
    @endif

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

</script>

</body>
</html>