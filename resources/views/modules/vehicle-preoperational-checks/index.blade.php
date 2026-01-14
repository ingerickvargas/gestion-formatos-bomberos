<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Preoperacional de vehículos</h1>

            <a href="{{ route('modules.vehicle-preoperational-checks.create') }}"
               class="px-4 py-2 bg-red-600 text-white rounded-md">
                Nuevo
            </a>
        </div>

        {{-- Filtros --}}
        <div class="bg-white shadow rounded p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium">Placa</label>
                    <select name="vehicle_id" class="w-full rounded-md border-gray-300">
                        <option value="">Todas</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" @selected(request('vehicle_id') == $v->id)>
                                {{ $v->plate }} - {{ $v->vehicle_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date"
                           name="filled_date"
                           value="{{ request('filled_date') }}"
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-red-600 text-white rounded-md">Filtrar</button>
                    <a href="{{ route('modules.vehicle-preoperational-checks.index') }}"
                       class="px-4 py-2 border rounded-md bg-sky-800 text-white">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="bg-white shadow rounded">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-red-600 text-white">
                        <tr class="text-left">
                            <th class="px-3 py-2">Fecha/Hora</th>
                            <th class="px-3 py-2">Placa</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Conductor</th>
                            <th class="px-3 py-2">Diligenciado por</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($checks as $c)
                            <tr>
                                <td class="px-3 py-2">
                                    {{ optional($c->filled_date)->format('Y-m-d') }}
                                    {{ $c->filled_time }}
                                </td>
                                <td class="px-3 py-2 font-semibold">{{ $c->vehicle->plate ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $c->vehicle_type ?? ($c->vehicle->vehicle_type ?? '-') }}</td>
                                <td class="px-3 py-2">{{ $c->driver->name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $c->creator->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-right">
                                    <a class="text-blue-600 hover:underline"
                                       href="{{ route('modules.vehicle-preoperational-checks.show', $c) }}">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center text-gray-500">
                                    No hay preoperacionales con esos filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $checks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
