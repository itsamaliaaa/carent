document.addEventListener('DOMContentLoaded', () => {

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function jalankanLoading(formId, feedbackId) {
        showModal('loadingModal');

        const lingkaran = document.getElementById('progressCircle');
        const teks = document.getElementById('progressText');

        // Reset setiap kali loading dibuka
        lingkaran.style.strokeDashoffset = 314;
        teks.innerText = '0%';

        let progress = 0;

        const interval = setInterval(() => {
            progress += 10;
            lingkaran.style.strokeDashoffset = 314 - (314 * progress / 100);
            teks.innerText = progress + '%';

            if (progress >= 100) {
                clearInterval(interval);
                hideModal('loadingModal');

                if (feedbackId) {
                    showModal(feedbackId);
                    setTimeout(() => {
                        hideModal(feedbackId);
                        document.getElementById(formId)?.submit();
                    }, 2000);
                } else {
                    document.getElementById(formId)?.submit();
                }
            }
        }, 200);
    }

    // BUKA CONFIRM MODAL — isi data-submit dari data-target-submit
    document.querySelectorAll('[data-confirm]').forEach(button => {
    button.addEventListener('click', () => {
        const modalId = button.dataset.confirm;
        const targetSubmit = button.dataset.targetSubmit;
        const targetFeedback = button.dataset.feedback;

        const modal = document.getElementById(modalId);
        const submitBtn = modal?.querySelector('[data-submit]');

        if (submitBtn) {
            if (targetSubmit) submitBtn.dataset.submit = targetSubmit;
            if (targetFeedback) submitBtn.dataset.feedback = targetFeedback;
            
            // Simpan alpine element jika ada
            const alpineEl = button.closest('[x-data]');
            if (alpineEl) {
                submitBtn.dataset.alpineClose = 'true';
                submitBtn._alpineEl = alpineEl;
            }
        }

        showModal(modalId);
    });
});

    // TUTUP MODAL
    document.querySelectorAll('[data-close]').forEach(button => {
        button.addEventListener('click', () => hideModal(button.dataset.close));
    });

    // KONFIRMASI → LOADING → FEEDBACK → SUBMIT
    document.querySelectorAll('[data-submit]').forEach(button => {
    button.addEventListener('click', () => {
        const confirmModalId = button.closest('[id]').id;
        hideModal(confirmModalId);

        // Close Alpine modal saat Ya dipencet
        if (button._alpineEl) {
            const alpineData = Alpine.$data(button._alpineEl);
            if (alpineData.openEdit !== undefined) alpineData.openEdit = false;
            if (alpineData.popUpTambah !== undefined) alpineData.popUpTambah = false;
        }

        const formId = button.dataset.submit;
        const feedbackId = button.dataset.feedback;

        if (!formId) {
            console.warn('form ID kosong!');
            return;
        }

        jalankanLoading(formId, feedbackId);
    });
});
});