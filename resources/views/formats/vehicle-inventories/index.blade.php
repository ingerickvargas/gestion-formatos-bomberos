<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventario por vehículo
            </h2>

            <a href="{{ route('formats.vehicle-inventories.create') }}"
               class="px-4 py-2 rounded bg-red-600 text-white hover:bg-gray-800">
                Nuevo
            </a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded bg-green-50 border border-green-200 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white shadow rounded p-4">
                <form method="GET" action="{{ route('formats.vehicle-inventories.index') }}"
                      class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700">Placa</label>
                        <input
                            type="text"
                            name="plate"
                            value="{{ request('plate') }}"
                            placeholder="Buscar por placa..."
                            class="w-full rounded-md border-gray-300 focus:border-gray-500 focus:ring-gray-500"
                        />
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input
                            type="date"
                            name="date"
                            value="{{ request('date') }}"
                            class="w-full rounded-md border-gray-300 focus:border-gray-500 focus:ring-gray-500"
                        />
                    </div>

                    <div class="md:col-span-3 flex gap-2">
                        <button class="w-full px-4 py-2 rounded bg-red-600 text-white hover:bg-gray-800">
                            Filtrar
                        </button>

                        <a href="{{ route('formats.vehicle-inventories.index') }}"
                           class="w-full px-4 py-2 rounded border bg-sky-800 text-white text-center hover:bg-gray-50">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-600 text-white">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold">Fecha</th>
                                <th class="px-4 py-3 font-semibold">Placa</th>
                                <th class="px-4 py-3 font-semibold">Tipo</th>
                                <th class="px-4 py-3 font-semibold">Marca</th>
                                <th class="px-4 py-3 font-semibold">Modelo</th>
								<th class="px-4 py-3 font-semibold">Usuario</th>
                                <th class="px-4 py-3 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($inventories as $inv)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ optional($inv->inventory_date)->format('Y-m-d') }}
                                    </td>

                                    <td class="px-4 py-3 font-medium">
                                        {{ $inv->vehicle->plate ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $inv->vehicle->vehicle_type ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $inv->vehicle->brand ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $inv->vehicle->model ?? '—' }}
                                    </td>
									<td class="px-4 py-3">
                                        {{ $inv->creator?->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('formats.vehicle-inventories.show', $inv) }}"
                                               class="text-blue-600 hover:underline">
                                                Ver
                                            </a>

                                            @role('admin')
                                                <a href="{{ route('formats.vehicle-inventories.edit', $inv) }}"
                                                   class="text-red-600 hover:underline">
                                                    Editar
                                                </a>
                                            @endrole
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                        No hay registros con los filtros actuales.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="px-4 py-3 border-t bg-white">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
