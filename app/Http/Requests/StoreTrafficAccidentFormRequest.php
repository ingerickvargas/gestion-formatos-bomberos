<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrafficAccidentFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $priorities = ['R','A','V','N','B'];
        $docTypes   = ['CC','TI','RC','CE','PA','AS'];

        // EXACTO como está en tu blade (con tildes)
        $injuryOptions = [
            'Escoriación','Laceración','Contusión','Trauma','Avulsión','Herida abierta',
            'Amputación','Deformidad','Politraumatismo','Fractura','Quemadura','Empalamiento','Hematoma'
        ];

        // EXACTO como está en tu blade (con tildes)
        $procedureOptions = [
            'Monitoreo','Hemostasia','Reanimación','Oxigenación','Glucometría',
            'Inmovilización','Asepsia','Desfibrilación','Intubación','Curación'
        ];

        // EXACTO como está en tu blade (con tildes)
        $eventCauseOptions = [
            'Enfermedad general',
            'Accidente de tránsito',
            'Accidente laboral',
            'Accidente común',
            'Lesión autoinfligida',
            'Evento catastrófico',
            'Evento terrorista',
            'Lesión por agresión',
            'Violencia sexual',
            'Otro',
        ];

        // EXACTO como está en tu blade (minúscula)
        $serviceModeOptions = ['sencillo','redondo'];

        // EXACTO como está en tu blade
        $locationOptions = ['U','R','O'];

        // EXACTO como está en tu blade (minúscula + tilde)
        $patientQualityOptions = ['peatón','conductor','ocupante','ciclista','otro'];

        // EXACTO como está en tu blade (minúscula)
        $deliveryStatus = ['vivo','muerto'];

        return [
            // ===== Modulo I. ANAMNESIS =====
            'nuap' => ['nullable','string','max:255'],
            'priority' => ['required', Rule::in($priorities)],

            'informer_user_id' => ['required','integer', Rule::exists('users','id')],

            'attention_date' => ['required','date'],
            'departure_time' => ['required','date_format:H:i'],
            'attention_time' => ['required','date_format:H:i'],

            'clinical_history' => ['nullable','string','max:255'],

            'patient_name' => ['required','string','max:255'],
            'patient_doc_type' => ['required', Rule::in($docTypes)],
            'patient_doc_number' => ['required','string','max:255'],

            'patient_birth_date' => ['nullable','date'],
            'patient_age' => ['nullable','integer','min:0','max:130'],
            'patient_sex' => ['nullable','string','max:255'],
            'patient_civil_status' => ['nullable','string','max:255'],

            'patient_address' => ['nullable','string','max:255'],
            'patient_phone' => ['nullable','string','max:255'],
            'patient_occupation' => ['nullable','string','max:255'],

            'eps' => ['nullable','string','max:255'],
            'insurance_company' => ['nullable','string','max:255'],

            'companion_name' => ['nullable','string','max:255'],
            'companion_relationship' => ['nullable','string','max:255'],
            'companion_phone' => ['nullable','string','max:255'],

            // ===== Modulo II. Motivo =====
            'reason_observation' => ['required','string','max:8000'],

            // ===== Modulo III. Examen físico =====
            'fc' => ['nullable','string','max:255'],
            'fr' => ['nullable','string','max:255'],
            'ta' => ['nullable','string','max:255'],
            'spo2' => ['nullable','string','max:255'],
            'temperature' => ['nullable','string','max:255'],
            'ro' => ['nullable','string','max:255'],
            'rv' => ['nullable','string','max:255'],
            'rm' => ['nullable','string','max:255'],

            'allergies' => ['nullable','string','max:8000'],
            'pathologies' => ['nullable','string','max:8000'],
            'medications' => ['nullable','string','max:8000'],
            'lividity' => ['nullable','string','max:255'],
            'capillary_refill' => ['nullable','string','max:255'],
            'background' => ['nullable','string','max:8000'],

            'injuries' => ['nullable','array'],
            'injuries.*' => ['string', Rule::in($injuryOptions)],

            'primary_assessment' => ['nullable','string','max:8000'],
            'secondary_assessment' => ['nullable','string','max:8000'],
            'diagnostic_impression' => ['nullable','string','max:8000'],

            // ===== Modulo IV. Procedimientos =====
            'procedures' => ['nullable','array'],
            'procedures.*' => ['string', Rule::in($procedureOptions)],

            // ===== Modulo V. Insumos (lista) =====
            'supplies_used' => ['nullable','array'],
            'supplies_used.*.supply_id' => ['nullable','integer', Rule::exists('supplies','id')],
            'supplies_used.*.name' => ['nullable','string','max:255'],
            'supplies_used.*.qty' => ['nullable','numeric','min:0', 'required_with:supplies_used.*.name,supplies_used.*.supply_id'],

            // ===== Modulo VI. Traslado =====
            'transport_to' => ['nullable','string','max:255'],
            'transport_municipality' => ['nullable','string','max:255'],
            'transport_department' => ['nullable','string','max:255'],

            'transfer_start_time' => ['nullable','date_format:H:i'],
            'ips_arrival_date' => ['nullable','date'],
            'ips_arrival_time' => ['nullable','date_format:H:i'],

            'delivery_status' => ['nullable', Rule::in($deliveryStatus)],
            'receiver_name' => ['nullable','string','max:255'],
            'receiver_document' => ['nullable','string','max:255'],
            'receiver_role' => ['nullable','string','max:255'],
            'rg_md' => ['nullable','string','max:255'],

            // ===== Modulo VII. Datos del evento =====
            'event_cause' => ['required', Rule::in($eventCauseOptions)],
            'service_mode' => ['required', Rule::in($serviceModeOptions)],
            'event_location_type' => ['required', Rule::in($locationOptions)],

            'event_address' => ['required','string','max:255'],
            'event_municipality' => ['required','string','max:255'],
            'event_department' => ['required','string','max:255'],

            'patient_quality' => ['required', Rule::in($patientQualityOptions)],
            'involved_driver_name' => ['nullable','string','max:255'],
            'involved_driver_document' => ['nullable','string','max:255'],

            'soat_vehicle_plate' => ['nullable','string','max:255'],
            'soat_insurance_name' => ['nullable','string','max:255'],
            'soat_policy_number' => ['nullable','string','max:255'],

            'vehicle_id' => ['required','integer', Rule::exists('vehicles','id')],
            'responsible_user_id' => ['required','integer', Rule::exists('users','id')],
            'responsible_document' => ['nullable','string','max:255'],

            'general_observations' => ['nullable','string','max:8000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Limpieza básica (evita espacios)
        $this->merge([
            'nuap' => is_string($this->nuap) ? trim($this->nuap) : $this->nuap,
            'patient_doc_number' => is_string($this->patient_doc_number) ? trim($this->patient_doc_number) : $this->patient_doc_number,
        ]);
    }
}
