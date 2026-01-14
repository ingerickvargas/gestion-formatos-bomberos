<x-app-layout>
@php
    $modules = [
        'kit_emergency' => [
            'title' => 'Kit de emergencia',
            'obs' => 'kit_observations',
            'items' => [
                'llanta_repuesto' => 'Llanta de repuesto',
                'botiquin' => 'Botiquín de emergencia',
                'gato' => 'Herramienta tipo gato',
                'cono_senalizacion' => 'Cono de señalización',
                'maleta_herramientas' => 'Maleta de herramientas básicas',
                'chalecos_reflectivos' => 'Chalecos reflectivos',
                'extintor' => 'Extintor',
                'cruceta' => 'Cruceta',
                'tacos' => 'Tacos',
                'cables_inicio' => 'Cables de inicio',
            ],
        ],
        'lights' => [
            'title' => 'Luces',
            'obs' => 'lights_observations',
            'items' => [
                'bajas' => 'Bajas',
                'altas' => 'Altas',
                'direccionales' => 'Direccionales',
                'estacionarias' => 'Estacionarias',
                'reversa' => 'Reversa',
                'stop' => 'Stop',
                'rutilantes' => 'Rutilantes de emergencias rojas y blancas',
            ],
        ],
        'brakes' => [
            'title' => 'Frenos',
            'obs' => 'brakes_observations',
            'items' => [
                'mano' => 'Freno de mano',
                'pedal' => 'Freno de pedal',
            ],
        ],
        'mirrors_glass' => [
            'title' => 'Vidrios y espejos',
            'obs' => 'mirrors_observations',
            'items' => [
                'parabrisas' => 'Parabrisas',
                'plumillas' => 'Plumillas',
                'espejos_laterales' => 'Espejos laterales',
                'vidrio_trasero' => 'Vidrio trasero',
                'espejo_retrovisor' => 'Espejo retrovisor',
            ],
        ],
        'fluids' => [
            'title' => 'Fluidos del vehículo',
            'obs' => 'fluids_observations',
            'items' => [
                'aceite_motor' => 'Aceite de motor',
                'liquido_frenos' => 'Líquido de frenos',
                'refrigerante' => 'Refrigerante',
                'agua_limpiaparabrisas' => 'Agua limpia parabrisas',
                'combustible' => 'Combustible',
            ],
        ],
        'general_state' => [
            'title' => 'Estado general del vehículo',
            'obs' => 'general_observations',
            'items' => [
                'latoneria_pintura' => 'Latonería y pintura',
                'llantas_calibradas' => 'Llantas calibradas',
                'cojineria_sillas' => 'Cojinería y sillas buenas',
                'tapiceria' => 'Tapicería',
                'aseo' => 'Aseo del vehículo',
                'manijas_puertas' => 'Manijas de puertas',
                'eleva_vidrios' => 'Eleva vidrios',
                'bocina' => 'Bocina principal',
                'alarma_reversa' => 'Alarma de reversa',
                'cinturones' => 'Cinturones de seguridad',
                'tablero_controles' => 'Tablero de controles (botones)',
                'aire_acondicionado' => 'Aire acondicionado',
                'testigo_encendido' => 'Testigo encendido',
                'sirena' => 'Sirena buena',
            ],
        ],
    ];

    $badge = fn($val) => $val ? 'Sí' : 'No';
    $badgeClass = fn($val) => $val ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
@endphp

<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Preoperacional de vehículos</h1>
        <a href="{{ route('modules.vehicle-preoperational-checks.index') }}" class="px-3 py-2 border rounded-md bg-sky-800 text-white">
            Volver
        </a>
    </div>

    {{-- Resumen --}}
    <div class="bg-white shadow rounded p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Placa</div>
                <div class="font-semibold">{{ $check->vehicle->plate ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Tipo vehículo</div>
                <div class="font-semibold">{{ $check->vehicle_type ?? ($check->vehicle->vehicle_type ?? '-') }}</div>
            </div>
            <div>
                <div class="text-gray-500">Vence seguro</div>
                <div class="font-semibold">{{ optional($check->insurance_expires_at)->format('Y-m-d') ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Vence tecnomecánica</div>
                <div class="font-semibold">{{ optional($check->tech_review_expires_at)->format('Y-m-d') ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Conductor</div>
                <div class="font-semibold">{{ $check->driver->name ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Cédula conductor</div>
                <div class="font-semibold">{{ $check->driver->document ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Licencia</div>
                <div class="font-semibold">{{ $check->license_category ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Diligenciado por</div>
                <div class="font-semibold">{{ $check->creator->name ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-500">Fecha/Hora</div>
                <div class="font-semibold">
                    {{ optional($check->filled_date)->format('Y-m-d') }} {{ $check->filled_time }}
                </div>
            </div>
            <div>
                <div class="text-gray-500">Kilometraje</div>
                <div class="font-semibold">{{ $check->odometer ?? '-' }}</div>
            </div>
            <div>
                <div class="text-gray-500">Tarjeta de propiedad</div>
                <div class="font-semibold">{{ $check->property_card ? 'Sí' : 'No' }}</div>
            </div>
        </div>
    </div>

    {{-- Módulos --}}
    @foreach($modules as $moduleKey => $mod)
        @php
            $values = data_get($check, $moduleKey, []);
            if (!is_array($values)) $values = [];
            $obs = data_get($check, $mod['obs']);
        @endphp

        <div class="bg-white shadow rounded p-4 space-y-3">
            <h3 class="font-semibold">{{ $mod['title'] }}</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="px-3 py-2">Ítem</th>
                            <th class="px-3 py-2 w-32">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($mod['items'] as $itemKey => $label)
                            @php
                                $val = (int)($values[$itemKey] ?? 0);
                            @endphp
                            <tr>
                                <td class="px-3 py-2">{{ $label }}</td>
                                <td class="px-3 py-2">
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-semibold {{ $badgeClass($val) }}">
                                        {{ $badge($val) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-sm">
                <div class="text-gray-500">Observaciones</div>
                <div class="mt-1 whitespace-pre-wrap">{{ $obs ?: '-' }}</div>
            </div>
        </div>
    @endforeach
</div>
</x-app-layout>
