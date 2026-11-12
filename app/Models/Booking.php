<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'technician_id',
        'address_id',
        'booking_date',
        'booking_time',
        'notes',
        'total_price',
        'status',

        // Rincian biaya setelah pemeriksaan teknisi
        'service_cost',
        'material_cost',
        'additional_cost',
        'inspection_notes',

        // Status persetujuan biaya
        'price_status',
        'price_submitted_at',
        'price_approved_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i',
        'total_price' => 'decimal:2',

        'service_cost' => 'decimal:2',
        'material_cost' => 'decimal:2',
        'additional_cost' => 'decimal:2',

        'price_submitted_at' => 'datetime',
        'price_approved_at' => 'datetime',
    ];

    // Relasi: booking dibuat oleh satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: booking ditangani oleh satu teknisi
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    // Relasi: booking menggunakan satu alamat
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    // Relasi: booking memiliki banyak detail layanan
    public function details(): HasMany
    {
        return $this->hasMany(BookingDetail::class);
    }

    // Relasi: booking memiliki satu pembayaran
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi: booking memiliki satu review
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
