<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $primaryKey = 'mobil_id';
    protected $table = 'mobil';

    protected $fillable = [
        'rental_id', 'nama_mobil', 'tahun', 'transmisi', 'kategori',
        'kapasitas_penumpang', 'jenis_bahan_bakar', 'harga_per_hari',
        'biaya_admin', 'biaya_over_km', 'batas_km_per_hari',
        'deskripsi', 'status',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoMobil::class, 'mobil_id', 'mobil_id');
    }

    public function fotoPrimary()
    {
        return $this->hasOne(FotoMobil::class, 'mobil_id', 'mobil_id')->where('is_primary', true);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'mobil_id', 'mobil_id');
    }

    public function getRatingAttribute()
    {
        return $this->bookings()
            ->whereHas('review')
            ->with('review')
            ->get()
            ->avg(fn($b) => $b->review->rating);
    }
}