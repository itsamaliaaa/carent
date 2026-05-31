<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebijakan extends Model
{
    protected $table = 'kebijakan';

    protected $primaryKey = 'kebijakan_id';

    protected $fillable = [
        'judul',
        'isi',
        'tipe',
        'status',
        'dibuat_oleh',
    ];

    /**
     * Relasi ke user pembuat kebijakan
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'user_id');
    }

    /**
     * Scope kebijakan aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope berdasarkan tipe
     */
    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }
}