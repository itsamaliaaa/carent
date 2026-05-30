document.addEventListener('DOMContentLoaded', () => {

    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileBtnMobile = document.getElementById('editProfileBtnMobile');

    const editModal = document.getElementById('editModal');
    const closeEditModal = document.getElementById('closeEditModal');

    const profileDropdown = document.getElementById('profileDropdown');
    const profileOverlay = document.getElementById('profileOverlay');
    const mobileMenu = document.getElementById('mobileMenu');

    if (editProfileBtn) {

        editProfileBtn.addEventListener('click', () => {

            profileDropdown?.classList.add('hidden');
            profileOverlay?.classList.add('hidden');

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');

        });

    }

    if (editProfileBtnMobile) {

        editProfileBtnMobile.addEventListener('click', () => {

            mobileMenu?.classList.add('hidden');

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');

        });

    }

    if (closeEditModal) {

        closeEditModal.addEventListener('click', () => {

            editModal.classList.add('hidden');
            editModal.classList.remove('flex');

        });

    }

});