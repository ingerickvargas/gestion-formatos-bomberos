<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleExitReportDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $brm = Rule::in(['B','R','M']);

        return [
            'mechanical_status' => ['required', $brm],
            'electrical_status' => ['required', $brm],
            'lights_status' => ['required', $brm],
            'emergency_lights_status' => ['required', $brm],
            'siren_status' => ['required', $brm],
            'communications_status' => ['required', $brm],
            'tires_status' => ['required', $brm],
            'brakes_status' => ['required', $brm],

            'odometer' => ['required', 'integer', 'min:0'],
            'route_description' => ['required', 'string', 'max:4000'],
            'movement_description' => ['required', 'string', 'max:4000'],
            'general_observations' => ['nullable', 'string', 'max:4000'],
        ];
    }
}
