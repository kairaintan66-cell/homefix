<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicianSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'technician_id',
        'day',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    // Relasi: jadwal dimiliki oleh satu teknisi
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }
}