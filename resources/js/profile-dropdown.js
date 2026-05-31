document.addEventListener('DOMContentLoaded', () => {

    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileOverlay = document.getElementById('profileOverlay');

    if (profileBtn) {

        profileBtn.addEventListener('click', () => {

            profileDropdown.classList.toggle('hidden');
            profileOverlay.classList.toggle('hidden');

        });

    }

    if (profileOverlay) {

        profileOverlay.addEventListener('click', () => {

            profileDropdown.classList.add('hidden');
            profileOverlay.classList.add('hidden');

        });

    }

});