<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyReview extends Model
{
    use HasFactory;

    protected $table = 'reply_review'; // Nama tabel asli
    protected $primaryKey = 'reply_id'; // Primary key asli database kamu!

    // Daftarkan semua kolom yang wajib diisi
    protected $fillable = [
        'review_id',
        'user_id',      // Tambahkan ini agar tidak error mass-assignment!
        'komentar',
        'tanggal_balas',
    ];

    // Matikan timestamps jika di phpMyAdmin kamu tidak ada kolom created_at / updated_at
    public $timestamps = false; 
}