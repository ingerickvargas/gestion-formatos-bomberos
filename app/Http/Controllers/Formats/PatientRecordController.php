<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRecordRequest;
use App\Models\PatientRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PatientRecordController extends Controller
{
  public function index(Request $request)
  {
    $q = PatientRecord::query()->with('creator')->latest();

    if ($request->filled('tipo_formato')) {
      $q->where('tipo_formato', $request->string('tipo_formato'));
    }

    if ($request->filled('search')) {
      $s = $request->string('search');
      $q->where(function($sub) use ($s){
        $sub->where('patient_name','like',"%{$s}%")
            ->orWhere('document','like',"%{$s}%");
      });
    }
	
	if ($request->filled('month')) {
        [$year, $month] = explode('-', $request->month);

        $q->whereYear('service_date', $year)
              ->whereMonth('service_date', $month);
    }

    $records = $q
        ->orderByDesc('service_date')
        ->paginate(10)
        ->withQueryString();
		
    return view('formats.patient-records.index', compact('records'));
  }

  public function create()
  {
    return view('formats.patient-records.create');
  }

  public function store(StorePatientRecordRequest $request)
  {
    $data = $request->validated();

    $extras = $data['extras'] ?? [];
    $data['extras'] = $extras;

    $data['created_by'] = auth()->id();
    $data['updated_by'] = auth()->id();

    PatientRecord::create($data);

    return redirect()->route('formats.patient-records.index')
      ->with('success','Registro guardado correctamente.');
  }

  public function show(PatientRecord $patientRecord)
  {
    $patientRecord->load('creator');
    return view('formats.patient-records.show', compact('patientRecord'));
  }

	private function applyFilters($query, Request $request)
	{
		if ($request->filled('tipo_formato')) {
			$query->where('tipo_formato', $request->tipo_formato);
		}

		if ($request->filled('search')) {
			$s = $request->search;
			$query->where(function ($qq) use ($s) {
				$qq->where('responsible_name', 'like', "%{$s}%")
				   ->orWhere('document', 'like', "%{$s}%");
			});
		}

		if ($request->filled('date')) {
			$query->whereDate('created_at', $request->date);
		}

		return $query;
	}
	
	public function exportPdf(Request $request)
	{
		$request->validate([
			'month' => ['required', 'date_format:Y-m'],
		], [
			'month.required' => 'Debes seleccionar un mes antes de exportar.',
			'month.date_format' => 'El mes no tiene un formato válido.',
		]);
		
		$exportFormat = $request->get('export_format');
		abort_unless(in_array($exportFormat, ['ALCALDIA','BOMBEROS','ANCIANATO']), 404);

		$query = PatientRecord::query()
			->with(['creator'])
			->latest();

		if ($request->filled('tipo_formato')) {
			$query->where('tipo_formato', $request->tipo_formato);
		}

		if ($request->filled('search')) {
			$s = trim($request->search);
			$query->where(function ($q) use ($s) {
				$q->where('patient_name', 'like', "%{$s}%")
				  ->orWhere('document', 'like', "%{$s}%");
			});
		}

		if ($request->filled('month')) {
			[$year, $month] = explode('-', $request->month);

			$query->whereYear('service_date', $year)
				  ->whereMonth('service_date', $month);
		}

		$records = $query
			->orderBy('service_date')
			->get();

		$records = $query->get();

		$view = match ($exportFormat) {
			'ALCALDIA'  => 'formats.patient-records.pdf.alcaldia',
			'BOMBEROS'  => 'formats.patient-records.pdf.bomberos',
			'ANCIANATO' => 'formats.patient-records.pdf.ancianato',
		};

		$pdf = Pdf::loadView($view, [
			'records' => $records,
			'filters' => $request->only(['tipo_formato','search','date']),
			'exportFormat' => $exportFormat,
		])->setPaper('letter', 'landscape');

		return $pdf->stream("pacientes_{$exportFormat}_" . now()->format('Ymd_His') . ".pdf");
	}
}
