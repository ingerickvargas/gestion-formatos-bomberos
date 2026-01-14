<x-app-layout>
@php
    $vehiclesJson = $vehicles->map(fn($v) => [
        'id' => $v->id,
        'plate' => $v->plate,
        'vehicle_type' => $v->vehicle_type,
        'insurance_expires_at' => optional($v->insurance_expires_at)->format('Y-m-d'),
        'tech_review_expires_at' => optional($v->tech_review_expires_at)->format('Y-m-d'),
    ]);

    $driversJson = $drivers->map(fn($u) => [
        'id' => $u->id,
        'name' => $u->name,
        'document' => $u->document,
    ]);

    $licenseCategories = ['A1','A2','B1','B2','B3','C1','C2','C3'];

    $modules = [
        'kit_emergency' => [
            'title' => 'Kit de emergencia',
            'obs' => 'kit_observations',
            'items' => [
                'llanta_repuesto' => 'Llanta de repuesto',
                'botiquin' => 'Botiquín de emergencia',
                'gato' => 'Herramienta tipo gato',
                'cono_senalizacion' => 'Cono de señalización',
                'maleta_herramientas' => 'Maleta de herramientas básicas',
                'chalecos_reflectivos' => 'Chalecos reflectivos',
                'extintor' => 'Extintor',
                'cruceta' => 'Cruceta',
                'tacos' => 'Tacos',
                'cables_inicio' => 'Cables de inicio',
            ],
        ],
        'lights' => [
            'title' => 'Luces',
            'obs' => 'lights_observations',
            'items' => [
                'bajas' => 'Bajas',
                'altas' => 'Altas',
                'direccionales' => 'Direccionales',
                'estacionarias' => 'Estacionarias',
                'reversa' => 'Reversa',
                'stop' => 'Stop',
                'rutilantes' => 'Rutilantes de emergencias rojas y blancas',
            ],
        ],
        'brakes' => [
            'title' => 'Frenos',
            'obs' => 'brakes_observations',
            'items' => [
                'mano' => 'Freno de mano',
                'pedal' => 'Freno de pedal',
            ],
        ],
        'mirrors_glass' => [
            'title' => 'Vidrios y espejos',
            'obs' => 'mirrors_observations',
            'items' => [
                'parabrisas' => 'Parabrisas',
                'plumillas' => 'Plumillas',
                'espejos_laterales' => 'Espejos laterales',
                'vidrio_trasero' => 'Vidrio trasero',
                'espejo_retrovisor' => 'Espejo retrovisor',
            ],
        ],
        'fluids' => [
            'title' => 'Fluidos del vehículo',
            'obs' => 'fluids_observations',
            'items' => [
                'aceite_motor' => 'Aceite de motor',
                'liquido_frenos' => 'Líquido de frenos',
                'refrigerante' => 'Refrigerante',
                'agua_limpiaparabrisas' => 'Agua limpia parabrisas',
                'combustible' => 'Combustible',
            ],
        ],
        'general_state' => [
            'title' => 'Estado general del vehículo',
            'obs' => 'general_observations',
            'items' => [
                'latoneria_pintura' => 'Latonería y pintura',
                'llantas_calibradas' => 'Llantas calibradas',
                'cojineria_sillas' => 'Cojinería y sillas buenas',
                'tapiceria' => 'Tapicería',
                'aseo' => 'Aseo del vehículo',
                'manijas_puertas' => 'Manijas de puertas',
                'eleva_vidrios' => 'Eleva vidrios',
                'bocina' => 'Bocina principal',
                'alarma_reversa' => 'Alarma de reversa',
                'cinturones' => 'Cinturones de seguridad',
                'tablero_controles' => 'Tablero de controles (botones)',
                'aire_acondicionado' => 'Aire acondicionado',
                'testigo_encendido' => 'Testigo encendido',
                'sirena' => 'Sirena buena',
            ],
        ],
    ];
@endphp

<div
    x-data="{
        vehicles: @js($vehiclesJson),
        drivers: @js($driversJson),

        selectedVehicleId: '',
        v: { plate:'', vehicle_type:'', insurance_expires_at:'', tech_review_expires_at:'' },

        selectedDriverId: '',
        d: { document:'' },

        updateVehicle() {
            const x = this.vehicles.find(i => i.id == this.selectedVehicleId);
            this.v = x ? {...x} : { plate:'', vehicle_type:'', insurance_expires_at:'', tech_review_expires_at:'' };
        },

        updateDriver() {
            const x = this.drivers.find(i => i.id == this.selectedDriverId);
            this.d.document = x ? x.document : '';
        },
    }"
    class="space-y-6"
