<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telp',
        'password',
        'foto_profile',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ROLE HELPERS
    public function isCustomer(): bool    { return $this->role === 'customer'; }
    public function isAdminRental(): bool { return $this->role === 'admin_rental'; }
    public function isSuperAdmin(): bool  { return $this->role === 'super_admin'; }

    // RELASI

    // Admin rental memiliki satu rental
    public function rental()
    {
        return $this->hasOne(Rental::class, 'admin_id', 'user_id');
    }

    // Customer memiliki banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'user_id');
    }

    // User bisa memiliki banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'user_id');
    }

    // Admin bisa memiliki banyak reply review
    public function replyReviews()
    {
        return $this->hasMany(ReplyReview::class, 'user_id', 'user_id');
    }

    // fitur lupa password
    public function getEmailForPasswordReset(): string
    {
        return $this->email;
    }
}