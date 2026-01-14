<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
   protected $fillable = [
    'tipo_formato','patient_name','document','age','phone','address',
    'service_date','service_time','service_type','consultation_type','procedure',
    'responsible_name','responsible_document','observations','extras',
    'created_by','updated_by',
  ];

  protected $casts = [
    'service_date' => 'date',
    'extras' => 'array',
  ];

  public function creator() {
    return $this->belongsTo(User::class, 'created_by');
  }
}
