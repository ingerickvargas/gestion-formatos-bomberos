<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleShiftHandoffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required','integer','exists:vehicles,id'],
            'action'     => ['required','in:ENTREGA,RECIBE'],
            'notes'      => ['nullable','string','max:2000'],
        ];
    }
}
