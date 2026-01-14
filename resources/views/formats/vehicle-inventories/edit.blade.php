<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar inventario</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('formats.vehicle-inventories.update', $vehicleInventory) }}">
          @csrf
          @method('PUT')

          @include('formats.vehicle-inventories.partials.form', [
            'vehicleInventory'=>$vehicleInventory,
            'vehicles'=>collect([$vehicleInventory->vehicle]), // no cambiar placa en edit
            'supplies'=>$supplies,
			'items' => $items, 
          ])

          <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('formats.vehicle-inventories.show', $vehicleInventory) }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
            <button class="px-4 py-2 rounded bg-red-600 text-white">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
