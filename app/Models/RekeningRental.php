<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningRental extends Model
{
    protected $table = 'rekening_rental';

    protected $primaryKey = 'rekening_id';

    protected $fillable = [
        'rental_id',
        'tipe',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'url_qris',
        'is_aktif',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }
}