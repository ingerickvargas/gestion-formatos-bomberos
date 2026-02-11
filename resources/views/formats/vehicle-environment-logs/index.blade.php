<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Temperatura - Humedad vehículo</h2>
            <a href="{{ route('formats.vehicle-environment-logs.create') }}" class="px-4 py-2 bg-red-600 text-white rounded">Nuevo</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            <form method="GET" class="bg-white shadow rounded p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Placa</label>
                    <input name="plate" value="{{ request('plate') }}" class="w-full rounded-md border-gray-300" placeholder="Buscar por placa..." />
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-md border-gray-300" />
                </div>
                <div class="flex items-end gap-2">
					@php
						$plate = request('plate');
						$date  = request('date');
						$hasFilters = filled($plate) || filled($date);
					@endphp
                    <button class="px-4 py-2 bg-red-600 text-white rounded w-full">Filtrar</button>
                    <a href="{{ route('formats.vehicle-environment-logs.index') }}" class="px-4 py-2 border rounded w-full bg-sky-800 text-white text-center">Limpiar</a>
					<a href="{{ $hasFilters ? route('formats.vehicle-environment-logs.export', request()->only(['plate','date'])) : '#'  }}" class="px-4 py-2 rounded-md border {{ $hasFilters ? 'hover:bg-gray-50' : 'opacity-50 cursor-not-allowed pointer-events-none' }}"
    				aria-disabled="{{ $hasFilters ? 'false' : 'true' }}">Exportar</a>
                </div>
            </form>
            <div class="bg-white shadow rounded p-4 overflow-x-auto">
				<div class="p-6 border-b">
					<p class="text-sm text-gray-600">
						Total (página): {{ $logs->count() }} — Mostrando {{ $logs->firstItem() }} a {{ $logs->lastItem() }} de {{ $logs->total() }}
					</p>
				</div>
                <table class="min-w-full text-sm">
                    <thead class="bg-red-600 text-white">
                        <tr class="text-left">
                            <th class="px-3 py-2">Fecha / Hora</th>
                            <th class="px-3 py-2">Placa</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Temp (°C)</th>
                            <th class="px-3 py-2">Humedad (%)</th>
                            <th class="px-3 py-2">Usuario</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-3 py-2">{{ $log->logged_at->format('Y-m-d H:i') }}</td>
                                <td class="px-3 py-2">{{ $log->vehicle?->plate }}</td>
                                <td class="px-3 py-2">{{ $log->vehicle?->vehicle_type }}</td>
                                <td class="px-3 py-2">{{ number_format((float)$log->temperature, 1) }}</td>
                                <td class="px-3 py-2">{{ $log->humidity }}</td>
                                <td class="px-3 py-2">{{ $log->creator?->name ?? '—' }}</td>
                                <td class="px-3 py-2 text-right space-x-2">
                                    <a class="text-blue-600" href="{{ route('formats.vehicle-environment-logs.show', $log) }}">Ver</a>
                                    <a class="text-red-600" href="{{ route('formats.vehicle-environment-logs.edit', $log) }}">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="px-3 py-6 text-center text-gray-500">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
