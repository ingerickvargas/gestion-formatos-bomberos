<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear insumo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                <form method="POST" action="{{ route('admin.supplies.store') }}" class="space-y-4">
                    @csrf

                    @include('admin.supplies.partials.form', ['supply' => null])

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.supplies.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
                        <button class="px-4 py-2 bg-red-600 text-white rounded">Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
