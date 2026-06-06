<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RiwayatStatusBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Mobil;

class BookingController extends Controller
{
    /**
     * Daftar semua booking (index untuk admin).
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'mobil', 'driver', 'pembayaran'])
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

        if ($request->filled('tanggal_sewa')) {
            $query->whereDate('tanggal_sewa', $request->tanggal_sewa);
        }

        $bookings      = $query->paginate(3)->withQueryString();
        $statusOptions = $this->statusOptions();

        return view('admin.booking.index', compact('bookings', 'statusOptions'));
    }

    /**
     * Detail booking — semua field read-only kecuali status_booking.
     */
    public function show(string $kodeBooking)
    {
        $booking = Booking::with([
            'user',
            'mobil',
            'driver',
            'pembayaran',
            'riwayatStatus',
            'review',
        ])->where('booking_id', $kodeBooking)->firstOrFail();

        $statusOptions = $this->statusOptions();

        return view('admin.booking.detail', compact('booking', 'statusOptions'));
    }

    /**
     * Update HANYA status_booking dari halaman detail.
     * Semua field lain di halaman detail bersifat read-only.
     */
    public function updateStatus(Request $request, string $kodeBooking)
    {
        $booking = Booking::where('booking_id', $kodeBooking)->firstOrFail();

        $validated = $request->validate([
            'status_booking' => ['required', Rule::in(array_keys($this->statusOptions()))],
        ]);

        // Tidak ada yang perlu diupdate jika status sama
        if ($booking->status_booking === $validated['status_booking']) {
            return back()->with('info', 'Status tidak berubah.');
        }

        $statusLama = $booking->status_booking;

        DB::transaction(function () use ($booking, $validated, $statusLama) {
            $booking->update(['status_booking' => $validated['status_booking']]);

            // Jika status baru adalah "dikonfirmasi", verifikasi pembayaran sekaligus
            if ($validated['status_booking'] === 'dikonfirmasi' && $booking->pembayaran) {
                $booking->pembayaran->update([
                    'status_pembayaran' => 'verified',
                    'verified_by'       => Auth::id(),
                    'verified_at'       => now(),
                ]);
            }

            // Jika status baru adalah "dibatalkan" atau "ditolak", catat waktu & penyewa
            if (in_array($validated['status_booking'], ['dibatalkan', 'ditolak'])) {
                $booking->update([
                    'tanggal_pembatalan' => now(),
                    'dibatalkan_oleh'    => Auth::id(),
                ]);
            }

            RiwayatStatusBooking::create([
                'booking_id'  => $booking->booking_id,
                'status_lama' => $statusLama,
                'status_baru' => $validated['status_booking'],
                'diubah_oleh' => Auth::id(),
                'catatan'     => 'Status diubah oleh admin',
            ]);
        });

        return redirect()
            ->route('booking.show', $booking->booking_id)
            ->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Download bukti transfer
     */
    public function downloadBuktiTransfer(string $kodeBooking)
    {
        $booking = Booking::with('pembayaran')
            ->where('booking_id', $kodeBooking)
            ->firstOrFail();

        $pembayaran = $booking->pembayaran;

        if (! $pembayaran || ! $pembayaran->bukti_pembayaran) {
            return back()->with('error', 'Bukti transfer tidak tersedia.');
        }

        $path = storage_path('app/public/' . $pembayaran->bukti_pembayaran);

        if (! file_exists($path)) {
            return back()->with('error', 'File bukti transfer tidak ditemukan.');
        }

        return response()->download(
            $path,
            'bukti-transfer-' . $booking->booking_id . '.' . pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }

    private function statusOptions(): array
    {
        return [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'dikonfirmasi'        => 'Dikonfirmasi',
            'sedang_berlangsung'  => 'Sedang Berlangsung',
            'deposit_kembali'     => 'Deposit Kembali',
            'selesai'             => 'Selesai',
            'dibatalkan'          => 'Dibatalkan',
            'ditolak'             => 'Ditolak',
        ];
    }
}
