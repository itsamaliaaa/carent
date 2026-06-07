<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReplyReview;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $rental = Rental::where('admin_id', auth()->id())->first();

        if (!$rental) {
            abort(403, 'Rental tidak ditemukan.');
        }

        $query = Review::with(['user', 'reply'])
            ->whereHas('booking', function ($q) use ($rental) {
                $q->where('rental_id', $rental->rental_id);
            });

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_posting', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_posting', '<=', $request->end_date);
        }

        if ($request->filled('cari')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%');
            });
        }

        $reviews = $query->orderBy('tanggal_posting', 'desc')->get();

        return view('admin.review.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        // Review hanya milik rental yang login
        $rental = Rental::where('admin_id', auth()->id())->firstOrFail();

        $reviewMilikRental = Review::whereHas('booking', function ($q) use ($rental) {
            $q->where('rental_id', $rental->rental_id);
        })->findOrFail($id);

        ReplyReview::create([
            'review_id'     => $reviewMilikRental->review_id,
            'user_id'       => Auth::id(),
            'komentar'      => $request->komentar,
            'tanggal_balas' => now()->toDateString(),
        ]);

        return redirect()->back();
    }
}