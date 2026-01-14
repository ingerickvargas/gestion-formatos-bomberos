<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleCleaning extends Model
{
    protected $fillable = [
    'vehicle_id','cleaning_type','areas','notes','created_by','updated_by'
	];

	 protected $casts = [
		'areas' => 'array',
	 ];

	public function vehicle() { 
		return $this->belongsTo(Vehicle::class); 
	}
	
	public function creator() { 
		return $this->belongsTo(User::class, 'created_by'); 
	}
}
