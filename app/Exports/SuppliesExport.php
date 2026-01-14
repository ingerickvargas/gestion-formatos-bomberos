<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Supply;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuppliesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private ?string $search = null,
        private ?string $semaforo = null
    ) {}

    public function query()
    {
        $q = Supply::query();

        if (!empty($this->search)) {
            $search = $this->search;
            $q->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('group', 'like', "%{$search}%")
                    ->orWhere('serial', 'like', "%{$search}%")
                    ->orWhere('batch', 'like', "%{$search}%")
                    ->orWhere('manufacturer_lab', 'like', "%{$search}%")
                    ->orWhere('invima_registration', 'like', "%{$search}%");
            });
        }

        if (in_array($this->semaforo, ['green','yellow','red'], true)) {
            $today = Carbon::today();

            if ($this->semaforo === 'green') {
                $q->whereNotNull('expires_at')
                  ->whereDate('expires_at', '>=', $today->copy()->addMonths(6));
            }

            if ($this->semaforo === 'yellow') {
                $q->whereNotNull('expires_at')
                  ->whereBetween('expires_at', [
                      $today->copy()->addMonths(3),
                      $today->copy()->addMonths(6)->subDay(),
                  ]);
            }

            if ($this->semaforo === 'red') {
                $q->whereNotNull('expires_at')
                  ->whereDate('expires_at', '<', $today->copy()->addMonths(3));
            }
        }

        return $q->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Grupo',
            'Cantidad',
            'Serie',
            'Presentación comercial',
            'Registro INVIMA',
            'Lote',
            'Fecha vencimiento',
            'Laboratorio fabricante',
			'Fecha de creación',
        ];
    }

    public function map($supply): array
    {
        return [
            $supply->name,
            $supply->group,
            $supply->quantity,
            $supply->serial,
            $supply->commercial_presentation,
            $supply->invima_registration,
            $supply->batch,
            optional($supply->expires_at)->format('Y-m-d'),
            $supply->manufacturer_lab,
			$supply->created_at,
        ];
    }
}
