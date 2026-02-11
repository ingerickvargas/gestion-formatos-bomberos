<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Accidente de tránsito</title>
    <style>
        @page { margin: 18px 18px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color:#111; }
        .title { text-align:center; font-weight:700; font-size: 12px; margin-bottom: 6px; }
        .subtitle { text-align:center; font-size: 10px; margin-bottom: 10px; color:#444; }
        .box { border:1px solid #111; padding:6px; margin-bottom:8px; }
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #111; padding:4px; vertical-align: top; }
        th { background:#f2f2f2; font-weight:700; }
        .grid2 td { width:50%; }
        .grid3 td { width:33.33%; }
        .muted { color:#444; }
        .badge { display:inline-block; padding:2px 6px; border:1px solid #111; border-radius:10px; font-size:9px; }
    </style>
</head>
<body>
    <div class="title">FORMATO ACCIDENTE DE TRÁNSITO</div>
    <div class="subtitle">Registro #{{ $form->id }} — Diligenciado por: {{ $form->creator->name ?? '—' }}</div>
    <div class="box">
        <table class="grid2">
            <tr>
                <td><b>NUAP:</b> {{ $form->nuap ?? '-' }}</td>
                <td><b>Prioridad:</b> <span class="badge">{{ $form->priority ?? '-' }}</span></td>
            </tr>
            <tr>
                <td><b>Quién informa:</b> {{ $form->informer->name ?? '-' }}</td>
                <td><b>Historia clínica:</b> {{ $form->clinical_history ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>Fecha atención:</b> {{ optional($form->attention_date)->format('Y-m-d') ?? '-' }}</td>
                <td><b>Hora salida:</b> {{ $form->departure_time ?? '-' }} | <b>Hora atención:</b> {{ $form->attention_time ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo I. ANAMNESIS</b>
        <table>
            <tr>
                <th>Paciente / Víctima</th><th>Tipo Doc</th><th>No Doc</th><th>F. Nacimiento</th><th>Edad</th>
            </tr>
            <tr>
                <td>{{ $form->patient_name ?? '-' }}</td>
                <td>{{ $form->patient_doc_type ?? '-' }}</td>
                <td>{{ $form->patient_doc_number ?? '-' }}</td>
                <td>{{ optional($form->patient_birth_date)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $form->patient_age ?? '-' }}</td>
            </tr>
            <tr>
                <th>Sexo</th><th>Estado civil</th><th>Teléfono</th><th colspan="2">Dirección</th>
            </tr>
            <tr>
                <td>{{ $form->patient_sex ?? '-' }}</td>
                <td>{{ $form->patient_civil_status ?? '-' }}</td>
                <td>{{ $form->patient_phone ?? '-' }}</td>
                <td colspan="2">{{ $form->patient_address ?? '-' }}</td>
            </tr>
            <tr>
                <th>Ocupación</th><th>EPS</th><th colspan="3">Aseguradora</th>
            </tr>
            <tr>
                <td>{{ $form->patient_occupation ?? '-' }}</td>
                <td>{{ $form->eps ?? '-' }}</td>
                <td colspan="3">{{ $form->insurance_company ?? '-' }}</td>
            </tr>
            <tr>
                <th>Acompañante</th><th>Parentesco</th><th colspan="3">Teléfono</th>
            </tr>
            <tr>
                <td>{{ $form->companion_name ?? '-' }}</td>
                <td>{{ $form->companion_relationship ?? '-' }}</td>
                <td colspan="3">{{ $form->companion_phone ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo II. MOTIVO DE ATENCIÓN</b>
        <table>
            <tr><th>Observación</th></tr>
            <tr><td>{{ $form->reason_observation ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo III. EXAMEN FÍSICO</b>
        <table>
            <tr>
                <th>F.C</th><th>F.R</th><th>T.A</th><th>SPO2</th><th>T°</th><th>RO</th><th>RV</th><th>RM</th>
            </tr>
            <tr>
                <td>{{ $form->fc ?? '-' }}</td>
                <td>{{ $form->fr ?? '-' }}</td>
                <td>{{ $form->ta ?? '-' }}</td>
                <td>{{ $form->spo2 ?? '-' }}</td>
                <td>{{ $form->temperature ?? '-' }}</td>
                <td>{{ $form->ro ?? '-' }}</td>
                <td>{{ $form->rv ?? '-' }}</td>
                <td>{{ $form->rm ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alergias</th><th>Patologías</th><th>Medicamentos</th><th>Lividez</th><th>Llenado capilar</th><th colspan="3">Antecedentes</th>
            </tr>
            <tr>
                <td>{{ $form->allergies ?? '-' }}</td>
                <td>{{ $form->pathologies ?? '-' }}</td>
                <td>{{ $form->medications ?? '-' }}</td>
                <td>{{ $form->lividity ?? '-' }}</td>
                <td>{{ $form->capillary_refill ?? '-' }}</td>
                <td colspan="3">{{ $form->background ?? '-' }}</td>
            </tr>
            <tr><th colspan="8">Lesiones (marcadas)</th></tr>
            <tr><td colspan="8">{{ count($injuries) ? implode(', ', $injuries) : '-' }}</td></tr>
            <tr>
                <th colspan="4">Valoración primaria</th>
                <th colspan="4">Valoración secundaria</th>
            </tr>
            <tr>
                <td colspan="4">{{ $form->primary_assessment ?? '-' }}</td>
                <td colspan="4">{{ $form->secondary_assessment ?? '-' }}</td>
            </tr>
            <tr><th colspan="8">Impresión diagnóstica</th></tr>
            <tr><td colspan="8">{{ $form->diagnostic_impression ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo IV. PROCEDIMIENTOS</b>
        <table>
            <tr><th>Procedimientos realizados</th></tr>
            <tr><td>{{ count($procedures) ? implode(', ', $procedures) : '-' }}</td></tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo V. INSUMOS UTILIZADOS</b>
        <table>
            <tr><th>Insumo</th><th style="width:100px;">Cantidad</th></tr>
            @if(count($supplies))
                @foreach($supplies as $s)
                    <tr>
                        <td>{{ $s['name'] ?? '-' }}</td>
                        <td>{{ $s['qty'] ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="2">-</td></tr>
            @endif
        </table>
    </div>
    <div class="box">
        <b>Módulo VI. TRASLADO ASISTENCIAL BÁSICO</b>
        <table>
            <tr>
                <th>Transportado a</th><th>Municipio</th><th>Departamento</th>
            </tr>
            <tr>
                <td>{{ $form->transport_to ?? '-' }}</td>
                <td>{{ $form->transport_municipality ?? '-' }}</td>
                <td>{{ $form->transport_department ?? '-' }}</td>
            </tr>
            <tr>
                <th>Hora inicio traslado</th><th>Fecha llegada IPS</th><th>Hora llegada IPS</th>
            </tr>
            <tr>
                <td>{{ $form->transfer_start_time ?? '-' }}</td>
                <td>{{ optional($form->ips_arrival_date)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $form->ips_arrival_time ?? '-' }}</td>
            </tr>
            <tr>
                <th>Estado entrega</th><th>Recibe</th><th>Documento / Cargo</th>
            </tr>
            <tr>
                <td>{{ $form->delivery_status ?? '-' }}</td>
                <td>{{ $form->receiver_name ?? '-' }}</td>
                <td>{{ $form->receiver_document ?? '-' }} / {{ $form->receiver_role ?? '-' }}</td>
            </tr>
            <tr>
                <th colspan="2">RG.MD</th><th>—</th>
            </tr>
            <tr>
                <td colspan="2">{{ $form->rg_md ?? '-' }}</td><td>—</td>
            </tr>
        </table>
    </div>
    <div class="box">
        <b>Módulo VII. DATOS DEL EVENTO</b>
        <table>
            <tr>
                <th>Causa</th><th>Modo</th><th>Ubicación (U/R/O)</th>
            </tr>
            <tr>
                <td>{{ $form->event_cause ?? '-' }}</td>
                <td>{{ $form->service_mode ?? '-' }}</td>
                <td>{{ $form->event_location_type ?? '-' }}</td>
            </tr>
            <tr>
                <th colspan="2">Dirección</th><th>Municipio / Depto</th>
            </tr>
            <tr>
                <td colspan="2">{{ $form->event_address ?? '-' }}</td>
                <td>{{ $form->event_municipality ?? '-' }} / {{ $form->event_department ?? '-' }}</td>
            </tr>
            <tr>
                <th>Calidad paciente</th><th>Conductor involucrado</th><th>Documento</th>
            </tr>
            <tr>
                <td>{{ $form->patient_quality ?? '-' }}</td>
                <td>{{ $form->involved_driver_name ?? '-' }}</td>
                <td>{{ $form->involved_driver_document ?? '-' }}</td>
            </tr>
            <tr>
                <th>SOAT Placa</th><th>Aseguradora SOAT</th><th>Póliza</th>
            </tr>
            <tr>
                <td>{{ $form->soat_vehicle_plate ?? '-' }}</td>
                <td>{{ $form->soat_insurance_name ?? '-' }}</td>
                <td>{{ $form->soat_policy_number ?? '-' }}</td>
            </tr>
            <tr>
                <th>Vehículo institución</th><th>Responsable</th><th>Documento responsable</th>
            </tr>
            <tr>
                <td>{{ $form->vehicle->plate ?? '-' }}</td>
                <td>{{ $form->responsibleUser->name ?? '-' }}</td>
                <td>{{ $form->responsible_document ?? '-' }}</td>
            </tr>
            <tr><th colspan="3">Observaciones</th></tr>
            <tr><td colspan="3">{{ $form->general_observations ?? '-' }}</td></tr>
        </table>
    </div>
</body>
</html>
