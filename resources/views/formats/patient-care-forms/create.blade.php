<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Formulario atención a pacientes</h1>
        </div>

        <form method="POST" action="{{ route('formats.patient-care-forms.store') }}" class="space-y-4">
            @csrf
            @include('formats.patient-care-forms.partials.form')
            <div class="flex justify-end gap-2">
                <a href="{{ route('formats.patient-care-forms.index') }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Cancelar</a>
                <button class="px-4 py-2 bg-red-600 text-white rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
