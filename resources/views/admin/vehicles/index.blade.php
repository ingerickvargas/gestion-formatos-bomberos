<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vehículos</h2>
      <a href="{{ route('admin.vehicles.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md">
        Nuevo
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

      @if(session('success'))
        <div class="rounded bg-green-50 p-3 text-green-700 text-sm">{{ session('success') }}</div>
      @endif

      <div class="bg-white shadow rounded p-4">
        <form class="flex gap-2 flex-wrap">
          <input name="search" value="{{ request('search') }}"
                 placeholder="Buscar por placa, marca, seguro..."
                 class="flex-1 min-w-[240px] rounded-md border-gray-300" />

          <select name="vehicle_type" class="rounded-md border-gray-300">
            <option value="">Todos los tipos</option>
            @foreach(config('vehicles.types') as $key => $label)
              <option value="{{ $key }}" @selected(request('vehicle_type')==$key)>{{ $label }}</option>
            @endforeach
          </select>

          <button class="px-4 py-2 rounded bg-red-600 text-white">Filtrar</button>
          <a class="px-4 py-2 rounded border bg-sky-800 text-white" href="{{ route('admin.vehicles.index') }}">Limpiar</a>
        </form>
      </div>

      <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">
          <thead class="bg-red-600 text-white text-left">
            <tr>
              <th class="p-3">Placa</th>
              <th class="p-3">Tipo</th>
              <th class="p-3">Marca</th>
              <th class="p-3">Modelo</th>
              <th class="p-3">Vence seguro</th>
              <th class="p-3">Vence tecno</th>
              <th class="p-3 text-right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vehicles as $v)
              <tr class="border-t">
                <td class="p-3 font-medium">{{ $v->plate }}</td>
                <td class="p-3">{{ config('vehicles.types')[$v->vehicle_type] ?? $v->vehicle_type }}</td>
                <td class="p-3">{{ $v->brand }}</td>
                <td class="p-3">{{ $v->model }}</td>
                <td class="p-3">{{ optional($v->insurance_expires_at)->format('Y-m-d') ?? '—' }}</td>
                <td class="p-3">{{ optional($v->tech_review_expires_at)->format('Y-m-d') ?? '—' }}</td>
                <td class="p-3 text-right">
                  <a class="text-blue-600" href="{{ route('admin.vehicles.edit', $v) }}">Editar</a>
                  <form class="inline" method="POST" action="{{ route('admin.vehicles.destroy', $v) }}"
                        onsubmit="return confirm('¿Eliminar vehículo?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 ms-3" type="submit">Eliminar</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td class="p-3" colspan="7">No hay vehículos registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div>{{ $vehicles->links() }}</div>
    </div>
  </div>
</x-app-layout>
