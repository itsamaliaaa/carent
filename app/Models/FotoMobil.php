<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoMobil extends Model
{
    protected $table = 'foto_mobil';
    protected $primaryKey = 'foto_id';
    public $timestamps = false;
    
    protected $fillable = [
        'mobil_id',
        'url_foto',
        'is_primary',
        'urutan',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }
}