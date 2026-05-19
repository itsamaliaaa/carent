<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaran_id';

    protected $fillable = [
        'booking_id',
        'metode_pembayaran',
        'bukti_pembayaran',
        'jumlah_bayar',
        'status_pembayaran',
        'tanggal_bayar',
        'verified_by',
        'verified_at',
        'jumlah_refund',
    ];


    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'verified_at' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
        'jumlah_refund' => 'decimal:2',
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    // Admin yang memverifikasi pembayaran
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }
}