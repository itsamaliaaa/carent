<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReplyReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {

        $query = Review::with(['user', 'reply']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_posting', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_posting', '<=', $request->end_date);
        }

        if ($request->filled('cari')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->where('users.nama_lengkap', 'like', '%' . $request->cari . '%')
                        ->orWhere('users.email', 'like', '%' . $request->cari . '%');
                });
            });
        }

        $reviews = $query->orderBy('tanggal_posting', 'asc')->get();

        return view('admin.review.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        // Simpan data balasan ke database
        ReplyReview::create([
            'review_id'     => $id,
            'user_id'       => Auth::id(),      
            'komentar'      => $request->komentar,
            'tanggal_balas' => now()->toDateString(),
        ]);

        return redirect()->back();
    }
}
