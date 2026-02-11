<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupplyRequest;
use App\Http\Requests\UpdateSupplyRequest;
use App\Models\Supply;
use Illuminate\Support\Carbon;
use App\Exports\SuppliesExport;
use Maatwebsite\Excel\Facades\Excel;

class SupplyController extends Controller
{
    public function index(Request $request)
    {
		$q = Supply::query();
		$semaforo = $request->string('semaforo')->toString();

		if (in_array($semaforo, ['green','yellow','red'], true)) {
			$today = Carbon::today();

			if ($semaforo === 'green') {
				$q->whereDate('expires_at', '>=', $today->copy()->addMonths(6));
			}

			if ($semaforo === 'yellow') {
				$q->whereBetween('expires_at', [
					$today->copy()->addMonths(3),
					$today->copy()->addMonths(6)->subDay(),
				]);
			}

			if ($semaforo === 'red') {
				$q->whereDate('expires_at', '<', $today->copy()->addMonths(3));
			}
		}

		if ($request->filled('search')) {
			$search = $request->string('search');
			$q->where(function ($sub) use ($search) {
				$sub->where('name', 'like', "%{$search}%")
					->orWhere('group', 'like', "%{$search}%")
					->orWhere('serial', 'like', "%{$search}%")
					->orWhere('batch', 'like', "%{$search}%");
			});
		}
		
		$today = now()->startOfDay();
		$hasReds = (clone $q)
			->whereNotNull('expires_at')
			->whereDate('expires_at', '<', $today->copy()->addMonths(3))
			->exists();

		$supplies = $q->orderByDesc('id')->paginate(10)->withQueryString();

		return view('admin.supplies.index', compact('supplies', 'hasReds'));
    }

    public function create()
    {
        return view('admin.supplies.create');
    }

    public function store(StoreSupplyRequest $request)
    {
        Supply::create(array_merge(
            $request->validated(),
            ['created_by' => auth()->id()]
        ));

        return redirect()
            ->route('admin.supplies.index')
            ->with('success', 'Insumo creado correctamente.');
    }

    public function show(string $id)
    {
        //
    }
	
	public function export(Request $request)
	{
		$search = $request->string('search')->toString();
		$semaforo = $request->string('semaforo')->toString();

		$filename = 'insumos_' . now()->format('Ymd_His') . '.xlsx';

		return Excel::download(
			new SuppliesExport($search ?: null, $semaforo ?: null),
			$filename
		);
	}

    public function edit(string $id)
    {
		$supply = Supply::findOrFail($id);
		
        return view('admin.supplies.edit', compact('supply'));
    }

    public function update(UpdateSupplyRequest $request, string $id)
    {
		$supply = Supply::findOrFail($id);
		
        $supply->update(array_merge(
            $request->validated(),
            ['updated_by' => auth()->id()]
        ));

        return redirect()
            ->route('admin.supplies.index')
            ->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(string $id)
    {
		$supply = Supply::findOrFail($id);
        $supply->delete();

        return back()->with('success', 'Insumo eliminado.');
    }
}
