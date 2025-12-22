<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Logs de Acceso
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Evento</label>
                        <select name="event" class="mt-1 w-full rounded-md border-gray-300">
                            <option value="">Todos</option>
                            @foreach($events as $key => $label)
                                <option value="{{ $key }}" @selected(request('event') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" name="email" value="{{ request('email') }}"
                               class="mt-1 w-full rounded-md border-gray-300"
                               placeholder="admin@bomberos.local">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">IP</label>
                        <input type="text" name="ip" value="{{ request('ip') }}"
                               class="mt-1 w-full rounded-md border-gray-300"
                               placeholder="127.0.0.1">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Desde</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                               class="mt-1 w-full rounded-md border-gray-300">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Hasta</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                               class="mt-1 w-full rounded-md border-gray-300">
                    </div>

                    <div class="md:col-span-6 flex items-center gap-3 mt-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-800">
                            Filtrar
                        </button>

                        <a href="{{ route('admin.access-logs.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-900 rounded-md hover:bg-gray-300">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <p class="text-sm text-gray-600">
                        Total (página): {{ $logs->count() }} — Mostrando {{ $logs->firstItem() }} a {{ $logs->lastItem() }} de {{ $logs->total() }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="text-left px-4 py-3">Fecha</th>
                                <th class="text-left px-4 py-3">Evento</th>
                                <th class="text-left px-4 py-3">Resultado</th>
                                <th class="text-left px-4 py-3">Usuario</th>
                                <th class="text-left px-4 py-3">Email</th>
                                <th class="text-left px-4 py-3">IP</th>
                                <th class="text-left px-4 py-3">Motivo</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-md bg-gray-100 text-gray-800">
                                            {{ $events[$log->event] ?? $log->event }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($log->success)
                                            <span class="px-2 py-1 rounded-md bg-green-100 text-green-800">Éxito</span>
                                        @else
                                            <span class="px-2 py-1 rounded-md bg-red-100 text-red-800">Fallido</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $log->user?->name ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $log->email ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $log->ip ?? '—' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $log->failure_reason ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                        No hay registros con los filtros aplicados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
