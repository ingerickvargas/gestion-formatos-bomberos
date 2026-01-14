@php
  $handoff = $handoff ?? null;
  $initialVehicleId = old('vehicle_id', $handoff->vehicle_id ?? '');
@endphp

<div
  x-data="{
    vehicleId: '{{ $initialVehicleId }}',
    vehicle: { vehicle_type: '', brand: '', model: '' },

    async loadVehicle() {
      if (!this.vehicleId) { this.vehicle = {vehicle_type:'',brand:'',model:''}; return; }
      const res = await fetch('{{ route('formats.vehicles.json', ['vehicle' => '___ID___']) }}'.replace('___ID___', this.vehicleId));
      this.vehicle = await res.json();
    }
  }"
  x-init="loadVehicle()"
  class="space-y-4"
>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium">Placa<span class="text-red-500">*</span></label>
      <select name="vehicle_id" required class="w-full rounded-md border-gray-300"
              x-model="vehicleId" @change="loadVehicle()">
        <option value="">Seleccione</option>
        @foreach($vehicles as $v)
          <option value="{{ $v->id }}">{{ $v->plate }}</option>
        @endforeach
      </select>
      @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium">Acción<span class="text-red-500">*</span></label>
      <select name="action" required class="w-full rounded-md border-gray-300">
        <option value="">Seleccione</option>
        <option value="ENTREGA" @selected(old('action', $handoff->action ?? '')==='ENTREGA')>Entregar turno</option>
        <option value="RECIBE"  @selected(old('action', $handoff->action ?? '')==='RECIBE')>Recibir turno</option>
      </select>
      @error('action') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
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

  <div>
    <label class="block text-sm font-medium">Observaciones</label>
    <textarea name="notes" rows="2" class="w-full rounded-md border-gray-300">{{ old('notes', $handoff->notes ?? '') }}</textarea>
    @error('notes') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
  </div>

  @if ($errors->any())
    <div class="rounded bg-red-50 p-3 text-sm text-red-700">
      <ul class="list-disc ms-5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
</div>
