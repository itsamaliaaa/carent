<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Nama tabel di database Anda
    protected $table = 'review';

    // Primary key tabel Anda
    protected $primaryKey = 'review_id';

    // Kolom yang dapat diisi secara massal (Mass Assignment)
    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'komentar',
        'status_tampilkan',
        'tanggal_posting'
    ];

    /**
     * 1. Relasi ke model User
     * Menggunakan 'user_id' sebagai Foreign Key dan Local Key
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * 2. Relasi ke model ReviewReply (Balasan Ulasan)
     * Menghubungkan satu ulasan ke satu balasan admin
     */
    public function reply()
    {
        // Pastikan di sini memanggil ReplyReview::class
        return $this->hasOne(ReplyReview::class, 'review_id', 'review_id');
    }
}
