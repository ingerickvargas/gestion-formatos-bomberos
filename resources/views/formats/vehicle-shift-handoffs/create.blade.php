<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear entrega de turno</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('formats.vehicle-shift-handoffs.store') }}" class="space-y-4">
                    @csrf
                    @include('formats.vehicle-shift-handoffs.partials.form', ['handoff' => null])
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('formats.vehicle-shift-handoffs.index') }}" class="px-4 py-2 border rounded bg-red-600 text-white">Cancelar</a>
                        <button class="px-4 py-2 bg-sky-800 text-white rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
