<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiclePreoperationalCheckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'vehicle_id' => ['required','exists:vehicles,id'],
			'driver_user_id' => ['required','exists:users,id'],
			'filled_date' => ['required','date'],
			'filled_time' => ['required','date_format:H:i'],
			'odometer' => ['nullable','integer','min:0'],
			'property_card' => ['required','boolean'],
			'license_category' => ['required','in:A1,A2,B1,B2,B3,C1,C2,C3'],

			// módulos (todos los checks como boolean)
			'kit_emergency' => ['required','array'],
			'kit_emergency.*' => ['boolean'],
			'kit_observations' => ['nullable','string','max:1000'],

			'lights' => ['required','array'],
			'lights.*' => ['boolean'],
			'lights_observations' => ['nullable','string','max:1000'],

			'brakes' => ['required','array'],
			'brakes.*' => ['boolean'],
			'brakes_observations' => ['nullable','string','max:1000'],

			'mirrors_glass' => ['required','array'],
			'mirrors_glass.*' => ['boolean'],
			'mirrors_observations' => ['nullable','string','max:1000'],

			'fluids' => ['required','array'],
			'fluids.*' => ['boolean'],
			'fluids_observations' => ['nullable','string','max:1000'],

			'general_state' => ['required','array'],
			'general_state.*' => ['boolean'],
			'general_observations' => ['nullable','string','max:1500'],
		];
    }
}
