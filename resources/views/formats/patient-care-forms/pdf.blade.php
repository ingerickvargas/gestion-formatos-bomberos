<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Formulario atención a pacientes</title>
    <style>
        @page { margin: 18px 18px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color: #111; }

        .title { text-align:center; font-weight:700; font-size: 12px; margin-bottom: 6px; }
        .subtitle { text-align:center; font-size: 10px; margin-bottom: 10px; }
        .box { border:1px solid #111; padding:6px; margin-bottom:8px; }

        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #111; padding:4px; vertical-align: top; }
        th { background:#f2f2f2; font-weight:700; }
        .grid2 td { width:50%; }
        .muted { color:#444; }

        .page { page-break-after: always; }
        .page:last-child { page-break-after: auto; }

        .report-head { margin-bottom: 10px; }
    </style>
</head>
<body>

    {{-- Encabezado general del reporte (opcional) --}}
    @if(isset($month))
        <div class="report-head">
            <div class="subtitle">
                <b>Mes:</b> {{ $month->format('Y-m') }}
                @if(!empty($filters['vehicle_id'] ?? null))
                    — <b>Vehículo:</b> {{ $filters['vehicle_id'] }}
                @endif
                @if(!empty($filters['search'] ?? null))
                    — <b>Búsqueda:</b> {{ $filters['search'] }}
                @endif
            </div>
        </div>
    @endif

    @forelse($forms as $form)
        <div class="page">
            <div class="title">FORMULARIO DE ATENCIÓN A PACIENTES</div>

            <div class="box">
                <table class="grid2">
                    <tr>
                        <td><b>Fecha:</b> {{ optional($form->filled_date)->format('Y-m-d') ?? '-' }}</td>
                        <td><b>Hora salida:</b> {{ $form->departure_time ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><b>Vehículo (placa):</b> {{ $form->vehicle->plate ?? '-' }}</td>
                        <td><b>Ubicación:</b> {{ $form->location_type ?? '-' }} | <b>Clase evento:</b> {{ $form->event_class ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Dirección evento:</b> {{ $form->event_address ?? '-' }} — <b>Ciudad:</b> {{ $form->event_city ?? '-' }} — <b>Depto:</b> {{ $form->event_department ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>1. Información general del paciente</b>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo Doc</th>
                        <th>No Doc</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                    </tr>
                    <tr>
                        <td>{{ $form->patient_name ?? '-' }}</td>
                        <td>{{ $form->patient_doc_type ?? '-' }}</td>
                        <td>{{ $form->patient_doc_number ?? '-' }}</td>
                        <td>{{ $form->patient_age ?? '-' }}</td>
                        <td>{{ $form->patient_phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Dirección</th>
                        <th colspan="3">Ocupación</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $form->patient_address ?? '-' }}</td>
                        <td colspan="3">{{ $form->patient_occupation ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>2. Valoración del paciente</b>
                <table>
                    <tr>
                        <th>Pulso</th>
                        <th>Resp.</th>
                        <th>P/A</th>
                        <th>SPO2</th>
                        <th>Temp.</th>
                        <th>RO</th>
                        <th>RV</th>
                        <th>RM</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td>{{ $form->v_pulse ?? '-' }}</td>
                        <td>{{ $form->v_respiration ?? '-' }}</td>
                        <td>{{ $form->v_pa ?? '-' }}</td>
                        <td>{{ $form->v_spo2 ?? '-' }}</td>
                        <td>{{ $form->v_temperature ?? '-' }}</td>
                        <td>{{ $form->v_ro ?? '-' }}</td>
                        <td>{{ $form->v_rv ?? '-' }}</td>
                        <td>{{ $form->v_rm ?? '-' }}</td>
                        <td>{{ $form->v_total ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Observación general</th>
                    </tr>
                    <tr>
                        <td colspan="9">{{ $form->v_general_observation ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            @php
                $procedures = $form->procedures ?? [];
                if (is_string($procedures)) {
                    $decoded = json_decode($procedures, true);
                    $procedures = is_array($decoded) ? $decoded : [];
                }
            @endphp

            <div class="box">
                <b>3. Procedimientos realizados</b>
                <table>
                    <tr>
                        <th>Procedimientos (marcados)</th>
                        <th>SSN 0.9%</th>
                        <th>Lactato (g/m)</th>
                        <th>Dextrosa (g/m)</th>
                    </tr>
                    <tr>
                        <td>{{ count($procedures) ? implode(', ', $procedures) : '-' }}</td>
                        <td>{{ $form->ssn_09 ?? '-' }}</td>
                        <td>{{ $form->lactato ?? '-' }}</td>
                        <td>{{ $form->dextrosa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Descripción procedimiento</th>
                    </tr>
                    <tr>
                        <td colspan="4">{{ $form->procedure_description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alergias</th>
                        <th>Medicamentos</th>
                        <th>Patologías</th>
                        <th>Ambiente</th>
                    </tr>
                    <tr>
                        <td>{{ $form->allergies ?? '-' }}</td>
                        <td>{{ $form->medications ?? '-' }}</td>
                        <td>{{ $form->pathologies ?? '-' }}</td>
                        <td>{{ $form->environment ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Observaciones generales</th>
                    </tr>
                    <tr>
                        <td colspan="4">{{ $form->general_notes ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>4. Transporte</b>
                <table>
                    <tr>
                        <th>Estado entrega</th>
                        <th>Hora entrega</th>
                        <th>Pertenencias</th>
                        <th>Quién recibe</th>
                        <th>Cédula recibe</th>
                    </tr>
                    <tr>
                        <td>{{ $form->delivery_status ?? '-' }}</td>
                        <td>{{ $form->delivery_time ?? '-' }}</td>
                        <td>{{ is_null($form->belongings) ? '-' : ($form->belongings ? 'Sí' : 'No') }}</td>
                        <td>{{ $form->receiver_name ?? '-' }}</td>
                        <td>{{ $form->receiver_document ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Transportado a (ciudad)</th>
                        <th colspan="3">Código</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $form->transported_to ?? '-' }}</td>
                        <td colspan="3">{{ $form->transport_code ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>5. Acompañante y/o responsable</b>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                    </tr>
                    <tr>
                        <td>{{ $form->companion_name ?? '-' }}</td>
                        <td>{{ $form->companion_document ?? '-' }}</td>
                        <td>{{ $form->companion_phone ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>6. Responsable de la atención</b>
                <table>
                    <tr>
                        <th>Conductor</th>
                        <th>Tripulante 1</th>
                        <th>Tripulante 2</th>
                    </tr>
                    <tr>
                        <td>{{ $form->driverUser->name ?? '-' }} ({{ $form->driverUser->document ?? '-' }})</td>
                        <td>{{ $form->crew1User->name ?? '-' }} ({{ $form->crew1User->document ?? '-' }})</td>
                        <td>{{ $form->crew2User->name ?? '-' }} ({{ $form->crew2User->document ?? '-' }})</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <b>7. Evaluación del servicio</b>
                <table>
                    <tr>
                        <th>Servicio</th>
                        <th>Personal</th>
                        <th>Medios</th>
                        <th>Recomendaría</th>
                    </tr>
                    <tr>
                        <td>{{ $form->service_evaluation['service'] ?? '-' }}</td>
                        <td>{{ $form->service_evaluation['staff'] ?? '-' }}</td>
                        <td>{{ $form->service_evaluation['means'] ?? '-' }}</td>
                        <td>{{ $form->service_evaluation['recommend'] ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @empty
        <div class="box" style="text-align:center;">No hay registros para el filtro seleccionado.</div>
    @endforelse

</body>
</html>
