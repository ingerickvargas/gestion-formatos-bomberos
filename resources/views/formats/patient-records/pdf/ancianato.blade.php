@php
    $logoPath = public_path('images/logo-latebaida.png');
    $logoPath2 = public_path('images/logo-bomberos.png');
    $logoPath3 = public_path('images/logo-bomberos-colombia.jpg');
    $logoPath4 = public_path('images/logo-ancianato.png');
    $logoBase64 = null;
    $logoBase64_b = null;
    $logoBase64_bc = null;
    $logoBase64_a = null;
    if (file_exists($logoPath) || file_exists($logoPath2) || file_exists($logoPath3) || file_exists($logoPath4) ) {
        $type1 = pathinfo($logoPath, PATHINFO_EXTENSION);
        $data1 = file_get_contents($logoPath);
        $type2 = pathinfo($logoPath2, PATHINFO_EXTENSION);
        $data2 = file_get_contents($logoPath2);
        $type3 = pathinfo($logoPath3, PATHINFO_EXTENSION);
        $data3 = file_get_contents($logoPath3);
        $type4 = pathinfo($logoPath4, PATHINFO_EXTENSION);
        $data4 = file_get_contents($logoPath4);
        $logoBase64 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
        $logoBase64_b = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
        $logoBase64_bc = 'data:image/' . $type3 . ';base64,' . base64_encode($data3);
        $logoBase64_a = 'data:image/' . $type4 . ';base64,' . base64_encode($data4);
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
			.header-table td { vertical-align: middle; border: 1px solid transparent; padding: 8px; }
			.logo { width: 95px; }
			.title { text-align: center; font-size: 11px; font-weight: 700; line-height: 1.2; }
			.subtitle { text-align: center; font-size: 9px; font-weight: 600; margin-top: 2px; }
			.meta { font-size: 9px; line-height: 1.25; }
			.meta b { font-weight: 700; }
			.mt-10 { margin-top: 10px; }
			.table { width: 100%; border-collapse: collapse; }
			.table th, .table td { border: 1px solid #000; padding: 4px; vertical-align: top; }
			.table th { background: #FFFFFF; font-weight: 700; text-align: center; font-size: 9px; }
			.table td { font-size: 9px; }
			.center { text-align: center; }
			.right { text-align: right; }
			.small { font-size: 8px; }
		</style>
	</head>
	<body>
		<table class="header-table" cellpadding="0" cellspacing="0" style="margin-top:0; margin-bottom:8px;">
			<tr>
				<td style="width: 10%; text-align:center;">
					@if($logoBase64)
						<img src="{{ $logoBase64 }}" class="logo" alt="Bomberos">
					@else
						<div class="small">LOGO NO ENCONTRADO</div>
					@endif
				</td>
				<td style="width: 10%; text-align:center;">
					@if($logoBase64_a)
						<img src="{{ $logoBase64_a }}" class="logo" alt="Bomberos">
					@else
						<div class="small">LOGO NO ENCONTRADO</div>
					@endif
				</td>
				<td style="width: 62%;">
					<div class="title">REPULICA DE COLOMBIA</div>
					<div class="title">ALCALDIA MUNICIPAL</div>
					<div class="title">LA TEBAIDA QUINDIO</div>
					<div class="subtitle" style="margin-top:3px;">Nit: 890 000564-1</div>
					<div class="title">INFORME DE SERVICIOS PRESTADOS AL HOGAR DEL ANCIANO POR PARTE DEL CUERPO DE BOMBERO</div>
				</td>
				<td style="width: 10%; text-align:right;">
					@if($logoBase64_bc)
						<img src="{{ $logoBase64_bc }}" class="logo" alt="Bomberos">
					@else
						<div class="small">LOGO NO ENCONTRADO</div>
					@endif
				</td>
				<td style="width: 10; text-align:center;">
					@if($logoBase64_b)
						<img src="{{ $logoBase64_b }}" class="logo" alt="Bomberos">
					@else
						<div class="small">LOGO NO ENCONTRADO</div>
					@endif
				</td>
			</tr>
		</table>
		<div class="mt-5">
			<table class="table">
				<thead>
					<tr>
						<th>N°</th>
						<th>TIPO DE SERVICIO</th>
						<th>FECHA</th>
						<th>BENEFICIARIO</th>
						<th>DOCUMENTO</th>
						<th>DIRECCIÓN</th>
						<th>HORA SERVICIO</th>
						<th>AUXILIAR RESPONSABLE DEL TRASLADO</th>
						<th>CÉDULA</th>
					</tr>
				</thead>
				<tbody>
					@forelse($records as $i => $r)
						<tr>
							<td>{{ $i+1 }}</td>
							<td>{{ $r->service_type }}</td>
							<td>{{ optional($r->service_date)->format('Y-m-d') }}</td>
							<td>{{ $r->patient_name }}</td>
							<td>{{ $r->document }}</td>
							<td>{{ $r->address }}</td>
							<td>{{ $r->service_time }}</td>
							<td>{{ $r->responsible_name }}</td>
							<td>{{ $r->responsible_document }}</td>
						</tr>
					@empty
						<tr><td colspan="8">No hay registros con los filtros seleccionados.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</body>
</html>
