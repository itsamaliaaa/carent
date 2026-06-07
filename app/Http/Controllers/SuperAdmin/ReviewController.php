<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ], [
            'sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
        ]);

        $query = Review::with(['user', 'booking.mobil.rental'])
            ->latest('tanggal_posting');

        if ($request->dari) {
            $query->whereDate('tanggal_posting', '>=', $request->dari);
        }

        if ($request->sampai) {
            $query->whereDate('tanggal_posting', '<=', $request->sampai);
        }

        if ($request->cari) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%');
            });
        }

        $reviews = $query->paginate(10)->withQueryString();

        return view('superadmin.review.index', compact('reviews'));
    }

    public function toggle($id)
    {
        $review = Review::findOrFail($id);
        $review->status_tampilkan = !$review->status_tampilkan;
        $review->save();

        $status = $review->status_tampilkan ? 'ditampilkan' : 'disembunyikan';

        return redirect()->back()->with('review_success', "Review berhasil {$status}.");
    }
}