<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate','vehicle_type','brand','model',
        'insurance_company','insurance_number','insurance_expires_at',
        'tech_review_number','tech_review_expires_at',
        'created_by','updated_by'
    ];

    protected $casts = [
        'insurance_expires_at' => 'date',
        'tech_review_expires_at' => 'date',
    ];
}
