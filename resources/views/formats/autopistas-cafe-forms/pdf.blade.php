<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario - Autopistas del Café</title>
    <style>
        @page { size: A4; margin: 8mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #000; }
        .t { width: 100%; border-collapse: collapse; }
        .t td, .t th { border: 1px solid #000; padding: 2px 3px; vertical-align: middle; }
        .no-b { border: 0 !important; }
        .b2 { border: 2px solid #000 !important; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .upper { text-transform: uppercase; }
        .gray { background: #e6e6e6; }
        .gray2 { background: #f2f2f2; }
        .redbar { background: #b00000; color: #fff; }
        .softred { background: #e6bcbc; }
        .h18 { height: 18px; }
        .h22 { height: 22px; }
        .h28 { height: 28px; }
        .small { font-size: 8px; }
        .tiny { font-size: 7px; }
        .box { border: 2px solid #000; padding: 0; }
        .vlabel-soft {
            width: 18px;
            background: #e6bcbc;
            color: #000;
            text-align: center;
            font-weight: bold;
        }
        .vlabel {
			background-color: #d9534f; /* Color rojizo de tu imagen */
			color: white;
			font-weight: bold;
			text-align: center;
			width: 30px; /* Ajusta según necesites */
			padding: 0;
		}

		.rotate {
			/* DomPDF maneja mejor el rotado con display: block */
			display: block;
			transform: rotate(-90deg);
			white-space: nowrap;
			width: 20px;
			/* Centrado óptico */
			margin-left: auto;
			margin-right: auto;
		}
        .xbox { display: inline-block; width: 10px; height: 10px; border: 1px solid #000; text-align: center; line-height: 10px; font-weight: bold; font-size: 9px; }
        .sp { margin-top: 4px; }

        img { display: block; }
    </style>
</head>
<body>

@php
    // ===== Helpers =====
    $fmtDate = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('Y-m-d') : '';
    $fmtTime = fn($t) => $t ? \Carbon\Carbon::parse($t)->format('H:i') : '';

    $mark = function($cond) { return $cond ? 'X' : ''; };

    $docTypes = ['CC','TI','RC','CE'];

    // Siempre mostramos 2 vehículos y 4 acompañantes (2 por vehículo)
    $vehicles = $form->vehicles ?? collect();
    $v1 = $vehicles->get(0);
    $v2 = $vehicles->get(1);

    $v1c1 = $v1?->companions?->get(0);
    $v1c2 = $v1?->companions?->get(1);

    $v2c1 = $v2?->companions?->get(0);
    $v2c2 = $v2?->companions?->get(1);

    // Si manejas AM/MQ/UR en un campo, ajusta acá:
    // Ej: $form->vehicle_scope = 'AM'|'MQ'|'UR'
    $scope = $form->vehicle_scope ?? null;
@endphp

<table class="t no-b" style="border:0; margin-bottom: 4px;">
    <tr>
        <td class="no-b" style="width: 20%;">
            <div style="border:1px solid #aaa; width:70px; height:70px; text-align:center; line-height:70px;">
                @php $logoBomberos = public_path('images/logo-bomberos-colombia.jpg'); @endphp
                @if(file_exists($logoBomberos))
                    <img src="{{ $logoBomberos }}" style="width:70px; height:70px; object-fit:contain;">
                @else
                    LOGO BOMBEROS
                @endif
            </div>
        </td>

        <td class="no-b left" style="width: 60%;">
            <div class="bold upper" style="font-size: 14px;">REPÚBLICA DE COLOMBIA</div>
            <div class="bold" style="font-size: 10px;">Benemérito Cuerpo de Bomberos Voluntarios de La Tebaida</div>
            <div style="font-size: 9px;">Departamento del Quindío</div>
            <div class="bold" style="font-size: 10px; margin-top: 2px;">NIT. 890.000.590-3</div>
            <div class="tiny upper" style="margin-top: 2px;">ENTIDAD PRIVADA SIN ANIMO DE LUCRO</div>
        </td>

        <td class="w-24 flex flex-col items-center">
            <div style=" width:90px; height:50px; text-align:center; line-height:50px; margin-left:auto;">
                @php $logoAuto = public_path('images/logo-autopista.jpg'); @endphp
                @if(file_exists($logoAuto))
                    <img src="{{ $logoAuto }}" style="width:90px; height:60px; object-fit:contain;">
                @else
                    LOGO CONCESIÓN
                @endif
            </div>
            <div class="redbar center tiny text-white text-[7px] w-full text-center px-1 py-0.5 mt-1" style="padding: 2px; margin-top: 2px;">
                TRAMO VIAL LA PAILA - VERSALLES
            </div>
        </td>
    </tr>
</table>

<table class="t no-b" style="border:0; margin-bottom: 4px; width: 100%;">
    <tr>
        <td class="no-b" style="width:65%; vertical-align: middle;">
            <div class="bold upper" style="font-size: 18px; color:#b00000; line-height: 1;">
                FORMULARIO DE ATENCIÓN DE EVENTOS
            </div>
        </td>
        <td class="no-b" style="width:35%; vertical-align: middle;">
            <table class="t b2" style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="font-size: 11px; width: 35%; padding: 5px;">
                        RADICADO
                    </td>
                    <td class="center bold" style="font-size: 16px; height: 30px; background-color: white;">
                        {{ $form->radicado ?? '' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="t b2">
    <tr class="gray bold center">
        <td>FECHA</td>
        <td>HORA SALIDA</td>
        <td>HORA SITIO</td>
        <td>HORA REGRESO</td>
        <td>KM INICIAL</td>
        <td>KM EVENTO</td>
        <td>KM FINAL</td>
        <td colspan="6">VEHÍCULO</td>
		<td>PLACA</td>
    </tr>
    <tr class="center h18">
        <td>{{ $fmtDate($form->event_date) }}</td>
        <td>{{ $fmtTime($form->departure_time) }}</td>
        <td>{{ $fmtTime($form->site_time) }}</td>
        <td>{{ $fmtTime($form->return_time) }}</td>
        <td>{{ $form->km_initial ?? '' }}</td>
        <td>{{ $form->km_event ?? '' }}</td>
        <td>{{ $form->km_final ?? '' }}</td>

        <td class="gray bold" style="width:20px;">AM</td>
        <td style="width:20px;">{{ $mark($scope==='AM') }}</td>
        <td class="gray bold" style="width:20px;">MQ</td>
        <td style="width:20px;">{{ $mark($scope==='MQ') }}</td>
		<td class="gray bold" style="width:20px;">UR</td>
        <td style="width:20px;">{{ $mark($scope==='UR') }}</td>	
		<td>{{ $form->plate ?? '' }}</td>
    </tr>

    <tr>
        <td class="gray bold center">EVENTO</td>
		<td colspan="7">{{ $form->event ?? '' }}</td>
		<td class="gray bold center">KILOMETRO</td>
		<td colspan="5">{{ $form->kilometer ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2" class="gray bold center">SITIO DEL EVENTO</td>
		<td colspan="4">{{ $form->event_site ?? '' }}</td>
        <td colspan="3" class="gray bold center">PUNTO DE REFERENCIA</td>
		<td colspan="5">{{ $form->reference_point ?? '' }}</td>
    </tr>
</table>

<div class="sp"></div>



{{-- VEHÍCULO 1 --}}
@php
$docType = $v1?->driver_doc_type ?? null;
$trans = $v1?->transferred ?? null;
echo '<table class="t b2" style="margin-bottom: 4px;">';
echo '<tr><td class="vlabel" rowspan="9"><div class="rotate">VEHÍCULO 1</div></td>';
echo '<td class="gray bold center" style="width:70px;">TIPO</td>';
echo '<td style="width:140px;">'.($v1?->vehicle_type ?? '').'</td>';
echo '<td class="gray2 bold" style="width:80px;">CONDUCTOR</td>';
echo '<td colspan="7">'.($v1?->driver_name ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">MARCA</td>';
echo '<td>'.($v1?->brand ?? '').'</td>';
echo '<td class="gray2 bold">DOCUMENTO</td>';
echo '<td colspan="3" class="small">';
foreach($docTypes as $type) {
    $chk = $mark($docType===$type);
    echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$chk.'</span></span>';
}
echo '</td><td class="gray2 bold" style="width:60px;">N°</td>';
echo '<td colspan="3">'.($v1?->driver_document ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">MODELO</td>';
echo '<td>'.($v1?->model ?? '').'</td>';
echo '<td class="gray2 bold">EDAD</td>';
echo '<td>'.($v1?->driver_age ?? '').'</td>';
echo '<td class="gray2 bold">TELÉFONO</td>';
echo '<td colspan="5">'.($v1?->driver_phone ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">COLOR</td>';
echo '<td>'.($v1?->color ?? '').'</td>';
echo '<td class="gray2 bold">DIRECCIÓN</td>';
echo '<td colspan="7">'.($v1?->driver_address ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">PLACA</td>';
echo '<td>'.($v1?->plate ?? '').'</td>';
echo '<td class="gray2 bold">PRESENTA</td>';
echo '<td colspan="7" style="height: 30px; vertical-align: top;">'.($v1?->presents ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">REMOLQUE</td>';
echo '<td>'.($v1?->trailer ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray2 bold">N° INTERNO</td>';
echo '<td>'.($v1?->internal_number ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray2 bold">RUTA</td>';
echo '<td>'.($v1?->route ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray bold center">TRASLADADO</td>';
echo '<td class="center" colspan="1">SI <span class="xbox">'.$mark($trans==='Si').'</span>&nbsp; NO <span class="xbox">'.$mark($trans==='No').'</span></td>';
echo '<td class="gray bold center">DESTINO</td>';
echo '<td colspan="2">'.($v1?->destination ?? '').'</td>';
echo '<td class="gray bold center">RADICADO</td>';
echo '<td colspan="4">'.($v1?->radicado ?? '').'</td></tr>';
echo '</table>';
@endphp

{{-- Acompañantes del vehículo 1 (2 cajas) --}}
<table class="t no-b" style="border:0; margin-bottom:4px;">
    <tr>
        <td class="no-b" style="width:50%; padding-right:2px;">
            @php
            $c = $v1c1 ?? (object)[];
            $docType = $c->doc_type ?? null;
            $trans = $c->transferred ?? null;
            echo '<table class="t b2" style="margin-bottom:4px;">';
            echo '<tr><td class="vlabel" rowspan="7"><div class="rotate">ACOMPAÑANTE #1</div></td>';
            echo '<td class="gray2 bold" style="width:80px;">NOMBRE</td>';
            echo '<td colspan="5">'.($c->name ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DOCUMENTO</td>';
            echo '<td colspan="5" class="small">';
            foreach($docTypes as $type) {
                echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$mark($docType===$type).'</span></span>';
            }
            echo '<span style="margin-left:8px;">N°: '.($c->doc_number ?? '').'</span></td></tr>';
            echo '<tr><td class="gray2 bold">EDAD</td>';
            echo '<td style="width:50px;">'.($c->age ?? '').'</td>';
            echo '<td class="gray2 bold" style="width:70px;">TELÉFONO</td>';
            echo '<td colspan="3">'.($c->phone ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DIRECCIÓN</td>';
            echo '<td colspan="5">'.($c->address ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">PRESENTA</td>';
            echo '<td colspan="5" style="height: 26px; vertical-align: top;">'.($c->presents ?? '').'</td></tr>';
            echo '<tr><td class="gray bold center">TRASLADADO</td>';
            echo '<td class="left" colspan="1">SI<span class="xbox">'.$mark($trans==='Si').'</span>&nbsp;NO<span class="xbox">'.$mark($trans==='No').'</span></td>';
            echo '<td class="gray bold center">RADICADO</td>';
            echo '<td colspan="3">'.($c->radicado ?? '').'</td></tr>';
			echo '<tr><td class="gray bold left">DESTINO</td>';
			echo '<td colspan="5">'.($c->destination ?? '').'</td></tr>';
            echo '</table>';
            @endphp
        </td>
        <td class="no-b" style="width:50%; padding-left:2px;">
            @php
            $c = $v1c2 ?? (object)[];
            $docType = $c->doc_type ?? null;
            $trans = $c->transferred ?? null;
            echo '<table class="t b2" style="margin-bottom:4px;">';
            echo '<tr><td class="vlabel" rowspan="7"><div class="rotate">ACOMPAÑANTE #2</div></td>';
            echo '<td class="gray2 bold" style="width:80px;">NOMBRE</td>';
            echo '<td colspan="5">'.($c->name ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DOCUMENTO</td>';
            echo '<td colspan="5" class="small">';
            foreach($docTypes as $type) {
                echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$mark($docType===$type).'</span></span>';
            }
            echo '<span style="margin-left:8px;">N°: '.($c->doc_number ?? '').'</span></td></tr>';
            echo '<tr><td class="gray2 bold">EDAD</td>';
            echo '<td style="width:50px;">'.($c->age ?? '').'</td>';
            echo '<td class="gray2 bold" style="width:70px;">TELÉFONO</td>';
            echo '<td colspan="3">'.($c->phone ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DIRECCIÓN</td>';
            echo '<td colspan="5">'.($c->address ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">PRESENTA</td>';
            echo '<td colspan="5" style="height: 26px; vertical-align: top;">'.($c->presents ?? '').'</td></tr>';
            echo '<tr><td class="gray bold center">TRASLADADO</td>';
            echo '<td class="left" colspan="1">SI<span class="xbox">'.$mark($trans==='Si').'</span>&nbsp;NO<span class="xbox">'.$mark($trans==='No').'</span></td>';
            echo '<td class="gray bold center">RADICADO</td>';
            echo '<td colspan="3">'.($c->radicado ?? '').'</td></tr>';
			echo '<tr><td class="gray bold left">DESTINO</td>';
			echo '<td colspan="5">'.($c->destination ?? '').'</td></tr>';
            echo '</table>';
            @endphp
        </td>
    </tr>
</table>

{{-- VEHÍCULO 2 (aunque no exista, lo mostramos vacío) --}}
@php
$docType = $v2?->driver_doc_type ?? null;
$trans = $v2?->transferred ?? null;
echo '<table class="t b2" style="margin-bottom: 4px;">';
echo '<tr><td class="vlabel" rowspan="9"><div class="rotate">VEHÍCULO 2</div></td>';
echo '<td class="gray bold center" style="width:70px;">TIPO</td>';
echo '<td style="width:140px;">'.($v2?->vehicle_type ?? '').'</td>';
echo '<td class="gray2 bold" style="width:80px;">CONDUCTOR</td>';
echo '<td colspan="7">'.($v2?->driver_name ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">MARCA</td>';
echo '<td>'.($v2?->brand ?? '').'</td>';
echo '<td class="gray2 bold">DOCUMENTO</td>';
echo '<td colspan="3" class="small">';
foreach($docTypes as $type) {
    $chk = $mark($docType===$type);
    echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$chk.'</span></span>';
}
echo '</td><td class="gray2 bold" style="width:60px;">N°</td>';
echo '<td colspan="3">'.($v2?->driver_document ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">MODELO</td>';
echo '<td>'.($v2?->model ?? '').'</td>';
echo '<td class="gray2 bold">EDAD</td>';
echo '<td>'.($v2?->driver_age ?? '').'</td>';
echo '<td class="gray2 bold">TELÉFONO</td>';
echo '<td colspan="5">'.($v2?->driver_phone ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">COLOR</td>';
echo '<td>'.($v2?->color ?? '').'</td>';
echo '<td class="gray2 bold">DIRECCIÓN</td>';
echo '<td colspan="7">'.($v2?->driver_address ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">PLACA</td>';
echo '<td>'.($v2?->plate ?? '').'</td>';
echo '<td class="gray2 bold">PRESENTA</td>';
echo '<td colspan="7" style="height: 30px; vertical-align: top;">'.($v2?->presents ?? '').'</td></tr>';
echo '<tr><td class="gray2 bold">REMOLQUE</td>';
echo '<td>'.($v2?->trailer ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray2 bold">N° INTERNO</td>';
echo '<td>'.($v2?->internal_number ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray2 bold">RUTA</td>';
echo '<td>'.($v2?->route ?? '').'</td>';
echo '<td colspan="8"> </td></tr>';
echo '<tr><td class="gray bold center">TRASLADADO</td>';
echo '<td class="center" colspan="1">SI <span class="xbox">'.$mark($trans==='Si').'</span>&nbsp; NO <span class="xbox">'.$mark($trans==='No').'</span></td>';
echo '<td class="gray bold center">DESTINO</td>';
echo '<td colspan="2">'.($v2?->destination ?? '').'</td>';
echo '<td class="gray bold center">RADICADO</td>';
echo '<td colspan="4">'.($v2?->radicado ?? '').'</td></tr>';
echo '</table>';
@endphp

<table class="t no-b" style="border:0; margin-bottom:4px;">
    <tr>
        <td class="no-b" style="width:50%; padding-right:2px;">
            @php
            $c = $v2c1 ?? (object)[];
            $docType = $c->doc_type ?? null;
            $trans = $c->transferred ?? null;
            echo '<table class="t b2" style="margin-bottom:4px;">';
            echo '<tr><td class="vlabel" rowspan="7"><div class="rotate">ACOMPAÑANTE #3</div></td>';
            echo '<td class="gray2 bold" style="width:80px;">NOMBRE</td>';
            echo '<td colspan="5">'.($c->name ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DOCUMENTO</td>';
            echo '<td colspan="5" class="small">';
            foreach($docTypes as $type) {
                echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$mark($docType===$type).'</span></span>';
            }
            echo '<span style="margin-left:8px;">N°: '.($c->doc_number ?? '').'</span></td></tr>';
            echo '<tr><td class="gray2 bold">EDAD</td>';
            echo '<td style="width:50px;">'.($c->age ?? '').'</td>';
            echo '<td class="gray2 bold" style="width:70px;">TELÉFONO</td>';
            echo '<td colspan="3">'.($c->phone ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DIRECCIÓN</td>';
            echo '<td colspan="5">'.($c->address ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">PRESENTA</td>';
            echo '<td colspan="5" style="height: 26px; vertical-align: top;">'.($c->presents ?? '').'</td></tr>';
            echo '<tr><td class="gray bold center">TRASLADADO</td>';
            echo '<td class="left" colspan="1">SI<span class="xbox">'.$mark($trans==='Si').'</span>&nbsp;NO<span class="xbox">'.$mark($trans==='No').'</span></td>';
            echo '<td class="gray bold center">RADICADO</td>';
            echo '<td colspan="3">'.($c->radicado ?? '').'</td></tr>';
			echo '<tr><td class="gray bold left">DESTINO</td>';
			echo '<td colspan="5">'.($c->destination ?? '').'</td></tr>';
            echo '</table>';
            @endphp
        </td>
        <td class="no-b" style="width:50%; padding-left:2px;">
            @php
            $c = $v2c2 ?? (object)[];
            $docType = $c->doc_type ?? null;
            $trans = $c->transferred ?? null;
            echo '<table class="t b2" style="margin-bottom:4px;">';
            echo '<tr><td class="vlabel" rowspan="7"><div class="rotate">ACOMPAÑANTE #4</div></td>';
            echo '<td class="gray2 bold" style="width:80px;">NOMBRE</td>';
            echo '<td colspan="5">'.($c->name ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DOCUMENTO</td>';
            echo '<td colspan="5" class="small">';
            foreach($docTypes as $type) {
                echo '<span style="margin-right:4px;">'.$type.' <span class="xbox">'.$mark($docType===$type).'</span></span>';
            }
            echo '<span style="margin-left:8px;">N°: '.($c->doc_number ?? '').'</span></td></tr>';
            echo '<tr><td class="gray2 bold">EDAD</td>';
            echo '<td style="width:50px;">'.($c->age ?? '').'</td>';
            echo '<td class="gray2 bold" style="width:70px;">TELÉFONO</td>';
            echo '<td colspan="3">'.($c->phone ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">DIRECCIÓN</td>';
            echo '<td colspan="5">'.($c->address ?? '').'</td></tr>';
            echo '<tr><td class="gray2 bold">PRESENTA</td>';
            echo '<td colspan="5" style="height: 26px; vertical-align: top;">'.($c->presents ?? '').'</td></tr>';
            echo '<tr><td class="gray bold center">TRASLADADO</td>';
            echo '<td class="left" colspan="1">SI<span class="xbox">'.$mark($trans==='Si').'</span>&nbsp;NO<span class="xbox">'.$mark($trans==='No').'</span></td>';
            echo '<td class="gray bold center">RADICADO</td>';
            echo '<td colspan="3">'.($c->radicado ?? '').'</td></tr>';
			echo '<tr><td class="gray bold left">DESTINO</td>';
			echo '<td colspan="5">'.($c->destination ?? '').'</td></tr>';
            echo '</table>';
            @endphp
        </td>
    </tr>
</table>

<table class="t b2" style="margin-bottom:4px;">
    <tr class="gray bold center">
        <td style="width:120px;">AUTORIZADO</td>
        <td>HORA SALIDA</td>
        <td>HORA SITIO</td>
        <td>HORA REGRESO</td>
        <td>KM INICIAL</td>
        <td>KM EVENTO</td>
        <td>KM FINAL</td>
        <td style="width:110px;">PLACA</td>
    </tr>
    <tr class="center h18">
        <td>{{ $form->authorized ?? '' }}</td>
        <td>{{ $fmtTime($form->authorized_departure_time) }}</td>
        <td>{{ $fmtTime($form->authorized_site_time) }}</td>
        <td>{{ $fmtTime($form->authorized_return_time) }}</td>
        <td>{{ $form->authorized_km_initial ?? '' }}</td>
        <td>{{ $form->authorized_km_event ?? '' }}</td>
        <td>{{ $form->authorized_km_final ?? '' }}</td>
        <td>{{ $form->authorized_plate ?? '' }}</td>
    </tr>
</table>

<table class="t b2">
    <tr>
        <td class="gray bold" style="width:180px;">FUNCIONARIO QUE REPORTA</td>
        <td colspan="6">{{ $form->reporting_officer ?? '' }}</td>
    </tr>
    <tr>
        <td class="gray bold">INSPECTOR VIAL</td>
        <td colspan="6">{{ $form->road_inspector ?? '' }}</td>
    </tr>
    <tr>
        <td class="gray bold">HOSPITAL QUE RECIBE</td>
        <td colspan="6">{{ $form->receiving_hospital ?? '' }}</td>
    </tr>
    <tr>
        <td class="gray bold">CONDUCTOR</td>
        <td>{{ $form->driver_name ?? '' }}</td>
		<td class="gray bold">TRIPULANTE</td>
        <td colspan="4">{{ $form->crew_member ?? '' }}</td>
    </tr>
</table>

<div class="center tiny" style="margin-top:4px; color:#666;">
    COD: FAE-AUTOCAFÉ / VERSIÓN 2.0 / 02-01-2020
</div>

</body>
</html>
