<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutopistasCafeFormVehicle extends Model
{
    protected $fillable = [
        'form_id',
        'plate','vehicle_type','brand','model',
        'color','trailer','internal_number','route',
        'driver_name','driver_doc_type','driver_document','driver_phone','driver_age','driver_address',
        'presents','transferred','destination','radicado',
    ];

    public function form()
    {
        return $this->belongsTo(AutopistasCafeForm::class, 'form_id');
    }

    public function companions()
    {
        return $this->hasMany(AutopistasCafeFormVehicleCompanion::class, 'form_vehicle_id');
    }

}
