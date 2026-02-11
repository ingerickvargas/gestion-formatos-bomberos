<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutopistasCafeForm extends Model
{
    protected $fillable = [
        'created_by','updated_by',
        'event_date','departure_time','site_time','return_time',
        'km_initial','km_event','km_final',
        'vehicle_id',
        'event','kilometer','event_site','reference_point',
        'authorized','authorized_departure_time','authorized_site_time','authorized_return_time',
        'authorized_km_initial','authorized_km_event','authorized_km_final',
        'authorized_vehicle_id',
        'reporting_officer','road_inspector','receiving_hospital','driver_name','crew_member',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function vehicles()
    {
        return $this->hasMany(AutopistasCafeFormVehicle::class, 'form_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function authorizedVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'authorized_vehicle_id');
    }
}
