<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required','exists:vehicles,id'],
            'inventory_date' => ['required','date'],
            'notes' => ['nullable','string','max:2000'],
            'items' => ['nullable', 'array'],
			'items.*.selected' => ['nullable', 'in:1'],
			'items.*.quantity' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
