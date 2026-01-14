<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar entrega de turno</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('formats.vehicle-shift-handoffs.update', $handoff) }}" class="space-y-4">
          @csrf
          @method('PUT')

          @include('formats.vehicle-shift-handoffs.partials.form', ['handoff' => $handoff])

          <div class="flex justify-end gap-2">
            <a href="{{ route('formats.vehicle-shift-handoffs.index', $handoff) }}" class="px-4 py-2 border rounded bg-sky-800 text-white">Cancelar</a>
            <button class="px-4 py-2 bg-red-600 text-white rounded">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
