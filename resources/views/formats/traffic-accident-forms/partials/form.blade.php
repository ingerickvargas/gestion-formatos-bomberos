@php
    // Para edit: $form existe. Para create: puede no existir.
    $isEdit = isset($form);

    $usersJson = ($users ?? collect())->map(fn($u) => [
        'id' => $u->id,
        'name' => $u->name,
        'document' => $u->document,
    ]);

    // Defaults para checkboxes múltiples (edit)
    $oldInjuries = old('injuries', $isEdit ? ($form->injuries ?? []) : []);
    $oldProcedures = old('procedures', $isEdit ? ($form->procedures ?? []) : []);

    // Insumos dinámicos (edit)
    $oldSupplies = old('supplies_used', $isEdit ? ($form->supplies_used ?? []) : []);
@endphp

@php
    $timeValue = function ($value) {
        if (!$value) return '';
        try {
            return \Carbon\Carbon::parse($value)->format('H:i'); // soporta H:i y H:i:s
        } catch (\Throwable $e) {
            return '';
        }
    };
@endphp

<div
    x-data="{
        users: @js($usersJson),
        responsibleId: '{{ old('responsible_user_id', $isEdit ? $form->responsible_user_id : '') }}',
        responsibleDoc: '{{ old('responsible_document', $isEdit ? ($form->responsible_document ?? '') : '') }}',

        syncResponsible() {
            const u = this.users.find(x => String(x.id) === String(this.responsibleId));
            this.responsibleDoc = u ? (u.document ?? '') : '';
        },

        // Insumos dinámicos
        supplies: @js($oldSupplies),
        addSupply() {
            this.supplies.push({ name: '', qty: '' });
        },
        removeSupply(i) {
            this.supplies.splice(i, 1);
        }
    }"
    x-init="syncResponsible()"
    class="space-y-6"
