<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear vehículo</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('admin.vehicles.store') }}" class="space-y-4">
          @csrf
          @include('admin.vehicles.partials.form', ['vehicle' => null, 'types' => $types])

          <div class="flex justify-end gap-2">
            <a href="{{ route('admin.vehicles.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
            <button class="px-4 py-2 rounded bg-red-600 text-white">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
