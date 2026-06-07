<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatusBooking extends Model
{
    use HasFactory;
    protected $table = 'riwayat_status_booking';

    public $timestamps = false;

    protected $fillable = [
        'booking_id', 'status_lama', 'status_baru', 'diubah_oleh', 'waktu_perubahan'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}
