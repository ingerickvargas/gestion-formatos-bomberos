<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Atención a pacientes</h1>
            <a href="{{ route('formats.patient-care-forms.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md">Nuevo</a>
        </div>

        <div class="bg-white shadow rounded p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium">Vehículo</label>
                    <select name="vehicle_id" class="w-full rounded-md border-gray-300">
                        <option value="">Todos</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" @selected(request('vehicle_id') == $v->id)>{{ $v->plate }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Buscar</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Paciente o documento" class="w-full rounded-md border-gray-300" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Mes</label>
                    <input type="month" name="filled_month" value="{{ request('filled_month') }}" class="w-full rounded-md border-gray-300" />
                </div>

                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-red-600 text-white rounded-md">Filtrar</button>
                    <a href="{{ route('formats.patient-care-forms.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Limpiar</a>
                    @php
                        $hasMonth = filled(request('filled_month'));
                    @endphp
                    <a href="{{ $hasMonth ? route('formats.patient-care-forms.export-pdf', request()->query()) : '#' }}" class="px-4 py-2 border rounded-md bg-white hover:bg-gray-50">Exportar</a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow rounded">
			<div class="p-6 border-b">
				<p class="text-sm text-gray-600">
					Total (página): {{ $forms->count() }} — Mostrando {{ $forms->firstItem() }} a {{ $forms->lastItem() }} de {{ $forms->total() }}
				</p>
			</div>
            <table class="min-w-full text-sm">
                <thead class="bg-red-600 text-white">
                    <tr class="text-left">
                        <th class="px-3 py-2">Fecha</th>
                        <th class="px-3 py-2">Paciente</th>
                        <th class="px-3 py-2">Documento</th>
                        <th class="px-3 py-2">Vehículo</th>
                        <th class="px-3 py-2">Usuario</th>
                        <th class="px-3 py-2">Consentimiento</th>
                        <th class="px-3 py-2 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($forms as $f)
                        <tr>
                            <td class="px-3 py-2">{{ optional($f->filled_date)->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">{{ $f->patient_name }}</td>
                            <td class="px-3 py-2">{{ $f->patient_doc_number }}</td>
                            <td class="px-3 py-2">{{ $f->vehicle->plate ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $f->creator->name ?? '-' }}</td>
                            <td class="px-3 py-2">
                                @if($f->attachment_path)
                                    <a href="{{ asset('storage/'.$f->attachment_path) }}" target="_blank" class="inline-flex items-center px-2 py-1 text-xs rounded bg-green-100 text-green-800">Foto adjunta</a>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">No adjunta</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-right">
                                <a class="text-blue-600" href="{{ route('formats.patient-care-forms.show', $f) }}">Ver</a>
                                <span class="mx-2">|</span>
                                <a class="text-red-600" href="{{ route('formats.patient-care-forms.edit', $f) }}">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-gray-500" colspan="7">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $forms->links() }}
    </div>
</x-app-layout>