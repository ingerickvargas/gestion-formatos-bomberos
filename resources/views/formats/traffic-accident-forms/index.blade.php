<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Accidentes de tránsito
                </h2>
                <p class="text-sm text-gray-500">
                    Consulta y gestiona registros por mes, placa y búsqueda.
                </p>
            </div>

            <a href="{{ route('formats.traffic-accident-forms.create') }}"
               class="px-4 py-2 rounded-md bg-red-600 text-white">
                Nuevo
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded p-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded p-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="bg-white shadow rounded p-4">
            <form method="GET" action="{{ route('formats.traffic-accident-forms.index') }}"
                  class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                {{-- Mes --}}
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium">Mes</label>
                    <input
                        type="month"
                        name="filled_month"
                        value="{{ request('filled_month') }}"
                        class="w-full rounded-md border-gray-300"
                    >
                </div>

                {{-- Placa --}}
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium">Placa (vehículo institución)</label>
                    <select name="vehicle_id" class="w-full rounded-md border-gray-300">
                        <option value="">Todas</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" @selected(request('vehicle_id') == $v->id)>
                                {{ $v->plate }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Búsqueda --}}
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium">Buscar (paciente / documento / NUAP)</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Ej: Juan, 12345, NUAP..."
                        class="w-full rounded-md border-gray-300"
                    >
                </div>

                {{-- Botones --}}
                <div class="md:col-span-2 flex gap-2">
                    <button class="px-4 py-2 rounded-md bg-red-600 text-white">
                        Filtrar
                    </button>

                    <a href="{{ route('formats.traffic-accident-forms.index') }}"
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
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3 border-b">Fecha/Hora atención</th>
                            <th class="text-left p-3 border-b">Paciente</th>
                            <th class="text-left p-3 border-b">Documento</th>
                            <th class="text-left p-3 border-b">Prioridad</th>
                            <th class="text-left p-3 border-b">Placa</th>
                            <th class="text-left p-3 border-b">Quien informa</th>
                            <th class="text-left p-3 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($forms as $f)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border-b whitespace-nowrap">
                                    {{ optional($f->attention_date)->format('Y-m-d') ?? '-' }}
                                    <span class="text-gray-500">/</span>
                                    {{ $f->attention_time ?? '-' }}
                                </td>

                                <td class="p-3 border-b">
                                    {{ $f->patient_name ?? '-' }}
                                </td>

                                <td class="p-3 border-b whitespace-nowrap">
                                    {{ $f->patient_doc_type ?? '-' }} {{ $f->patient_doc_number ?? '-' }}
                                </td>

                                <td class="p-3 border-b">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded border">
                                        {{ $f->priority ?? '-' }}
                                    </span>
                                </td>

                                <td class="p-3 border-b whitespace-nowrap">
                                    {{ $f->vehicle->plate ?? '-' }}
                                </td>

                                <td class="p-3 border-b">
                                    {{ $f->informerUser->name ?? '-' }}
                                </td>

                                <td class="p-3 border-b whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('formats.traffic-accident-forms.show', $f) }}"
                                           class="text-blue-600 hover:underline">
                                            Ver
                                        </a>

                                        <a href="{{ route('formats.traffic-accident-forms.edit', $f) }}"
                                           class="text-gray-900 hover:underline">
                                            Editar
                                        </a>
										<a class="text-blue-600 hover:underline"
											 target="_blank"
											 href="{{ route('formats.traffic-accident-forms.export-pdf', $f) }}">
											 PDF
										  </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-500">
                                    No hay registros para los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="p-4">
                {{ $forms->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
