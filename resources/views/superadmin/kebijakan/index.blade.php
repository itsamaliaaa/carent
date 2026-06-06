@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-5 px-5">
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Kebijakan</h1>
            <button type="button" id="btnEdit" onclick="enableEdit()"
                    class="flex items-center gap-2 bg-[#0b1f67] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#0e2781] transition">
                <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">
                Edit Kebijakan
            </button>
        </div>

        <form id="kebijakanForm" action="{{ route('superadmin.kebijakan.save') }}" method="POST">
            @csrf

            {{-- Syarat Pembatalan --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Syarat Pembatalan</label>
                <div id="list-pembatalan" class="flex flex-col gap-2">
                    @php
                        $poinPembatalan = $pembatalan ? array_filter(explode("\n", $pembatalan->isi)) : [''];
                    @endphp
                    @foreach($poinPembatalan as $poin)
                    <div class="poin-row flex items-center gap-2">
                        <span class="text-[#0b1f67] font-bold text-sm mt-0.5">•</span>
                        <input type="text" name="pembatalan[]"
                               value="{{ trim($poin) }}"
                               disabled
                               placeholder="Tambah poin..."
                               class="poin-input flex-1 border border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:border-[#1D2B6B] disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">
                        <button type="button" onclick="hapusPoin(this)"
                                class="btn-hapus-poin hidden w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="tambahPoin('list-pembatalan', 'pembatalan')"
                        id="btn-add-pembatalan"
                        class="btn-tambah-poin hidden mt-3 flex items-center gap-1 text-[#0b1f67] text-sm font-semibold hover:underline">
                    + Tambah Poin
                </button>
            </div>

            {{-- Pengembalian Dana --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Kebijakan Pengembalian Dana</label>
                <div id="list-pengembalian_dana" class="flex flex-col gap-2">
                    @php
                        $poinDana = $pengembalianDana ? array_filter(explode("\n", $pengembalianDana->isi)) : [''];
                    @endphp
                    @foreach($poinDana as $poin)
                    <div class="poin-row flex items-center gap-2">
                        <span class="text-[#0b1f67] font-bold text-sm mt-0.5">•</span>
                        <input type="text" name="pengembalian_dana[]"
                               value="{{ trim($poin) }}"
                               disabled
                               placeholder="Tambah poin..."
                               class="poin-input flex-1 border border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:border-[#1D2B6B] disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">
                        <button type="button" onclick="hapusPoin(this)"
                                class="btn-hapus-poin hidden w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="tambahPoin('list-pengembalian_dana', 'pengembalian_dana')"
                        id="btn-add-pengembalian_dana"
                        class="btn-tambah-poin hidden mt-3 flex items-center gap-1 text-[#0b1f67] text-sm font-semibold hover:underline">
                    + Tambah Poin
                </button>
            </div>

            {{-- Syarat dan Ketentuan --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Syarat dan Ketentuan Umum</label>
                <div id="list-syarat_ketentuan_umum" class="flex flex-col gap-2">
                    @php
                        $poinSyarat = $syaratKetentuan ? array_filter(explode("\n", $syaratKetentuan->isi)) : [''];
                    @endphp
                    @foreach($poinSyarat as $poin)
                    <div class="poin-row flex items-center gap-2">
                        <span class="text-[#0b1f67] font-bold text-sm mt-0.5">•</span>
                        <input type="text" name="syarat_ketentuan_umum[]"
                               value="{{ trim($poin) }}"
                               disabled
                               placeholder="Tambah poin..."
                               class="poin-input flex-1 border border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:border-[#1D2B6B] disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">
                        <button type="button" onclick="hapusPoin(this)"
                                class="btn-hapus-poin hidden w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="tambahPoin('list-syarat_ketentuan_umum', 'syarat_ketentuan_umum')"
                        id="btn-add-syarat_ketentuan_umum"
                        class="btn-tambah-poin hidden mt-3 flex items-center gap-1 text-[#0b1f67] text-sm font-semibold hover:underline">
                    + Tambah Poin
                </button>
            </div>

            {{-- Tombol Aksi --}}
            <div id="actionButtons" class="hidden flex gap-3">
                <button type="button" onclick="cancelEdit()"
                        class="w-full border border-gray-300 text-gray-600 py-2.5 rounded-lg font-semibold text-[13px] hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="button" onclick="openKebijakanConfirm()"
                        class="bg-[#0b1f67] w-full text-white py-2.5 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] transition">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div id="kebijakanConfirmModal" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm z-10 text-center">
        <p class="text-[22px] font-semibold leading-[34px] text-[#050E2D]">
            Apakah kamu yakin ingin menyimpan perubahan kebijakan?
        </p>
        <div class="flex gap-4 mt-8">
            <button type="button" id="confirmKebijakanBtn"
                    class="flex-1 bg-[#62B33B] hover:bg-green-600 text-white py-3 rounded-xl font-semibold">
                Ya
            </button>
            <button type="button" id="closeKebijakanConfirmModal"
                    class="flex-1 bg-[#B92A44] hover:bg-red-600 text-white py-3 rounded-xl font-semibold">
                Tidak
            </button>
        </div>
    </div>
</div>

{{-- LOADING --}}
<div id="kebijakanLoadingModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[80] hidden items-center justify-center">
    <div class="relative w-32 h-32">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="50" fill="none" stroke="#E5E7EB" stroke-width="10"/>
            <circle id="kebijakanProgressCircle" cx="60" cy="60" r="50" fill="none"
                    stroke="#0B1F67" stroke-width="10" stroke-linecap="round"
                    stroke-dasharray="314" stroke-dashoffset="314"
                    style="transition: stroke-dashoffset 0.3s ease"/>
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
            <span id="kebijakanProgressText" class="text-2xl font-bold text-[#0B1F67]">0%</span>
        </div>
    </div>
</div>

{{-- SUCCESS MODAL --}}
<div id="kebijakanSuccessModal" class="fixed inset-0 z-[90] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white rounded-3xl p-10 w-full max-w-sm z-10 text-center">
        <div class="flex justify-center">
            <img src="{{ asset('images/icons/check-circle.svg') }}" class="w-24 h-24">
        </div>
        <h2 class="mt-6 text-xl font-bold text-[#0B1F67]">Kebijakan berhasil disimpan</h2>
    </div>
</div>

<script>
    // SIMPAN NILAI AWAL
    let originalRows = {};

    function snapshotValues() {
        ['pembatalan', 'pengembalian_dana', 'syarat_ketentuan_umum'].forEach(key => {
            const list = document.getElementById('list-' + key);
            originalRows[key] = Array.from(list.querySelectorAll('.poin-row')).map(row => ({
                value: row.querySelector('input').value,
            }));
        });
    }

    snapshotValues();

    // ENABLE EDIT
    function enableEdit() {
        document.querySelectorAll('.poin-input').forEach(el => el.disabled = false);
        document.querySelectorAll('.btn-hapus-poin').forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('.btn-tambah-poin').forEach(el => el.classList.remove('hidden'));
        document.getElementById('btnEdit').classList.add('hidden');
        document.getElementById('actionButtons').classList.remove('hidden');
    }

    // CANCEL EDIT
    function cancelEdit() {
        ['pembatalan', 'pengembalian_dana', 'syarat_ketentuan_umum'].forEach(key => {
            const list = document.getElementById('list-' + key);
            // Hapus semua row lalu kembalikan snapshot
            list.innerHTML = '';
            originalRows[key].forEach(item => {
                list.appendChild(buatRow(key, item.value));
            });
        });

        document.querySelectorAll('.poin-input').forEach(el => el.disabled = true);
        document.querySelectorAll('.btn-hapus-poin').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.btn-tambah-poin').forEach(el => el.classList.add('hidden'));
        document.getElementById('btnEdit').classList.remove('hidden');
        document.getElementById('actionButtons').classList.add('hidden');
    }

    // BUAT ROW POIN
    function buatRow(name, value = '') {
        const div = document.createElement('div');
        div.className = 'poin-row flex items-center gap-2';
        div.innerHTML = `
            <span class="text-[#0b1f67] font-bold text-sm mt-0.5">•</span>
            <input type="text" name="${name}[]" value="${value}"
                   placeholder="Tambah poin..."
                   class="poin-input flex-1 border border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:border-[#1D2B6B] transition">
            <button type="button" onclick="hapusPoin(this)"
                    class="btn-hapus-poin w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>`;
        return div;
    }

    // TAMBAH POIN
    function tambahPoin(listId, name) {
        const list = document.getElementById(listId);
        list.appendChild(buatRow(name));
        list.lastElementChild.querySelector('input').focus();
    }

    // HAPUS POIN─
    function hapusPoin(btn) {
        const row = btn.closest('.poin-row');
        const list = row.parentElement;
        // Minimal 1 baris tetap ada
        if (list.querySelectorAll('.poin-row').length > 1) {
            row.remove();
        } else {
            row.querySelector('input').value = '';
        }
    }

    // KONFIRMASI─
    function openKebijakanConfirm() {
        document.getElementById('kebijakanConfirmModal').classList.remove('hidden');
        document.getElementById('kebijakanConfirmModal').classList.add('flex');
    }

    document.getElementById('closeKebijakanConfirmModal')
        ?.addEventListener('click', () => {
            document.getElementById('kebijakanConfirmModal').classList.add('hidden');
            document.getElementById('kebijakanConfirmModal').classList.remove('flex');
        });

    document.getElementById('confirmKebijakanBtn')
        ?.addEventListener('click', () => {
            document.getElementById('kebijakanConfirmModal').classList.add('hidden');
            document.getElementById('kebijakanConfirmModal').classList.remove('flex');

            // Loading
            const loadingModal = document.getElementById('kebijakanLoadingModal');
            const circle = document.getElementById('kebijakanProgressCircle');
            const text   = document.getElementById('kebijakanProgressText');

            loadingModal.classList.remove('hidden');
            loadingModal.classList.add('flex');

            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                text.textContent = progress + '%';
                circle.style.strokeDashoffset = 314 - (314 * progress / 100);
                if (progress >= 100) {
                    clearInterval(interval);
                    document.getElementById('kebijakanForm').submit();
                }
            }, 80);
        });

    // SUCCESS
    @if(session('kebijakan_success'))
        window.addEventListener('load', function () {
            const modal = document.getElementById('kebijakanSuccessModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 2500);
        });
    @endif
</script>

@endsection