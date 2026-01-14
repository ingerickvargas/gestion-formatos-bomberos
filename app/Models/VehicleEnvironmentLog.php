<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleEnvironmentLog extends Model
{
    protected $fillable = [
        'vehicle_id',
        'temperature',
        'humidity',
        'logged_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
        'temperature' => 'decimal:1',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
