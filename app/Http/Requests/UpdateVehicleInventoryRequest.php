<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }
	
    public function rules(): array
    {
        return [
            'notes' => ['nullable','string','max:2000'],
            'items' => ['nullable', 'array'],
			'items.*.selected' => ['nullable', 'in:1'],
			'items.*.quantity' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
