<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCareForm extends Model
{
    protected $fillable = [
        'created_by','updated_by',

        // encabezado
        'filled_date','departure_time','vehicle_id','location_type','event_class',
        'event_address','event_city','event_department',

        // paciente
        'patient_name','patient_doc_type','patient_doc_number','patient_address',
        'patient_age','patient_phone','patient_occupation',

        // valoración
        'v_pulse','v_respiration','v_pa','v_spo2','v_ro','v_rv','v_rm','v_total',
        'v_temperature','v_general_observation',

        // procedimientos
        'procedures','ssn_09','lactato','dextrosa','procedure_description',
        'allergies','medications','pathologies','lividity','environment','general_notes',

        // transporte
        'delivery_status','delivery_time','belongings','receiver_name','receiver_document',
        'transported_to','transport_city','transport_code',

        // acompañante
        'companion_name','companion_document','companion_phone',

        // responsables
        'driver_user_id','driver_document',
        'crew1_user_id','crew1_document',
        'crew2_user_id','crew2_document',

        // evaluación
        'service_evaluation',
		'attachment_path',
    ];

    protected $casts = [
        'filled_date' => 'date',
        'procedures' => 'array',
        'service_evaluation' => 'array',
        'belongings' => 'boolean',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function driverUser() { return $this->belongsTo(User::class, 'driver_user_id'); }
    public function crew1User() { return $this->belongsTo(User::class, 'crew1_user_id'); }
    public function crew2User() { return $this->belongsTo(User::class, 'crew2_user_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
