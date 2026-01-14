<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleInventoryItem extends Model
{
    protected $fillable = [
        'vehicle_inventory_id','supply_id','quantity','batch','serial'
    ];

    public function inventory()
    {
        return $this->belongsTo(VehicleInventory::class, 'vehicle_inventory_id');
    }

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
