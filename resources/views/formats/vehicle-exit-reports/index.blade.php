<x-app-layout>
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold">Informe de salida vehicular</h1>
      <p class="text-sm text-gray-500">Creados por el guardia y completados por el conductor.</p>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('formats.vehicle-exit-reports.create') }}"
         class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-gray-800">
        Nuevo
      </a>
      <a href="{{ route('formats.vehicle-exit-reports.pending') }}"
         class="px-4 py-2 bg-sky-800 text-white border rounded-md hover:bg-gray-50">
        Pendientes
      </a>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
      <div>
        <label class="block text-sm font-medium">Placa</label>
        <input name="plate" value="{{ request('plate') }}"
               class="w-full rounded-md border-gray-300"
               placeholder="Ej: DEP602">
      </div>
      <div>
        <label class="block text-sm font-medium">Estado</label>
        <select name="status" class="w-full rounded-md border-gray-300">
          <option value="">Todos</option>
          <option value="PENDING_DRIVER" @selected(request('status')==='PENDING_DRIVER')>Pendiente conductor</option>
          <option value="COMPLETED" @selected(request('status')==='COMPLETED')>Completado</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Desde</label>
        <input type="date" name="from" value="{{ request('from') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Hasta</label>
        <input type="date" name="to" value="{{ request('to') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div class="flex gap-2">
        <button class="px-4 py-2 bg-red-600 text-white rounded-md w-32">Filtrar</button>
        <a href="{{ route('formats.vehicle-exit-reports.index') }}"
           class="px-4 py-2 border rounded-md w-32 bg-sky-800 text-white">
          Limpiar
        </a>
      </div>
    </form>
  </div>
  <div class="bg-white shadow rounded overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-red-600 text-white">
          <tr>
            <th class="px-4 py-3 w-44">Fecha creación</th>
            <th class="px-4 py-3">Vehículo</th>
            <th class="px-4 py-3">Evento</th>
            <th class="px-4 py-3">Ubicación</th>
            <th class="px-4 py-3">Guardia</th>
            <th class="px-4 py-3">Conductor</th>
            <th class="px-4 py-3 w-44">Estado</th>
            <th class="px-4 py-3 w-40 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($reports as $r)
            <tr>
              <td class="px-4 py-3">
                <div class="font-medium">{{ optional($r->created_at)->format('Y-m-d') }}</div>
                <div class="text-gray-500">{{ optional($r->created_at)->format('H:i') }}</div>
              </td>
              <td class="px-4 py-3">
                <div class="font-medium">
                  {{ $r->vehicle?->plate ?? '—' }}
                </div>
                <div class="text-gray-500">
                  {{ $r->vehicle_type ?? '—' }}
                </div>
              </td>
              <td class="px-4 py-3">
                <div class="font-medium">{{ $r->event_type ?? '—' }}</div>
                <div class="text-gray-500">
                  Salida: {{ $r->departure_time ? \Illuminate\Support\Carbon::parse($r->departure_time)->format('H:i') : '—' }}
                </div>
              </td>
              <td class="px-4 py-3">
                <div class="font-medium">{{ $r->city ?? '—' }}</div>
                <div class="text-gray-500">
                  {{ $r->neighborhood ?? $r->vereda ?? '—' }}
                </div>
              </td>
              <td class="px-4 py-3">
                {{ $r->guardUser?->name ?? '—' }}
              </td>
              <td class="px-4 py-3">
                {{ $r->driverUser?->name ?? '—' }}
              </td>
              <td class="px-4 py-3">
                @php
                  $status = $r->status ?? '';
                @endphp
                @if($status === 'COMPLETED')
                  <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-800 text-xs font-medium">
                    Completado
                  </span>
                  <div class="text-xs text-gray-500 mt-1">
                    Conductor: {{ $r->driver_completed_at ? \Illuminate\Support\Carbon::parse($r->driver_completed_at)->format('Y-m-d H:i') : '—' }}
                  </div>
                @else
                  <span class="inline-flex items-center px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">
                    Pendiente conductor
                  </span>
                  <div class="text-xs text-gray-500 mt-1">
                    Guardia: {{ $r->guard_completed_at ? \Illuminate\Support\Carbon::parse($r->guard_completed_at)->format('Y-m-d H:i') : '—' }}
                  </div>
                @endif
              </td>
              <td class="px-4 py-3 text-right">
                <div class="flex justify-end gap-3">
                  <a href="{{ route('formats.vehicle-exit-reports.show', $r) }}"
                     class="text-blue-600 hover:underline">
                    Ver
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                No hay registros con los filtros actuales.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    @if(method_exists($reports, 'links'))
      <div class="px-4 py-3 border-t">
        {{ $reports->appends(request()->query())->links() }}
      </div>
    @endif
  </div>
</div>
</x-app-layout>
