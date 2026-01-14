<x-app-layout>
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Informe de salida vehicular</h1>
        <div class="flex gap-2">
            <a href="{{ route('formats.vehicle-exit-reports.index') }}" class="px-3 py-2 border rounded-md bg-sky-800 text-white">Volver</a>
            @if($report->status === 'PENDING_DRIVER' && $report->driver_user_id === auth()->id())
                <a href="{{ route('formats.vehicle-exit-reports.driver-form', $report) }}"
                   class="px-3 py-2 bg-gray-900 text-white rounded-md">
                    Diligenciar
                </a>
            @endif
        </div>
    </div>
    @if(session('success'))
        <div class="rounded bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rounded bg-red-50 p-3 text-red-700">{{ session('error') }}</div>
    @endif
    <div class="bg-white shadow rounded p-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
        <div><span class="text-gray-500">Estado:</span>
            <b>{{ $report->status }}</b>
        </div>
        <div><span class="text-gray-500">Creado:</span>
            <b>{{ $report->created_at->format('Y-m-d H:i') }}</b>
        </div>
        <div><span class="text-gray-500">Guardia:</span>
            <b>{{ $report->guardUser->name ?? '-' }}</b>
        </div>
        <div><span class="text-gray-500">Conductor:</span>
            <b>{{ $report->driverUser->name ?? '-' }}</b>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-2 text-sm">
        <h3 class="font-semibold">Datos del vehículo / evento</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div><span class="text-gray-500">Placa:</span> <b>{{ $report->vehicle->plate ?? '-' }}</b></div>
            <div><span class="text-gray-500">Tipo vehículo:</span> <b>{{ $report->vehicle_type }}</b></div>
            <div><span class="text-gray-500">Evento:</span> <b>{{ $report->event_type }}</b></div>
            <div><span class="text-gray-500">Hora salida:</span> <b>{{ $report->departure_time ?? '-' }}</b></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
            <div><span class="text-gray-500">Departamento:</span> <b>{{ $report->department ?? '-' }}</b></div>
            <div><span class="text-gray-500">Ciudad/Mpio:</span> <b>{{ $report->city ?? '-' }}</b></div>
            <div><span class="text-gray-500">Nomenclatura:</span> <b>{{ $report->nomenclature ?? '-' }}</b></div>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4 space-y-2 text-sm">
        <h3 class="font-semibold">Parte del conductor</h3>
        @if($report->status !== 'COMPLETED')
            <div class="text-gray-500">Pendiente por diligenciar.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><span class="text-gray-500">Kilometraje:</span> <b>{{ $report->odometer }}</b></div>
                <div><span class="text-gray-500">Diligenciado:</span>
                    <b>{{ ($report->updated_at)->format('Y-m-d H:i') ?? '-' }}</b>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-gray-500">Estado del vehículo:</span>
                <div class="grid grid-cols-1 md:grid-cols-8 gap-2 mt-2">
                    <div><span class="text-gray-500">Mecánico:</span> <b>{{ $report->mechanical_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Electrico:</span> <b>{{ $report->electrical_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Luces:</span> <b>{{ $report->lights_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Luces de emergencia:</span> <b>{{ $report->emergency_lights_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Sirena:</span> <b>{{ $report->siren_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Comunicaciones:</span> <b>{{ $report->communications_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Llantas:</span> <b>{{ $report->tires_status ?? '-' }}</b></div>
					<div><span class="text-gray-500">Frenos:</span> <b>{{ $report->brakes_status ?? '-' }}</b></div>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-gray-500">Ruta:</span>
                <div class="whitespace-pre-wrap"><b>{{ $report->route_description }}</b></div>
            </div>
            <div class="mt-3">
                <span class="text-gray-500">Desplazamiento:</span>
                <div class="whitespace-pre-wrap"><b>{{ $report->movement_description }}</b></div>
            </div>
            @if($report->general_observations)
                <div class="mt-3">
                    <span class="text-gray-500">Observaciones:</span>
                    <div class="whitespace-pre-wrap"><b>{{ $report->general_observations }}</b></div>
                </div>
            @endif
        @endif
    </div>
</div>
</x-app-layout>
