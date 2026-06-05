<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Pastikan model Booking sudah terimport

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking.
     */
    public function index(Request $request)
    {
        // Mulai query dengan relasi yang dibutuhkan untuk menghindari N+1 issue
        $query = Booking::with(['user', 'mobil']);

        // Jika Anda ingin menambahkan fitur pencarian (sesuai form search di view anda)
        if ($request->has('cari') && !empty($request->cari)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->cari . '%');
            });
        }

        // Ambil data dengan pagination (10 item per halaman)
        $bookings = $query->latest()->paginate(10);

        // Kirim data ke view
        return view('admin.booking.index', compact('bookings'));
    }
<<<<<<< HEAD

    /**
     * Menampilkan detail booking.
     */
=======
  
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
    public function show($id)
    {
        $booking = Booking::with([
            'mobil',
            'user',
            'driver',
            'pembayaran', 
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status_booking' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}