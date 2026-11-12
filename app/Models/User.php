<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke teknisi
    public function technician()
    {
        return $this->hasOne(Technician::class);
    }

    // Relasi ke alamat
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relasi ke notifikasi
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}