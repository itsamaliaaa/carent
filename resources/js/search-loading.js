document.addEventListener('DOMContentLoaded', function () {

    const form    = document.getElementById('searchForm');
    const overlay = document.getElementById('loadingOverlay');
    const circle  = document.getElementById('progressCircle');
    const text    = document.getElementById('progressText');
    const total   = 314;

    if (!form) return;

    form.addEventListener('submit', function () {

        // Langsung muncul begitu tombol Cek diklik
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        let persen = 0;

        const interval = setInterval(() => {
            persen += Math.floor(Math.random() * 10) + 5;

            if (persen >= 95) {
                persen = 95;
                clearInterval(interval);
            }

            const offset = total - (total * persen / 100);
            circle.style.strokeDashoffset = offset;
            text.textContent = persen + '%';

        }, 200);
    });
});