@php
    $docTypes = ['CC','TI','RC','CE'];
    $yesNo = ['Si','No'];

    $toTime = function ($value) {
        if (!$value) return '';
        // si viene Carbon, pásalo a string H:i
        if ($value instanceof \Carbon\Carbon) return $value->format('H:i');
        $v = (string) $value;
        return strlen($v) >= 5 ? substr($v, 0, 5) : $v;
    };

    $oldVehicles = old('vehicles');

    if ($oldVehicles !== null) {
        $vehiclesInitial = $oldVehicles;
    } elseif (!empty($isEdit) && isset($form) && $form) {
        $vehiclesInitial = $form->vehicles()
            ->with('companions')
            ->get()
            ->map(function($v) {
                return [
                    'plate' => $v->plate,
                    'vehicle_type' => $v->vehicle_type,
                    'brand' => $v->brand,
                    'model' => $v->model,
                    'color' => $v->color,
                    'trailer' => $v->trailer,
                    'internal_number' => $v->internal_number,
                    'route' => $v->route,
                    'driver_name' => $v->driver_name,
                    'driver_doc_type' => $v->driver_doc_type,
                    'driver_document' => $v->driver_document,
                    'driver_phone' => $v->driver_phone,
                    'driver_age' => $v->driver_age,
                    'driver_address' => $v->driver_address,
                    'presents' => $v->presents,
                    'transferred' => $v->transferred,
                    'destination' => $v->destination,
                    'radicado' => $v->radicado,
                    'companions' => $v->companions->map(function($c){
                        return [
                            'name' => $c->name,
                            'doc_type' => $c->doc_type,
                            'doc_number' => $c->doc_number,
                            'age' => $c->age,
                            'phone' => $c->phone,
                            'address' => $c->address,
                            'presents' => $c->presents,
                            'transferred' => $c->transferred,
                            'radicado' => $c->radicado,
                            'destination' => $c->destination,
                        ];
                    })->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
    } else {
        $vehiclesInitial = [];
    }

    if (empty($vehiclesInitial)) {
        $vehiclesInitial = [
            [
                'plate' => '',
                'vehicle_type' => '',
                'brand' => '',
                'model' => '',
                'color' => '',
                'trailer' => '',
                'internal_number' => '',
                'route' => '',
                'driver_name' => '',
                'driver_doc_type' => '',
                'driver_document' => '',
                'driver_phone' => '',
                'driver_age' => '',
                'driver_address' => '',
                'presents' => '',
                'transferred' => '',
                'destination' => '',
                'radicado' => '',
                'companions' => [],
            ]
        ];
    }

@endphp

<div
    x-data="autopistasCafeForm({
        vehiclesInitial: @js($vehiclesInitial),
    })"
    class="space-y-6"
>
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded p-4">
            <div class="font-semibold mb-2">Hay errores en el formulario:</div>
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Cabecera - Atención de eventos</h3>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium">Fecha</label>
                <input type="date" name="event_date"
                       value="{{ old('event_date', (!empty($isEdit) && $form?->event_date) ? $form->event_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('event_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora salida</label>
                <input type="time" name="departure_time"
                       value="{{ old('departure_time', (!empty($isEdit) ? $toTime($form?->departure_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('departure_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora sitio</label>
                <input type="time" name="site_time"
                       value="{{ old('site_time', (!empty($isEdit) ? $toTime($form?->site_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('site_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora regreso</label>
                <input type="time" name="return_time"
                       value="{{ old('return_time', (!empty($isEdit) ? $toTime($form?->return_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('return_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">KM inicial</label>
                <input type="number" min="0" name="km_initial"
                       value="{{ old('km_initial', $isEdit ? $form?->km_initial : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('km_initial') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">KM evento</label>
                <input type="number" min="0" name="km_event"
                       value="{{ old('km_event', $isEdit ? $form?->km_event : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('km_event') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium">KM final</label>
                <input type="number" min="0" name="km_final"
                       value="{{ old('km_final', $isEdit ? $form?->km_final : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('km_final') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Placa (institución)</label>
                <select name="vehicle_id" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" @selected(old('vehicle_id', $isEdit ? $form?->vehicle_id : '') == $v->id)>
                            {{ $v->plate }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Evento</label>
                <input type="text" name="event"
                       value="{{ old('event', $isEdit ? $form?->event : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('event') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-medium">Kilómetro</label>
                <input type="text" name="kilometer"
                       value="{{ old('kilometer', $isEdit ? $form?->kilometer : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('kilometer') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Sitio del evento</label>
                <input type="text" name="event_site"
                       value="{{ old('event_site', $isEdit ? $form?->event_site : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('event_site') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Punto de referencia</label>
                <input type="text" name="reference_point"
                       value="{{ old('reference_point', $isEdit ? $form?->reference_point : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('reference_point') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-lg">Vehículos involucrados</h3>
            <button type="button" @click="addVehicle()"
                    class="bg-red-600 text-white px-4 py-2 rounded-md">
                + Añadir vehículo
            </button>
        </div>

        @error('vehicles') <div class="text-sm text-red-600">{{ $message }}</div> @enderror

        <div class="space-y-4">
            <template x-for="(v, vIndex) in vehicles" :key="vIndex">
                <div class="border rounded-md p-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold" x-text="'Vehículo ' + (vIndex + 1)"></div>
                        <button type="button"
                                @click="removeVehicle(vIndex)"
                                class="px-3 py-2 rounded-md border hover:bg-gray-50"
                                x-show="vehicles.length > 1">
                            Quitar vehículo
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Placa</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][plate]`"
                                   x-model="v.plate">
                            <template x-if="fieldError(`vehicles.${vIndex}.plate`)">
                                <div class="text-sm text-red-600 mt-1" x-text="fieldError(`vehicles.${vIndex}.plate`)"></div>
                            </template>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tipo</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][vehicle_type]`"
                                   x-model="v.vehicle_type">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Marca</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][brand]`"
                                   x-model="v.brand">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Modelo</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][model]`"
                                   x-model="v.model">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Color</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][color]`"
                                   x-model="v.color">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Remolque</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][trailer]`"
                                   x-model="v.trailer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">N° interno</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][internal_number]`"
                                   x-model="v.internal_number">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Ruta</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][route]`"
                                   x-model="v.route">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium">Conductor</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][driver_name]`"
                                   x-model="v.driver_name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tipo documento</label>
                            <select class="w-full rounded-md border-gray-300"
                                    :name="`vehicles[${vIndex}][driver_doc_type]`"
                                    x-model="v.driver_doc_type">
                                <option value="">Seleccione</option>
                                @foreach($docTypes as $dt)
                                    <option value="{{ $dt }}">{{ $dt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Número documento</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][driver_document]`"
                                   x-model="v.driver_document">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Teléfono</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][driver_phone]`"
                                   x-model="v.driver_phone">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Edad</label>
                            <input type="number" min="0" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][driver_age]`"
                                   x-model="v.driver_age">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium">Dirección</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][driver_address]`"
                                   x-model="v.driver_address">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium">Presenta</label>
                            <textarea rows="3" class="w-full rounded-md border-gray-300"
                                      :name="`vehicles[${vIndex}][presents]`"
                                      x-model="v.presents"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Trasladado</label>
                            <select class="w-full rounded-md border-gray-300"
                                    :name="`vehicles[${vIndex}][transferred]`"
                                    x-model="v.transferred">
                                <option value="">Seleccione</option>
                                @foreach($yesNo as $yn)
                                    <option value="{{ $yn }}">{{ $yn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Destino</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][destination]`"
                                   x-model="v.destination">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Radicado</label>
                            <input type="text" class="w-full rounded-md border-gray-300"
                                   :name="`vehicles[${vIndex}][radicado]`"
                                   x-model="v.radicado">
                        </div>
                    </div>

                    <div class="pt-2 border-t">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">Acompañantes</div>
                            <button type="button"
                                    class="px-3 py-2 rounded-md border bg-red-600 text-white hover:bg-red-700"
                                    @click="addCompanion(vIndex)">
                                + Añadir acompañante
                            </button>
                        </div>

                        <template x-if="!v.companions || !v.companions.length">
                            <div class="text-sm text-gray-500 mt-2">No hay acompañantes agregados.</div>
                        </template>

                        <div class="space-y-3 mt-3" x-show="v.companions && v.companions.length">
                            <template x-for="(c, cIndex) in v.companions" :key="cIndex">
                                <div class="border rounded-md p-3 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium" x-text="'Acompañante ' + (cIndex + 1)"></div>
                                        <button type="button"
                                                class="px-3 py-2 rounded-md border hover:bg-gray-50"
                                                @click="removeCompanion(vIndex, cIndex)">
                                            Quitar
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium">Nombre</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][name]`"
                                                   x-model="c.name">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Tipo documento</label>
                                            <select class="w-full rounded-md border-gray-300"
                                                    :name="`vehicles[${vIndex}][companions][${cIndex}][doc_type]`"
                                                    x-model="c.doc_type">
                                                <option value="">Seleccione</option>
                                                @foreach($docTypes as $dt)
                                                    <option value="{{ $dt }}">{{ $dt }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Número documento</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][doc_number]`"
                                                   x-model="c.doc_number">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium">Edad</label>
                                            <input type="number" min="0" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][age]`"
                                                   x-model="c.age">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Teléfono</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][phone]`"
                                                   x-model="c.phone">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium">Dirección</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][address]`"
                                                   x-model="c.address">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium">Presenta</label>
                                            <textarea rows="2" class="w-full rounded-md border-gray-300"
                                                      :name="`vehicles[${vIndex}][companions][${cIndex}][presents]`"
                                                      x-model="c.presents"></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Trasladado</label>
                                            <select class="w-full rounded-md border-gray-300"
                                                    :name="`vehicles[${vIndex}][companions][${cIndex}][transferred]`"
                                                    x-model="c.transferred">
                                                <option value="">Seleccione</option>
                                                @foreach($yesNo as $yn)
                                                    <option value="{{ $yn }}">{{ $yn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium">Destino</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][destination]`"
                                                   x-model="c.destination">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium">Radicado</label>
                                            <input type="text" class="w-full rounded-md border-gray-300"
                                                   :name="`vehicles[${vIndex}][companions][${cIndex}][radicado]`"
                                                   x-model="c.radicado">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Cierre / Autorización</h3>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Autorizado</label>
                <input type="text" name="authorized"
                       value="{{ old('authorized', $isEdit ? $form?->authorized : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('authorized') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora salida</label>
                <input type="time" name="authorized_departure_time"
                       value="{{ old('authorized_departure_time', ($isEdit ? $toTime($form?->authorized_departure_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('authorized_departure_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora sitio</label>
                <input type="time" name="authorized_site_time"
                       value="{{ old('authorized_site_time', ($isEdit ? $toTime($form?->authorized_site_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('authorized_site_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora regreso</label>
                <input type="time" name="authorized_return_time"
                       value="{{ old('authorized_return_time', ($isEdit ? $toTime($form?->authorized_return_time) : '')) }}"
                       class="w-full rounded-md border-gray-300">
                @error('authorized_return_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium">KM inicial</label>
                <input type="number" min="0" name="authorized_km_initial"
                       value="{{ old('authorized_km_initial', $isEdit ? $form?->authorized_km_initial : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">KM evento</label>
                <input type="number" min="0" name="authorized_km_event"
                       value="{{ old('authorized_km_event', $isEdit ? $form?->authorized_km_event : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">KM final</label>
                <input type="number" min="0" name="authorized_km_final"
                       value="{{ old('authorized_km_final', $isEdit ? $form?->authorized_km_final : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Placa (institución)</label>
                <select name="authorized_vehicle_id" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" @selected(old('authorized_vehicle_id', $isEdit ? $form?->authorized_vehicle_id : '') == $v->id)>
                            {{ $v->plate }}
                        </option>
                    @endforeach
                </select>
                @error('authorized_vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="md:col-span-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium">Funcionario que reporta</label>
                <input type="text" name="reporting_officer"
                       value="{{ old('reporting_officer', $isEdit ? $form?->reporting_officer : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Inspector vial</label>
                <input type="text" name="road_inspector"
                       value="{{ old('road_inspector', $isEdit ? $form?->road_inspector : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Hospital que recibe</label>
                <input type="text" name="receiving_hospital"
                       value="{{ old('receiving_hospital', $isEdit ? $form?->receiving_hospital : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Conductor</label>
                <input type="text" name="driver_name"
                       value="{{ old('driver_name', $isEdit ? $form?->driver_name : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Tripulante</label>
                <input type="text" name="crew_member"
                       value="{{ old('crew_member', $isEdit ? $form?->crew_member : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>
    </div>
</div>

<script>
function autopistasCafeForm({ vehiclesInitial }) {
    return {
        vehicles: vehiclesInitial || [],
        errors: @json($errors->toArray()),

        fieldError(key) {
            // key ejemplo: "vehicles.0.plate"
            const err = this.errors?.[key];
            return Array.isArray(err) ? err[0] : null;
        },

        emptyVehicle() {
            return {
                plate: '',
                vehicle_type: '',
                brand: '',
                model: '',
                color: '',
                trailer: '',
                internal_number: '',
                route: '',
                driver_name: '',
                driver_doc_type: '',
                driver_document: '',
                driver_phone: '',
                driver_age: '',
                driver_address: '',
                presents: '',
                transferred: '',
                destination: '',
                radicado: '',
                companions: [],
            };
        },

        emptyCompanion() {
            return {
                name: '',
                doc_type: '',
                doc_number: '',
                age: '',
                phone: '',
                address: '',
                presents: '',
                transferred: '',
                radicado: '',
                destination: '',
            };
        },

        addVehicle() {
            this.vehicles.push(this.emptyVehicle());
        },

        removeVehicle(idx) {
            this.vehicles.splice(idx, 1);
        },

        addCompanion(vIndex) {
            if (!this.vehicles[vIndex].companions) this.vehicles[vIndex].companions = [];
            this.vehicles[vIndex].companions.push(this.emptyCompanion());
        },

        removeCompanion(vIndex, cIndex) {
            this.vehicles[vIndex].companions.splice(cIndex, 1);
        }
    }
}
</script>
