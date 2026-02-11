@php
    $injuries = $form->injuries ?? [];
    $procedures = $form->procedures ?? [];
    $supplies = $form->supplies_used ?? [];
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Accidente de tránsito #{{ $form->id }}</h2>
                <p class="text-sm text-gray-500">Fecha atención: <span class="font-medium">{{ optional($form->attention_date)->format('Y-m-d') ?? '-' }}</span> — Hora: <span class="font-medium">{{ $form->attention_time ?? '-' }}</span></p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('formats.traffic-accident-forms.edit', $form) }}" class="px-4 py-2 rounded-md bg-red-600 text-white">Editar</a>
                <a href="{{ route('formats.traffic-accident-forms.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Volver</a>
                <a href="{{ route('formats.traffic-accident-forms.export-pdf', $form) }}" target="_blank" class="px-4 py-2 rounded-md btn-primary">Exportar PDF</a>
            </div>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo I. Anamnesis</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div><span class="text-gray-500">NUAP:</span> <span class="font-medium">{{ $form->nuap ?? '-' }}</span></div>
                <div><span class="text-gray-500">Prioridad:</span> <span class="font-medium">{{ $form->priority ?? '-' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500">Quién informa:</span> <span class="font-medium">{{ $form->informer->name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Hora salida:</span> <span class="font-medium">{{ $form->departure_time ?? '-' }}</span></div>
                <div><span class="text-gray-500">Fecha atención:</span> <span class="font-medium">{{ optional($form->attention_date)->format('Y-m-d') ?? '-' }}</span></div>
                <div><span class="text-gray-500">Hora atención:</span> <span class="font-medium">{{ $form->attention_time ?? '-' }}</span></div>
                <div><span class="text-gray-500">Historia clínica:</span> <span class="font-medium">{{ $form->clinical_history ?? '-' }}</span></div>
            </div>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="md:col-span-2"><span class="text-gray-500">Paciente / Víctima:</span> <span class="font-medium">{{ $form->patient_name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Tipo doc:</span> <span class="font-medium">{{ $form->patient_doc_type ?? '-' }}</span> <span class="text-gray-500"> / No:</span> <span class="font-medium">{{ $form->patient_doc_number ?? '-' }}</span></div>
                <div><span class="text-gray-500">Nacimiento:</span> <span class="font-medium">{{ optional($form->patient_birth_date)->format('Y-m-d') ?? '-' }}</span></div>
                <div><span class="text-gray-500">Edad:</span> <span class="font-medium">{{ $form->patient_age ?? '-' }}</span></div>
                <div><span class="text-gray-500">Sexo:</span> <span class="font-medium">{{ $form->patient_sex ?? '-' }}</span></div>
                <div><span class="text-gray-500">Estado civil:</span> <span class="font-medium">{{ $form->patient_civil_status ?? '-' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500">Dirección:</span> <span class="font-medium">{{ $form->patient_address ?? '-' }}</span></div>
                <div><span class="text-gray-500">Teléfono:</span> <span class="font-medium">{{ $form->patient_phone ?? '-' }}</span></div>
                <div><span class="text-gray-500">Ocupación:</span> <span class="font-medium">{{ $form->patient_occupation ?? '-' }}</span></div>
                <div><span class="text-gray-500">EPS:</span> <span class="font-medium">{{ $form->eps ?? '-' }}</span></div>
                <div><span class="text-gray-500">Aseguradora:</span> <span class="font-medium">{{ $form->insurance_company ?? '-' }}</span></div>
                <div><span class="text-gray-500">Acompañante:</span> <span class="font-medium">{{ $form->companion_name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Parentesco:</span> <span class="font-medium">{{ $form->companion_relationship ?? '-' }}</span></div>
                <div><span class="text-gray-500">Teléfono acompañante:</span> <span class="font-medium">{{ $form->companion_phone ?? '-' }}</span></div>
            </div>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo II. Motivo de atención</h3>
            <div class="text-sm whitespace-pre-line">{{ $form->reason_observation ?? '-' }}</div>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo III. Examen físico</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-sm">
                <div><span class="text-gray-500">F.C:</span> <span class="font-medium">{{ $form->fc ?? '-' }}</span></div>
                <div><span class="text-gray-500">F.R:</span> <span class="font-medium">{{ $form->fr ?? '-' }}</span></div>
                <div><span class="text-gray-500">T.A:</span> <span class="font-medium">{{ $form->ta ?? '-' }}</span></div>
                <div><span class="text-gray-500">SPO2:</span> <span class="font-medium">{{ $form->spo2 ?? '-' }}</span></div>
                <div><span class="text-gray-500">T°:</span> <span class="font-medium">{{ $form->temperature ?? '-' }}</span></div>
                <div><span class="text-gray-500">RO/RV/RM:</span> <span class="font-medium">{{ $form->ro ?? '-' }}</span> / <span class="font-medium">{{ $form->rv ?? '-' }}</span> / <span class="font-medium">{{ $form->rm ?? '-' }}</span></div>
            </div>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div><span class="text-gray-500">Alergias:</span> <span class="font-medium">{{ $form->allergies ?? '-' }}</span></div>
                <div><span class="text-gray-500">Patologías:</span> <span class="font-medium">{{ $form->pathologies ?? '-' }}</span></div>
                <div><span class="text-gray-500">Medicamentos:</span> <span class="font-medium">{{ $form->medications ?? '-' }}</span></div>
                <div><span class="text-gray-500">Lividez:</span> <span class="font-medium">{{ $form->lividity ?? '-' }}</span></div>
                <div><span class="text-gray-500">Llenado capilar:</span> <span class="font-medium">{{ $form->capillary_refill ?? '-' }}</span></div>
                <div><span class="text-gray-500">Antecedentes:</span> <span class="font-medium">{{ $form->background ?? '-' }}</span></div>
            </div>
            <div class="mt-4 text-sm">
                <div class="text-gray-500 mb-1">Lesiones:</div>
                <div class="font-medium">{{ count($injuries) ? implode(', ', $injuries) : '-' }}</div>
            </div>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-gray-500 mb-1">Valoración primaria</div>
                    <div class="whitespace-pre-line font-medium">{{ $form->primary_assessment ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-gray-500 mb-1">Valoración secundaria</div>
                    <div class="whitespace-pre-line font-medium">{{ $form->secondary_assessment ?? '-' }}</div>
                </div>
            </div>
            <div class="mt-4 text-sm">
                <div class="text-gray-500 mb-1">Impresión diagnóstica</div>
                <div class="whitespace-pre-line font-medium">{{ $form->diagnostic_impression ?? '-' }}</div>
            </div>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo IV. Procedimientos realizados</h3>
            <div class="text-sm font-medium">{{ count($procedures) ? implode(', ', $procedures) : '-' }}</div>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo V. Insumos utilizados</h3>
            @if(count($supplies))
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left p-2 border">Insumo</th>
                                <th class="text-left p-2 border w-32">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplies as $row)
                                <tr>
                                    <td class="p-2 border">{{ $row['name'] ?? '-' }}</td>
                                    <td class="p-2 border">{{ $row['qty'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-sm text-gray-500">No hay insumos registrados.</div>
            @endif
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo VI. Traslado asistencial básico</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div class="md:col-span-2"><span class="text-gray-500">Transportado a:</span> <span class="font-medium">{{ $form->transport_to ?? '-' }}</span></div>
                <div><span class="text-gray-500">Municipio:</span> <span class="font-medium">{{ $form->transport_municipality ?? '-' }}</span></div>
                <div><span class="text-gray-500">Departamento:</span> <span class="font-medium">{{ $form->transport_department ?? '-' }}</span></div>
                <div><span class="text-gray-500">Hora inicio traslado:</span> <span class="font-medium">{{ $form->transfer_start_time ?? '-' }}</span></div>
                <div><span class="text-gray-500">Fecha llegada IPS:</span> <span class="font-medium">{{ optional($form->ips_arrival_date)->format('Y-m-d') ?? '-' }}</span></div>
                <div><span class="text-gray-500">Hora llegada IPS:</span> <span class="font-medium">{{ $form->ips_arrival_time ?? '-' }}</span></div>
                <div><span class="text-gray-500">Estado entrega:</span> <span class="font-medium">{{ $form->delivery_status ?? '-' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500">Recibe:</span> <span class="font-medium">{{ $form->receiver_name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Documento:</span> <span class="font-medium">{{ $form->receiver_document ?? '-' }}</span></div>
                <div><span class="text-gray-500">Cargo:</span> <span class="font-medium">{{ $form->receiver_role ?? '-' }}</span></div>
                <div><span class="text-gray-500">RG.MD:</span> <span class="font-medium">{{ $form->rg_md ?? '-' }}</span></div>
            </div>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Módulo VII. Datos del evento</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div class="md:col-span-2"><span class="text-gray-500">Causa:</span> <span class="font-medium">{{ $form->event_cause ?? '-' }}</span></div>
                <div><span class="text-gray-500">Modo:</span> <span class="font-medium">{{ $form->service_mode ?? '-' }}</span></div>
                <div><span class="text-gray-500">Ubicación:</span> <span class="font-medium">{{ $form->event_location_type ?? '-' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500">Dirección:</span> <span class="font-medium">{{ $form->event_address ?? '-' }}</span></div>
                <div><span class="text-gray-500">Municipio:</span> <span class="font-medium">{{ $form->event_municipality ?? '-' }}</span></div>
                <div><span class="text-gray-500">Departamento:</span> <span class="font-medium">{{ $form->event_department ?? '-' }}</span></div>
                <div><span class="text-gray-500">Calidad paciente:</span> <span class="font-medium">{{ $form->patient_quality ?? '-' }}</span></div>
                <div><span class="text-gray-500">Conductor involucrado:</span> <span class="font-medium">{{ $form->involved_driver_name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Doc conductor:</span> <span class="font-medium">{{ $form->involved_driver_document ?? '-' }}</span></div>
                <div><span class="text-gray-500">Placa (SOAT):</span> <span class="font-medium">{{ $form->soat_vehicle_plate ?? '-' }}</span></div>
                <div><span class="text-gray-500">Aseguradora SOAT:</span> <span class="font-medium">{{ $form->soat_insurance_name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Póliza SOAT:</span> <span class="font-medium">{{ $form->soat_policy_number ?? '-' }}</span></div>
                <div><span class="text-gray-500">Vehículo institución:</span> <span class="font-medium">{{ $form->vehicle->plate ?? '-' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500">Responsable:</span> <span class="font-medium">{{ $form->responsibleUser->name ?? '-' }} @if($form->responsible_document)({{ $form->responsible_document }})@endif</span></div>
            </div>
            <div class="mt-4 text-sm">
                <div class="text-gray-500 mb-1">Observaciones</div>
                <div class="whitespace-pre-line font-medium">{{ $form->general_observations ?? '-' }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
