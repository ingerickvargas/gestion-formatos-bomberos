<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleExitReport extends Model
{
    protected $fillable = [
        'status',
        'guard_user_id',
        'driver_user_id',
        'guard_completed_at',
        'driver_completed_at',

        // guardia
        'vehicle_type',
        'vehicle_id',
        'event_type',
        'department',
        'city',
        'neighborhood',
        'vereda',
        'nomenclature',
        'departure_time',

        // conductor
        'mechanical_status',
        'electrical_status',
        'lights_status',
        'emergency_lights_status',
        'siren_status',
        'communications_status',
        'tires_status',
        'brakes_status',
        'odometer',
        'route_description',
        'movement_description',
        'general_observations',
    ];

    public function guardUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guard_user_id');
    }

    public function driverUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_user_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
