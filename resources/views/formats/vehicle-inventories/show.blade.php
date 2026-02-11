<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle inventario por vehículo
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('formats.vehicle-inventories.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Volver</a>
                @role('admin')
                    <a href="{{ route('formats.vehicle-inventories.edit', $vehicleInventory) }}" class="px-4 py-2 rounded bg-red-600 text-white">Editar</a>
                @endrole
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Fecha</div>
                        <div class="font-medium">{{ $vehicleInventory->inventory_date }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Placa</div>
                        <div class="font-medium">{{ $vehicleInventory->vehicle?->plate ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Usuario</div>
                        <div class="font-medium">{{ $vehicleInventory->creator?->name ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Tipo</div>
                        <div class="font-medium">{{ $vehicleInventory->vehicle?->vehicle_type ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Marca</div>
                        <div class="font-medium">{{ $vehicleInventory->vehicle?->brand ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Modelo</div>
                        <div class="font-medium">{{ $vehicleInventory->vehicle?->model ?? '—' }}</div>
                    </div>
                </div>
                @if(!empty($vehicleInventory->notes))
                    <div class="mt-4">
                        <div class="text-xs text-gray-500">Observaciones</div>
                        <div class="mt-1 text-gray-800">{{ $vehicleInventory->notes }}</div>
                    </div>
                @endif
            </div>
            <div class="bg-white shadow rounded p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Ítems del inventario</h3>
                    <div class="text-sm text-gray-500">
                        Total: {{ $vehicleInventory->items->count() }}
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-600 text-white">
                            <tr>
                                <th class="text-left px-4 py-3">Insumo</th>
                                <th class="text-left px-4 py-3">Grupo</th>
                                <th class="text-left px-4 py-3">Cantidad</th>
                                <th class="text-left px-4 py-3">Lote</th>
                                <th class="text-left px-4 py-3">Fecha Vencimiento</th>
                                <th class="px-4 py-2">Semáforo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($vehicleInventory->items as $item)
                                @php
                                    $expiresAt = $item->supply?->expires_at ? \Carbon\Carbon::parse($item->supply->expires_at) : null;
                                    $color = 'bg-gray-200';
                                    if ($expiresAt) {
                                        $diffMonths = now()->diffInMonths($expiresAt, false);
                                        if ($diffMonths > 6) $color = 'bg-green-500';
                                        elseif ($diffMonths >= 3) $color = 'bg-yellow-400';
                                        else $color = 'bg-red-500';
                                    }
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $item->supply?->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->supply?->group ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->supply?->batch ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->supply?->expires_at ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="inline-block w-10 h-4 @if($item->supply->semaphore === 'green') bg-green-500 @elseif($item->supply->semaphore === 'yellow') bg-yellow-400 @elseif($item->supply->semaphore === 'red') bg-red-500 @else bg-gray-300 @endif" title="@if($item->supply->semaphore === 'green') Vence en más de 12 meses @elseif($item->supply->semaphore === 'yellow') Vence entre 3 y 12 meses @elseif($item->supply->semaphore === 'red') Vence en menos de 3 meses @else Sin fecha de vencimiento @endif"></span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        Este inventario no tiene ítems aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
