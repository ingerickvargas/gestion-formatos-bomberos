@php
    $log = $log ?? null;
    $initialVehicleId = old('vehicle_id', $log->vehicle_id ?? '');
    $initialLoggedAt = old('logged_at', optional($log?->logged_at)->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'));
@endphp
<div x-data="{ vehicleId: '{{ $initialVehicleId }}', vehicle: { vehicle_type: '', brand: '', model: '' }, async loadVehicle() { if (!this.vehicleId) { this.vehicle = {vehicle_type:'',brand:'',model:''}; return; } const res = await fetch('{{ route('formats.vehicles.json', ['vehicle' => '___ID___']) }}'.replace('___ID___', this.vehicleId)); this.vehicle = await res.json(); } }" x-init="loadVehicle()" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Placa<span class="text-red-500">*</span></label>
            <select name="vehicle_id" required class="w-full rounded-md border-gray-300" x-model="vehicleId" @change="loadVehicle()">
                <option value="">Seleccione</option>
                @foreach($vehicles as $v)
                    <option value="{{ $v->id }}">{{ $v->plate }}</option>
                @endforeach
            </select>
            @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Fecha y hora<span class="text-red-500">*</span></label>
            <input type="datetime-local" name="logged_at" required value="{{ $initialLoggedAt }}" class="w-full rounded-md border-gray-300">
            @error('logged_at') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">Tipo</label>
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Temperatura (°C)<span class="text-red-500">*</span></label>
            <input type="number" name="temperature" required step="0.1" inputmode="decimal" value="{{ old('temperature', $log->temperature ?? '') }}" class="w-full rounded-md border-gray-300" placeholder="Ej: 36.5">
            @error('temperature') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Humedad (%)<span class="text-red-500">*</span></label>
            <input type="number" name="humidity" required min="0" max="100" step="1" value="{{ old('humidity', $log->humidity ?? '') }}" class="w-full rounded-md border-gray-300" placeholder="0 - 100">
            @error('humidity') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
    @if ($errors->any())
        <div class="rounded bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc ms-5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif
</div>
