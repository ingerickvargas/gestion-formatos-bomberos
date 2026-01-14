<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
		$groups = [
        'EQUIPOS BIOMÉDICOS Y OTROS',
        'PEDIÁTRICO',
        'QUIRÚRGICO',
        'CIRCULATORIO',
        'RESPIRATORIO',
		'DISPOSITIVOS CERVICALES',
        'CILINDROS DE OXÍGENO',
        'ACCESORIOS',
        'BOLSAS',
        'N/A',
		];
		
        return [
            'name' => ['required', 'string', 'max:150'],
            'group' => ['nullable', 'string', Rule::in($groups)],
            'quantity' => ['required', 'integer', 'min:0'],
            'serial' => ['nullable', 'string', 'max:100'],
            'commercial_presentation' => ['nullable', 'string', 'max:150'],
            'batch' => ['nullable', 'string', 'max:100'],
            'expires_at' => ['nullable', 'date'],
            'manufacturer_lab' => ['nullable', 'string', 'max:150'],
			'invima_registration' => ['nullable', 'string', 'max:80'],
        ];
    }
}
