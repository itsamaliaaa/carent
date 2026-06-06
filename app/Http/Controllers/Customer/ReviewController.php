<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Mobil;

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

    public function show($id)
    {
        // 1. Get the mobil
        $mobil = Mobil::findOrFail($id);

        // 2. Use Eloquent to get reviews with the user who wrote them
        // Ensure your Review model has a 'user' relationship defined
        $reviews = \App\Models\Review::with('user')
            ->whereHas('booking', function($query) use ($id) {
                $query->where('mobil_id', $id);
            })
            ->where('status_tampilkan', true)
            ->latest('tanggal_posting')
            ->get();

        return view('customer.rating-ulasan', compact('mobil', 'reviews'));
    }
}
