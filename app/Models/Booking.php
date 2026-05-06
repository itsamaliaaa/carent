<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $table = 'booking';

    protected $fillable = [
        'kode_booking', 'user_id', 'rental_id', 'mobil_id', 'driver_id',
        'pakai_driver', 'nama_pengendara', 'no_telp_pengendara',
        'no_sim_pengendara', 'tgl_lahir_pengendara',
        'tanggal_sewa', 'tanggal_kembali', 'waktu_ambil', 'waktu_kembali',
        'lokasi_penjemputan', 'latitude_penjemputan', 'longitude_penjemputan',
        'total_harga', 'rincian_harga', 'setuju_syarat', 'waktu_setuju_syarat',
        'alasan_pembatalan', 'tanggal_pembatalan', 'dibatalkan_oleh',
        'status_deposit', 'tanggal_deposit_dikembalikan',
        'catatan', 'status_booking',
    ];

    protected $casts = [
        'rincian_harga'         => 'array',
        'pakai_driver'          => 'boolean',
        'setuju_syarat'         => 'boolean',
        'tanggal_sewa'          => 'date',
        'tanggal_kembali'       => 'date',
        'waktu_setuju_syarat'   => 'datetime',
        'tanggal_pembatalan'    => 'datetime',
    ];

    public static function generateKodeBooking(): string
    {
        $prefix = 'RENT-' . now()->format('Ym') . '-';
        $last = static::where('kode_booking', 'like', $prefix . '%')
            ->orderByDesc('kode_booking')->first();
        $number = $last ? ((int) substr($last->kode_booking, -4)) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function user() { return $this->belongsTo(User::class, 'user_id', 'user_id'); }
    public function rental() { return $this->belongsTo(Rental::class, 'rental_id', 'rental_id'); }
    public function mobil() { return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id'); }
    public function driver() { return $this->belongsTo(Driver::class, 'driver_id', 'driver_id'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'booking_id', 'booking_id'); }
    public function review() { return $this->hasOne(Review::class, 'booking_id', 'booking_id'); }
    public function riwayatStatus() { return $this->hasMany(RiwayatStatusBooking::class, 'booking_id', 'booking_id'); }
}