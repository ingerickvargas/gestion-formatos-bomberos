<x-app-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Editar formulario atención</h1>
        </div>

        @if(session('success'))
            <div class="rounded bg-green-50 p-3 text-green-700">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="rounded bg-red-50 p-3 text-red-700">
                <ul class="list-disc ms-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('formats.patient-care-forms.update', $form) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold">Adjunto (imagen)</h2>
                    @if($form->attachment_path)
                        <form method="POST" action="{{ route('formats.patient-care-forms.attachment.delete', $form) }}">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 border rounded-md bg-red-600 text-white" type="submit">Quitar imagen</button>
                        </form>
                    @endif
                </div>

                @if($form->attachment_path)
                    <div class="text-sm">
                        <a class="underline" href="{{ route('formats.patient-care-forms.attachment', $form) }}">Descargar imagen actual</a>
                    </div>
                    <div class="mt-2">
                        <img src="{{ Storage::url($form->attachment_path) }}" alt="Adjunto" style="max-height: 240px; border:1px solid #ddd; border-radius:8px;" />
                    </div>
                @else
                    <div class="text-sm text-gray-500">No hay imagen adjunta.</div>
                @endif

                <div>
                    <label class="block text-sm font-medium">Subir nueva imagen</label>
                    <input type="file" name="attachment" accept="image/*" class="w-full rounded-md border-gray-300" />
                    <div class="text-xs text-gray-500 mt-1">Formatos: JPG/PNG/WEBP. Máx 4MB.</div>
                    @error('attachment')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('formats.patient-care-forms.partials.form', ['form' => $form])

            <div class="flex justify-end gap-2">
                <a href="{{ route('formats.patient-care-forms.index', $form) }}" class="px-4 py-2 border rounded-md bg-sky-800 text-white">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
