<?php

namespace App\Http\Controllers\Formats;

use App\Http\Requests\StoreVehicleExitReportGuardRequest;
use App\Http\Requests\UpdateVehicleExitReportDriverRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleExitReport;
use Illuminate\Http\Request;

class VehicleExitReportController extends Controller
{
    // Index general (guardia/admin)
    public function index(Request $request)
    {
        $q = VehicleExitReport::query()
            ->with(['guardUser','driverUser','vehicle'])
            ->latest();

        // Si quieres: filtros por placa, estado, fecha
        $reports = $q->paginate(10)->withQueryString();

        return view('formats.vehicle-exit-reports.index', compact('reports'));
    }

    // Form guardia
    public function create()
    {
        $drivers = User::orderBy('name')->get(); // aquí puedes filtrar solo rol conductor si manejas roles
        $vehicles = Vehicle::orderBy('plate')->get();

        $vehicleTypes = [
            'AMBULANCIA',
            'MAQUINA EXTINTORA',
            'MAQUINA CISTERNA',
            'UNIDAD DE APOYO',
            'UNIDAD DE RESCATE',
            'UNIDAD FORESTAL',
            'VEHICULO COMANDO',
            'UNIDAD ACUATICA',
        ];

        $eventTypes = [
            'TAB',
            'ACCIDENTE VEHICULAR',
            'ACCIDENTE LABORAL',
            'ACCIDENTE ESTUDIANTIL',
            'ACCIDENTE CASERO',
            'ACCIDENTE AEREO',
            'INCENDIO ESTRUCTURAL',
            'INCENDIO VEHICULAR',
            'INCENDIO FORESTAL',
            'INCENDIO INDUSTRIAL',
            'MATPEL',
            'INUNDACIONES',
            'COLAPSO ESTRUCTURAL',
            'RESCATE ACUATICO',
            'ATENCIÓN PREHOSPOITALARIA',
            'BUSQUEDA Y RESCATE',
            'CAIDA DE ARBOL',
            'DERRAME DE HIDROCARBURO',
            'FUGAS DE GAS',
            'CONTROL DE ABEJAS',
            'VENDAVAL',
            'SISMO O TERREMOTO',
            'EXPLOSIÓN',
            'QUEMA DE RESIDUOS SOLIDOS',
            'RESCATE ANIMAL',
            'RESCATE VEHICULAR',
            'APOYO OPERATIVO',
            'SUMINISTRO DE AGUA',
            'FALSA ALARMA',
            'MISIÓN OFICIAL',
        ];

        return view('formats.vehicle-exit-reports.create', compact('drivers','vehicles','vehicleTypes','eventTypes'));
    }

    // Guardar etapa guardia (crea y asigna)
    public function store(StoreVehicleExitReportGuardRequest $request)
    {
        $report = VehicleExitReport::create([
            'status' => 'PENDING_DRIVER',
            'guard_user_id' => auth()->id(),
            'driver_user_id' => $request->integer('driver_user_id'),
            'guard_completed_at' => now(),

            'vehicle_type' => $request->vehicle_type,
            'vehicle_id' => $request->integer('vehicle_id'),
            'event_type' => $request->event_type,

            'department' => $request->department,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'vereda' => $request->vereda,
            'nomenclature' => $request->nomenclature,
            'departure_time' => $request->departure_time,
        ]);

        return redirect()
            ->route('formats.vehicle-exit-reports.show', $report)
            ->with('success', 'Informe creado y asignado al conductor.');
    }

    public function show(VehicleExitReport $report)
    {
		$userId = auth()->id();
		$isGuard = $report->guard_user_id === $userId;
		$isDriver = $report->driver_user_id === $userId;

		if (!$isGuard && !$isDriver && !auth()->user()->hasRole('admin')) {
			abort(403);
		}

        $report->load(['guardUser','driverUser','vehicle']);
        return view('formats.vehicle-exit-reports.show', compact('report'));
    }

    // Bandeja conductor: solo asignados y pendientes
    public function pending(Request $request)
    {
		$userId = auth()->id();
        $reports = VehicleExitReport::query()
            ->with(['guardUser','vehicle', 'driverUser'])
            ->where('status', 'PENDING_DRIVER')
            ->where('driver_user_id', $userId)
            ->latest()
            ->paginate(20);

        return view('formats.vehicle-exit-reports.pending', compact('reports'));
    }

    // Form conductor
    public function driverForm(VehicleExitReport $report)
    {
        $this->authorizeDriver($report);

		if ($report->status !== 'PENDING_DRIVER') {
			return redirect()
				->route('formats.vehicle-exit-reports.show', $report)
				->with('error', 'Este informe ya fue diligenciado o no está disponible.');
		}

        $report->load(['guardUser','vehicle', 'driverUser']);

        return view('formats.vehicle-exit-reports.driver', compact('report'));
    }

    // guardUserar etapa conductor (finaliza)
    public function driverUpdate(UpdateVehicleExitReportDriverRequest $request, VehicleExitReport $report)
    {
        $this->authorizeDriver($report);

		if ($report->status !== 'PENDING_DRIVER') {
			return redirect()
				->route('formats.vehicle-exit-reports.show', $report)
				->with('error', 'Este informe ya fue diligenciado o no está disponible.');
		}

        $report->update([
            'mechanical_status' => $request->mechanical_status,
            'electrical_status' => $request->electrical_status,
            'lights_status' => $request->lights_status,
            'emergency_lights_status' => $request->emergency_lights_status,
            'siren_status' => $request->siren_status,
            'communications_status' => $request->communications_status,
            'tires_status' => $request->tires_status,
            'brakes_status' => $request->brakes_status,

            'odometer' => $request->odometer,
            'route_description' => $request->route_description,
            'movement_description' => $request->movement_description,
            'general_observations' => $request->general_observations,

            'status' => 'COMPLETED',
            'driver_completed_at' => now(),
        ]);

        return redirect()
            ->route('formats.vehicle-exit-reports.pending', $report)
            ->with('success', 'Informe completado correctamente.');
    }
	
	private function authorizeDriver(VehicleExitReport $report): void
	{
		if ($report->driver_user_id !== auth()->id()) {
			abort(403, 'No tienes permiso para diligenciar este informe.');
		}
	}
}

