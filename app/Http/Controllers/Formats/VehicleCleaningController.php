<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleCleaningRequest;
use App\Http\Requests\UpdateVehicleCleaningRequest;
use App\Models\Vehicle;
use App\Models\VehicleCleaning;
use Illuminate\Http\Request;

class VehicleCleaningController extends Controller
{
	private array $areaOptions = [
    'SILLAS',
    'PISOS',
    'PAREDES Y TECHOS',
    'PUERTAS Y VENTANAS',
    'MANIJAS',
    'INTERRUPTORES',
    'PASAMANOS',
    'RECIPIENTES',
  ];

    public function index(Request $request)
	{
		$q = VehicleCleaning::query()
		  ->with(['vehicle','creator'])
		  ->orderByDesc('id');

		if ($request->filled('plate')) {
		  $plate = $request->string('plate');
		  $q->whereHas('vehicle', fn($v) => $v->where('plate','like',"%{$plate}%"));
		}

		if ($request->filled('cleaning_type')) {
		  $q->where('cleaning_type', $request->string('cleaning_type'));
		}

		if ($request->filled('date')) {
		  $q->whereDate('created_at', $request->date('date'));
		}

		$cleanings = $q->paginate(10)->withQueryString();

		return view('formats.vehicle-cleanings.index', compact('cleanings'));
    }
	
    public function create()
    {
        $vehicles = Vehicle::query()->orderBy('plate')->get(['id','plate','vehicle_type','brand','model']);
		$areaOptions = $this->areaOptions;

    return view('formats.vehicle-cleanings.create', compact('vehicles','areaOptions'));
    }

    public function store(StoreVehicleCleaningRequest $request)
    {
		VehicleCleaning::create([
		  'vehicle_id' => $request->integer('vehicle_id'),
		  'cleaning_type' => $request->string('cleaning_type'),
		  'areas' => array_values($request->input('areas', [])),
		  'notes' => $request->input('notes'),
		  'created_by' => auth()->id(),
		  'updated_by' => auth()->id(),
		]);

    return redirect()->route('formats.vehicle-cleanings.index')
      ->with('success','Aseo registrado correctamente.');
    }

    public function show(VehicleCleaning $vehicleCleaning)
	{
		$vehicleCleaning->load(['vehicle','creator']);
		return view('formats.vehicle-cleanings.show', compact('vehicleCleaning'));
    }

    public function edit(VehicleCleaning $vehicleCleaning)
	{
		$vehicleCleaning->load(['vehicle','creator']);
		$vehicles = Vehicle::query()->orderBy('plate')->get(['id','plate','vehicle_type','brand','model']);
		$areaOptions = $this->areaOptions;

		return view('formats.vehicle-cleanings.edit', compact('vehicleCleaning','vehicles','areaOptions'));
    }

    public function update(UpdateVehicleCleaningRequest $request, VehicleCleaning $vehicleCleaning)
	{
		$vehicleCleaning->update([
		  'vehicle_id' => $request->integer('vehicle_id'),
		  'cleaning_type' => $request->string('cleaning_type'),
		  'areas' => array_values($request->input('areas', [])),
		  'notes' => $request->input('notes'),
		  'updated_by' => auth()->id(),
		]);

		return redirect()->route('formats.vehicle-cleanings.index')
		  ->with('success','Aseo actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        //
    }
}
