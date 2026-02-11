<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientCareFormRequest;
use App\Models\PatientCareForm;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePatientCareFormRequest;

class PatientCareFormController extends Controller
{
    public function index(Request $request)
    {
        $q = PatientCareForm::query()->with(['vehicle','creator']);

        // filtros (fecha, placa, paciente, documento)
        if ($request->filled_date) {
            $start = Carbon::createFromFormat('Y-m', $request->filled_month)->startOfMonth();
			$end   = Carbon::createFromFormat('Y-m', $request->filled_month)->endOfMonth();

			$q->whereBetween('filled_date', [$start->toDateString(), $end->toDateString()]);
        }

        if ($request->vehicle_id) {
            $q->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->search) {
            $s = trim($request->search);
            $q->where(function($qq) use ($s) {
                $qq->where('patient_name','like',"%$s%")
                   ->orWhere('patient_doc_number','like',"%$s%");
            });
        }

        $forms = $q->latest()->paginate(10)->withQueryString();

        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);

        return view('formats.patient-care-forms.index', compact('forms','vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        $users = User::orderBy('name')->get(['id','name','document']); // para conductor/tripulantes

        $locationTypes = ['U','R','O'];
        $eventClasses = ['EG','AT','AL','R','O'];

        $docTypes = ['CC','TI','RC','CE'];

        $proceduresList = [
            'MONITOREO','HEMOSTASI','REANIMACION','ASPIRACION','OXIGENACION',
            'PARTO','INMOVILIZACION','ASEPSIA','DESFIBRILACION','INTUBACION'
        ];

        return view('formats.patient-care-forms.create', compact(
            'vehicles','users','locationTypes','eventClasses','docTypes','proceduresList'
        ));
    }

    public function store(StorePatientCareFormRequest $request)
    {
        $data = $request->validated();

        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        PatientCareForm::create($data);

        return redirect()
            ->route('formats.patient-care-forms.index')
            ->with('success', 'Formulario creado correctamente.');
    }

    public function show(PatientCareForm $patient_care_form)
    {
        $form = $patient_care_form->load(['vehicle','creator','driverUser','crew1User','crew2User']);

        return view('formats.patient-care-forms.show', compact('form'));
    }

    // Si NO quieres editar, puedes borrar edit/update/destroy.
    public function edit(PatientCareForm $patient_care_form)
    {
        $form = $patient_care_form;

        $vehicles = Vehicle::orderBy('plate')->get(['id','plate']);
        $users = User::orderBy('name')->get(['id','name','document']);

        $locationTypes = ['U','R','O'];
        $eventClasses = ['EG','AT','AL','R','O'];
        $docTypes = ['CC','TI','RC','CE'];
        $proceduresList = [
            'MONITOREO','HEMOSTASI','REANIMACION','ASPIRACION','OXIGENACION',
            'PARTO','INMOVILIZACION','ASEPSIA','DESFIBRILACION','INTUBACION'
        ];

        return view('formats.patient-care-forms.edit', compact(
            'form','vehicles','users','locationTypes','eventClasses','docTypes','proceduresList'
        ));
    }

    public function update(UpdatePatientCareFormRequest $request, PatientCareForm $patient_care_form)
	{
		$data = $request->validated();

		if ($request->hasFile('attachment')) {

			if ($patient_care_form->attachment_path) {
				Storage::disk(config('filesystems.default'))
					->delete($patient_care_form->attachment_path);
			}

			$path = $request->file('attachment')->store('patient-care-forms', config('filesystems.default'));

			$data['attachment_path'] = $path;
		}

		$patient_care_form->update($data);

		return redirect()
			->route('formats.patient-care-forms.show', $patient_care_form)
			->with('success', 'Registro actualizado correctamente.');
	}

    public function destroy(string $id)
    {
        //
    }
	
	public function downloadAttachment(PatientCareForm $form)
	{
		abort_unless($form->attachment_path, 404);

		return Storage::disk(config('filesystems.default'))
			->stream($form->attachment_path);
	}
	
	public function deleteAttachment(PatientCareForm $form)
	{
		abort_unless($form->attachment_path, 404);

		Storage::disk(config('filesystems.default'))->delete($form->attachment_path);

		$form->update(['attachment_path' => null]);

		return back()->with('success', 'Imagen eliminada.');
	}
	
	public function exportPdf(Request $request)
	{
		$data = $request->validate([
			'filled_month' => ['required', 'date_format:Y-m'],
			'vehicle_id'   => ['nullable','integer'],
			'search'       => ['nullable','string'],
		]);

		$month = Carbon::createFromFormat('Y-m', $data['filled_month']);
		$start = $month->copy()->startOfMonth();
		$end   = $month->copy()->endOfMonth();

		$query = PatientCareForm::query()
			->with(['vehicle:id,plate','creator:id,name'])
			->whereBetween('filled_date', [$start->toDateString(), $end->toDateString()]);

		if (!empty($data['vehicle_id'])) {
			$query->where('vehicle_id', $data['vehicle_id']);
		}

		if (!empty($data['search'])) {
			$s = $data['search'];
			$query->where(function($q) use ($s) {
				$q->where('patient_name','like',"%{$s}%")
				  ->orWhere('patient_doc_number','like',"%{$s}%");
			});
		}

		$forms = $query->orderBy('filled_date','asc')->get();

		$pdf = Pdf::loadView('formats.patient-care-forms.pdf', [
        'forms' => $forms,
        'month' => $month,
        'filters' => $data,
		])->setPaper('letter', 'landscape');

		return $pdf->stream('patient-care-forms-'.$month->format('Y-m').'.pdf');
	}
}
