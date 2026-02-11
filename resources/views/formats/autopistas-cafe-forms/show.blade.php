<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Formulario - Autopistas del Café #{{ $form->id }}</h2>
                <p class="text-sm text-gray-500">Detalle del registro con vehículos y acompañantes.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-sky-800 text-white rounded-md">Volver</a>
                <a href="{{ route('formats.autopistas-cafe-forms.edit', $form) }}" class="px-4 py-2 bg-red-600 text-white rounded-md">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Cabecera</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div><span class="font-medium">Fecha:</span> {{ optional($form->event_date)->format('Y-m-d') }}</div>
                <div><span class="font-medium">Hora salida:</span> {{ $form->departure_time }}</div>
                <div><span class="font-medium">Hora sitio:</span> {{ $form->site_time }}</div>
                <div><span class="font-medium">Hora regreso:</span> {{ $form->return_time }}</div>

                <div><span class="font-medium">KM inicial:</span> {{ $form->km_initial }}</div>
                <div><span class="font-medium">KM evento:</span> {{ $form->km_event }}</div>
                <div><span class="font-medium">KM final:</span> {{ $form->km_final }}</div>
                <div><span class="font-medium">Placa:</span> {{ $form->vehicle?->plate }}</div>

                <div class="md:col-span-2"><span class="font-medium">Evento:</span> {{ $form->event }}</div>
                <div><span class="font-medium">Kilómetro:</span> {{ $form->kilometer }}</div>
                <div class="md:col-span-2"><span class="font-medium">Sitio:</span> {{ $form->event_site }}</div>
                <div class="md:col-span-2"><span class="font-medium">Referencia:</span> {{ $form->reference_point }}</div>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Vehículos involucrados</h3>

            <div class="space-y-4">
                @foreach($form->vehicles as $idx => $v)
                    <div class="border rounded p-4">
                        <div class="font-semibold mb-2">Vehículo {{ $idx+1 }}</div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">
                            <div><span class="font-medium">Placa:</span> {{ $v->plate }}</div>
                            <div><span class="font-medium">Tipo:</span> {{ $v->vehicle_type }}</div>
                            <div><span class="font-medium">Marca:</span> {{ $v->brand }}</div>
                            <div><span class="font-medium">Modelo:</span> {{ $v->model }}</div>

                            <div><span class="font-medium">Color:</span> {{ $v->color }}</div>
                            <div><span class="font-medium">Remolque:</span> {{ $v->trailer }}</div>
                            <div><span class="font-medium">N° interno:</span> {{ $v->internal_number }}</div>
                            <div><span class="font-medium">Ruta:</span> {{ $v->route }}</div>

                            <div class="md:col-span-2"><span class="font-medium">Conductor:</span> {{ $v->driver_name }}</div>
                            <div><span class="font-medium">Documento:</span> {{ $v->driver_document }}</div>
                            <div><span class="font-medium">Teléfono:</span> {{ $v->driver_phone }}</div>

                            <div><span class="font-medium">Tipo doc:</span> {{ $v->driver_doc_type }}</div>
                            <div><span class="font-medium">Edad:</span> {{ $v->driver_age }}</div>
                            <div class="md:col-span-2"><span class="font-medium">Dirección:</span> {{ $v->driver_address }}</div>

                            <div class="md:col-span-4"><span class="font-medium">Presenta:</span> {{ $v->presents }}</div>

                            <div><span class="font-medium">Trasladado:</span> {{ $v->transferred }}</div>
                            <div><span class="font-medium">Destino:</span> {{ $v->destination }}</div>
                            <div><span class="font-medium">Radicado:</span> {{ $v->radicado }}</div>
                        </div>

                        <div class="mt-3">
                            <div class="font-semibold mb-2">Acompañantes</div>

                            @if($v->companions->count())
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">
                                    @foreach($v->companions as $c)
										<div><span class="font-medium">Nombre:</span> {{ $c->name }}</div>
										<div><span class="font-medium">Tipo doc:</span> {{ $c->doc_type }}</div>
										<div><span class="font-medium">Documento:</span> {{ $c->doc_number }}</div>
										<div><span class="font-medium">Teléfono:</span> {{ $c->phone }}</div>
										<div><span class="font-medium">Edad:</span> {{ $c->age }}</div>
										<div><span class="font-medium">Dirección:</span> {{ $c->address }}</div>
										<div><span class="font-medium">Observaciones:</span> {{ $c->presents }}</div>
										<div><span class="font-medium">Trasladado:</span> {{ $c->transferred }}</div>
										<div><span class="font-medium">Destino:</span> {{ $c->destination }}</div>
										<div><span class="font-medium">Radicado:</span> {{ $c->radicado }}</div>
									@endforeach
                                </div>
                            @else
                                <div class="text-sm text-gray-500">Sin acompañantes.</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold text-lg mb-3">Datos finales</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div><span class="font-medium">Autorizado:</span> {{ $form->authorized }}</div>
                <div><span class="font-medium">Hora salida:</span> {{ $form->authorized_departure_time }}</div>
                <div><span class="font-medium">Hora sitio:</span> {{ $form->authorized_site_time }}</div>
                <div><span class="font-medium">Hora regreso:</span> {{ $form->authorized_return_time }}</div>

                <div><span class="font-medium">KM inicial:</span> {{ $form->authorized_km_initial }}</div>
                <div><span class="font-medium">KM evento:</span> {{ $form->authorized_km_event }}</div>
                <div><span class="font-medium">KM final:</span> {{ $form->authorized_km_final }}</div>
                <div><span class="font-medium">Placa:</span> {{ $form->authorizedVehicle?->plate }}</div>

                <div><span class="font-medium">Funcionario:</span> {{ $form->reporting_officer }}</div>
                <div><span class="font-medium">Inspector vial:</span> {{ $form->road_inspector }}</div>
                <div><span class="font-medium">Hospital:</span> {{ $form->receiving_hospital }}</div>
                <div><span class="font-medium">Conductor:</span> {{ $form->driver_name }}</div>
                <div><span class="font-medium">Tripulante:</span> {{ $form->crew_member }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
