<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';

    protected $primaryKey = 'review_id';

    public $timestamps = false;
    use HasFactory;

    // Kolom yang dapat diisi secara massal (Mass Assignment)
    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'komentar',
        'status_tampilkan',
        'tanggal_posting',
    ];

    protected $casts = [
        'status_tampilkan' => 'boolean',
        'tanggal_posting' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function reply()
    {
        return $this->hasOne(ReplyReview::class, 'review_id', 'review_id');
    }

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
}
