@php
    $r = $record;
    $initialVehicleId = old('vehicle_id', $r->vehicle_id ?? '');
    $selectedAreas = old('areas', $r->areas ?? []);
@endphp
<div x-data="{ vehicleId: '{{ $initialVehicleId }}', vehicle: { vehicle_type: '', brand: '', model: '' }, async loadVehicle() { if (!this.vehicleId) { this.vehicle = {vehicle_type:'',brand:'',model:''}; return; } const res = await fetch('{{ route('formats.vehicles.json', ['vehicle' => '___ID___']) }}'.replace('___ID___', this.vehicleId)); this.vehicle = await res.json(); }, }" x-init="loadVehicle()" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Placa <span class="text-red-500">*</span></label>
            <select name="vehicle_id" required class="w-full rounded-md border-gray-300" x-model="vehicleId" @change="loadVehicle()">
                <option value="">Seleccione</option>
                @foreach($vehicles as $v)
                    <option value="{{ $v->id }}">{{ $v->plate }}</option>
                @endforeach
            </select>
            @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Tipo de aseo <span class="text-red-500">*</span></label>
            <select name="cleaning_type" required class="w-full rounded-md border-gray-300">
                <option value="">Seleccione</option>
                <option value="RUTINIA" @selected(old('cleaning_type', $r->cleaning_type ?? '')==='RUTINIA')>RUTINIA</option>
                <option value="TERMINAL" @selected(old('cleaning_type', $r->cleaning_type ?? '')==='TERMINAL')>TERMINAL</option>
            </select>
            @error('cleaning_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">Tipo vehículo</label>
            <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50" x-model="vehicle.vehicle_type">
        </div>
        <div>
            <label class="block text-sm font-medium">Marca</label>
            <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50" x-model="vehicle.brand">
        </div>
        <div>
            <label class="block text-sm font-medium">Modelo</label>
            <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50" x-model="vehicle.model">
        </div>
    </div>
    <div class="bg-white border rounded p-4">
        <h3 class="font-semibold mb-3">Checklist de aseo</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            @foreach($areaOptions as $area)
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300" name="areas[]" value="{{ $area }}" @checked(in_array($area, $selectedAreas))>
                    <span>{{ $area }}</span>
                </label>
            @endforeach
        </div>
        @error('areas') <div class="text-sm text-red-600 mt-2">{{ $message }}</div> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Observaciones</label>
        <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300">{{ old('notes', $r->notes ?? '') }}</textarea>
        @error('notes') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>
    @if($r)
        <div class="text-xs text-gray-500">Registrado por: <b>{{ $r->creator?->name ?? '-' }}</b> · {{ $r->created_at->format('Y-m-d H:i') }}</div>
    @endif
</div>