>
    {{-- ===================== MODULO I. ANAMNESIS ===================== --}}
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Módulo I. Anamnesis</h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">NUAP</label>
                <input type="text" name="nuap"
                       value="{{ old('nuap', $isEdit ? $form->nuap : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('nuap') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Prioridad</label>
                <select name="priority" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($priorities ?? ['R','A','V','N','B'] as $p)
                        <option value="{{ $p }}" @selected(old('priority', $isEdit ? $form->priority : '') == $p)>{{ $p }}</option>
                    @endforeach
                </select>
                @error('priority') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Quién informa el evento</label>
                <select name="informer_user_id" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" @selected(old('informer_user_id', $isEdit ? $form->informer_user_id : '') == $u->id)>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
                @error('informer_user_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">Hora de salida</label>
                <input type="time" name="departure_time"
                       value="{{ old('departure_time', $timeValue($isEdit ? $form->departure_time : null)) }}"
                       class="w-full rounded-md border-gray-300">
                @error('departure_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Fecha de atención</label>
                <input type="date" name="attention_date"
                       value="{{ old('attention_date', $isEdit && $form->attention_date ? $form->attention_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('attention_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Hora de atención</label>
                <input type="time" name="attention_time"
                       value="{{ old('attention_time', $timeValue($isEdit ? $form->attention_time : null)) }}"
                       class="w-full rounded-md border-gray-300">
                @error('attention_time') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Historia clínica</label>
                <input type="text" name="clinical_history"
                       value="{{ old('clinical_history', $isEdit ? $form->clinical_history : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('clinical_history') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Nombre paciente / víctima</label>
                <input type="text" name="patient_name"
                       value="{{ old('patient_name', $isEdit ? $form->patient_name : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Tipo documento</label>
                <select name="patient_doc_type" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($docTypes ?? ['CC','TI','RC','CE','PA','AS'] as $t)
                        <option value="{{ $t }}" @selected(old('patient_doc_type', $isEdit ? $form->patient_doc_type : '') == $t)>{{ $t }}</option>
                    @endforeach
                </select>
                @error('patient_doc_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">Número documento</label>
                <input type="text" name="patient_doc_number"
                       value="{{ old('patient_doc_number', $isEdit ? $form->patient_doc_number : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_doc_number') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Fecha nacimiento</label>
                <input type="date" name="patient_birth_date"
                       value="{{ old('patient_birth_date', $isEdit && $form->patient_birth_date ? $form->patient_birth_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_birth_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Edad</label>
                <input type="number" min="0" name="patient_age"
                       value="{{ old('patient_age', $isEdit ? $form->patient_age : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_age') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Sexo</label>
                <input type="text" name="patient_sex"
                       value="{{ old('patient_sex', $isEdit ? $form->patient_sex : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_sex') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">Estado civil</label>
                <input type="text" name="patient_civil_status"
                       value="{{ old('patient_civil_status', $isEdit ? $form->patient_civil_status : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_civil_status') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Dirección</label>
                <input type="text" name="patient_address"
                       value="{{ old('patient_address', $isEdit ? $form->patient_address : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="patient_phone"
                       value="{{ old('patient_phone', $isEdit ? $form->patient_phone : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Ocupación</label>
                <input type="text" name="patient_occupation"
                       value="{{ old('patient_occupation', $isEdit ? $form->patient_occupation : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('patient_occupation') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">EPS</label>
                <input type="text" name="eps"
                       value="{{ old('eps', $isEdit ? $form->eps : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('eps') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Aseguradora</label>
                <input type="text" name="insurance_company"
                       value="{{ old('insurance_company', $isEdit ? $form->insurance_company : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('insurance_company') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Acompañante</label>
                <input type="text" name="companion_name"
                       value="{{ old('companion_name', $isEdit ? $form->companion_name : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('companion_name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Parentesco</label>
                <input type="text" name="companion_relationship"
                       value="{{ old('companion_relationship', $isEdit ? $form->companion_relationship : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('companion_relationship') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Teléfono acompañante</label>
                <input type="text" name="companion_phone"
                       value="{{ old('companion_phone', $isEdit ? $form->companion_phone : '') }}"
                       class="w-full rounded-md border-gray-300">
                @error('companion_phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- ===================== MODULO II. MOTIVO ===================== --}}
    <div class="bg-white shadow rounded p-4 space-y-3">
        <h3 class="font-semibold text-lg">Módulo II. Motivo de atención</h3>

        <div>
            <label class="block text-sm font-medium">Observación</label>
            <textarea name="reason_observation" rows="3"
                      class="w-full rounded-md border-gray-300">{{ old('reason_observation', $isEdit ? $form->reason_observation : '') }}</textarea>
            @error('reason_observation') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- ===================== MODULO III. EXAMEN FISICO ===================== --}}
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Módulo III. Examen físico</h3>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium">F.C</label>
                <input type="text" name="fc" value="{{ old('fc', $isEdit ? $form->fc : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">F.R</label>
                <input type="text" name="fr" value="{{ old('fr', $isEdit ? $form->fr : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">T.A</label>
                <input type="text" name="ta" value="{{ old('ta', $isEdit ? $form->ta : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">SPO2</label>
                <input type="text" name="spo2" value="{{ old('spo2', $isEdit ? $form->spo2 : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">T°</label>
                <input type="text" name="temperature" value="{{ old('temperature', $isEdit ? $form->temperature : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">RO/RV/RM</label>
                <div class="grid grid-cols-3 gap-2">
                    <input type="text" name="ro" placeholder="RO"
                           value="{{ old('ro', $isEdit ? $form->ro : '') }}"
                           class="w-full rounded-md border-gray-300">
                    <input type="text" name="rv" placeholder="RV"
                           value="{{ old('rv', $isEdit ? $form->rv : '') }}"
                           class="w-full rounded-md border-gray-300">
                    <input type="text" name="rm" placeholder="RM"
                           value="{{ old('rm', $isEdit ? $form->rm : '') }}"
                           class="w-full rounded-md border-gray-300">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Alergias</label>
                <textarea name="allergies" rows="2" class="w-full rounded-md border-gray-300">{{ old('allergies', $isEdit ? $form->allergies : '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Patologías</label>
                <textarea name="pathologies" rows="2" class="w-full rounded-md border-gray-300">{{ old('pathologies', $isEdit ? $form->pathologies : '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Medicamentos</label>
                <textarea name="medications" rows="2" class="w-full rounded-md border-gray-300">{{ old('medications', $isEdit ? $form->medications : '') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Lividez</label>
                <input type="text" name="lividity" value="{{ old('lividity', $isEdit ? $form->lividity : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Llenado capilar</label>
                <input type="text" name="capillary_refill" value="{{ old('capillary_refill', $isEdit ? $form->capillary_refill : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Antecedentes</label>
                <input type="text" name="background" value="{{ old('background', $isEdit ? $form->background : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>

        @php
            $injuryOptions = [
                'Escoriación','Laceración','Contusión','Trauma','Avulsión','Herida abierta','Amputación','Deformidad',
                'Politraumatismo','Fractura','Quemadura','Empalamiento','Hematoma'
            ];
        @endphp

        <div>
            <div class="text-sm font-medium mb-2">Lesiones (marcar)</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($injuryOptions as $opt)
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="injuries[]" value="{{ $opt }}"
                               @checked(in_array($opt, $oldInjuries ?? []))
                               class="rounded border-gray-300">
                        <span class="text-sm">{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
            @error('injuries') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Valoración primaria</label>
                <textarea name="primary_assessment" rows="3"
                          class="w-full rounded-md border-gray-300">{{ old('primary_assessment', $isEdit ? $form->primary_assessment : '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Valoración secundaria</label>
                <textarea name="secondary_assessment" rows="3"
                          class="w-full rounded-md border-gray-300">{{ old('secondary_assessment', $isEdit ? $form->secondary_assessment : '') }}</textarea>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Impresión diagnóstica</label>
            <textarea name="diagnostic_impression" rows="3"
                      class="w-full rounded-md border-gray-300">{{ old('diagnostic_impression', $isEdit ? $form->diagnostic_impression : '') }}</textarea>
        </div>
    </div>

    {{-- ===================== MODULO IV. PROCEDIMIENTOS ===================== --}}
    @php
        $procedureOptions = ['Monitoreo','Hemostasia','Reanimación','Oxigenación','Glucometría','Inmovilización','Asepsia','Desfibrilación','Intubación','Curación'];
    @endphp

    <div class="bg-white shadow rounded p-4 space-y-3">
        <h3 class="font-semibold text-lg">Módulo IV. Procedimientos realizados</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2">
            @foreach($procedureOptions as $opt)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="procedures[]" value="{{ $opt }}"
                           @checked(in_array($opt, $oldProcedures ?? []))
                           class="rounded border-gray-300">
                    <span class="text-sm">{{ $opt }}</span>
                </label>
            @endforeach
        </div>
        @error('procedures') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- ===================== MODULO V. INSUMOS ===================== --}}
    <div class="bg-white shadow rounded p-4 space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-lg">Módulo V. Insumos utilizados</h3>
            <button type="button" @click="addSupply()"
                    class="px-3 py-2 rounded-md border hover:bg-gray-50">
                + Agregar insumo
            </button>
        </div>

        <template x-if="!supplies.length">
            <div class="text-sm text-gray-500">No hay insumos agregados.</div>
        </template>

        <div class="space-y-2" x-show="supplies.length">
            <template x-for="(item, idx) in supplies" :key="idx">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-end border rounded p-3">
                    <div class="md:col-span-7">
                        <label class="block text-sm font-medium">Insumo</label>
                        <input type="text" class="w-full rounded-md border-gray-300"
                               :name="`supplies_used[${idx}][name]`"
                               x-model="item.name"
                               placeholder="Ej: Guantes, gasas, etc.">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium">Cantidad</label>
                        <input type="number" min="0" step="0.01" class="w-full rounded-md border-gray-300"
                               :name="`supplies_used[${idx}][qty]`"
                               x-model="item.qty"
                               placeholder="0">
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="button" @click="removeSupply(idx)"
                                class="px-3 py-2 rounded-md border hover:bg-gray-50">
                            Quitar
                        </button>
                    </div>
                </div>
            </template>
        </div>

        @error('supplies_used') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        @error('supplies_used.*.name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        @error('supplies_used.*.qty') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- ===================== MODULO VI. TRASLADO ===================== --}}
    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Módulo VI. Traslado asistencial básico</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Transportado a</label>
                <input type="text" name="transport_to"
                       value="{{ old('transport_to', $isEdit ? $form->transport_to : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Municipio</label>
                <input type="text" name="transport_municipality"
                       value="{{ old('transport_municipality', $isEdit ? $form->transport_municipality : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Departamento</label>
                <input type="text" name="transport_department"
                       value="{{ old('transport_department', $isEdit ? $form->transport_department : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium">Hora inicio traslado</label>
                <input type="time" name="transfer_start_time"
                       value="{{ old('transfer_start_time', $timeValue($isEdit ? $form->transfer_start_time : null)) }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Fecha llegada IPS</label>
                <input type="date" name="ips_arrival_date"
                       value="{{ old('ips_arrival_date', $isEdit && $form->ips_arrival_date ? $form->ips_arrival_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Hora llegada IPS</label>
                <input type="time" name="ips_arrival_time"
                       value="{{ old('ips_arrival_time', $timeValue($isEdit ? $form->ips_arrival_time : null)) }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Estado de entrega</label>
                <select name="delivery_status" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    <option value="vivo" @selected(old('delivery_status', $isEdit ? $form->delivery_status : '')=='vivo')>Vivo</option>
                    <option value="muerto" @selected(old('delivery_status', $isEdit ? $form->delivery_status : '')=='muerto')>Muerto</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Nombre de quien recibe</label>
                <input type="text" name="receiver_name"
                       value="{{ old('receiver_name', $isEdit ? $form->receiver_name : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Documento</label>
                <input type="text" name="receiver_document"
                       value="{{ old('receiver_document', $isEdit ? $form->receiver_document : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Cargo</label>
                <input type="text" name="receiver_role"
                       value="{{ old('receiver_role', $isEdit ? $form->receiver_role : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">RG.MD</label>
                <input type="text" name="rg_md"
                       value="{{ old('rg_md', $isEdit ? $form->rg_md : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>
    </div>

    {{-- ===================== MODULO VII. DATOS DEL EVENTO ===================== --}}
    @php
        $eventCauseOptions = [
            'Enfermedad general','Accidente de tránsito','Accidente laboral','Accidente común','Lesión autoinfligida',
            'Evento catastrófico','Evento terrorista','Lesión por agresión','Violencia sexual','Otro'
        ];
        $patientQualityOptions = ['peatón','conductor','ocupante','ciclista','otro'];
    @endphp

    <div class="bg-white shadow rounded p-4 space-y-4">
        <h3 class="font-semibold text-lg">Módulo VII. Datos del evento</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Causa que origina la atención</label>
                <select name="event_cause" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($eventCauseOptions as $opt)
                        <option value="{{ $opt }}" @selected(old('event_cause', $isEdit ? $form->event_cause : '') == $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Modo de servicio</label>
                <select name="service_mode" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    <option value="sencillo" @selected(old('service_mode', $isEdit ? $form->service_mode : '')=='sencillo')>Sencillo</option>
                    <option value="redondo" @selected(old('service_mode', $isEdit ? $form->service_mode : '')=='redondo')>Redondo</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Ubicación del evento (U/R/O)</label>
                <select name="event_location_type" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($locations ?? ['U','R','O'] as $l)
                        <option value="{{ $l }}" @selected(old('event_location_type', $isEdit ? $form->event_location_type : '')==$l)>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Dirección del evento</label>
                <input type="text" name="event_address"
                       value="{{ old('event_address', $isEdit ? $form->event_address : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Municipio</label>
                <input type="text" name="event_municipality"
                       value="{{ old('event_municipality', $isEdit ? $form->event_municipality : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Departamento</label>
                <input type="text" name="event_department"
                       value="{{ old('event_department', $isEdit ? $form->event_department : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Calidad del paciente</label>
                <select name="patient_quality" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($patientQualityOptions as $opt)
                        <option value="{{ $opt }}" @selected(old('patient_quality', $isEdit ? $form->patient_quality : '')==$opt)>{{ ucfirst($opt) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Conductor involucrado</label>
                <input type="text" name="involved_driver_name"
                       value="{{ old('involved_driver_name', $isEdit ? $form->involved_driver_name : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Documento conductor involucrado</label>
                <input type="text" name="involved_driver_document"
                       value="{{ old('involved_driver_document', $isEdit ? $form->involved_driver_document : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Placa vehículo (SOAT involucrado)</label>
                <input type="text" name="soat_vehicle_plate"
                       value="{{ old('soat_vehicle_plate', $isEdit ? $form->soat_vehicle_plate : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Aseguradora SOAT</label>
                <input type="text" name="soat_insurance_name"
                       value="{{ old('soat_insurance_name', $isEdit ? $form->soat_insurance_name : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Número póliza SOAT</label>
                <input type="text" name="soat_policy_number"
                       value="{{ old('soat_policy_number', $isEdit ? $form->soat_policy_number : '') }}"
                       class="w-full rounded-md border-gray-300">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Placa vehículo (institución)</label>
                <select name="vehicle_id" class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" @selected(old('vehicle_id', $isEdit ? $form->vehicle_id : '') == $v->id)>
                            {{ $v->plate }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Responsable (usuario)</label>
                <select name="responsible_user_id"
                        x-model="responsibleId"
                        @change="syncResponsible()"
                        class="w-full rounded-md border-gray-300">
                    <option value="">Seleccione</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
                @error('responsible_user_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Cédula responsable</label>
                <input type="text"
                       name="responsible_document"
                       x-model="responsibleDoc"
                       readonly
                       class="w-full rounded-md border-gray-300 bg-gray-100">
                @error('responsible_document') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Observaciones</label>
            <textarea name="general_observations" rows="3"
                      class="w-full rounded-md border-gray-300">{{ old('general_observations', $isEdit ? $form->general_observations : '') }}</textarea>
        </div>
    </div>
</div>
