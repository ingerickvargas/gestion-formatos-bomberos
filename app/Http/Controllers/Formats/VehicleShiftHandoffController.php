<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleShiftHandoffRequest;
use App\Http\Requests\UpdateVehicleShiftHandoffRequest;
use App\Models\Vehicle;
use App\Models\VehicleShiftHandoff;
use Illuminate\Http\Request;

class VehicleShiftHandoffController extends Controller
{
    public function index(Request $request)
    {
        $q = VehicleShiftHandoff::query()->with(['vehicle','creator']);

        if ($request->filled('plate')) {
            $plate = $request->string('plate');
            $q->whereHas('vehicle', fn($v) => $v->where('plate', 'like', "%{$plate}%"));
        }

        if ($request->filled('action')) {
            $q->where('action', $request->string('action'));
        }

        if ($request->filled('date')) {
            $q->whereDate('created_at', $request->date('date'));
        }

        $handOffs = $q->orderByDesc('created_at')->paginate(10)->withQueryString();

        $vehicles = Vehicle::orderBy('plate')->get(['id','plate','vehicle_type','brand','model']);

		$latestPerVehicle = VehicleShiftHandoff::query()
			->select('vehicle_shift_handoffs.*')
			->joinSub(
				VehicleShiftHandoff::query()
					->selectRaw('vehicle_id, MAX(created_at) as max_created_at')
					->groupBy('vehicle_id'),
				'lasts',
				function ($join) {
					$join->on('vehicle_shift_handoffs.vehicle_id', '=', 'lasts.vehicle_id')
						 ->on('vehicle_shift_handoffs.created_at', '=', 'lasts.max_created_at');
				}
			)
				->with(['creator','vehicle'])
				->get()
				->keyBy('vehicle_id');

			return view('formats.vehicle-shift-handoffs.index', [
				'handOffs' => $handOffs,
				'vehicles' => $vehicles,
				'latestPerVehicle' => $latestPerVehicle,
			]);
		}

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        return view('formats.vehicle-shift-handoffs.create', compact('vehicles'));
    }

    public function store(StoreVehicleShiftHandoffRequest $request)
    {
        VehicleShiftHandoff::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('formats.vehicle-shift-handoffs.index')
            ->with('success', 'Registro de turno guardado correctamente.');
    }

    public function show(VehicleShiftHandoff $vehicleShiftHandoff)
    {
        $vehicleShiftHandoff->load(['vehicle','creator']);
        return view('formats.vehicle-shift-handoffs.show', ['handoff' => $vehicleShiftHandoff]);
    }

    public function edit(VehicleShiftHandoff $vehicleShiftHandoff)
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        return view('formats.vehicle-shift-handoffs.edit', [
            'handoff' => $vehicleShiftHandoff,
            'vehicles' => $vehicles,
        ]);
    }

    public function update(UpdateVehicleShiftHandoffRequest $request, VehicleShiftHandoff $vehicleShiftHandoff)
    {
        $vehicleShiftHandoff->update([
            ...$request->validated(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('formats.vehicle-shift-handoffs.show', $vehicleShiftHandoff)
            ->with('success', 'Registro actualizado.');
    }

    public function destroy(string $id)
    {
        //
    }
}
