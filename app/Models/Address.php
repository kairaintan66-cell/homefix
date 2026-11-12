<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'is_default',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_default' => 'boolean',
    ];

    // Relasi: alamat dimiliki oleh satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: satu alamat dapat digunakan untuk banyak booking
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}