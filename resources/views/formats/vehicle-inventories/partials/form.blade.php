@php
  $inv = $vehicleInventory ?? null;

  $initialVehicleId = old('vehicle_id', $inv->vehicle_id ?? '');
  $initialDate = old('inventory_date', optional($inv?->inventory_date)->format('Y-m-d') ?? now()->format('Y-m-d'));

  // Mapa inicial: supply_id => {checked, qty}
  $initialItemsMap = [];

  // Si vienes de un validation error (old), intenta reconstruir el mapa
  if (old('items')) {
      foreach (old('items') as $sid => $row) {
          $initialItemsMap[(int)$sid] = [
              'checked' => isset($row['checked']) && $row['checked'],
              'qty'     => $row['quantity'] ?? '',
          ];
      }
  } elseif ($inv) {
      foreach ($inv->items as $it) {
          $initialItemsMap[$it->supply_id] = [
              'checked' => true,
              'qty'     => (int)$it->quantity,
          ];
      }
  }
@endphp

<div
  x-data="{
    vehicleId: '{{ $initialVehicleId }}',
    vehicle: { vehicle_type: '', brand: '', model: '' },

    // objeto por supply_id
    itemsById: {},

    initItems() {
      // 1) crea todos en false
      @foreach($supplies as $s)
        this.itemsById[{{ $s->id }}] = { checked: false, qty: '' };
      @endforeach

      // 2) aplica los guardados (o old)
      const initial = @js($initialItemsMap);
      for (const [sid, data] of Object.entries(initial)) {
        const id = parseInt(sid, 10);
        if (this.itemsById[id]) {
          this.itemsById[id].checked = !!data.checked;
          this.itemsById[id].qty = data.qty ?? '';
        }
      }
    },

    async loadVehicle() {
      if (!this.vehicleId) { this.vehicle = {vehicle_type:'',brand:'',model:''}; return; }
      const res = await fetch('{{ route('formats.vehicles.json', ['vehicle' => '___ID___']) }}'.replace('___ID___', this.vehicleId));
      this.vehicle = await res.json();
    }
  }"
  x-init="initItems(); loadVehicle()"
  class="space-y-4"
>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium">Placa<span class="text-red-500"> *</label>
      <select name="vehicle_id" required class="w-full rounded-md border-gray-300"
              x-model="vehicleId" @change="loadVehicle()">
        <option value="">Seleccione</option>
        @foreach($vehicles as $v)
          <option value="{{ $v->id }}">{{ $v->plate }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Fecha<span class="text-red-500"> *</label>
      <input type="date" name="inventory_date" required
             value="{{ $initialDate }}"
             class="w-full rounded-md border-gray-300">
      @if($errors->has('inventory_date'))
        <div class="text-sm text-red-600 mt-1">{{ $errors->first('inventory_date') }}</div>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium">Tipo</label>
      <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50"
             x-model="vehicle.vehicle_type">
    </div>
    <div>
      <label class="block text-sm font-medium">Marca</label>
      <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50"
             x-model="vehicle.brand">
    </div>
    <div>
      <label class="block text-sm font-medium">Modelo</label>
      <input type="text" readonly class="w-full rounded-md border-gray-300 bg-gray-50"
             x-model="vehicle.model">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium">Observaciones</label>
    <textarea name="notes" rows="2" class="w-full rounded-md border-gray-300">{{ old('notes', $inv->notes ?? '') }}</textarea>
  </div>
  <h3 class="text-lg font-semibold mb-4">Insumos</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-red-600 text-white">
                <tr class="text-left">
                    <th class="px-3 py-2 w-12">+</th>
                    <th class="px-3 py-2">Nombre Insumo</th>
                    <th class="px-3 py-2 w-40">Cantidad</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($supplies as $s)
                    <tr>
                        {{-- CHECK --}}
                        <td class="px-3 py-2">
                            <input
							  type="checkbox"
							  class="rounded border-gray-300"
							  x-model="itemsById[{{ $s->id }}].checked"
							  @change="if(!itemsById[{{ $s->id }}].checked){ itemsById[{{ $s->id }}].qty=''; }"
							  name="items[{{ $s->id }}][checked]"
							  value="1"
							/>
                        </td>

                        {{-- NOMBRE (solo lectura) --}}
                        <td class="px-3 py-2">
                            <span class="text-gray-900">{{ $s->name }}</span>
                        </td>

                        {{-- CANTIDAD (habilita solo si está checked) --}}
                        <td class="px-3 py-2">
                            <input
							  type="number"
							  min="1"
							  step="1"
							  class="w-full rounded-md border-gray-300 focus:border-gray-500 focus:ring-gray-500 disabled:bg-gray-100"
							  :disabled="!itemsById[{{ $s->id }}].checked"
							  :required="itemsById[{{ $s->id }}].checked"
							  x-model="itemsById[{{ $s->id }}].qty"
							  name="items[{{ $s->id }}][quantity]"
							  placeholder="0"
							/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-500 mt-3">
        Marca el insumo para habilitar la cantidad. Al desmarcar, la cantidad se limpia.
    </p>
</div>


  @if ($errors->any())
    <div class="rounded bg-red-50 p-3 text-sm text-red-700">
      <ul class="list-disc ms-5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
</div>
