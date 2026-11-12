<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicianService extends Model
{
    use HasFactory;

    protected $fillable = [
        'technician_id',
        'service_id',
    ];

    // Relasi: data ini milik satu teknisi
    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    // Relasi: data ini terhubung dengan satu layanan
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}