<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Entrega de turno</h2>
            <a href="{{ route('formats.vehicle-shift-handoffs.create') }}" class="px-4 py-2 bg-red-600 text-white rounded">Nuevo</a>
        </div>
    </x-slot>
    @php
        $pendingCount = $latestPerVehicle->filter(fn($x) => $x?->action === 'ENTREGA')->count();
    @endphp
    @if($pendingCount > 0)
        <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            ⚠️ Hay <b>{{ $pendingCount }}</b> vehículo(s) con turno <b>PENDIENTE POR RECIBIR</b>.
        </div>
    @else
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            ✅ Todos los vehículos están con turno <b>RECIBIDO</b> (sin pendientes).
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($vehicles as $v)
            @php
                $last = $latestPerVehicle->get($v->id);
                $action = $last?->action;
                $who = $last?->creator?->name;
                $when = $last?->created_at?->format('Y-m-d H:i');
                if ($action === 'ENTREGA') {
                    $statusText = 'Pendiente por RECIBIR';
                    $badgeClass = 'bg-red-50 text-red-700 border border-red-200';
                    $icon = '⚠️';
                } elseif ($action === 'RECIBE') {
                    $statusText = 'Turno OK (Recibido)';
                    $badgeClass = 'bg-green-50 text-green-700 border border-green-200';
                    $icon = '✅';
                } else {
                    $statusText = 'Sin control';
                    $badgeClass = 'bg-gray-100 text-gray-600 border border-gray-200';
                    $icon = 'ℹ️';
                }
            @endphp
            <div class="bg-white shadow rounded p-4 border {{ ($last?->action === 'ENTREGA') ? 'ring-2 ring-red-200' : '' }}">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm text-gray-500">Placa</div>
                        <div class="text-lg font-semibold">{{ $v->plate }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $v->vehicle_type }} / {{ $v->brand }} / {{ $v->model }}
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $badgeClass }}">
                        {{ $icon }} {{ $statusText }}
                    </span>
                </div>
                <div class="mt-3 text-sm">
                    @if($last)
                        <div><span class="text-gray-500">Último evento:</span> <span class="font-medium">{{ $last->action }}</span></div>
                        <div><span class="text-gray-500">Usuario:</span> <span class="font-medium">{{ $who }}</span></div>
                        <div><span class="text-gray-500">Fecha/Hora:</span> <span class="font-medium">{{ $when }}</span></div>
                        <div class="mt-3 flex justify-end gap-2">
                            <a class="text-blue-600 text-sm" href="{{ route('formats.vehicle-shift-handoffs.show', $last) }}">Ver</a>
                            <a class="text-red-600 text-sm" href="{{ route('formats.vehicle-shift-handoffs.edit', $last) }}">Editar</a>
                        </div>
                    @else
                        <div class="text-gray-500">Aún no hay entregas/recibos para este vehículo.</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            <form method="GET" class="bg-white shadow rounded p-4 grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium">Placa</label>
                    <input name="plate" value="{{ request('plate') }}" class="w-full rounded-md border-gray-300" placeholder="Buscar por placa..." />
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-md border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Acción</label>
                    <select name="action" class="w-full rounded-md border-gray-300">
                        <option value="">Todas</option>
                        <option value="ENTREGA" @selected(request('action')==='ENTREGA')>ENTREGA</option>
                        <option value="RECIBE"  @selected(request('action')==='RECIBE')>RECIBE</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex items-end gap-2">
					@php
						$plate = request('plate');
						$date  = request('date');
						$hasFilters = filled($plate) || filled($date);
					@endphp
                    <button class="px-4 py-2 bg-red-600 text-white rounded w-full">Filtrar</button>
                    <a href="{{ route('formats.vehicle-shift-handoffs.index') }}" class="px-4 py-2 border rounded w-full text-center bg-sky-800 text-white">Limpiar</a>
					<a href="{{ $hasFilters ? route('formats.vehicle-shift-handoffs.export', request()->only(['plate','date'])) : '#' }}"
    				class="px-4 py-2 rounded-md border {{ $hasFilters ? 'hover:bg-gray-50' : 'opacity-50 cursor-not-allowed pointer-events-none' }}"
    				aria-disabled="{{ $hasFilters ? 'false' : 'true' }}">Exportar</a>
                </div>
            </form>
            <div class="bg-white shadow rounded p-4 overflow-x-auto">
				<div class="p-6 border-b">
					<p class="text-sm text-gray-600">
						Total (página): {{ $handOffs->count() }} — Mostrando {{ $handOffs->firstItem() }} a {{ $handOffs->lastItem() }} de {{ $handOffs->total() }}
					</p>
				</div>
                <table class="min-w-full text-sm">
                    <thead class="bg-red-600 text-white">
                        <tr class="text-left">
                            <th class="px-3 py-2">Fecha creación</th>
                            <th class="px-3 py-2">Placa</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Marca</th>
                            <th class="px-3 py-2">Modelo</th>
                            <th class="px-3 py-2">Usuario</th>
                            <th class="px-3 py-2">Estado</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($handOffs as $h)
                            <tr>
                                <td class="px-3 py-2">{{ $h->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-3 py-2">{{ $h->vehicle?->plate }}</td>
                                <td class="px-3 py-2">{{ $h->vehicle?->vehicle_type }}</td>
                                <td class="px-3 py-2">{{ $h->vehicle?->brand }}</td>
                                <td class="px-3 py-2">{{ $h->vehicle?->model }}</td>
                                <td class="px-3 py-2">{{ $h->creator?->name ?? '—' }}</td>
                                <td class="px-3 py-2">
                                    @if($h->action === 'ENTREGA')
                                        <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700 text-xs font-semibold">ENTREGÓ</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-green-50 text-green-700 text-xs font-semibold">RECIBIÓ</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right space-x-2">
                                    <a class="text-blue-600" href="{{ route('formats.vehicle-shift-handoffs.show', $h) }}">Ver</a>
                                    <a class="text-red-600" href="{{ route('formats.vehicle-shift-handoffs.edit', $h) }}">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-3 py-6 text-center text-gray-500">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $handOffs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
