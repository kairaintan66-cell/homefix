<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'bio',
        'photo',
        'rating',
        'is_available',
        'is_verified',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
    ];

    // Relasi: teknisi terhubung dengan satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: teknisi dapat memiliki banyak layanan
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'technician_services'
        );
    }

    // Relasi: teknisi memiliki banyak booking
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi: teknisi memiliki banyak review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Relasi: teknisi memiliki banyak jadwal
    public function schedules(): HasMany
    {
        return $this->hasMany(TechnicianSchedule::class);
    }
}