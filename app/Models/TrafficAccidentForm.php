<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficAccidentForm extends Model
{
    protected $fillable = [
        'created_by','updated_by',
        'nuap','priority','informer_user_id',
        'attention_date','departure_time','attention_time',
        'clinical_history',
        'patient_name','patient_doc_type','patient_doc_number',
        'patient_birth_date','patient_age','patient_sex','patient_civil_status',
        'patient_address','patient_phone','patient_occupation',
        'eps','insurance_company',
        'companion_name','companion_relationship','companion_phone',
        'reason_observation',
        'fc','fr','ta','spo2','temperature','ro','rv','rm',
        'allergies','pathologies','medications','lividity','capillary_refill','background',
        'injuries','primary_assessment','secondary_assessment','diagnostic_impression',
        'procedures',
        'supplies_used',
        'transport_to','transport_municipality','transport_department',
        'transfer_start_time','ips_arrival_date','ips_arrival_time',
        'delivery_status','receiver_name','receiver_document','receiver_role','rg_md',
        'event_cause','service_mode','event_location_type',
        'event_address','event_municipality','event_department',
        'patient_quality','involved_driver_name','involved_driver_document',
        'soat_vehicle_plate','soat_insurance_name','soat_policy_number',
        'vehicle_id','responsible_user_id','responsible_document',
        'general_observations',
    ];

    protected $casts = [
        'attention_date' => 'date',
        'patient_birth_date' => 'date',
        'ips_arrival_date' => 'date',
        'injuries' => 'array',
        'procedures' => 'array',
        'supplies_used' => 'array',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function informer() { return $this->belongsTo(User::class, 'informer_user_id'); }
    public function responsibleUser() { return $this->belongsTo(User::class, 'responsible_user_id'); }
}
