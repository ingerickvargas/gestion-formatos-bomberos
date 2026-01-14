<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
         $q = Vehicle::query();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $q->where(function ($sub) use ($search) {
                $sub->where('plate', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('insurance_company', 'like', "%{$search}%")
                    ->orWhere('insurance_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('vehicle_type')) {
            $q->where('vehicle_type', $request->string('vehicle_type')->toString());
        }

        $vehicles = $q->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $types = config('vehicles.types');
        return view('admin.vehicles.create', compact('types'));
    }

    public function store(StoreVehicleRequest $request)
    {
         Vehicle::create(array_merge(
            $request->validated(),
            ['created_by' => auth()->id(), 'updated_by' => auth()->id()]
        ));

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehículo creado correctamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Vehicle $vehicle)
    {
        $types = config('vehicles.types');
        return view('admin.vehicles.edit', compact('vehicle', 'types'));
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update(array_merge(
            $request->validated(),
            ['updated_by' => auth()->id()]
        ));

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehículo eliminado.');
    }
}
