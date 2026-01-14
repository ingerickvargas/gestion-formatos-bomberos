<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VehicleInventory extends Model
{
    protected $fillable = [
        'vehicle_id','inventory_date','notes','created_by','updated_by'
    ];

    protected $casts = [
        'inventory_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items()
    {
        return $this->hasMany(VehicleInventoryItem::class);
    }
	
	public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
