<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       $types = array_keys(config('vehicles.types'));
        $vehicleId = $this->route('vehicle')?->id ?? $this->route('vehicle');

        return [
            'plate' => ['required','string','max:20', Rule::unique('vehicles','plate')->ignore($vehicleId)],
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
