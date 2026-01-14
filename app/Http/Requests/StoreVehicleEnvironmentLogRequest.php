<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleEnvironmentLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id'   => ['required','integer','exists:vehicles,id'],
            'logged_at'    => ['required','date'],
            'temperature'  => ['required','numeric','between:-50,80'],
            'humidity'     => ['required','integer','between:0,100'],
        ];
    }
}
