<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi: detail booking milik satu booking
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: detail booking menggunakan satu layanan
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}