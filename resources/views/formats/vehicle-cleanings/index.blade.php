<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aseo de vehículo</h2>
            <a href="{{ route('formats.vehicle-cleanings.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md">Nuevo</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded bg-green-50 border border-green-200 p-3 text-green-800 text-sm">{{ session('success') }}</div>
            @endif
            <form method="GET" class="bg-white shadow rounded p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium">Placa</label>
                        <input name="plate" value="{{ request('plate') }}" class="w-full rounded-md border-gray-300" placeholder="Buscar por placa...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tipo</label>
                        <select name="cleaning_type" class="w-full rounded-md border-gray-300">
                            <option value="">Todos</option>
                            <option value="RUTINIA" @selected(request('cleaning_type')==='RUTINIA')>RUTINIA</option>
                            <option value="TERMINAL" @selected(request('cleaning_type')==='TERMINAL')>TERMINAL</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Fecha</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-md border-gray-300">
                    </div>
                    <div class="flex gap-2">
						@php
							$plate = request('plate');
							$date  = request('date');
							$hasFilters = filled($plate) || filled($date);
						@endphp
                        <button class="px-4 py-2 bg-red-600 text-white rounded-md w-full">Filtrar</button>
                        <a href="{{ route('formats.vehicle-cleanings.index') }}" class="px-4 py-2 border rounded-md w-full text-center bg-sky-800 text-white">Limpiar</a>
						<a href="{{ $hasFilters ? route('formats.vehicle-cleanings.export', request()->only(['plate','date'])) : '#' }}"
						class="px-4 py-2 rounded-md border {{ $hasFilters ? 'hover:bg-gray-50' : 'opacity-50 cursor-not-allowed pointer-events-none' }}"
						aria-disabled="{{ $hasFilters ? 'false' : 'true' }}">Exportar</a>
                    </div>
                </div>
            </form>
            <div class="bg-white shadow rounded p-4">
                <div class="overflow-x-auto">
					<div class="p-6 border-b">
						<p class="text-sm text-gray-600">
							Total (página): {{ $cleanings->count() }} — Mostrando {{ $cleanings->firstItem() }} a {{ $cleanings->lastItem() }} de {{ $cleanings->total() }}
						</p>
					</div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-600 text-white">
                            <tr class="text-left">
                                <th class="px-3 py-2">Fecha / Hora</th>
                                <th class="px-3 py-2">Placa</th>
                                <th class="px-3 py-2">Tipo vehículo</th>
                                <th class="px-3 py-2">Aseo</th>
                                <th class="px-3 py-2">Usuario</th>
                                <th class="px-3 py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($cleanings as $c)
                                <tr>
                                    <td class="px-3 py-2">{{ $c->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-3 py-2">{{ $c->vehicle->plate }}</td>
                                    <td class="px-3 py-2">{{ $c->vehicle->vehicle_type }}</td>
                                    <td class="px-3 py-2">
                                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $c->cleaning_type==='TERMINAL' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-green-50 text-green-700 border border-green-200' }}">{{ $c->cleaning_type }}</span>
                                    </td>
                                    <td class="px-3 py-2">{{ $c->creator?->name ?? '-' }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <a class="text-blue-600" href="{{ route('formats.vehicle-cleanings.show',$c) }}">Ver</a>
                                        <a class="text-red-600 ms-3" href="{{ route('formats.vehicle-cleanings.edit',$c) }}">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Sin registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $cleanings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
