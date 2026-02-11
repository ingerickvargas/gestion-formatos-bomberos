@php
    $logoPath = public_path('images/logo-bomberos.png');
    $logoBase64 = null;
    if (file_exists($logoPath)) {
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        $data = file_get_contents($logoPath);
        $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
@endphp

<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<style>
			@page { margin: 22px 22px 18px 22px; }
			body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color:#111; }
			.header-table { width: 100%; border-collapse: collapse; }
			.header-table td { vertical-align: middle; border: 1px solid #000; padding: 6px; }
			.logo { width: 95px; }
			.title { text-align: center; font-size: 11px; font-weight: 700; line-height: 1.2; }
			.subtitle { text-align: center; font-size: 9px; font-weight: 600; margin-top: 2px; }
			.meta { font-size: 9px; line-height: 1.25; }
			.meta b { font-weight: 700; }
			.mt-10 { margin-top: 10px; }
			.table { width: 100%; border-collapse: collapse; }
			.table th, .table td { border: 1px solid #000; padding: 4px; vertical-align: top; }
			.table th { background: #6B51ED; font-weight: 700; text-align: center; font-size: 9px; }
			.table td { font-size: 9px; }
			.center { text-align: center; }
			.right { text-align: right; }
			.small { font-size: 8px; }
		</style>
	</head>
	<body>
		<table class="header-table">
			<tr>
				<td style="width: 18%; text-align:center;">
					@if($logoBase64)
						<img src="{{ $logoBase64 }}" class="logo" alt="Bomberos">
					@else
						<div class="small">LOGO NO ENCONTRADO</div>
					@endif
				</td>
				<td style="width: 62%;">
					<div class="title">PROGRAMA DE SEGURIDAD DEL PACIENTE</div>
					<div class="subtitle">CAJA DE HERRAMIENTAS</div>
					<div class="subtitle">PROCESOS PRIORITARIOS</div>
					<div class="title" style="margin-top:3px;">REGISTRO DE USUARIOS       M-</div>
					<div class="subtitle">VERSIÓN 1.0-2018</div>
				</td>
				<td style="width: 20%;">
					<div class="meta">
						<b>CUERPO DE BOMBEROS VOLUNTARIOS DE LA TEBAIDA TRANSPORTES ASISTENCIAL BASICO-ATENCIÓN PREHOSPITALARIA</b>
					</div>
				</td>
			</tr>
		</table>
		<div class="mt-5">
			<table class="table">
				<thead>
					<tr>
						<th style="width: 4%;">ITEM</th>
						<th style="width: 15%;">NOMBRE PACIENTE</th>
						<th style="width: 10%;">NO. DOCUMENTO</th>
						<th style="width: 5%;">EDAD</th>
						<th style="width: 10%;">NO. TELÉFONO</th>
						<th style="width: 10%;">TIPO DE CONSULTA</th>
						<th style="width: 10%;">QUIÉN REALIZA</th>
						<th style="width: 14%;">PROCEDIMIENTO</th>
						<th style="width: 7%;">FECHA ATENCIÓN</th>
						<th style="width: 7%;">HORA ATENCIÓN</th>
						<th style="width: 8%;">OBSERVACIONES</th>
					</tr>
				</thead>
				<tbody>
					@forelse($records as $i => $r)
						<tr>
							<td class="center">{{ $i + 1 }}</td>
							<td>{{ $r->patient_name }}</td>
							<td class="center">{{ $r->document }}</td>
							<td class="center">{{ $r->age ?? '' }}</td>
							<td class="center">{{ $r->phone ?? '' }}</td>
							<td class="center">{{ $r->service_type ?? '' }}</td>
							<td>{{ data_get($r->extras, 'quien_realiza', '') }}</td>
							<td>{{ $r->procedure ?? '' }}</td>
							<td class="center">{{ data_get($r->extras, 'fecha_atencion', '') }}</td>
							<td class="center">{{ data_get($r->extras, 'hora_atencion', '') }}</td>
							<td>{{ $r->observations ?? '' }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="11" class="center">No hay registros para los filtros seleccionados.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</body>
</html>
