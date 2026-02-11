<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Diligenciar informe (Conductor)</h1>
            <a href="{{ route('formats.vehicle-exit-reports.pending') }}" class="px-3 py-2 border rounded-md bg-sky-800 text-white">Volver</a>
        </div>
        <div class="bg-white shadow rounded p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div><span class="text-gray-500">Placa:</span> <b>{{ $report->vehicle->plate ?? '-' }}</b></div>
                <div><span class="text-gray-500">Tipo:</span> <b>{{ $report->vehicle_type }}</b></div>
                <div><span class="text-gray-500">Evento:</span> <b>{{ $report->event_type }}</b></div>
                <div><span class="text-gray-500">Guardia:</span> <b>{{ $report->guardUser->name ?? '-' }}</b></div>
            </div>
        </div>
        <form method="POST" action="{{ route('formats.vehicle-exit-reports.driver-update', $report) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="bg-white shadow rounded p-4 space-y-4">
                <h3 class="font-semibold">Estado del vehículo (B/R/M)</h3>
                @php
                    $items = [
                        'mechanical_status' => 'Sistema mecánico',
                        'electrical_status' => 'Sistema eléctrico',
                        'lights_status' => 'Luces',
                        'emergency_lights_status' => 'Luces emergencia',
                        'siren_status' => 'Sirena',
                        'communications_status' => 'Comunicaciones',
                        'tires_status' => 'Llantas',
                        'brakes_status' => 'Frenos',
                    ];
                @endphp
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left">
                                <th class="px-3 py-2">Componente</th>
                                <th class="px-3 py-2 w-56">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($items as $key => $label)
                                <tr>
                                    <td class="px-3 py-2">{{ $label }}</td>
                                    <td class="px-3 py-2">
                                        <div class="flex gap-4">
                                            @foreach(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Malo'] as $v => $txt)
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" name="{{ $key }}" value="{{ $v }}" required class="rounded border-gray-300" {{ old("state.$key") === $v ? 'checked' : '' }}>
                                                    <span>{{ $v }} ({{ $txt }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error("$key") <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white shadow rounded p-4 space-y-4">
                <h3 class="font-semibold">Datos del desplazamiento</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Kilometraje *</label>
                        <input type="number" name="odometer" min="0" required value="{{ old('odometer') }}" class="w-full rounded-md border-gray-300">
                        @error('odometer') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Descripción de la ruta *</label>
                    <textarea name="route_description" rows="3" required class="w-full rounded-md border-gray-300">{{ old('route_description') }}</textarea>
                    @error('route_description') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Descripción del desplazamiento *</label>
                    <textarea name="movement_description" rows="3" required class="w-full rounded-md border-gray-300">{{ old('movement_description') }}</textarea>
                    @error('movement_description') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Observaciones generales</label>
                    <textarea name="general_observations" rows="3" class="w-full rounded-md border-gray-300">{{ old('general_observations') }}</textarea>
                    @error('general_observations') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('formats.vehicle-exit-reports.pending') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
