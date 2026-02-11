<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AutopistasCafeForm;
use App\Models\Vehicle;
use App\Http\Requests\StoreAutopistasCafeFormRequest;
use App\Http\Requests\UpdateAutopistasCafeFormRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AutopistasCafeFormController extends Controller
{
	public function index(Request $request)
	{
		$plate = $request->get('plate');
		$date  = $request->get('date');

		$query = AutopistasCafeForm::query()
			->with(['vehicle']) 
			->orderByDesc('id');

		if ($plate) {
			$query->where('vehicle_id', $plate);
		}

		if ($date) {
			$query->whereDate('event_date', $date);
		}

		$forms = $query->paginate(10)->withQueryString();

		$vehicles = Vehicle::orderBy('plate')->get(['id','plate']);

		$hasFilters = filled($plate) || filled($date);

		return view('formats.autopistas-cafe-forms.index', compact(
			'forms',
			'vehicles',
			'plate',
			'date',
			'hasFilters'
		));
	}
	public function create()
    {
        $form = new AutopistasCafeForm();
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);

        return view('formats.autopistas-cafe-forms.create', compact('form','vehicles'));
    }
   
	public function store(StoreAutopistasCafeFormRequest $request)
	{
		$data = $request->validated();

        return DB::transaction(function () use ($data) {
            $form = AutopistasCafeForm::create(array_merge(
                collect($data)->except('vehicles')->toArray(),
                ['created_by' => auth()->id()]
            ));

            foreach ($data['vehicles'] as $v) {
                $fv = $form->vehicles()->create($v);

                foreach (($v['companions'] ?? []) as $c) {
                    $fv->companions()->create($c);
                }
            }

            return redirect()
                ->route('formats.autopistas-cafe-forms.show', $form)
                ->with('success', 'Formulario creado correctamente.');
        });
	}

	public function edit(AutopistasCafeForm $autopistas_cafe_form)
    {
        $form = $autopistas_cafe_form->load(['vehicles.companions']);

        $vehicles = Vehicle::orderBy('plate')->get(['id','plate','vehicle_type','brand','model']);

        return view('formats.autopistas-cafe-forms.edit', compact('form','vehicles'));
    }

	public function show(AutopistasCafeForm $autopistas_cafe_form)
    {
        $form = $autopistas_cafe_form->load(['vehicle','authorizedVehicle','vehicles.companions']);
        return view('formats.autopistas-cafe-forms.show', compact('form'));
    }

	public function update(UpdateAutopistasCafeFormRequest $request, AutopistasCafeForm $autopistasCafeForm)
	{
		$data = $request->validated();
        $form = $autopistasCafeForm;

        return DB::transaction(function () use ($data, $form) {
            $form->update(array_merge(
                collect($data)->except('vehicles')->toArray(),
                ['updated_by' => auth()->id()]
            ));

            $form->vehicles()->delete();

            foreach ($data['vehicles'] as $v) {
                $fv = $form->vehicles()->create($v);

                foreach (($v['companions'] ?? []) as $c) {
                    $fv->companions()->create($c);
                }
            }

            return redirect()
                ->route('formats.autopistas-cafe-forms.show', $form)
                ->with('success', 'Formulario actualizado correctamente.');
        });
	}

	public function pdf(AutopistasCafeForm $autopistas_cafe_form)
    {
        $form = $autopistas_cafe_form->load(['vehicles.companions']);

		$docTypes = ['CC','TI','RC','CE'];

		$pdf = Pdf::loadView('formats.autopistas-cafe-forms.pdf', [
			'form' => $form,
			'docTypes' => $docTypes,
		])->setPaper('a4', 'portrait');

		return $pdf->stream("autopistas-cafe-form-{$form->id}.pdf");
    }

}
