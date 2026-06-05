<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $booking = Booking::findOrFail($id);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('review', 'public');
        }

        Review::create([
            'booking_id' => $booking->booking_id,
            'user_id' => auth()->user()->user_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'foto' => $foto,
            'status_tampilkan' => true,
            'tanggal_posting' => now(),
        ]);

        return back()->with('review_success', true);
    }
}