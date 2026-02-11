<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Insumos
            </h2>
            <a href="{{ route('admin.supplies.create') }}"
               class="px-4 py-2 bg-red-600 text-white rounded-md text-sm">
                Nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
			@if(!empty($hasReds))
				<div class="mb-4 rounded-md border border-red-200 bg-red-50 p-4 text-red-800">
					<div class="font-semibold">Atención</div>
					<div class="text-sm">
						Hay insumos en <b>rojo</b> (vencidos o con vencimiento menor a 3 meses). Revisa el listado o filtra por <b>Rojo</b>.
					</div>
				</div>
			@endif
            <div class="bg-white shadow rounded p-4 mb-4">
                <form method="GET" class="flex flex-col gap-3 md:flex-row md:items-center">
					<div class="flex-1">
						<input name="search"
							   value="{{ request('search') }}"
							   placeholder="Buscar por nombre, grupo, serie o lote"
							   class="w-full rounded-md border-gray-300" />
					</div>
					<div class="w-full md:w-64">
						<select name="semaforo" class="w-full rounded-md border-gray-300">
							<option value="">Semáforo: Todos</option>
							<option value="green"  @selected(request('semaforo')==='green')>Verde</option>
							<option value="yellow" @selected(request('semaforo')==='yellow')>Amarillo</option>
							<option value="red"    @selected(request('semaforo')==='red')>Rojo</option>
						</select>
					</div>
					<div class="flex gap-2">
						<button class="px-4 py-2 bg-red-600 text-white rounded-md">Filtrar</button>
						<a href="{{ route('admin.supplies.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Limpiar</a>
						<a href="{{ route('admin.supplies.export', request()->query()) }}" class="px-4 py-2 border rounded-md bg-white hover:bg-gray-50">Exportar</a>
					</div>
				</form>
            </div>

            <div class="bg-white shadow rounded">
                <div class="overflow-x-auto">
					<div class="p-6 border-b">
						<p class="text-sm text-gray-600">
							Total (página): {{ $supplies->count() }} — Mostrando {{ $supplies->firstItem() }} a {{ $supplies->lastItem() }} de {{ $supplies->total() }}
						</p>
					</div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-600 text-white">
                            <tr>
                                <th class="text-left p-3">Nombre</th>
                                <th class="text-left p-3">Grupo</th>
                                <th class="text-left p-3">Cantidad</th>
                                <th class="text-left p-3">Lote</th>
                                <th class="text-left p-3">Vence</th>
								<th class="px-4 py-2">Semáforo</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($supplies as $s)
                            <tr class="border-t">
                                <td class="p-3">{{ $s->name }}</td>
                                <td class="p-3">{{ $s->group ?? '—' }}</td>
                                <td class="p-3">{{ $s->quantity }}</td>
                                <td class="p-3">{{ $s->batch ?? '—' }}</td>
								<td class="p-3">{{ $s->expires_at?->format('Y-m-d') ?? '—' }}</td>
								<td class="px-4 py-2 text-center">
									<span
										class="
											inline-block w-10 h-4
											@if($s->semaphore === 'green') bg-green-500
											@elseif($s->semaphore === 'yellow') bg-yellow-400
											@elseif($s->semaphore === 'red') bg-red-500
											@else bg-gray-300
											@endif
										"
										title="
											@if($s->semaphore === 'green') Vence en más de 12 meses
											@elseif($s->semaphore === 'yellow') Vence entre 3 y 12 meses
											@elseif($s->semaphore === 'red') Vence en menos de 3 meses
											@else Sin fecha de vencimiento
											@endif
										"
									></span>
								</td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.supplies.edit', $s) }}" class="text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('admin.supplies.destroy', $s) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Eliminar este insumo?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline ms-3" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-3" colspan="6">No hay insumos registrados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $supplies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
