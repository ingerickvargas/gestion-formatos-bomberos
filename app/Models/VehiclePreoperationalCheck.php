<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehiclePreoperationalCheck extends Model
{
    protected $fillable = [
        'created_by',
        'vehicle_id',
        'vehicle_type',
        'tech_review_expires_at',
        'insurance_expires_at',
        'driver_user_id',
        'driver_document',
        'filled_date',
        'filled_time',
        'odometer',
        'property_card',
        'license_category',
        'kit_emergency',
        'kit_observations',
        'lights',
        'lights_observations',
        'brakes',
        'brakes_observations',
        'mirrors_glass',
        'mirrors_observations',
        'fluids',
        'fluids_observations',
        'general_state',
        'general_observations',
    ];

    protected $casts = [
        'filled_date' => 'date',
        'property_card' => 'boolean',
        'kit_emergency' => 'array',
        'lights' => 'array',
        'brakes' => 'array',
        'mirrors_glass' => 'array',
        'fluids' => 'array',
        'general_state' => 'array',
        'tech_review_expires_at' => 'date',
        'insurance_expires_at' => 'date',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_user_id');
    }
}