>
    <h1 class="text-xl font-semibold">Nuevo Preoperacional</h1>

    <form method="POST" action="{{ route('modules.vehicle-preoperational-checks.store') }}" class="space-y-6">
        @csrf

        {{-- Vehículo --}}
        <div class="bg-white shadow rounded p-4 space-y-4">
            <h3 class="font-semibold">Vehículo</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Placa <span class="text-red-500">*</span></label>
                    <select name="vehicle_id"
                            x-model="selectedVehicleId"
                            @change="updateVehicle()"
                            required
                            class="w-full rounded-md border-gray-300">
                        <option value="">Seleccione</option>
                        @foreach($vehicles as $veh)
                            <option value="{{ $veh->id }}">{{ $veh->plate }}</option>
                        @endforeach
                    </select>
                    @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Tipo vehículo</label>
                    <input type="text" x-model="v.vehicle_type" readonly
                           class="w-full rounded-md border-gray-300 bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Vence seguro</label>
                    <input type="text" x-model="v.insurance_expires_at" readonly
                           class="w-full rounded-md border-gray-300 bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Vence tecnomecánica</label>
                    <input type="text" x-model="v.tech_review_expires_at" readonly
                           class="w-full rounded-md border-gray-300 bg-gray-100">
                </div>
            </div>
        </div>

        {{-- Conductor --}}
        <div class="bg-white shadow rounded p-4 space-y-4">
            <h3 class="font-semibold">Conductor</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium">Usuario <span class="text-red-500">*</span></label>
                    <select name="driver_user_id"
                            x-model="selectedDriverId"
                            @change="updateDriver()"
                            required
                            class="w-full rounded-md border-gray-300">
                        <option value="">Seleccione</option>
                        @foreach($drivers as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    @error('driver_user_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Cédula</label>
                    <input type="text" x-model="d.document" readonly
                           class="w-full rounded-md border-gray-300 bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Categoría licencia <span class="text-red-500">*</span></label>
                    <select name="license_category" required class="w-full rounded-md border-gray-300">
                        <option value="">Seleccione</option>
                        @foreach($licenseCategories as $c)
                            <option value="{{ $c }}" @selected(old('license_category')===$c)>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('license_category') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Datos generales --}}
        <div class="bg-white shadow rounded p-4 space-y-4">
            <h3 class="font-semibold">Datos generales</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Fecha diligenciamiento <span class="text-red-500">*</span></label>
                    <input type="date" name="filled_date" required value="{{ old('filled_date', now()->format('Y-m-d')) }}"
                           class="w-full rounded-md border-gray-300">
                    @error('filled_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Hora diligenciamiento <span class="text-red-500">*</span></label>
                    <input type="time" name="filled_time" required value="{{ old('filled_time', now()->format('H:i')) }}"
                           class="w-full rounded-md border-gray-300">
                    @error('filled_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Kilometraje</label>
                    <input type="number" min="0" name="odometer" value="{{ old('odometer') }}"
                           class="w-full rounded-md border-gray-300">
                    @error('odometer') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Tarjeta de propiedad <span class="text-red-500">*</span></label>
                    <select name="property_card" required class="w-full rounded-md border-gray-300">
                        <option value="1" @selected(old('property_card')==='1')>Sí</option>
                        <option value="0" @selected(old('property_card')==='0')>No</option>
                    </select>
                    @error('property_card') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Módulos --}}
        @foreach($modules as $moduleKey => $mod)
            <div class="bg-white shadow rounded p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">{{ $mod['title'] }}</h3>
                    <span class="text-xs text-gray-500">Marque si está OK (Sí/No)</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($mod['items'] as $itemKey => $label)
                        <label class="flex items-center justify-between gap-3 border rounded p-3">
                            <span class="text-sm">{{ $label }}</span>

                            <div class="flex items-center gap-4">
                                {{-- hidden para garantizar envío --}}
                                <input type="hidden" name="{{ $moduleKey }}[{{ $itemKey }}]" value="0">

                                <label class="inline-flex items-center gap-2 text-sm">
                                    <input type="checkbox"
                                           name="{{ $moduleKey }}[{{ $itemKey }}]"
                                           value="1"
                                           class="rounded border-gray-300"
                                           @checked(old("$moduleKey.$itemKey") == 1)>
                                    <span>Sí</span>
                                </label>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div>
                    <label class="block text-sm font-medium">Observaciones</label>
                    <textarea name="{{ $mod['obs'] }}" rows="2"
                              class="w-full rounded-md border-gray-300">{{ old($mod['obs']) }}</textarea>
                    @error($mod['obs']) <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-2">
            <a href="{{ route('modules.vehicle-preoperational-checks.index') }}"
               class="px-4 py-2 border rounded-md bg-sky-800 text-white">
                Cancelar
            </a>

            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">
                Guardar
            </button>
        </div>

        @if($errors->any())
            <div class="rounded bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc ms-5">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
</x-app-layout>
