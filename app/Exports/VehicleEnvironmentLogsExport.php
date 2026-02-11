<?php

namespace App\Exports;

use App\Models\VehicleEnvironmentLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehicleEnvironmentLogsExport implements FromCollection, WithHeadings, WithMapping
{
	public function __construct(
        private ?string $plate = null,
        private ?string $date = null
    ) {}

    public function collection()
    {
        $q = VehicleEnvironmentLog::query()
            ->with(['vehicle', 'creator']) 
            ->orderByDesc('created_at');

        if (!empty($this->plate)) {
            $q->whereHas('vehicle', function ($qq) {
                $qq->where('plate', 'like', '%'.$this->plate.'%');
            });
        }

        if (!empty($this->date)) {
            $q->whereDate('created_at', $this->date);

        }

        return $q->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Placa',
            'Temperatura (°C)',
            'Humedad (%)',
            'Registrado por',
            'Fecha de creación',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            optional($log->vehicle)->plate,
            $log->temperature,
            $log->humidity,
            optional($log->creator)->name,
            $log->created_at->format('Y-m-d H:i'),
        ];
    }
}
