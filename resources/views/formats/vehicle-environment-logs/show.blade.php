<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle registro</h2>
	  <div>
	  <a href="{{ route('formats.vehicle-environment-logs.index') }}" class="px-4 py-2 border rounded bg-sky-800 text-white">Volver</a>
      <a href="{{ route('formats.vehicle-environment-logs.edit', $log) }}" class="px-4 py-2 bg-red-600 text-white rounded">Editar</a>
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
          <div><span class="text-gray-500">Placa:</span> <span class="font-medium">{{ $log->vehicle?->plate }}</span></div>
          <div><span class="text-gray-500">Fecha y hora:</span> <span class="font-medium">{{ $log->logged_at->format('Y-m-d H:i') }}</span></div>
          <div><span class="text-gray-500">Tipo:</span> <span class="font-medium">{{ $log->vehicle?->vehicle_type }}</span></div>
          <div><span class="text-gray-500">Usuario:</span> <span class="font-medium">{{ $log->creator?->name ?? '—' }}</span></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="p-4 rounded border">
            <div class="text-sm text-gray-500">Temperatura</div>
            <div class="text-2xl font-semibold">{{ number_format((float)$log->temperature, 1) }} °C</div>
          </div>
          <div class="p-4 rounded border">
            <div class="text-sm text-gray-500">Humedad</div>
            <div class="text-2xl font-semibold">{{ $log->humidity }} %</div>
          </div>
        </div>

        <div class="text-xs text-gray-500">
          Creado: {{ $log->created_at->format('Y-m-d H:i') }} · Actualizado: {{ $log->updated_at->format('Y-m-d H:i') }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
