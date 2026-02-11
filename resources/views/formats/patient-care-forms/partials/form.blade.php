@php
  $form = $form ?? null;
  $usersJson = $users->map(fn($u) => [
    'id' => $u->id,
    'name' => $u->name,
    'document' => $u->document,
  ])->values();
@endphp

<div x-data="{
    users: @js($usersJson),
    driverId: '{{ old('driver_user_id', $form->driver_user_id ?? '') }}',
    crew1Id: '{{ old('crew1_user_id', $form->crew1_user_id ?? '') }}',
    crew2Id: '{{ old('crew2_user_id', $form->crew2_user_id ?? '') }}',
    driverDoc: '{{ old('driver_document', $form->driver_document ?? '') }}',
    crew1Doc: '{{ old('crew1_document', $form->crew1_document ?? '') }}',
    crew2Doc: '{{ old('crew2_document', $form->crew2_document ?? '') }}',
    pickDoc(id) {
      const u = this.users.find(x => String(x.id) === String(id));
      return u ? (u.document ?? '') : '';
    },
    syncDocs() {
      this.driverDoc = this.pickDoc(this.driverId);
      this.crew1Doc = this.pickDoc(this.crew1Id);
      this.crew2Doc = this.pickDoc(this.crew2Id);
    }
}" x-init="syncDocs()" class="space-y-4">
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">Encabezado</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium">Fecha diligenciamiento <span class="text-red-500">*</span></label>
        <input type="date" name="filled_date" required
               value="{{ old('filled_date', optional($form?->filled_date)->format('Y-m-d')) }}"
               class="w-full rounded-md border-gray-300">
        @error('filled_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
	@php
	  $departure = old('departure_time', $form->departure_time ?? '');
	  $departure = $departure ? \Illuminate\Support\Str::of($departure)->substr(0, 5) : '';

	  $delivery = old('delivery_time', $form->delivery_time ?? '');
	  $delivery = $delivery ? \Illuminate\Support\Str::of($delivery)->substr(0, 5) : '';
	@endphp
      <div>
        <label class="block text-sm font-medium">Hora de salida <span class="text-red-500">*</span></label>
        <input type="time" name="departure_time" required
               value="{{ $departure }}"
               class="w-full rounded-md border-gray-300">
        @error('departure_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Vehículo <span class="text-red-500">*</span></label>
        <select name="vehicle_id" required class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($vehicles as $v)
            <option value="{{ $v->id }}" @selected(old('vehicle_id', $form->vehicle_id ?? '') == $v->id)>
              {{ $v->plate }}
            </option>
          @endforeach
        </select>
        @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Ubicación (U/R/O) <span class="text-red-500">*</span></label>
        <select name="location_type" required class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($locationTypes as $t)
            <option value="{{ $t }}" @selected(old('location_type', $form->location_type ?? '') == $t)>{{ $t }}</option>
          @endforeach
        </select>
        @error('location_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Clase de evento <span class="text-red-500">*</span></label>
        <select name="event_class" required class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($eventClasses as $e)
            <option value="{{ $e }}" @selected(old('event_class', $form->event_class ?? '') == $e)>{{ $e }}</option>
          @endforeach
        </select>
        @error('event_class') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div class="md:col-span-3">
        <label class="block text-sm font-medium">Dirección del evento <span class="text-red-500">*</span></label>
        <input name="event_address" required
               value="{{ old('event_address', $form->event_address ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('event_address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Ciudad <span class="text-red-500">*</span></label>
        <input name="event_city" required
               value="{{ old('event_city', $form->event_city ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('event_city') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Departamento <span class="text-red-500">*</span></label>
        <input name="event_department" required
               value="{{ old('event_department', $form->event_department ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('event_department') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">1. Información general del paciente</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Nombre <span class="text-red-500">*</span></label>
        <input name="patient_name" required value="{{ old('patient_name', $form->patient_name ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Tipo documento <span class="text-red-500">*</span></label>
        <select name="patient_doc_type" required class="w-full rounded-md border-gray-300">
          @foreach($docTypes as $d)
            <option value="{{ $d }}" @selected(old('patient_doc_type', $form->patient_doc_type ?? '') == $d)>{{ $d }}</option>
          @endforeach
        </select>
        @error('patient_doc_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Número documento <span class="text-red-500">*</span></label>
        <input name="patient_doc_number" required value="{{ old('patient_doc_number', $form->patient_doc_number ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_doc_number') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Dirección <span class="text-red-500">*</span></label>
        <input name="patient_address" required value="{{ old('patient_address', $form->patient_address ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Edad <span class="text-red-500">*</span></label>
        <input type="number" min="0" max="130" name="patient_age" required
               value="{{ old('patient_age', $form->patient_age ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_age') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium">Teléfono</label>
        <input name="patient_phone" value="{{ old('patient_phone', $form->patient_phone ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Ocupación</label>
        <input name="patient_occupation" value="{{ old('patient_occupation', $form->patient_occupation ?? '') }}"
               class="w-full rounded-md border-gray-300">
        @error('patient_occupation') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">2. Valoración del paciente</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      @foreach([
        'v_pulse' => 'Pulso',
        'v_respiration' => 'Respiración',
        'v_pa' => 'P/A',
        'v_spo2' => 'SPO2',
        'v_ro' => 'RO',
        'v_rv' => 'RV',
        'v_rm' => 'RM',
        'v_total' => 'Total',
        'v_temperature' => 'Temperatura',
      ] as $field => $label)
        <div>
          <label class="block text-sm font-medium">{{ $label }}</label>
          <input name="{{ $field }}" value="{{ old($field, $form->{$field} ?? '') }}"
                 class="w-full rounded-md border-gray-300">
          @error($field) <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
      @endforeach
    </div>
    <div>
      <label class="block text-sm font-medium">Observación general</label>
      <textarea name="v_general_observation" rows="3"
                class="w-full rounded-md border-gray-300">{{ old('v_general_observation', $form->v_general_observation ?? '') }}</textarea>
      @error('v_general_observation') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">3. Procedimientos realizados al paciente</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
      @foreach($proceduresList as $p)
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="procedures[]"
                 value="{{ $p }}"
                 class="rounded border-gray-300"
                 @checked(in_array($p, old('procedures', $form->procedures ?? [])))>
          <span>{{ $p }}</span>
        </label>
      @endforeach
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium">SSN ,9%</label>
        <input name="ssn_09" value="{{ old('ssn_09', $form->ssn_09 ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">LACTATO (g/m)</label>
        <input name="lactato" value="{{ old('lactato', $form->lactato ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">DESTROSA (g/m)</label>
        <input name="dextrosa" value="{{ old('dextrosa', $form->dextrosa ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium">Descripción procedimiento</label>
      <textarea name="procedure_description" rows="3"
                class="w-full rounded-md border-gray-300">{{ old('procedure_description', $form->procedure_description ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium">Alergias</label>
        <textarea name="allergies" rows="2" class="w-full rounded-md border-gray-300">{{ old('allergies', $form->allergies ?? '') }}</textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Medicamentos</label>
        <textarea name="medications" rows="2" class="w-full rounded-md border-gray-300">{{ old('medications', $form->medications ?? '') }}</textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Patologías</label>
        <textarea name="pathologies" rows="2" class="w-full rounded-md border-gray-300">{{ old('pathologies', $form->pathologies ?? '') }}</textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Lividez</label>
        <input name="lividity" value="{{ old('lividity', $form->lividity ?? '') }}" class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Ambiente</label>
        <input name="environment" value="{{ old('environment', $form->environment ?? '') }}" class="w-full rounded-md border-gray-300">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium">Observaciones generales</label>
      <textarea name="general_notes" rows="3"
                class="w-full rounded-md border-gray-300">{{ old('general_notes', $form->general_notes ?? '') }}</textarea>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">4. Transporte</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium">Estado en que se entrega <span class="text-red-500">*</span></label>
        <select name="delivery_status" required class="w-full rounded-md border-gray-300">
          @foreach(['vivo','muerto'] as $ds)
            <option value="{{ $ds }}" @selected(old('delivery_status', $form->delivery_status ?? '') == $ds)>{{ $ds }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Hora entrega</label>
        <input type="time" name="delivery_time" value="{{ $delivery }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div class="flex items-end">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="belongings" value="1"
                 class="rounded border-gray-300"
                 @checked(old('belongings', $form->belongings ?? false))>
          <span>Pertenencias (Sí)</span>
        </label>
      </div>
      <div>
        <label class="block text-sm font-medium">Quién recibe</label>
        <input name="receiver_name" value="{{ old('receiver_name', $form->receiver_name ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Cédula quien recibe</label>
        <input name="receiver_document" value="{{ old('receiver_document', $form->receiver_document ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Transportado a</label>
        <input name="transported_to" value="{{ old('transported_to', $form->transported_to ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Ciudad</label>
        <input name="transport_city" value="{{ old('transport_city', $form->transport_city ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Código</label>
        <input name="transport_code" value="{{ old('transport_code', $form->transport_code ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">5. Acompañante y/o responsable</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium">Nombre</label>
        <input name="companion_name" value="{{ old('companion_name', $form->companion_name ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Cédula</label>
        <input name="companion_document" value="{{ old('companion_document', $form->companion_document ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Teléfono</label>
        <input name="companion_phone" value="{{ old('companion_phone', $form->companion_phone ?? '') }}"
               class="w-full rounded-md border-gray-300">
      </div>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">6. Responsable de la atención</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium">Conductor</label>
        <select name="driver_user_id" x-model="driverId" @change="syncDocs()" class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" @selected(old('driver_user_id', $form->driver_user_id ?? '') == $u->id)>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Cédula conductor</label>
        <input name="driver_document" x-model="driverDoc" readonly class="w-full rounded-md border-gray-300 bg-gray-100">
      </div>
      <div></div>
      <div>
        <label class="block text-sm font-medium">Tripulante 1</label>
        <select name="crew1_user_id" x-model="crew1Id" @change="syncDocs()" class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" @selected(old('crew1_user_id', $form->crew1_user_id ?? '') == $u->id)>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Cédula tripulante 1</label>
        <input name="crew1_document" x-model="crew1Doc" readonly class="w-full rounded-md border-gray-300 bg-gray-100">
      </div>
      <div></div>
      <div>
        <label class="block text-sm font-medium">Tripulante 2</label>
        <select name="crew2_user_id" x-model="crew2Id" @change="syncDocs()" class="w-full rounded-md border-gray-300">
          <option value="">Seleccione</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" @selected(old('crew2_user_id', $form->crew2_user_id ?? '') == $u->id)>{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Cédula tripulante 2</label>
        <input name="crew2_document" x-model="crew2Doc" readonly class="w-full rounded-md border-gray-300 bg-gray-100">
      </div>
    </div>
  </div>
  <div class="bg-white shadow rounded p-4 space-y-4">
    <h3 class="font-semibold">7. Evaluación del servicio</h3>
    @php
      $eval = old('service_evaluation', $form->service_evaluation ?? []);
      $questions = [
        'service' => 'Cómo califica el servicio',
        'staff' => 'Cómo califica el personal',
        'means' => 'Cómo califica los medios con los cuales se prestó el servicio',
        'recommend' => 'Recomendaría el servicio a otras personas',
      ];
      $opts = ['E' => 'Excelente', 'B' => 'Bueno', 'R' => 'Regular', 'M' => 'Malo'];
    @endphp
    <div class="space-y-3">
      @foreach($questions as $k => $lbl)
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 border rounded p-3">
          <div class="font-medium">{{ $lbl }}</div>
          <div class="flex gap-4">
            @foreach($opts as $v => $txt)
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="service_evaluation[{{ $k }}]" value="{{ $v }}"
                       class="rounded border-gray-300"
                       @checked(($eval[$k] ?? null) === $v)>
                <span>{{ $v }} ({{ $txt }})</span>
              </label>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @if($errors->any())
    <div class="rounded bg-red-50 p-3 text-sm text-red-700">
      <ul class="list-disc ms-5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
</div>
