<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Mobil;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'user_id'    => 'required|integer',
            'rating'     => 'required|integer|between:1,5',
            'komentar'   => 'required|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::table('reviews')->insert([
            'booking_id'       => $id, // Menangkap $id langsung dari parameter URL
            'user_id'          => $request->user_id,
            'rating'           => $request->rating,
            'komentar'         => $request->komentar,
            'status_tampilkan' => 1,
            'tanggal_posting'  => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function show($id)
    {
        $mobil = Mobil::with('fotos')->findOrFail($id);

        // Get all reviews for this car
        $reviews = \App\Models\Review::with('user', 'reply')
            ->whereHas('booking', function($query) use ($id) {
                $query->where('mobil_id', $id);
            })
            ->where('status_tampilkan', true)
            ->latest('tanggal_posting')
            ->get();

        // 1. Calculate Average Rating
        $averageRating = $reviews->avg('rating') ?? 0;
        $totalReviews = $reviews->count();

        // 2. Calculate Ratings Distribution (5, 4, 3, 2, 1 stars)
        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $ratingPercentages = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($reviews as $review) {
            if (isset($ratingCounts[$review->rating])) {
                $ratingCounts[$review->rating]++;
            }
        }

        foreach ($ratingCounts as $star => $count) {
            $ratingPercentages[$star] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
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

    public function storeReview(Request $request, $booking_id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $booking = Booking::findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status_booking !== 'selesai') {
            return back()->withErrors(['review' => 'Ulasan hanya bisa diberikan untuk perjalanan yang sudah selesai.']);
        }

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
}
