document.addEventListener('DOMContentLoaded', () => {

    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const changePasswordBtnMobile = document.getElementById('changePasswordBtnMobile');

    const passwordModal = document.getElementById('passwordModal');
    const closePasswordModal = document.getElementById('closePasswordModal');

    const profileDropdown = document.getElementById('profileDropdown');
    const profileOverlay = document.getElementById('profileOverlay');
    const mobileMenu = document.getElementById('mobileMenu');

    // BUKA MODAL UBAH PASSWORD
    if (changePasswordBtn) {

        changePasswordBtn.addEventListener('click', () => {

            profileDropdown?.classList.add('hidden');
            profileOverlay?.classList.add('hidden');

            passwordModal.classList.remove('hidden');
            passwordModal.classList.add('flex');

        });

    }

    if (changePasswordBtnMobile) {

        changePasswordBtnMobile.addEventListener('click', () => {

            mobileMenu?.classList.add('hidden');

            passwordModal.classList.remove('hidden');
            passwordModal.classList.add('flex');

        });

    }

    // TUTUP MODAL PASSWORD
    if (closePasswordModal) {

        closePasswordModal.addEventListener('click', () => {

            passwordModal.classList.add('hidden');
            passwordModal.classList.remove('flex');

        });

    }

    // MODAL KONFIRMASI PASSWORD
    const openPasswordConfirmModal = document.getElementById('openPasswordConfirmModal');
    const passwordConfirmModal = document.getElementById('passwordConfirmModal');
    const closePasswordConfirmModal = document.getElementById('closePasswordConfirmModal');

    if (openPasswordConfirmModal && passwordConfirmModal) {

        openPasswordConfirmModal.addEventListener('click', () => {

            passwordConfirmModal.classList.remove('hidden');
            passwordConfirmModal.classList.add('flex');

        });

    }

    if (closePasswordConfirmModal && passwordConfirmModal) {

        closePasswordConfirmModal.addEventListener('click', () => {

            passwordConfirmModal.classList.add('hidden');
            passwordConfirmModal.classList.remove('flex');

        });

    }

});