<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    
    protected $table = 'driver';
    protected $primaryKey = 'driver_id';

    protected $fillable = [
        'rental_id',
        'nama_driver',
        'foto',
        'umur',
        'tarif_harian',
        'status',
        'no_telp',
    ];
}