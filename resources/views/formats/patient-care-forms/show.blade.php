<x-app-layout>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">Formulario de atención a pacientes</h1>
            <p class="text-sm text-gray-500">Detalle del registro</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('formats.patient-care-forms.index') }}"
               class="px-4 py-2 border rounded-md bg-sky-800 text-white">
                Volver
            </a>
        </div>
    </div>
	<div class="bg-white shadow rounded p-4 space-y-3">
		<h3 class="font-semibold">Consentimiento informado</h3>
		@if(!empty($form->attachment_path))
			<div class="flex flex-col gap-3">
				<a
					href="{{ asset('storage/'.$form->attachment_path) }}"
					target="_blank"
					class="inline-flex items-center text-blue-600 hover:underline"
				>
					Abrir imagen en nueva pestaña
				</a>
			</div>
		@else
			<p class="text-gray-500">No se adjuntó consentimiento informado.</p>
		@endif
	</div>
    <div class="bg-white shadow rounded p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Fecha diligenciamiento</div>
                <div class="font-semibold">{{ optional($form->filled_date)->format('Y-m-d') ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Hora salida</div>
                <div class="font-semibold">{{ $form->departure_time ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Vehículo (placa)</div>
                <div class="font-semibold">{{ $form->vehicle->plate ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Diligenciado por</div>
                <div class="font-semibold">{{ $form->creator->name ?? '-' }}</div>
            </div>
        </div>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Ubicación</div>
                <div class="font-semibold">{{ $form->location_type ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Clase de evento</div>
                <div class="font-semibold">{{ $form->event_class ?? '-' }}</div>
            </div>
            <div class="md:col-span-2">
                <div class="text-gray-500">Dirección del evento</div>
                <div class="font-semibold">{{ $form->event_address ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Ciudad</div>
                <div class="font-semibold">{{ $form->event_city ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Departamento</div>
                <div class="font-semibold">{{ $form->event_department ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">1. Información general del paciente</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Nombre</div>
                <div class="font-semibold">{{ $form->patient_name ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Tipo documento</div>
                <div class="font-semibold">{{ $form->patient_doc_type ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">N° documento</div>
                <div class="font-semibold">{{ $form->patient_doc_number ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Dirección</div>
                <div class="font-semibold">{{ $form->patient_address ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Edad</div>
                <div class="font-semibold">{{ $form->patient_age ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Teléfono</div>
                <div class="font-semibold">{{ $form->patient_phone ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Ocupación</div>
                <div class="font-semibold">{{ $form->patient_occupation ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">2. Valoración del paciente</h2>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-sm">
            <div><div class="text-gray-500">Pulso</div><div class="font-semibold">{{ $form->v_pulse ?? '-' }}</div></div>
            <div><div class="text-gray-500">Resp.</div><div class="font-semibold">{{ $form->v_respiration ?? '-' }}</div></div>
            <div><div class="text-gray-500">P/A</div><div class="font-semibold">{{ $form->v_pa ?? '-' }}</div></div>
            <div><div class="text-gray-500">SPO2</div><div class="font-semibold">{{ $form->v_spo2 ?? '-' }}</div></div>
            <div><div class="text-gray-500">Temp.</div><div class="font-semibold">{{ $form->v_temperature ?? '-' }}</div></div>
            <div><div class="text-gray-500">Total</div><div class="font-semibold">{{ $form->v_total ?? '-' }}</div></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div><div class="text-gray-500">RO</div><div class="font-semibold">{{ $form->v_ro ?? '-' }}</div></div>
            <div><div class="text-gray-500">RV</div><div class="font-semibold">{{ $form->v_rv ?? '-' }}</div></div>
            <div><div class="text-gray-500">RM</div><div class="font-semibold">{{ $form->v_rm ?? '-' }}</div></div>
            <div><div class="text-gray-500">Observación general</div><div class="font-semibold">{{ $form->v_general_observation ?? '-' }}</div></div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">3. Procedimientos realizados</h2>
        @php
            $procedures = $form->procedures ?? []; // ej: ['MONITOREO','HEMOSTASI',...]
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
            @foreach(['MONITOREO','HEMOSTASI','REANIMACION','ASPIRACION','OXIGENACION','PARTO','INMOVILIZACION','ASEPSIA','DESFIBRILACION','INTUBACION'] as $p)
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded border {{ in_array($p, $procedures) ? 'bg-gray-900 text-white border-gray-900' : 'border-gray-300' }}">
                        {{ in_array($p, $procedures) ? '✓' : '' }}
                    </span>
                    <span>{{ $p }}</span>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div><div class="text-gray-500">SSN 0.9%</div><div class="font-semibold">{{ $form->ssn_09 ?? '-' }}</div></div>
            <div><div class="text-gray-500">Lactato (g/m)</div><div class="font-semibold">{{ $form->lactato ?? '-' }}</div></div>
            <div><div class="text-gray-500">Dextrosa (g/m)</div><div class="font-semibold">{{ $form->dextrosa ?? '-' }}</div></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><div class="text-gray-500">Descripción procedimiento</div><div class="font-semibold whitespace-pre-wrap">{{ $form->procedure_description ?? '-' }}</div></div>
            <div><div class="text-gray-500">Observaciones generales</div><div class="font-semibold whitespace-pre-wrap">{{ $form->general_notes ?? '-' }}</div></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div><div class="text-gray-500">Alergias</div><div class="font-semibold">{{ $form->allergies ?? '-' }}</div></div>
            <div><div class="text-gray-500">Medicamentos</div><div class="font-semibold">{{ $form->medications ?? '-' }}</div></div>
            <div><div class="text-gray-500">Patologías</div><div class="font-semibold">{{ $form->pathologies ?? '-' }}</div></div>
            <div><div class="text-gray-500">Ambiente</div><div class="font-semibold">{{ $form->environment ?? '-' }}</div></div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">4. Transporte</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div><div class="text-gray-500">Estado entrega</div><div class="font-semibold">{{ $form->delivery_status ?? '-' }}</div></div>
            <div><div class="text-gray-500">Hora entrega</div><div class="font-semibold">{{ $form->delivery_time ?? '-' }}</div></div>
            <div><div class="text-gray-500">Pertenencias</div><div class="font-semibold">{{ is_null($form->belongings) ? '-' : ($form->belongings ? 'Sí' : 'No') }}</div></div>
            <div><div class="text-gray-500">Quién recibe</div><div class="font-semibold">{{ $form->receiver_name ?? '-' }}</div></div>
            <div><div class="text-gray-500">Cédula quien recibe</div><div class="font-semibold">{{ $form->receiver_document ?? '-' }}</div></div>
            <div><div class="text-gray-500">Transportado a</div><div class="font-semibold">{{ $form->transported_to ?? '-' }}</div></div>
			<div><div class="text-gray-500">Ciudad</div><div class="font-semibold">{{ $form->transport_city ?? '-' }}</div></div>
            <div><div class="text-gray-500">Código</div><div class="font-semibold">{{ $form->transport_code ?? '-' }}</div></div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">5. Acompañante y/o responsable</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div><div class="text-gray-500">Nombre</div><div class="font-semibold">{{ $form->companion_name ?? '-' }}</div></div>
            <div><div class="text-gray-500">Cédula</div><div class="font-semibold">{{ $form->companion_document ?? '-' }}</div></div>
            <div><div class="text-gray-500">Teléfono</div><div class="font-semibold">{{ $form->companion_phone ?? '-' }}</div></div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">6. Responsable de la atención</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Conductor</div>
                <div class="font-semibold">{{ $form->driverUser->name ?? '-' }}</div>
                <div class="text-xs text-gray-500">Cédula: {{ $form->driverUser->document ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Tripulante 1</div>
                <div class="font-semibold">{{ $form->crew1User->name ?? '-' }}</div>
                <div class="text-xs text-gray-500">Cédula: {{ $form->crew1User->document ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Tripulante 2</div>
                <div class="font-semibold">{{ $form->crew2User->name ?? '-' }}</div>
                <div class="text-xs text-gray-500">Cédula: {{ $form->crew2User->document ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="font-semibold">7. Evaluación del servicio</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><div class="text-gray-500">Calificación servicio</div><div class="font-semibold">{{ $form->service_evaluation['service'] ?? '-' }}</div></div>
            <div><div class="text-gray-500">Calificación personal</div><div class="font-semibold">{{ $form->service_evaluation['staff'] ?? '-' }}</div></div>
            <div><div class="text-gray-500">Calificación medios</div><div class="font-semibold">{{ $form->service_evaluation['means'] ?? '-' }}</div></div>
            <div><div class="text-gray-500">Recomendaría</div><div class="font-semibold">{{ $form->service_evaluation['recommend'] ?? '-' }}</div></div>
        </div>
    </div>
</div>
</x-app-layout>
