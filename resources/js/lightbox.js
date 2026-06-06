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

    function jalankanLoading(formId) {
        showModal('loadingModal');

        const lingkaran = document.getElementById('progressCircle');
        const teks = document.getElementById('progressText');
        let progress = 0;

        const interval = setInterval(() => {
            progress += 10;
            lingkaran.style.strokeDashoffset = 314 - (314 * progress / 100);
            teks.innerText = progress + '%';

            if (progress >= 100) {
                clearInterval(interval);
                document.getElementById(formId).submit();
            }
        }, 200);
    }

    // BUKA CONFIRM MODAL
    document.querySelectorAll('[data-confirm]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.dataset.confirm;
            const targetSubmit = button.dataset.targetSubmit;
            const targetFeedback = button.dataset.feedback;

            if (targetSubmit) {
                const modal = document.getElementById(modalId);
                const submitBtn = modal?.querySelector('[data-submit]');
                if (submitBtn) {
                    submitBtn.dataset.submit = targetSubmit;
                    if (targetFeedback) submitBtn.dataset.feedback = targetFeedback;
                }
            }

            showModal(modalId);
        });
    });

    // TUTUP MODAL
    document.querySelectorAll('[data-close]').forEach(button => {
        button.addEventListener('click', () => hideModal(button.dataset.close));
    });

    // KONFIRMASI → LOADING → SUBMIT FORM → FEEDBACK
    document.querySelectorAll('[data-submit]').forEach(button => {
        button.addEventListener('click', () => {
            const confirmModalId = button.closest('[id]').id;
            hideModal(confirmModalId);

            const formId = button.dataset.submit;
            const feedbackId = button.dataset.feedback;

            jalankanLoading(formId);

            if (feedbackId) {
                setTimeout(() => showModal(feedbackId), 3500);
                setTimeout(() => hideModal(feedbackId), 6000);
            }
        });
    });

});