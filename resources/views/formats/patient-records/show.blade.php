<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle registro #{{ $patientRecord->id }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('formats.patient-records.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Volver</a>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="text-gray-500">Tipo:</span> <span class="font-medium">{{ $patientRecord->tipo_formato }}</span></div>
                    <div><span class="text-gray-500">Fecha:</span> <span class="font-medium">{{ optional($patientRecord->service_date)->format('Y-m-d') ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Hora:</span> <span class="font-medium">{{ $patientRecord->service_time ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Paciente:</span> <span class="font-medium">{{ $patientRecord->patient_name }}</span></div>
                    <div><span class="text-gray-500">Documento:</span> <span class="font-medium">{{ $patientRecord->document ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Teléfono:</span> <span class="font-medium">{{ $patientRecord->phone ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Dirección:</span> <span class="font-medium">{{ $patientRecord->address ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Usuario:</span> <span class="font-medium">{{ $patientRecord->creator?->name ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Creado:</span> <span class="font-medium">{{ $patientRecord->created_at->format('Y-m-d H:i') }}</span></div>
                </div>
                <hr>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Tipo servicio:</span> <span class="font-medium">{{ $patientRecord->service_type ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Responsable:</span> <span class="font-medium">{{ $patientRecord->responsible_name ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Tipo consulta:</span> <span class="font-medium">{{ $patientRecord->consultation_type ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Procedimiento:</span> <span class="font-medium">{{ $patientRecord->procedure ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Quién realiza:</span> <span class="font-medium">{{ $patientRecord->extras['quien_realiza'] ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Atención:</span> <span class="font-medium">{{ $patientRecord->extras['fecha_atencion'] ?? '-' }} {{ $patientRecord->extras['hora_atencion'] ?? '' }}</span></div>
                </div>
                <div class="text-sm">
                    <div class="text-gray-500 mb-1">Observaciones</div>
                    <div class="rounded border p-3 bg-gray-50">{{ $patientRecord->observations ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
