<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle entrega de turno</h2>
	  <div>
		  <a href="{{ route('formats.vehicle-shift-handoffs.index') }}" class="px-4 py-2 border rounded bg-sky-800 text-white">Volver</a>
		  <a href="{{ route('formats.vehicle-shift-handoffs.edit', $handoff) }}" class="px-4 py-2 bg-red-600 text-white rounded">Editar</a>
	  </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
      @if(session('success'))
        <div class="rounded bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
      @endif

      <div class="bg-white shadow rounded p-6 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div><span class="text-gray-500">Fecha creación:</span> <span class="font-medium">{{ $handoff->created_at->format('Y-m-d H:i') }}</span></div>
          <div><span class="text-gray-500">Usuario:</span> <span class="font-medium">{{ $handoff->creator?->name ?? '—' }}</span></div>
          <div><span class="text-gray-500">Placa:</span> <span class="font-medium">{{ $handoff->vehicle?->plate }}</span></div>
          <div><span class="text-gray-500">Acción:</span> <span class="font-medium">{{ $handoff->action }}</span></div>
          <div><span class="text-gray-500">Tipo:</span> <span class="font-medium">{{ $handoff->vehicle?->vehicle_type }}</span></div>
          <div><span class="text-gray-500">Marca:</span> <span class="font-medium">{{ $handoff->vehicle?->brand }}</span></div>
          <div><span class="text-gray-500">Modelo:</span> <span class="font-medium">{{ $handoff->vehicle?->model }}</span></div>
        </div>

        @if($handoff->notes)
          <div class="text-sm">
            <div class="text-gray-500">Observaciones:</div>
            <div class="mt-1">{{ $handoff->notes }}</div>
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
