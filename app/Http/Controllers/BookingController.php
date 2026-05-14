<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function check(Request $request)
    {
        $booking = null;

        // Only search if user has submitted the form
        if ($request->has('email') && $request->has('booking_code')) {
            $booking = Booking::where('email', $request->email)
                            ->where('booking_code', $request->booking_code)
                            ->first();
        }

        return view('bookings.check', compact('booking'));
    }
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Logika: Hanya bisa batal jika status masih pending
        if ($booking->status == 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan.');
    }
}
