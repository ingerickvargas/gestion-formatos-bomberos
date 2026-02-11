<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Informe de salida vehicular - Pendientes</h1>
            <a href="{{ route('formats.vehicle-exit-reports.index') }}" class="px-3 py-2 border rounded-md bg-sky-800 text-white">Ver todos</a>
        </div>
        @if(session('success'))
            <div class="rounded bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded bg-red-50 p-3 text-red-700">{{ session('error') }}</div>
        @endif
        <div class="bg-white shadow rounded p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium">Placa</label>
                    <input name="plate" value="{{ request('plate') }}" class="w-full rounded-md border-gray-300" placeholder="Buscar placa...">
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-md border-gray-300">
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-red-600 text-white rounded-md">Filtrar</button>
                    <a href="{{ route('formats.vehicle-exit-reports.pending') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Limpiar</a>
                </div>
            </form>
        </div>
        <div class="bg-white shadow rounded p-4 overflow-x-auto">
			<div class="p-6 border-b">
				<p class="text-sm text-gray-600">
					Total (página): {{ $reports->count() }} — Mostrando {{ $reports->firstItem() }} a {{ $reports->lastItem() }} de {{ $reports->total() }}
				</p>
			</div>
            <table class="min-w-full text-sm">
                <thead class="bg-red-600 text-white">
                    <tr class="text-left">
                        <th class="px-3 py-2">Fecha creación</th>
                        <th class="px-3 py-2">Placa</th>
                        <th class="px-3 py-2">Tipo vehículo</th>
                        <th class="px-3 py-2">Evento</th>
                        <th class="px-3 py-2">Guardia</th>
                        <th class="px-3 py-2 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($reports as $r)
                        <tr>
                            <td class="px-3 py-2">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-3 py-2">{{ $r->vehicle->plate ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $r->vehicle_type }}</td>
                            <td class="px-3 py-2">{{ $r->event_type }}</td>
                            <td class="px-3 py-2">{{ $r->guardUser->name ?? '-' }}</td>
                            <td class="px-3 py-2 text-right">
                                <a href="{{ route('formats.vehicle-exit-reports.driver-form', $r) }}" class="text-blue-600 hover:underline">Diligenciar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-gray-500">No tienes informes pendientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout>
