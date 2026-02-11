<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Nuevo Formulario - Autopistas del Café</h2>
                <p class="text-sm text-gray-500">Crea un registro con vehículos y acompañantes.</p>
            </div>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-sky-800 text-white rounded-md">Volver</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-4">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded p-4">
                <div class="font-semibold mb-2">Hay errores en el formulario:</div>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('formats.autopistas-cafe-forms.store') }}" class="space-y-6">
            @csrf

            @include('formats.autopistas-cafe-forms.partials.form', [
                'isEdit' => false,
                'form' => null,
                'vehicles' => $vehicles,
            ])

            <div class="flex justify-end gap-2">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-sky-800 text-white rounded-md">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
