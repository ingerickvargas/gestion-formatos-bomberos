@php
    $r = $record ?? null;
@endphp

<div x-data="{ tipo: '{{ old('tipo_formato', $r->tipo_formato ?? 'ALCALDIA') }}', }" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Tipo de formato <span class="text-red-500">*</span></label>
            <select name="tipo_formato" x-model="tipo" required class="w-full rounded-md border-gray-300">
                <option value="ALCALDIA">ALCALDIA</option>
                <option value="ANCIANATO">ANCIANATO</option>
                <option value="BOMBEROS">BOMBEROS</option>
            </select>
            @error('tipo_formato') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Fecha</label>
                <input type="date" name="service_date" value="{{ old('service_date', optional($r?->service_date)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300" />
                @error('service_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Hora</label>
                <input type="time" name="service_time" value="{{ old('service_time', $r->service_time ?? '') }}" class="w-full rounded-md border-gray-300" />
                @error('service_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Paciente / Beneficiario <span class="text-red-500">*</span></label>
            <input name="patient_name" required value="{{ old('patient_name', $r->patient_name ?? '') }}" class="w-full rounded-md border-gray-300" />
            @error('patient_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Documento</label>
            <input name="document" value="{{ old('document', $r->document ?? '') }}" class="w-full rounded-md border-gray-300" />
            @error('document') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div x-show="tipo === 'BOMBEROS'">
            <label class="block text-sm font-medium">Edad</label>
            <input type="number" min="0" name="age" value="{{ old('age', $r->age ?? '') }}" class="w-full rounded-md border-gray-300" />
            @error('age') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Teléfono</label>
            <input name="phone" value="{{ old('phone', $r->phone ?? '') }}" class="w-full rounded-md border-gray-300" />
            @error('phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div x-show="tipo !== 'BOMBEROS'">
            <label class="block text-sm font-medium">Dirección</label>
            <input name="address" value="{{ old('address', $r->address ?? '') }}" class="w-full rounded-md border-gray-300" />
            @error('address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
    <div x-show="tipo === 'ALCALDIA'" class="bg-gray-50 rounded p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tipo de servicio<span class="text-red-500">*</span></label>
                <input name="service_type" value="{{ old('service_type', $r->service_type ?? '') }}" class="w-full rounded-md border-gray-300" :disabled="tipo !== 'ALCALDIA'" :required="tipo==='ALCALDIA'" />
                @error('service_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Responsable atención <span class="text-red-500">*</span></label>
                <input name="responsible_name" value="{{ old('responsible_name', $r->responsible_name ?? '') }}" class="w-full rounded-md border-gray-300" :disabled="tipo !== 'ALCALDIA'" :required="tipo==='ALCALDIA'" />
                @error('responsible_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div x-show="tipo === 'ANCIANATO'" class="bg-gray-50 rounded p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Tipo de servicio<span class="text-red-500">*</span></label>
                <input name="service_type" value="{{ old('service_type', $r->service_type ?? '') }}" class="w-full rounded-md border-gray-300" :disabled="tipo !== 'ANCIANATO'" :required="tipo==='ANCIANATO'" />
                @error('service_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Responsable del traslado <span class="text-red-500">*</span></label>
                <input name="responsible_name" value="{{ old('responsible_name', $r->responsible_name ?? '') }}" class="w-full rounded-md border-gray-300" :disabled="tipo !== 'ANCIANATO'" :required="tipo==='ANCIANATO'" />
                @error('responsible_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Cédula responsable <span class="text-red-500">*</span></label>
                <input name="responsible_document" value="{{ old('responsible_document', $r->responsible_document ?? '') }}" class="w-full rounded-md border-gray-300" :required="tipo==='ANCIANATO'" />
                @error('responsible_document') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div x-show="tipo === 'BOMBEROS'" class="bg-gray-50 rounded p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tipo de servicio<span class="text-red-500">*</span></label>
                <input name="service_type" value="{{ old('service_type', $r->service_type ?? '') }}" class="w-full rounded-md border-gray-300" :disabled="tipo !== 'BOMBEROS'" :required="tipo==='BOMBEROS'" />
                @error('service_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Quién realiza <span class="text-red-500">*</span></label>
                <input name="extras[quien_realiza]" value="{{ old('extras.quien_realiza', $r->extras['quien_realiza'] ?? '') }}" class="w-full rounded-md border-gray-300" :required="tipo==='BOMBEROS'" />
                @error('extras.quien_realiza') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Procedimiento <span class="text-red-500">*</span></label>
                <input name="procedure" value="{{ old('procedure', $r->procedure ?? '') }}" class="w-full rounded-md border-gray-300" :required="tipo==='BOMBEROS'" />
                @error('procedure') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Fecha atención <span class="text-red-500">*</span></label>
                    <input type="date" name="extras[fecha_atencion]" value="{{ old('extras.fecha_atencion', $r->extras['fecha_atencion'] ?? '') }}" class="w-full rounded-md border-gray-300" :required="tipo==='BOMBEROS'" />
                    @error('extras.fecha_atencion') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Hora atención <span class="text-red-500">*</span></label>
                    <input type="time" name="extras[hora_atencion]" value="{{ old('extras.hora_atencion', $r->extras['hora_atencion'] ?? '') }}" class="w-full rounded-md border-gray-300" :required="tipo==='BOMBEROS'" />
                    @error('extras.hora_atencion') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium">Observaciones</label>
        <textarea name="observations" rows="3" class="w-full rounded-md border-gray-300">{{ old('observations', $r->observations ?? '') }}</textarea>
        @error('observations') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>
    @if($errors->any())
        <div class="rounded bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc ms-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
			</ul>
		</div>
	@endif
</div>
