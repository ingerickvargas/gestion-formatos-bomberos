<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleCleaningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
		  'vehicle_id' => ['required','integer','exists:vehicles,id'],
		  'cleaning_type' => ['required','in:RUTINIA,TERMINAL'],
		  'areas' => ['nullable','array'],
		  'areas.*' => ['string'],
		  'notes' => ['nullable','string','max:2000'],
		];
    }
}
