<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    h2 { margin: 0 0 10px 0; }
    .meta { margin-bottom: 8px; color: #444; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 4px; vertical-align: top; }
    th { background: #eee; font-weight: bold; }
  </style>
</head>
<body>

  <h2>Listado de pacientes - {{ strtoupper($type ?: 'TODOS') }}</h2>

  <div class="meta">
    @if($from || $to)
      Rango: {{ $from ? $from->format('Y-m-d') : '...' }} a {{ $to ? $to->format('Y-m-d') : '...' }}
    @else
      Rango: (sin filtro)
    @endif
    | Total: {{ $rows->count() }}
  </div>

  <table>
    <thead>
      <tr>
        @foreach($columns as $c)
          <th>{{ $c['label'] }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          @foreach($columns as $c)
            @php
              $key = $c['key'];
              $val = data_get($r, $key);

              if (in_array($key, ['service_date','attention_date']) && $val) {
                try { $val = \Carbon\Carbon::parse($val)->format('Y-m-d'); } catch (\Throwable $e) {}
              }
              if ($key === 'service_time' && $val) {
                $val = substr((string)$val, 0, 5);
              }
              if ($key === 'attention_time' && $val) {
                $val = substr((string)$val, 0, 5);
              }
            @endphp
            <td>{{ $val }}</td>
          @endforeach
        </tr>
      @empty
        <tr>
          <td colspan="{{ count($columns) }}">No hay registros para los filtros aplicados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

</body>
</html>
