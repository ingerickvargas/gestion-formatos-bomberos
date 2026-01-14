<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleExitReportGuardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'driver_user_id' => ['required', 'exists:users,id'],

            'vehicle_type' => ['required', 'string', 'max:100'],
            'vehicle_id'   => ['required', 'exists:vehicles,id'],
            'event_type'   => ['required', 'string', 'max:120'],

            'department'   => ['required', 'string', 'max:120'],
            'city'         => ['required', 'string', 'max:120'],
            'neighborhood' => ['nullable', 'string', 'max:120'],
            'vereda'       => ['nullable', 'string', 'max:120'],
            'nomenclature' => ['nullable', 'string', 'max:255'],
            'departure_time' => ['required', 'date_format:H:i'],
        ];
    }
}
