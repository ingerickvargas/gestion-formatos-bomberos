<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Título --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Crear informe de salida vehicular</h1>
                <p class="text-sm text-gray-500">Diligencia el guardia y asigna el conductor.</p>
            </div>
        </div>

        @php
            $usersJson = $drivers->map(fn($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'document' => $u->document,
                'phone' => $u->phone,
            ])->values();
        @endphp

        <form
            method="POST"
            action="{{ route('formats.vehicle-exit-reports.store') }}"
            x-data="{
                users: @js($usersJson),
                selectedDriverId: '{{ old('driver_user_id', '') }}',
                driver: { document: '', phone: '' },

                updateDriver() {
                    const u = this.users.find(x => String(x.id) === String(this.selectedDriverId));
                    this.driver.document = u ? (u.document ?? '') : '';
                    this.driver.phone = u ? (u.phone ?? '') : '';
                }
            }"
            x-init="updateDriver()"
            class="space-y-6"
        >
            @csrf

            {{-- Errores --}}
            @if ($errors->any())
                <div class="rounded bg-red-50 p-4 text-sm text-red-700">
                    <div class="font-semibold mb-2">Revisa estos campos:</div>
                    <ul class="list-disc ms-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Conductor asignado --}}
            <div class="bg-gray-50 rounded p-4 space-y-4">
                <h3 class="font-semibold">Conductor asignado</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Conductor <span class="text-red-500">*</span></label>
                        <select
                            name="driver_user_id"
                            x-model="selectedDriverId"
                            @change="updateDriver()"
                            required
                            class="w-full rounded-md border-gray-300"
                        >
                            <option value="">Seleccione</option>
                            @foreach($drivers as $u)
                                <option value="{{ $u->id }}" @selected(old('driver_user_id') == $u->id)>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('driver_user_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Cédula</label>
                        <input type="text" x-model="driver.document" readonly
                               class="w-full rounded-md border-gray-300 bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Teléfono</label>
                        <input type="text" x-model="driver.phone" readonly
                               class="w-full rounded-md border-gray-300 bg-gray-100">
                    </div>
                </div>
            </div>

            {{-- Datos del vehículo --}}
            <div class="bg-white shadow rounded p-4 space-y-4">
                <h3 class="font-semibold">Datos del vehículo</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Tipo de vehículo <span class="text-red-500">*</span></label>
                        <select name="vehicle_type" required class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione</option>
                            @foreach($vehicleTypes as $t)
                                <option value="{{ $t }}" @selected(old('vehicle_type') == $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Placa <span class="text-red-500">*</span></label>
                        <select name="vehicle_id" required class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" @selected(old('vehicle_id') == $v->id)>{{ $v->plate }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tipo de evento <span class="text-red-500">*</span></label>
                        <select name="event_type" required class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione</option>
                            @foreach($eventTypes as $e)
                                <option value="{{ $e }}" @selected(old('event_type') == $e)>{{ $e }}</option>
                            @endforeach
                        </select>
                        @error('event_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Ubicación --}}
            <div class="bg-white shadow rounded p-4 space-y-4">
                <h3 class="font-semibold">Ubicación del incidente</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Departamento <span class="text-red-500">*</span></label>
                        <input name="department" required value="{{ old('department') }}"
                               class="w-full rounded-md border-gray-300" placeholder="Departamento">
                        @error('department') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Ciudad / Municipio <span class="text-red-500">*</span></label>
                        <input name="city" required value="{{ old('city') }}"
                               class="w-full rounded-md border-gray-300" placeholder="Ciudad / Municipio">
                        @error('city') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Barrio</label>
                        <input name="neighborhood" value="{{ old('neighborhood') }}"
                               class="w-full rounded-md border-gray-300" placeholder="Barrio">
                        @error('neighborhood') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Vereda</label>
                        <input name="vereda" value="{{ old('vereda') }}"
                               class="w-full rounded-md border-gray-300" placeholder="Vereda">
                        @error('vereda') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nomenclatura</label>
                        <input name="nomenclature" value="{{ old('nomenclature') }}"
                               class="w-full rounded-md border-gray-300" placeholder="Nomenclatura">
                        @error('nomenclature') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Hora salida <span class="text-red-500">*</span></label>
                        <input type="time" name="departure_time" required value="{{ old('departure_time') }}"
                               class="w-full rounded-md border-gray-300">
                        @error('departure_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('formats.vehicle-exit-reports.index') }}"
                   class="px-4 py-2 border rounded-md bg-sky-800 text-white">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-gray-800">
                    Guardar y asignar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
