<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear accidente de tránsito</h2>
                <p class="text-sm text-gray-500">Diligencia el formulario completo y guarda.</p>
            </div>
            <a href="{{ route('formats.traffic-accident-forms.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Volver</a>
        </div>
    </x-slot>
    <div class="space-y-4">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded p-3">
                <div class="font-semibold mb-1">Hay errores en el formulario:</div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('formats.traffic-accident-forms.store') }}" class="space-y-6">
            @csrf
            @include('formats.traffic-accident-forms.partials.form')
            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('formats.traffic-accident-forms.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Cancelar</a>
                <button type="submit" class="px-5 py-2 rounded-md bg-red-600 text-white">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
