<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $primaryKey = 'rental_id';
    protected $table = 'rental';

    protected $fillable = [
        'admin_id', 'nama_rental', 'logo_perusahaan', 'alamat',
        'kota', 'deskripsi', 'no_telp', 'email',
        'latitude', 'longitude', 'status',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'rental_id', 'rental_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'rental_id', 'rental_id');
    }

    public function rekenings()
    {
        return $this->hasMany(RekeningRental::class, 'rental_id', 'rental_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'rental_id', 'rental_id');
    }

    public function getRatingRataRataAttribute()
    {
        return $this->bookings()
            ->whereHas('review')
            ->with('review')
            ->get()
            ->avg(fn($b) => $b->review->rating);
    }
}