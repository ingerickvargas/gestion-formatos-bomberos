<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\TrafficAccidentForm;
use App\Models\Vehicle;
use App\Models\User;
use App\Http\Requests\StoreTrafficAccidentFormRequest;
use App\Http\Requests\UpdateTrafficAccidentFormRequest;

class TrafficAccidentFormController extends Controller
{
    public function index(Request $request)
	{
		$data = $request->validate([
			'filled_month' => ['nullable','date_format:Y-m'],
			'vehicle_id' => ['nullable','integer'],
			'search' => ['nullable','string'],
		]);

		$query = TrafficAccidentForm::query()
			->with(['vehicle:id,plate','creator:id,name']);

		if (!empty($data['filled_month'])) {
			$month = Carbon::createFromFormat('Y-m', $data['filled_month']);
			$query->whereBetween('attention_date', [$month->startOfMonth()->toDateString(), $month->endOfMonth()->toDateString()]);
		}

		if (!empty($data['vehicle_id'])) {
			$query->where('vehicle_id', $data['vehicle_id']);
		}

		if (!empty($data['search'])) {
			$s = $data['search'];
			$query->where(function($q) use ($s) {
				$q->where('patient_name','like',"%{$s}%")
				  ->orWhere('patient_doc_number','like',"%{$s}%")
				  ->orWhere('nuap','like',"%{$s}%");
			});
		}

		$forms = $query->latest()->paginate(15)->withQueryString();
		$vehicles = Vehicle::select('id','plate')->orderBy('plate')->get();

		return view('formats.traffic-accident-forms.index', compact('forms','vehicles'));
	}

	public function create()
	{
		$vehicles = Vehicle::select('id','plate')->orderBy('plate')->get();
		$users = User::select('id','name','document')->orderBy('name')->get();

		// para selects
		$priorities = ['R','A','V','N','B'];
		$docTypes = ['CC','TI','RC','CE','PA','AS'];
		$locations = ['U','R','O'];

		return view('formats.traffic-accident-forms.create', compact('vehicles','users','priorities','docTypes','locations'));
	}

	public function store(StoreTrafficAccidentFormRequest $request)
	{
		$data = $request->validated();

		if (!empty($data['responsible_user_id'])) {
			$u = User::select('id','document')->find($data['responsible_user_id']);
			$data['responsible_document'] = $u?->document;
		}

		$data['created_by'] = auth()->id();

		$form = TrafficAccidentForm::create($data);

		return redirect()->route('formats.traffic-accident-forms.show', $form)
			->with('success','Formulario creado correctamente.');
	}

	public function show(TrafficAccidentForm $form)
	{
		$form->load(['vehicle:id,plate','creator:id,name,document','informer:id,name','responsibleUser:id,name,document']);
		return view('formats.traffic-accident-forms.show', compact('form'));
	}

	public function edit(TrafficAccidentForm $form)
	{
		$vehicles = Vehicle::select('id','plate')->orderBy('plate')->get();
		$users = User::select('id','name','document')->orderBy('name')->get();

		$priorities = ['R','A','V','N','B'];
		$docTypes = ['CC','TI','RC','CE','PA','AS'];
		$locations = ['U','R','O'];

		return view('formats.traffic-accident-forms.edit', compact('form','vehicles','users','priorities','docTypes','locations'));
	}

	public function update(UpdateTrafficAccidentFormRequest $request, TrafficAccidentForm $form)
	{
		$data = $request->validated();

		if (!empty($data['responsible_user_id'])) {
			$u = User::select('id','document')->find($data['responsible_user_id']);
			$data['responsible_document'] = $u?->document;
		}

		$data['updated_by'] = auth()->id();

		$form->update($data);

		return redirect()->route('formats.traffic-accident-forms.index', $form)
			->with('success','Formulario actualizado correctamente.');
	}

	public function exportPdf(TrafficAccidentForm $form)
	{
		$form->load(['vehicle:id,plate','creator:id,name,document','informer:id,name','responsibleUser:id,name,document']);

		 $injuries = is_array($form->injuries) ? $form->injuries : (json_decode($form->injuries ?? '[]', true) ?: []);
		$procedures = is_array($form->procedures) ? $form->procedures : (json_decode($form->procedures ?? '[]', true) ?: []);
		$supplies = is_array($form->supplies_used) ? $form->supplies_used : (json_decode($form->supplies_used ?? '[]', true) ?: []);

		$pdf = Pdf::loadView('formats.traffic-accident-forms.pdf', [
			'form' => $form,
			'injuries' => $injuries,
			'procedures' => $procedures,
			'supplies' => $supplies,
		])->setPaper('letter', 'portrait');

		return $pdf->stream('accidente-transito-'.$form->id.'.pdf');
	}
}
