<!-- confirm ubah status -->
<div
    id="confirmUbahStatus"
    class="fixed inset-0 z-[70] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">

        <p class="text-[24px] font-semibold leading-[36px] text-[#050E2D]">
            Apakah kamu yakin ingin mengubah status ini?
        </p>

        <div class="flex gap-4 mt-8">

            <button
                type="button"
                id="confirmUbahStatusBtn"
                class="flex-1 bg-[#62B33B] hover:bg-green-600
                    text-white py-3 rounded-xl font-semibold">
                Ya
            </button>

            <button
                type="button"
                id="closeUbahStatusConfirmModal"
                class="flex-1 bg-[#B92A44] hover:bg-red-600
                    text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>

        </div>

    </div>

</div>

<!-- feedback ubah status -->
<div
    id="successUbahStatus"
    class="fixed inset-0 z-[90] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">

        <div class="flex justify-center">

            <div class="w-24 h-24 flex items-center justify-center">

                <img
                    src="{{ asset('images/icons/check-circle.svg') }}"
                    alt="Success">

            </div>

        </div>

        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Status berhasil diubah</h2>

    </div>

</div>