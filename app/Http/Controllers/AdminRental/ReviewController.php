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

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        $reviews = $query->orderBy('tanggal_posting', 'desc')->get();

        return view('admin.review.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        // 1. Validasi input terlebih dahulu
        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        // 2. Simpan data balasan ke database dengan kolom yang sesuai di phpMyAdmin
        ReplyReview::create([
            'review_id'     => $id,
            'user_id'       => Auth::id(),                // Mengambil ID Admin yang sedang login
            'komentar'      => $request->komentar,
            'tanggal_balas' => now()->toDateString(),    // Format tanggal YYYY-MM-DD sesuai database
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Balasan berhasil dikirim!');
    }
}