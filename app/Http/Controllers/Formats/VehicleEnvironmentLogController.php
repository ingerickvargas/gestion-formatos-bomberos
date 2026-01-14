<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleEnvironmentLogRequest;
use App\Http\Requests\UpdateVehicleEnvironmentLogRequest;
use App\Models\Vehicle;
use App\Models\VehicleEnvironmentLog;
use Illuminate\Http\Request;

class VehicleEnvironmentLogController extends Controller
{
    public function index(Request $request)
    {
        $q = VehicleEnvironmentLog::query()
            ->with(['vehicle', 'creator']);

        if ($request->filled('plate')) {
            $plate = $request->string('plate');
            $q->whereHas('vehicle', fn($v) => $v->where('plate', 'like', "%{$plate}%"));
        }

        if ($request->filled('date')) {
            $q->whereDate('logged_at', $request->date('date'));
        }

        $logs = $q->orderByDesc('logged_at')->paginate(10)->withQueryString();

        return view('formats.vehicle-environment-logs.index', compact('logs'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        return view('formats.vehicle-environment-logs.create', compact('vehicles'));
    }

    public function store(StoreVehicleEnvironmentLogRequest $request)
    {
        VehicleEnvironmentLog::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('formats.vehicle-environment-logs.index')
            ->with('success', 'Registro guardado correctamente.');
    }

    public function show(VehicleEnvironmentLog $vehicleEnvironmentLog)
    {
        $vehicleEnvironmentLog->load(['vehicle','creator']);
        return view('formats.vehicle-environment-logs.show', ['log' => $vehicleEnvironmentLog]);
    }

    public function edit(VehicleEnvironmentLog $vehicleEnvironmentLog)
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        return view('formats.vehicle-environment-logs.edit', [
            'log' => $vehicleEnvironmentLog,
            'vehicles' => $vehicles
        ]);
    }

    public function update(UpdateVehicleEnvironmentLogRequest $request, VehicleEnvironmentLog $vehicleEnvironmentLog)
    {
        $vehicleEnvironmentLog->update([
            ...$request->validated(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('formats.vehicle-environment-logs.show', $vehicleEnvironmentLog)
            ->with('success', 'Registro actualizado.');
    }

    public function destroy(string $id)
    {
        //
    }
}
