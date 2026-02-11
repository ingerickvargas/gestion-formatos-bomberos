<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Formulario - Autopistas del Café</h2>
                <p class="text-sm text-gray-500">Listado de registros creados.</p>
            </div>

            <a href="{{ route('formats.autopistas-cafe-forms.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md">
                Nuevo
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-4">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-4">
            <form method="GET" action="{{ route('formats.autopistas-cafe-forms.index') }}"
                  class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium">Placa</label>
                    <select name="plate" class="w-full rounded-md border-gray-300">
                        <option value="">Todas</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" @selected($plate == $v->id)>{{ $v->plate }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" name="date" value="{{ $date }}"
                           class="w-full rounded-md border-gray-300">
                </div>

                <div class="md:col-span-5 flex gap-2 justify-start md:justify-end">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Filtrar</button>

                    <a href="{{ route('formats.autopistas-cafe-forms.index') }}" class="px-4 py-2 bg-sky-800 text-white rounded-md">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow rounded overflow-hidden">
            <div class="p-4 text-sm text-gray-600">
                Total (página): {{ $forms->count() }} — Mostrando {{ $forms->firstItem() ?? 0 }} a {{ $forms->lastItem() ?? 0 }} de {{ $forms->total() }}
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-red-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Placa</th>
                            <th class="px-4 py-3 text-left">Evento</th>
                            <th class="px-4 py-3 text-left">Kilómetro</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($forms as $f)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $f->id }}</td>
                                <td class="px-4 py-3">
                                    {{ $f->event_date ? \Illuminate\Support\Carbon::parse($f->event_date)->format('Y-m-d') : '' }}
                                </td>
                                <td class="px-4 py-3">{{ $f->vehicle?->plate }}</td>
                                <td class="px-4 py-3">{{ $f->event }}</td>
                                <td class="px-4 py-3">{{ $f->kilometer }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3">
                                        <a class="text-blue-600 hover:underline"
                                           href="{{ route('formats.autopistas-cafe-forms.show', $f) }}">
                                            Ver
                                        </a>
                                        <a class="text-red-600 hover:underline"
                                           href="{{ route('formats.autopistas-cafe-forms.edit', $f) }}">
                                            Editar
                                        </a>
                                        <a class="text-gray-700 hover:underline"
                                           href="{{ route('formats.autopistas-cafe-forms.pdf', $f) }}">
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No hay registros con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $forms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
