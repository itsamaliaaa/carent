<div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4 backdrop-blur-sm transition-opacity duration-300">

    <div class="relative w-full max-w-[500px] rounded-[20px] border border-gray-200 bg-white px-8 py-9 shadow-2xl text-center animate-fade-in-up">

        <button type="button" onclick="closeReviewModal()" class="absolute top-4 right-5 border-none bg-none text-3xl font-light text-gray-400 hover:text-gray-700 transition-colors">&times;</button>

        <h2 class="mb-6 text-3xl font-bold text-[#0A2269]">Perjalanan selesai!</h2>

        <form action="{{ route('review.store', $booking_id ?? $id) }}" method="POST" enctype="multipart/form-data" id="ratingForm">
            @csrf

            <input type="hidden" name="user_id" value="{{ auth()->id() ?? 3 }}">

            <p class="mb-4 text-lg font-semibold text-gray-900">Bagaimana Pengalamanmu?</p>

            <div class="mb-6 flex justify-center gap-2">
                <input type="hidden" name="rating" id="selected-rating" value="" required>

                <span class="star-icon cursor-pointer text-4xl text-gray-300 transition-colors duration-200" data-value="1">&#9733;</span>
                <span class="star-icon cursor-pointer text-4xl text-gray-300 transition-colors duration-200" data-value="2">&#9733;</span>
                <span class="star-icon cursor-pointer text-4xl text-gray-300 transition-colors duration-200" data-value="3">&#9733;</span>
                <span class="star-icon cursor-pointer text-4xl text-gray-300 transition-colors duration-200" data-value="4">&#9733;</span>
                <span class="star-icon cursor-pointer text-4xl text-gray-300 transition-colors duration-200" data-value="5">&#9733;</span>
            </div>

            <div class="mb-5 text-left">
                <label for="komentar" class="mb-2 block text-sm font-medium text-gray-500">Komentar *</label>
                <input type="text" id="komentar" name="komentar" placeholder="Masukkan komentar" required autocomplete="off"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:border-[#0A2269] focus:ring-1 focus:ring-[#0A2269]">
            </div>

            <div class="mb-5 text-left">
                <label for="foto" class="mb-2 block text-sm font-medium text-gray-500">Tambahkan Foto</label>
                <input type="file" id="foto" name="foto" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-3 file:cursor-pointer file:rounded-md file:border file:border-gray-300 file:bg-gray-100 file:px-4 file:py-2 file:text-gray-700 file:transition-colors hover:file:bg-gray-200">
            </div>

            <button type="submit" class="mt-2 w-full rounded-xl bg-[#0A2269] py-3.5 text-base font-semibold text-white transition-colors hover:bg-[#07174A]">
                Kirim Ulasan
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
</style>

<script>
    // Fungsi untuk membuka dan menutup Modal
    function openReviewModal() {
        const modal = document.getElementById('reviewModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');

        // Reset form jika ditutup (opsional)
        document.getElementById('ratingForm').reset();
        highlightStars(0);
        document.getElementById('selected-rating').value = '';
    }

    // Menutup modal jika user mengklik area gelap di luar card
    window.onclick = function(event) {
        const modal = document.getElementById('reviewModal');
        if (event.target === modal) {
            closeReviewModal();
        }
    }

    // Logika Interaktif Bintang (Rating)
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-icon');
        const ratingInput = document.getElementById('selected-rating');

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                const hoverValue = this.getAttribute('data-value');
                highlightStars(hoverValue);
            });

            star.addEventListener('mouseleave', function () {
                const currentValue = ratingInput.value || 0;
                highlightStars(currentValue);
            });

            star.addEventListener('click', function () {
                const clickValue = this.getAttribute('data-value');
                ratingInput.value = clickValue;
                highlightStars(clickValue);
            });
        });
    });

    // Fungsi pembantu pewarnaan bintang
    function highlightStars(value) {
        const stars = document.querySelectorAll('.star-icon');
        stars.forEach(star => {
            if (parseInt(star.getAttribute('data-value')) <= parseInt(value)) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-amber-400');
            } else {
                star.classList.remove('text-amber-400');
                star.classList.add('text-gray-300');
            }
        });
    }
</script>
