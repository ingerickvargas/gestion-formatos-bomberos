@php
    $val = fn($key, $default = '') => old($key, $supply?->{$key} ?? $default);
@endphp

@if($errors->any())
    <div class="p-3 rounded bg-red-50 text-red-700">
        <ul class="list-disc ms-5">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <x-input-label for="name">
    Nombre <span class="text-red-500">*</span>
	</x-input-label>
    <x-text-input
    id="name"
    name="name"
    type="text"
    class="mt-1 block w-full"
    required
    minlength="3"
    placeholder="Nombre del insumo"
    value="{{ $val('name') }}"
/>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @php
    $groupOptions = [
        'EQUIPOS BIOMÉDICOS Y OTROS',
        'PEDIÁTRICO',
        'QUIRÚRGICO',
        'CIRCULATORIO',
        'RESPIRATORIO',
		'DISPOSITIVOS CERVICALES',
        'CILINDROS DE OXÍGENO',
        'ACCESORIOS',
        'BOLSAS',
        'N/A',
    ];

    $selectedGroup = old('group', $supply->group ?? '');
	@endphp

	<div>
		<x-input-label for="group">
			Grupo <span class="text-red-500">*</span>
		</x-input-label>
		<select
			name="group"
			id="group"
			required
			class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
		>
			<option value="">Seleccione un grupo</option>

			@foreach([
				'EQUIPOS BIOMÉDICOS Y OTROS',
				'PEDIÁTRICO',
				'QUIRÚRGICO',
				'CIRCULATORIO',
				'RESPIRATORIO',
				'DISPOSITIVOS CERVICALES',
				'CILINDROS DE OXÍGENO',
				'ACCESORIOS',
				'BOLSAS',
				'N/A'
			] as $group)
				<option value="{{ $group }}" @selected($val('group') === $group)>
					{{ $group }}
				</option>
			@endforeach
		</select>
		<x-input-error :messages="$errors->get('group')" class="mt-2" />
	</div>
    <div>
        <x-input-label for="quantity">
			Cantidad <span class="text-red-500">*</span>
		</x-input-label>
        <x-text-input
		id="quantity"
		name="quantity"
		type="number"
		min="1"
		step="1"
		required
		class="mt-1 block w-full"
		value="{{ $val('quantity') }}"
	/>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Serie</label>
        <input name="serial" value="{{ $val('serial') }}" class="w-full border-gray-300 rounded" />
    </div>

    <div>
        <label class="block text-sm font-medium">Presentación comercial</label>
        <input name="commercial_presentation" value="{{ $val('commercial_presentation') }}" class="w-full border-gray-300 rounded" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Lote</label>
        <input name="batch" value="{{ $val('batch') }}" class="w-full border-gray-300 rounded" />
    </div>

    <div>
        <label class="block text-sm font-medium">Fecha de vencimiento</label>
        <input
			type="date"
			name="expires_at"
			value="{{ old('expires_at', $supply?->expires_at?->format('Y-m-d')) }}"
			class="w-full rounded-md border-gray-300 focus:border-gray-500 focus:ring-gray-500"
		/>
    </div>
</div>

<div>
    <label class="block text-sm font-medium">Laboratorio fabricante</label>
    <input name="manufacturer_lab" value="{{ $val('manufacturer_lab') }}" class="w-full border-gray-300 rounded" />
<div>
    <x-input-label for="invima_registration" value="Registro INVIMA" />
    <x-text-input
        id="invima_registration"
        name="invima_registration"
        type="text"
        class="mt-1 block w-full"
        :value="old('invima_registration', $supply->invima_registration ?? '')"
        placeholder="Ej: 2020DM-0001234"
    />
    <x-input-error :messages="$errors->get('invima_registration')" class="mt-2" />
</div>
</div>
