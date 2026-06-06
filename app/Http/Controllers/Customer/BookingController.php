<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Driver;
use App\Models\Pembayaran;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function check()
    {
        $bookings = Booking::with(['mobil', 'driver'])
        ->where('user_id', auth()->user()->user_id)
        ->latest()
        ->get();
    
        return view('customer.riwayat', compact('bookings'));
    }

    // aziza
    public function create(Request $request, $mobil_id)
    {
        $mobil = Mobil::with([
            'rental.rekenings',
            'fotos'
        ])->findOrFail($mobil_id);

        $tglAmbil = $request->tglAmbil;
        $tglKembali = $request->tglKembali;
        $waktuAmbil = $request->waktuAmbil;
        $waktuKembali = $request->waktuKembali;
        $lokasi = $request->lokasi;
        $hargaPerHari = $mobil->harga_per_hari;
        $deposit = 200000;
        $jumlahHari = 1;

        if ($tglAmbil && $tglKembali) {
            $start = strtotime($tglAmbil);
            $end = strtotime($tglKembali);
            $diff = $end - $start;
            $jumlahHari = ceil($diff / (60 * 60 * 24));

            if ($jumlahHari <= 0) {
                $jumlahHari = 1;
            }
        }

        $subtotal = $jumlahHari * $hargaPerHari;
        $total = $subtotal + $deposit;

        return view('customer.booking.create', compact(
            'mobil',
            'tglAmbil',
            'tglKembali',
            'waktuAmbil',
            'waktuKembali',
            'lokasi',
            'jumlahHari',
            'subtotal',
            'total',
            'deposit'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'syarat_ketentuan' => 'accepted',
            'tanggung_jawab' => 'accepted',
        ];

        if (!$request->has('driver')) {

            $rules['nama'] = [
                'required',
                'min:3',
                'regex:/^[A-Za-z\s]+$/'
            ];

            $rules['telepon'] = [
                'required',
                'regex:/^(08|\+628)[0-9]{8,13}$/'
            ];

            $rules['sim'] = [
                'required',
                'numeric',
                'digits_between:10,16'
            ];

            $rules['tgl_lahir'] = [
                'required',
                'date',
                'before:' . now()->subYears(17)->format('Y-m-d')
            ];
        }

        $request->validate($rules, [

            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.regex' => 'Nama hanya boleh berisi huruf.',

            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.regex' => 'Nomor telepon harus diawali 08 atau +62.',

            'sim.required' => 'Nomor SIM wajib diisi.',
            'sim.numeric' => 'Nomor SIM hanya boleh angka.',
            'sim.digits_between' => 'Nomor SIM harus 10-16 digit.',

            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date' => 'Tanggal lahir tidak valid.',
            'tgl_lahir.before' => 'Pengendara minimal berusia 17 tahun.',

            'bukti.required' => 'Bukti pembayaran wajib diupload.',
            'bukti.mimes' => 'Bukti pembayaran harus berupa file JPG, JPEG, PNG, atau PDF.',
            'bukti.max' => 'Ukuran bukti pembayaran maksimal 5 MB.',

            'syarat_ketentuan.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
            'tanggung_jawab.accepted' => 'Anda harus menyetujui tanggung jawab pengemudi.',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);
        $bukti = $request->file('bukti')->store('bukti-pembayaran', 'public');
        if (!$bukti) {
            return back()->withErrors([
                'bukti' => 'Upload bukti pembayaran gagal.'
            ]);
        }
                
        // HITUNG TOTAL HARGA
        $jumlahHari = ceil(
            (strtotime($request->tglKembali) - strtotime($request->tglAmbil))
            / (60 * 60 * 24)
        );
        $jumlahHari = max(1, $jumlahHari);
        $deposit = 200000;
        $totalHarga = $mobil->harga_per_hari * $jumlahHari;

        // TAMBAH BIAYA DRIVER JIKA DIPILIH
        if ($request->has('driver')) {
            $totalHarga += 250000 * $jumlahHari;
        }

        // TAMBAH DEPOSIT
        $totalHarga += $deposit;

        // SUPAYA KETIKA USER CENTANG DRIVER DAN TERNYATA KOSONG, DATA BOOKING TIDAK MASUK
        if ($request->has('driver') && !$request->driver_id) {
            return back()
                ->withErrors([
                    'driver' => 'Driver tidak ditemukan.'
                ])
                ->withInput();
        }
        
        $booking = Booking::create([

            'kode_booking' => Booking::generateKodeBooking(),
            'user_id' => auth()->user()->user_id,

            'rental_id' => $mobil->rental_id,
            'mobil_id' => $mobil->mobil_id,

            'driver_id' => $request->driver_id,
            'pakai_driver' => $request->has('driver'),

            'nama_pengendara' => $request->has('driver')
                ? 'Menggunakan Driver Rental'
                : $request->nama,

            'no_telp_pengendara' => $request->has('driver')
                ? '-'
                : $request->telepon,

            'no_sim_pengendara' => $request->has('driver')
                ? '-'
                : $request->sim,

            'tgl_lahir_pengendara' => $request->has('driver')
                ? null
                : $request->tgl_lahir,
            
            'tanggal_sewa' => $request->tglAmbil,
            'tanggal_kembali' => $request->tglKembali,
            'waktu_ambil' => $request->waktuAmbil,
            'waktu_kembali' => $request->waktuKembali,
            'lokasi_penjemputan' => $request->lokasi,
            'total_harga' => $totalHarga,
            'setuju_syarat' => true,
            'waktu_setuju_syarat' => now(),
            'catatan' => $request->catatan,
            'status_booking' => 'menunggu_konfirmasi',
        ]);

        Pembayaran::create([
            'booking_id' => $booking->booking_id,
            'metode_pembayaran' => 'transfer', // Perlu dibahas lagi
            'bukti_pembayaran' => $bukti,
            'jumlah_bayar' => $totalHarga,
            'status_pembayaran' => 'pending',
            'tanggal_bayar' => now(),
        ]);
        
        return redirect()
            ->route('customer.booking.create', [
                'mobil_id' => $mobil->mobil_id,
                'lokasi' => $request->lokasi,
                'tglAmbil' => $request->tglAmbil,
                'tglKembali' => $request->tglKembali,
                'waktuAmbil' => $request->waktuAmbil,
                'waktuKembali' => $request->waktuKembali,
            ])
            ->with('success_booking', true);
    }

    public function getRandomDriver($mobil_id)
    {
        $mobil = Mobil::findOrFail($mobil_id);

        $driver = Driver::where('rental_id', $mobil->rental_id)
            ->where('status', 'tersedia')
            ->inRandomOrder()
            ->first();

        return response()->json([
            'mobil' => $mobil,
            'driver' => $driver
        ]);
    }
}
