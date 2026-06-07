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
        'no_telp',
        'tarif_harian',
        'status'
    ];

    protected $appends = ['umur'];

    public function getUmurAttribute()
    {
        return \Carbon\Carbon::parse($this->tgl_lahir)->age;
    }
}
