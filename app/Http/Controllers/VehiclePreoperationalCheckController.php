<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehiclePreoperationalCheck;
use App\Http\Requests\StoreVehiclePreoperationalCheckRequest;
use App\Models\User;
class VehiclePreoperationalCheckController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::select('id','plate','vehicle_type')
            ->orderBy('plate')
            ->get();

        $q = VehiclePreoperationalCheck::query()
            ->with(['vehicle:id,plate,vehicle_type', 'driver:id,name', 'creator:id,name'])
            ->latest('id');

        if ($request->filled('vehicle_id')) {
            $q->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('filled_date')) {
            $q->whereDate('filled_date', $request->filled_date);
        }

        $checks = $q->paginate(15)->withQueryString();

        return view('modules.vehicle-preoperational-checks.index', compact('vehicles', 'checks'));
    }
	
	public function create()
    {
        $vehicles = Vehicle::select('id','plate','vehicle_type','insurance_expires_at','tech_review_expires_at')
            ->orderBy('plate')
            ->get();

        // si solo quieres conductores, luego lo filtramos por rol
        $drivers = User::select('id','name','document')->orderBy('name')->get();

        return view('modules.vehicle-preoperational-checks.create', [
            'vehicles' => $vehicles,
            'drivers' => $drivers,
        ]);
    }
	
	public function store(StoreVehiclePreoperationalCheckRequest $request)
	{
		$vehicle = Vehicle::findOrFail($request->vehicle_id);
		$driver  = User::findOrFail($request->driver_user_id);

		$check = VehiclePreoperationalCheck::create([
			'created_by' => auth()->id(),
			'vehicle_id' => $vehicle->id,

			// snapshot (para dejar histórico aunque cambie el vehículo)
			'vehicle_type' => $vehicle->vehicle_type ?? $vehicle->type ?? null,
			'insurance_expires_at' => $vehicle->insurance_expires_at ?? null,
			'tech_review_expires_at' => $vehicle->tech_review_expires_at ?? null,

			'driver_user_id' => $driver->id,
			'driver_document' => $driver->document,

			'filled_date' => $request->filled_date,
			'filled_time' => $request->filled_time,
			'odometer' => $request->odometer,
			'property_card' => (bool) $request->property_card,
			'license_category' => $request->license_category,

			'kit_emergency' => $request->kit_emergency,
			'kit_observations' => $request->kit_observations,

			'lights' => $request->lights,
			'lights_observations' => $request->lights_observations,

			'brakes' => $request->brakes,
			'brakes_observations' => $request->brakes_observations,

			'mirrors_glass' => $request->mirrors_glass,
			'mirrors_observations' => $request->mirrors_observations,

			'fluids' => $request->fluids,
			'fluids_observations' => $request->fluids_observations,

			'general_state' => $request->general_state,
			'general_observations' => $request->general_observations,
		]);

		return redirect()
			->route('modules.vehicle-preoperational-checks.show', $check)
			->with('success', 'Preoperacional creado correctamente.');
	}
	
	public function show(VehiclePreoperationalCheck $check)
    {
        $check->load([
            'vehicle:id,plate,vehicle_type,insurance_expires_at,tech_review_expires_at',
            'driver:id,name,document',
            'creator:id,name',
        ]);

        return view('modules.vehicle-preoperational-checks.show', compact('check'));
    }
}
