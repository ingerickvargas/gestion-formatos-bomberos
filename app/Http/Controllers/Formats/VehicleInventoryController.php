<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleInventoryRequest;
use App\Http\Requests\UpdateVehicleInventoryRequest;
use App\Models\Supply;
use App\Models\Vehicle;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleInventoryController extends Controller
{
    public function index(Request $request)
    {
        $q = VehicleInventory::query()->with(['vehicle', 'creator']);

        if ($request->filled('plate')) {
            $plate = $request->string('plate')->toString();
            $q->whereHas('vehicle', fn($v) => $v->where('plate','like',"%{$plate}%"));
        }

        if ($request->filled('date')) {
            $q->whereDate('inventory_date', $request->date('date'));
        }

        $inventories = $q->orderByDesc('inventory_date')->orderByDesc('id')
            ->paginate(10)->withQueryString();

        return view('formats.vehicle-inventories.index', compact('inventories'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate','vehicle_type','brand','model']);
        $supplies = Supply::orderBy('name')->get(['id','name','group']);

        return view('formats.vehicle-inventories.create', compact('vehicles','supplies'));
    }

    // Endpoint JSON para autocompletar datos del vehículo al seleccionar placa
    public function vehicleJson(Vehicle $vehicle)
    {
        return response()->json([
            'id' => $vehicle->id,
            'plate' => $vehicle->plate,
            'vehicle_type' => $vehicle->vehicle_type,
            'brand' => $vehicle->brand,
            'model' => $vehicle->model,
        ]);
    }

    public function store(StoreVehicleInventoryRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $inv = VehicleInventory::create([
                    'vehicle_id' => $request->integer('vehicle_id'),
                    'inventory_date' => $request->date('inventory_date'),
                    'notes' => $request->input('notes'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);

                foreach (($request->input('items') ?? []) as $supplyId => $row) {
					$selected = isset($row['checked']) && (int)$row['checked'] === 1;
					$qty      = (int)($row['quantity'] ?? 0);

					if (!$selected) {
						continue;
					}

					// Si está seleccionado, exigimos qty > 0
					if ($qty <= 0) {
						continue; // o puedes lanzar error si quieres obligar >0
					}

					$inv->items()->create([
						'supply_id' => (int)$supplyId,
						'quantity'  => $qty,
						'batch'     => null,
						'serial'    => null,
					]);
				}
			});

            return redirect()->route('formats.vehicle-inventories.index')
                ->with('success', 'Inventario guardado correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Si choca el unique (vehículo+fecha)
            return back()->withInput()->withErrors([
                'inventory_date' => 'Ya existe un inventario para este vehículo en esa fecha.'
            ]);
        }
    }

    public function show(VehicleInventory $vehicleInventory)
    {
        $vehicleInventory->load(['vehicle', 'creator', 'items.supply']);
        return view('formats.vehicle-inventories.show', compact('vehicleInventory'));
    }

    public function edit(VehicleInventory $vehicleInventory)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $vehicleInventory->load(['vehicle','items']);
		
        $vehicles = Vehicle::query()->orderBy('plate')->get();
		$supplies = Supply::query()->orderBy('name')->get();
		
		$items = $vehicleInventory->items
			->mapWithKeys(function ($it) {
				return [
					$it->supply_id => [
						'selected' => true,
						'quantity'  => (int) $it->quantity,
						'batch'     => $it->batch,
						'serial'    => $it->serial,
					]
				];
			})
			->toArray();

		return view('formats.vehicle-inventories.edit', compact(
			'vehicleInventory',
			'vehicles',
			'supplies',
			'items'
		));
    }

    public function update(UpdateVehicleInventoryRequest $request, VehicleInventory $vehicleInventory)
    {
        DB::transaction(function () use ($request, $vehicleInventory) {
            $vehicleInventory->update([
                'notes' => $request->input('notes'),
                'updated_by' => auth()->id(),
            ]);

            // Reemplazo simple (para empezar): borra detalle y recrea
            $vehicleInventory->items()->delete();

            foreach (($request->input('items') ?? []) as $supplyId => $row) {
				$selected = isset($row['checked']) && (int)$row['checked'] === 1;
				$qty      = (int)($row['quantity'] ?? 0);

				if (!$selected || $qty <= 0) {
					continue;
				}

				$vehicleInventory->items()->create([
					'supply_id' => (int)$supplyId,
					'quantity'  => $qty,
					'batch'     => null,
					'serial'    => null,
				]);
			}
		});
		
        return redirect()->route('formats.vehicle-inventories.show', $vehicleInventory)
            ->with('success', 'Inventario actualizado.');
    }
}
