<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'technician_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi: review berasal dari satu booking
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: review dibuat oleh satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: review ditujukan kepada satu teknisi
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }
}