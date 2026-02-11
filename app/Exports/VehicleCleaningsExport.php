<?php

namespace App\Exports;

use App\Models\VehicleCleaning;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehicleCleaningsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        private ?string $plate = null,
        private ?string $date = null
    ) {}

    public function collection(): Collection
    {
        $q = VehicleCleaning::query()
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
            'Fecha-Hora',
            'Placa',
			'Tipo vehículo',
			'Tipo de limpieza',
			'Usuario',
			'Observaciones',
			'Areas limpiadas',
        ];
    }

    public function map($row): array
    {
        return [
            optional($row->created_at)->format('Y-m-d H:i'),
            optional($row->vehicle)->plate,
			optional($row->vehicle)->vehicle_type,
			$row->cleaning_type,
			optional($row->creator)->name,
			$row->notes,
			implode(', ', $row->areas ?? []),
        ];
    }
}
