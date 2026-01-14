<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientCareFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // encabezado
            'filled_date' => ['required','date'],
            'departure_time' => ['required','date_format:H:i'],
            'vehicle_id' => ['required','exists:vehicles,id'],
            'location_type' => ['required', Rule::in(['U','R','O'])],
            'event_class' => ['required', Rule::in(['EG','AT','AL','R','O'])],
            'event_address' => ['required','string','max:255'],
            'event_city' => ['required','string','max:255'],
            'event_department' => ['required','string','max:255'],

            // paciente
            'patient_name' => ['required','string','max:255'],
            'patient_doc_type' => ['required', Rule::in(['CC','TI','RC','CE'])],
            'patient_doc_number' => ['required','string','max:50'],
            'patient_address' => ['required','string','max:255'],
            'patient_age' => ['required','integer','min:0','max:130'],
            'patient_phone' => ['nullable','string','max:30'],
            'patient_occupation' => ['nullable','string','max:255'],

            // valoración
            'v_pulse' => ['nullable','string','max:50'],
            'v_respiration' => ['nullable','string','max:50'],
            'v_pa' => ['nullable','string','max:50'],
            'v_spo2' => ['nullable','string','max:50'],
            'v_ro' => ['nullable','string','max:50'],
            'v_rv' => ['nullable','string','max:50'],
            'v_rm' => ['nullable','string','max:50'],
            'v_total' => ['nullable','string','max:50'],
            'v_temperature' => ['nullable','string','max:50'],
            'v_general_observation' => ['nullable','string'],

            // procedimientos
            'procedures' => ['nullable','array'],
            'procedures.*' => ['string','max:50'],
            'ssn_09' => ['nullable','string','max:100'],
            'lactato' => ['nullable','string','max:100'],
            'dextrosa' => ['nullable','string','max:100'],
            'procedure_description' => ['nullable','string'],
            'allergies' => ['nullable','string'],
            'medications' => ['nullable','string'],
            'pathologies' => ['nullable','string'],
            'lividity' => ['nullable','string','max:255'],
            'environment' => ['nullable','string','max:255'],
            'general_notes' => ['nullable','string'],

            // transporte
            'delivery_status' => ['required', Rule::in(['vivo','muerto'])],
            'delivery_time' => ['nullable','date_format:H:i'],
            'belongings' => ['nullable','boolean'],
            'receiver_name' => ['nullable','string','max:255'],
            'receiver_document' => ['nullable','string','max:50'],
            'transported_to' => ['nullable','string','max:255'],
            'transport_city' => ['nullable','string','max:255'],
            'transport_code' => ['nullable','string','max:50'],

            // acompañante
            'companion_name' => ['nullable','string','max:255'],
            'companion_document' => ['nullable','string','max:50'],
            'companion_phone' => ['nullable','string','max:30'],

            // responsables (usuarios)
            'driver_user_id' => ['nullable','exists:users,id'],
            'driver_document' => ['nullable','string','max:50'],
            'crew1_user_id' => ['nullable','exists:users,id'],
            'crew1_document' => ['nullable','string','max:50'],
            'crew2_user_id' => ['nullable','exists:users,id'],
            'crew2_document' => ['nullable','string','max:50'],

            // evaluación E/B/R/M
            'service_evaluation' => ['nullable','array'],
            'service_evaluation.service' => ['nullable', Rule::in(['E','B','R','M'])],
            'service_evaluation.staff' => ['nullable', Rule::in(['E','B','R','M'])],
            'service_evaluation.means' => ['nullable', Rule::in(['E','B','R','M'])],
            'service_evaluation.recommend' => ['nullable', Rule::in(['E','B','R','M'])],
        ];
    }
	
	protected function prepareForValidation(): void
    {
        // checkbox belongings puede no venir
        $this->merge([
            'belongings' => $this->boolean('belongings'),
			'departure_time' => $this->departure_time ? substr($this->departure_time, 0, 5) : null,
			'delivery_time'  => $this->delivery_time ? substr($this->delivery_time, 0, 5) : null,
        ]);
    }
}
