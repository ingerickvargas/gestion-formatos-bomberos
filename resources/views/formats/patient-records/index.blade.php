<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de pacientes</h2>
            <a href="{{ route('formats.patient-records.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md">Nuevo</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
            @endif
            <div class="bg-white shadow rounded p-4">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium">Tipo</label>
                        <select name="tipo_formato" class="w-full rounded-md border-gray-300">
                            <option value="">Todos</option>
                            @foreach(['ANCIANATO','ALCALDIA','BOMBEROS'] as $t)
                                <option value="{{ $t }}" @selected(request('tipo_formato')===$t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Buscar</label>
                        <input name="search" value="{{ request('search') }}" class="w-full rounded-md border-gray-300" placeholder="Paciente o documento" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mes</label>
                        <input type="month" name="month" value="{{ request('month') }}" class="w-full rounded-md border-gray-300" />
                    </div>
                    @php
                        $qs = request()->query();
                        $hasMonth = filled(request('month'));
                    @endphp
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-red-600 text-white rounded-md w-32">Filtrar</button>
                        <a href="{{ route('formats.patient-records.index') }}" class="px-4 py-2 border rounded-md w-32 text-center bg-sky-800 text-white">Limpiar</a>
                        <div x-data="{ open: false }" class="relative">
                            <button type="button" @click="open = !open" @click.away="open = false" class="px-4 py-2 rounded-md border bg-white hover:bg-gray-50 flex items-center gap-2" {{ $hasMonth ? '' : 'disabled' }}>PDF <span>▼</span></button>
                            <div x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-56 bg-white border rounded-md shadow z-50 overflow-hidden">
                                <a class="block px-4 py-2 hover:bg-gray-50" href="{{ route('formats.patient-records.export-pdf', array_merge($qs, ['export_format'=>'ALCALDIA'])) }}">Formato Alcaldía</a>
                                <a class="block px-4 py-2 hover:bg-gray-50" href="{{ route('formats.patient-records.export-pdf', array_merge($qs, ['export_format'=>'BOMBEROS'])) }}">Formato Bomberos</a>
                                <a class="block px-4 py-2 hover:bg-gray-50" href="{{ route('formats.patient-records.export-pdf', array_merge($qs, ['export_format'=>'ANCIANATO'])) }}">Formato Ancianato</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-white shadow rounded p-4 overflow-x-auto">
				<div class="p-6 border-b">
                    <p class="text-sm text-gray-600">
                        Total (página): {{ $records->count() }} — Mostrando {{ $records->firstItem() }} a {{ $records->lastItem() }} de {{ $records->total() }}
                    </p>
                </div>
                <table class="min-w-full text-sm">
                    <thead class="bg-red-600 text-white">
                        <tr class="text-left">
                            <th class="px-3 py-2">Fecha/Hora</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Paciente/Beneficiario</th>
                            <th class="px-3 py-2">Documento</th>
                            <th class="px-3 py-2">Usuario</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($records as $r)
                            <tr>
                                <td class="px-3 py-2">
                                    <div class="font-medium">{{ optional($r->service_date)->format('Y-m-d') ?? $r->created_at->format('Y-m-d') }}</div>
                                    <div class="text-gray-500">{{ $r->service_time ?? $r->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-semibold {{ $r->tipo_formato==='ALCALDIA' ? 'bg-blue-50 text-blue-700' : '' }} {{ $r->tipo_formato==='ANCIANATO' ? 'bg-green-50 text-green-700' : '' }} {{ $r->tipo_formato==='BOMBEROS' ? 'bg-yellow-50 text-yellow-700' : '' }}">{{ $r->tipo_formato }}</span>
                                </td>
                                <td class="px-3 py-2">{{ $r->patient_name }}</td>
                                <td class="px-3 py-2">{{ $r->document }}</td>
                                <td class="px-3 py-2">{{ $r->creator?->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-right whitespace-nowrap">
                                    <a class="text-blue-600 hover:underline" href="{{ route('formats.patient-records.show', $r) }}">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-3 py-6 text-center text-gray-500" colspan="6">No hay registros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $records->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
