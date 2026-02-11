@php
    $v = $vehicle ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Placa <span class="text-red-500">*</span></label>
        <input name="plate" required value="{{ old('plate', $v->plate ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Tipo vehículo <span class="text-red-500">*</span></label>
        <select name="vehicle_type" required class="w-full rounded-md border-gray-300">
            <option value="">Seleccione</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @selected(old('vehicle_type', $v->vehicle_type ?? '') == $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Marca</label>
        <input name="brand" value="{{ old('brand', $v->brand ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Modelo</label>
        <input name="model" value="{{ old('model', $v->model ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Compañía de seguro</label>
        <input name="insurance_company" value="{{ old('insurance_company', $v->insurance_company ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Número de seguro</label>
        <input name="insurance_number" value="{{ old('insurance_number', $v->insurance_number ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Vencimiento seguro</label>
        <input type="date" name="insurance_expires_at" value="{{ old('insurance_expires_at', optional($v?->insurance_expires_at)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Número revisión tecnomecánica</label>
        <input name="tech_review_number" value="{{ old('tech_review_number', $v->tech_review_number ?? '') }}" class="w-full rounded-md border-gray-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Vencimiento tecnomecánica</label>
        <input type="date" name="tech_review_expires_at" value="{{ old('tech_review_expires_at', optional($v?->tech_review_expires_at)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300" />
    </div>
</div>

@if($errors->any())
    <div class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-700">
        <ul class="list-disc ms-5">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
