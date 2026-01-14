<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventario por vehículo</h2>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('formats.vehicle-inventories.store') }}" class="space-y-4">
          @csrf
          @include('formats.vehicle-inventories.partials.form', ['vehicles'=>$vehicles,'supplies'=>$supplies])

          <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('formats.vehicle-inventories.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
            <button class="px-4 py-2 rounded bg-red-600 text-white">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
