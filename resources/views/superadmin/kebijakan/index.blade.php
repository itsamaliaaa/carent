@extends('layouts.admin')

@section('content')

<div class="flex flex-col gap-4 py-5 px-5">
    <div class="bg-white p-7 rounded-[20px] shadow-sm border border-gray-50">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-[#1D2B6B] text-2xl font-bold">Kebijakan</h1>

            <button
                type="button"
                id="btnEdit"
                onclick="enableEdit()"
                class="flex items-center gap-2 bg-[#0b1f67] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#0e2781] transition">
                <img src="{{ asset('images/icons/pencil-edit-01.svg') }}" class="w-5 h-5 brightness-0 invert">                
                Edit Kebijakan
            </button>
        </div>

        <form action="{{ route('superadmin.kebijakan.save') }}" method="POST">
            @csrf

            {{-- Syarat Pembatalan --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Syarat Pembatalan</label>
                <textarea
                    name="pembatalan"
                    rows="5"
                    placeholder="Masukkan Syarat Pembatalan"
                    disabled
                    class="kebijakan-textarea w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">{{ old('pembatalan', $pembatalan->isi ?? '') }}</textarea>
            </div>

            {{-- Pengembalian Dana --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Kebijakan Pengembalian Dana</label>
                <textarea
                    name="pengembalian_dana"
                    rows="5"
                    placeholder="Masukkan Kebijakan Pengembalian Dana"
                    disabled
                    class="kebijakan-textarea w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">{{ old('pengembalian_dana', $pengembalianDana->isi ?? '') }}</textarea>
            </div>

            {{-- Syarat dan Ketentuan --}}
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Syarat dan Ketentuan Umum</label>
                <textarea
                    name="syarat_ketentuan_umum"
                    rows="5"
                    placeholder="Masukkan Syarat dan Ketentuan Umum"
                    disabled
                    class="kebijakan-textarea w-full border border-gray-200 rounded-lg py-3 px-4 text-sm focus:outline-none focus:border-[#1D2B6B] resize-none disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed transition">{{ old('syarat_ketentuan_umum', $syaratKetentuan->isi ?? '') }}</textarea>
            </div>

            {{-- Tombol Simpan (tersembunyi sampai mode edit aktif) --}}
            <div id="actionButtons" class="hidden flex gap-3">
                <button
                    type="button"
                    onclick="cancelEdit()"
                    class="w-full border border-gray-300 text-gray-600 py-2.5 rounded-lg font-semibold text-[13px] hover:bg-gray-200 transition">
                    Batal
                </button>
                <button
                    type="submit"
                    class="bg-[#0b1f67] w-full text-white py-2.5 rounded-lg font-semibold text-[13px] hover:bg-[#0e2781] transition">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Simpan nilai awal untuk keperluan tombol Batal
    const originalValues = {};

    document.querySelectorAll('.kebijakan-textarea').forEach(el => {
        originalValues[el.name] = el.value;
    });

    function enableEdit() {
        document.querySelectorAll('.kebijakan-textarea').forEach(el => {
            el.disabled = false;
        });

        document.getElementById('btnEdit').classList.add('hidden');
        document.getElementById('actionButtons').classList.remove('hidden');
    }

    function cancelEdit() {
        // Kembalikan nilai semula
        document.querySelectorAll('.kebijakan-textarea').forEach(el => {
            el.value = originalValues[el.name];
            el.disabled = true;
        });

        document.getElementById('btnEdit').classList.remove('hidden');
        document.getElementById('actionButtons').classList.add('hidden');
    }
</script>

@endsection