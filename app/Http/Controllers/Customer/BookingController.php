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
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->reason
        ]);

        return redirect()->back()->with('success_cancel', true);
    }
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('photo') ? $request->file('photo')->store('reviews', 'public') : null;

        Review::create([
            'booking_id' => $bookingId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photo' => $path,
        ]);

        // Mengembalikan flash session agar Alpine.js tahu ulasan berhasil dikirim
        return redirect()->back()->with('review_success', true);
    }
}
