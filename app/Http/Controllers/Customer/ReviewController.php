<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a review submitted from the riwayat page popup.
     */
    public function storeReview(Request $request, $booking_id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $booking = Booking::findOrFail($booking_id);

        // Make sure the booking belongs to the logged-in user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow reviews for completed bookings
        if ($booking->status_booking !== 'selesai') {
            return back()->withErrors(['review' => 'Ulasan hanya bisa diberikan untuk perjalanan yang sudah selesai.']);
        }

        // Prevent duplicate reviews
        if (Review::where('booking_id', $booking_id)->exists()) {
            return back()->withErrors(['review' => 'Kamu sudah memberikan ulasan untuk perjalanan ini.']);
        }

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('reviews', 'public');
        }

        Review::create([
            'booking_id'       => $booking->booking_id,
            'user_id'          => Auth::id(),
            'rating'           => $request->rating,
            'komentar'         => $request->komentar,
            'foto_review'      => $pathFoto,
            'status_tampilkan' => true,
            'tanggal_posting'  => now(),
        ]);

        return back()->with('review_success', true);
    }

    /**
     * Show the rating & review page for a specific car.
     */
    public function show($id)
    {
        $mobil = Mobil::with('fotos')->findOrFail($id);

        $reviews = Review::with(['user', 'reply'])
            ->whereHas('booking', function ($query) use ($id) {
                $query->where('mobil_id', $id);
            })
            ->where('status_tampilkan', true)
            ->latest('tanggal_posting')
            ->get();

        $averageRating = round($reviews->avg('rating') ?? 0, 1);
        $totalReviews  = $reviews->count();

        $ratingCounts      = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $ratingPercentages = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($reviews as $review) {
            if (isset($ratingCounts[$review->rating])) {
                $ratingCounts[$review->rating]++;
            }
        }

        foreach ($ratingCounts as $star => $count) {
            $ratingPercentages[$star] = $totalReviews > 0
                ? round(($count / $totalReviews) * 100)
                : 0;
        }

        return view('customer.rating-ulasan', compact(
            'mobil',
            'reviews',
            'averageRating',
            'totalReviews',
            'ratingCounts',
            'ratingPercentages'
        ));
    }
}
