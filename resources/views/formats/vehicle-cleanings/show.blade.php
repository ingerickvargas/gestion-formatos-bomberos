<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aseo de vehículo</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6 space-y-3">
        <div class="text-sm text-gray-500">
          {{ $vehicleCleaning->created_at->format('Y-m-d H:i') }} · {{ $vehicleCleaning->creator?->name ?? '-' }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div><div class="text-xs text-gray-500">Placa</div><div class="font-semibold">{{ $vehicleCleaning->vehicle->plate }}</div></div>
          <div><div class="text-xs text-gray-500">Tipo vehículo</div><div class="font-semibold">{{ $vehicleCleaning->vehicle->vehicle_type }}</div></div>
          <div><div class="text-xs text-gray-500">Aseo</div><div class="font-semibold">{{ $vehicleCleaning->cleaning_type }}</div></div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Checklist</div>
          <div class="mt-1 flex flex-wrap gap-2">
            @foreach(($vehicleCleaning->areas ?? []) as $a)
              <span class="px-2 py-1 rounded bg-gray-100 text-gray-800 text-xs">{{ $a }}</span>
            @endforeach
            @if(empty($vehicleCleaning->areas))
              <span class="text-sm text-gray-500">Sin selección</span>
            @endif
          </div>
        </div>

        <div>
          <div class="text-xs text-gray-500">Observaciones</div>
          <div class="mt-1">{{ $vehicleCleaning->notes ?: '—' }}</div>
        </div>

        <div class="flex justify-end gap-2">
          <a href="{{ route('formats.vehicle-cleanings.index') }}" class="px-4 py-2 border rounded bg-sky-800 text-white">Volver</a>
          <a href="{{ route('formats.vehicle-cleanings.edit',$vehicleCleaning) }}" class="px-4 py-2 bg-red-600 text-white rounded">Editar</a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
