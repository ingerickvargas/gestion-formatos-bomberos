<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAutopistasCafeFormRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $docTypes = ['CC','TI','RC','CE'];

        return [
            'event_date' => ['nullable','date'],
            'departure_time' => ['nullable','date_format:H:i'],
            'site_time' => ['nullable','date_format:H:i'],
            'return_time' => ['nullable','date_format:H:i'],

            'km_initial' => ['nullable','integer','min:0'],
            'km_event' => ['nullable','integer','min:0'],
            'km_final' => ['nullable','integer','min:0'],

            'vehicle_id' => ['nullable','exists:vehicles,id'],
            'event' => ['nullable','string','max:255'],
            'kilometer' => ['nullable','string','max:255'],
            'event_site' => ['nullable','string','max:255'],
            'reference_point' => ['nullable','string','max:255'],

            'authorized' => ['nullable','string','max:255'],
            'authorized_departure_time' => ['nullable','date_format:H:i'],
            'authorized_site_time' => ['nullable','date_format:H:i'],
            'authorized_return_time' => ['nullable','date_format:H:i'],

            'authorized_km_initial' => ['nullable','integer','min:0'],
            'authorized_km_event' => ['nullable','integer','min:0'],
            'authorized_km_final' => ['nullable','integer','min:0'],

            'authorized_vehicle_id' => ['nullable','exists:vehicles,id'],
            'reporting_officer' => ['nullable','string','max:255'],
            'road_inspector' => ['nullable','string','max:255'],
            'receiving_hospital' => ['nullable','string','max:255'],
            'driver_name' => ['nullable','string','max:255'],
            'crew_member' => ['nullable','string','max:255'],

            'vehicles' => ['required','array','min:1'],

            'vehicles.*.plate' => ['nullable','string','max:50'],
            'vehicles.*.vehicle_type' => ['nullable','string','max:255'],
            'vehicles.*.brand' => ['nullable','string','max:255'],
            'vehicles.*.model' => ['nullable','string','max:255'],
            'vehicles.*.color' => ['nullable','string','max:255'],
            'vehicles.*.trailer' => ['nullable','string','max:255'],
            'vehicles.*.internal_number' => ['nullable','string','max:255'],
            'vehicles.*.route' => ['nullable','string','max:255'],

            'vehicles.*.driver_name' => ['nullable','string','max:255'],
            'vehicles.*.driver_doc_type' => ['nullable', Rule::in($docTypes)],
            'vehicles.*.driver_document' => ['nullable','string','max:255'],
            'vehicles.*.driver_phone' => ['nullable','string','max:255'],
            'vehicles.*.driver_age' => ['nullable','integer','min:0','max:130'],
            'vehicles.*.driver_address' => ['nullable','string','max:255'],
            'vehicles.*.presents' => ['nullable','string'],

            'vehicles.*.transferred' => ['nullable', Rule::in(['Si','No'])],
            'vehicles.*.destination' => ['nullable','string','max:255'],
            'vehicles.*.radicado' => ['nullable','string','max:255'],

            'vehicles.*.companions' => ['nullable','array'],

            'vehicles.*.companions.*.name' => ['nullable','string','max:255'],
            'vehicles.*.companions.*.doc_type' => ['nullable', Rule::in($docTypes)],
            'vehicles.*.companions.*.doc_number' => ['nullable','string','max:255'],
            'vehicles.*.companions.*.age' => ['nullable','integer','min:0','max:130'],
            'vehicles.*.companions.*.phone' => ['nullable','string','max:255'],
            'vehicles.*.companions.*.address' => ['nullable','string','max:255'],
            'vehicles.*.companions.*.presents' => ['nullable','string'],
            'vehicles.*.companions.*.transferred' => ['nullable', Rule::in(['Si','No'])],
            'vehicles.*.companions.*.radicado' => ['nullable','string','max:255'],
            'vehicles.*.companions.*.destination' => ['nullable','string','max:255'],
        ];
    }
}
