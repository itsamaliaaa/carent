<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
<<<<<<< HEAD
    protected $table = 'review';

    protected $primaryKey = 'review_id';

    public $timestamps = false;

=======
    use HasFactory;

    // Nama tabel di database Anda
    protected $table = 'review';

    // Primary key tabel Anda
    protected $primaryKey = 'review_id';

    // Kolom yang dapat diisi secara massal (Mass Assignment)
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'komentar',
        'status_tampilkan',
<<<<<<< HEAD
        'tanggal_posting',
    ];

    protected $casts = [
        'status_tampilkan' => 'boolean',
        'tanggal_posting' => 'datetime',
    ];

    /**
     * Relasi ke User (penulis review)
=======
        'tanggal_posting'
    ];

    /**
     * 1. Relasi ke model User
     * Menggunakan 'user_id' sebagai Foreign Key dan Local Key
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
<<<<<<< HEAD
     * Relasi ke ReplyReview
=======
     * 2. Relasi ke model ReviewReply (Balasan Ulasan)
     * Menghubungkan satu ulasan ke satu balasan admin
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
     */
    public function reply()
    {
        return $this->hasOne(ReplyReview::class, 'review_id', 'review_id');
    }
<<<<<<< HEAD

    /**
     * Relasi ke Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    /**
     * Scope review yang ditampilkan
     */
    public function scopeVisible($query)
    {
        return $query->where('status_tampilkan', true);
    }

    /**
     * Scope review yang disembunyikan
     */
    public function scopeHidden($query)
    {
        return $query->where('status_tampilkan', false);
    }
=======
>>>>>>> ff49cf2eaa6d82c3e52b91b27ff09e635bfa0bbb
}
