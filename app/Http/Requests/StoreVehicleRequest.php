<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         $types = array_keys(config('vehicles.types'));

        return [
            'plate' => ['required','string','max:20','unique:vehicles,plate'],
            'vehicle_type' => ['required', Rule::in($types)],
            'brand' => ['nullable','string','max:100'],
            'model' => ['nullable','string','max:100'],

            'insurance_company' => ['nullable','string','max:150'],
            'insurance_number' => ['nullable','string','max:100'],
            'insurance_expires_at' => ['nullable','date'],

            'tech_review_number' => ['nullable','string','max:100'],
            'tech_review_expires_at' => ['nullable','date'],
        ];
    }
	
	 protected function prepareForValidation(): void
    {
        if ($this->has('plate')) {
            $this->merge(['plate' => strtoupper(trim($this->plate))]);
        }
    }
}
