<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $base = [
		  'tipo_formato' => ['required', Rule::in(['ANCIANATO','ALCALDIA','BOMBEROS'])],
		  'patient_name' => ['required','string','max:255'],
		  'document' => ['nullable','styyring','max:50'],
		  'age' => ['nullable','integer','min:0','max:130'],
		  'phone' => ['nullable','string','max:30'],
		  'address' => ['nullable','string','max:255'],
		  'observations' => ['nullable','string'],
		  'service_date' => ['nullable','date'],
		  'service_time' => ['nullable','date_format:H:i'],
		];

		$type = $this->input('tipo_formato');

		if ($type === 'ANCIANATO') {
		  $base['service_type'] = ['required','string','max:100']; // TAB, etc.
		  $base['responsible_name'] = ['required','string','max:255']; // Auxiliar responsable
		  $base['responsible_document'] = ['required','string','max:50']; // Cédula auxiliar
		  $base['address'] = ['required','string','max:255'];
		}

		if ($type === 'BOMBEROS') {
		  $base['service_type'] = ['string','max:120'];
		  $base['procedure'] = ['required','string','max:255'];
		  $base['extras.quien_realiza'] = ['required','string','max:255'];
		  $base['extras.fecha_atencion'] = ['required','date'];
		  $base['extras.hora_atencion'] = ['required','date_format:H:i'];
		}

		if ($type === 'ALCALDIA') {
		  // Ajusta con lo que lleve ese formato (seguro muy similar a BOMBEROS)
		  $base['service_type'] = ['required','string','max:100'];
		  $base['procedure'] = ['nullable','string','max:255'];
		  $base['responsible_name'] = ['required','string','max:255'];
		}

		return $base;
	 }
}
