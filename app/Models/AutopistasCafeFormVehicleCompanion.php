<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutopistasCafeFormVehicleCompanion extends Model
{
    protected $fillable = [
        'form_vehicle_id',
        'name','doc_type','doc_number','age','phone','address','presents',
        'transferred','radicado','destination',
    ];

    public function vehicle()
    {
        return $this->belongsTo(AutopistasCafeFormVehicle::class, 'form_vehicle_id');
    }
}
