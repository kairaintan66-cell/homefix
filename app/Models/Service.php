<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'duration',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relasi: layanan dimiliki oleh satu kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: layanan dapat dikerjakan banyak teknisi
    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(
            Technician::class,
            'technician_services'
        );
    }

    // Relasi: layanan dapat digunakan di banyak detail booking
    public function bookingDetails(): HasMany
    {
        return $this->hasMany(BookingDetail::class);
    }
}