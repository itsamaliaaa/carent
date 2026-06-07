<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\RiwayatStatusBooking;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Daftar semua booking milik rental yang login
     */
    public function index(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();

        if (!$rental) {
            abort(403, 'Rental tidak ditemukan.');
        }

        $query = Booking::with(['user', 'mobil','driver', 'pembayaran'])
            ->where('rental_id', $rental->rental_id)
            ->orderByDesc('created_at');

        if ($request->filled('status_booking')) {
            $query->where('status_booking', $request->status_booking);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_id', 'like', "%{$search}%")
                  ->orWhere('nama_pengendara', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_sewa', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_sewa', '<=', $request->end_date);
        }

        $bookings      = $query->paginate(3)->withQueryString();
        $statusOptions = $this->statusOptions();

        return view('admin.booking.index', compact('bookings', 'statusOptions'));
    }

    /**
     * Detail booking — hanya milik rental yang login
     */
    public function show(string $kodeBooking)
    {
        $rental = Rental::where('admin_id', auth()->id())->firstOrFail();

        $booking = Booking::with([
            'user',
            'mobil',
            'driver',
            'pembayaran',
            'riwayatStatus',
            'review',
        ])
        ->where('kode_booking', $kodeBooking)
        ->where('rental_id', $rental->rental_id)
        ->firstOrFail();

        $statusOptions = $this->statusOptions();

        return view('admin.booking.detail', compact('booking', 'statusOptions'));
    }

    /**
     * Update status booking — hanya milik rental yang login
     */
    public function updateStatus(Request $request, string $kodeBooking)
    {
        $rental = Rental::where('admin_id', auth()->id())->firstOrFail();

        $booking = Booking::where('kode_booking', $kodeBooking)
            ->where('rental_id', $rental->rental_id)
            ->firstOrFail();

        $validated = $request->validate([
            'status_booking' => ['required', Rule::in(array_keys($this->statusOptions()))],
        ]);

        if ($booking->status_booking === $validated['status_booking']) {
            return back()->with('info', 'Status tidak berubah.');
        }

        $statusLama = $booking->status_booking;

        DB::transaction(function () use ($booking, $validated, $statusLama) {
            $booking->update(['status_booking' => $validated['status_booking']]);

            if ($validated['status_booking'] === 'dikonfirmasi' && $booking->pembayaran) {
                $booking->pembayaran->update([
                    'status_pembayaran' => 'lunas',
                    'verified_by'       => Auth::id(),
                    'verified_at'       => now(),
                ]);
            }

            if (in_array($validated['status_booking'], ['dibatalkan', 'ditolak'])) {
                $booking->update([
                    'tanggal_pembatalan' => now(),
                    'dibatalkan_oleh'    => Auth::id(),
                ]);
            }

            RiwayatStatusBooking::create([
                'booking_id'      => $booking->booking_id,
                'status_lama'     => $statusLama,
                'status_baru'     => $validated['status_booking'],
                'diubah_oleh'     => Auth::id(),
                'waktu_perubahan' => now(),
                'keterangan'      => 'Status diubah oleh admin',
            ]);
        });

        return redirect()->route('admin.booking.index');
    }

    /**
     * Download bukti transfer — hanya milik rental yang login
     */
    public function downloadBuktiTransfer(string $kodeBooking)
    {
        $rental = Rental::where('admin_id', auth()->id())->firstOrFail();

        $booking = Booking::with('pembayaran')
            ->where('kode_booking', $kodeBooking)
            ->where('rental_id', $rental->rental_id)
            ->firstOrFail();

        $pembayaran = $booking->pembayaran;

        if (!$pembayaran || !$pembayaran->bukti_pembayaran) {
            return back()->with('error', 'Bukti transfer tidak tersedia.');
        }

        $path = storage_path('app/public/' . $pembayaran->bukti_pembayaran);

        if (!file_exists($path)) {
            return back()->with('error', 'File bukti transfer tidak ditemukan.');
        }

        return response()->download(
            $path,
            'bukti-transfer-' . $booking->kode_booking . '.' . pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    private function statusOptions(): array
    {
        return [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'dikonfirmasi'        => 'Dikonfirmasi',
            'berjalan'            => 'Sedang Berlangsung',
            'deposit_kembali'     => 'Deposit Kembali',
            'selesai'             => 'Selesai',
            'dibatalkan'          => 'Dibatalkan',
            'ditolak'             => 'Ditolak',
        ];
    }
}