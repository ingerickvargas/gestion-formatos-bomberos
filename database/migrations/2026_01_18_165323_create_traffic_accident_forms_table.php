<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traffic_accident_forms', function (Blueprint $table) {
			$table->id();

			// Auditoría
			$table->foreignId('created_by')->constrained('users');
			$table->foreignId('updated_by')->nullable()->constrained('users');

			// ===== Modulo I. ANAMNESIS =====
			$table->string('nuap')->nullable();
			$table->string('priority', 1)->nullable(); // R,A,V,N,B

			$table->foreignId('informer_user_id')->nullable()->constrained('users'); // quien informa

			$table->date('attention_date')->nullable();
			$table->time('departure_time')->nullable();
			$table->time('attention_time')->nullable();

			$table->string('clinical_history')->nullable(); // historia clinica

			$table->string('patient_name')->nullable();
			$table->string('patient_doc_type', 3)->nullable(); // CC TI RC CE PA AS
			$table->string('patient_doc_number')->nullable();

			$table->date('patient_birth_date')->nullable();
			$table->unsignedInteger('patient_age')->nullable();
			$table->string('patient_sex')->nullable();
			$table->string('patient_civil_status')->nullable();

			$table->string('patient_address')->nullable();
			$table->string('patient_phone')->nullable();
			$table->string('patient_occupation')->nullable();

			$table->string('eps')->nullable();
			$table->string('insurance_company')->nullable(); // aseguradora

			$table->string('companion_name')->nullable();
			$table->string('companion_relationship')->nullable();
			$table->string('companion_phone')->nullable();

			// ===== Modulo II. Motivo =====
			$table->text('reason_observation')->nullable();

			// ===== Modulo III. Examen físico =====
			$table->string('fc')->nullable();
			$table->string('fr')->nullable();
			$table->string('ta')->nullable();
			$table->string('spo2')->nullable();
			$table->string('temperature')->nullable();
			$table->string('ro')->nullable();
			$table->string('rv')->nullable();
			$table->string('rm')->nullable();

			$table->text('allergies')->nullable();
			$table->text('pathologies')->nullable();
			$table->text('medications')->nullable();
			$table->string('lividity')->nullable();
			$table->string('capillary_refill')->nullable();
			$table->text('background')->nullable(); // antecedentes

			// Lesiones (check multiple)
			$table->json('injuries')->nullable();

			$table->text('primary_assessment')->nullable();
			$table->text('secondary_assessment')->nullable();
			$table->text('diagnostic_impression')->nullable();

			// ===== Modulo IV. Procedimientos =====
			$table->json('procedures')->nullable();

			// ===== Modulo V. Insumos (lista) =====
			$table->json('supplies_used')->nullable(); // [{id?, name, qty}...]

			// ===== Modulo VI. Traslado =====
			$table->string('transport_to')->nullable();
			$table->string('transport_municipality')->nullable();
			$table->string('transport_department')->nullable();

			$table->time('transfer_start_time')->nullable();
			$table->date('ips_arrival_date')->nullable();
			$table->time('ips_arrival_time')->nullable();

			$table->string('delivery_status')->nullable(); // vivo o muerto
			$table->string('receiver_name')->nullable();
			$table->string('receiver_document')->nullable();
			$table->string('receiver_role')->nullable();
			$table->string('rg_md')->nullable();

			// ===== Modulo VII. Datos del evento =====
			$table->string('event_cause')->nullable(); // lista
			$table->string('service_mode')->nullable(); // sencillo, redondo
			$table->string('event_location_type', 1)->nullable(); // U,R,O

			$table->string('event_address')->nullable();
			$table->string('event_municipality')->nullable();
			$table->string('event_department')->nullable();

			$table->string('patient_quality')->nullable(); // peatón, conductor, ocupante, ciclista, otro
			$table->string('involved_driver_name')->nullable();
			$table->string('involved_driver_document')->nullable();

			// SOAT del vehículo involucrado (texto libre)
			$table->string('soat_vehicle_plate')->nullable();
			$table->string('soat_insurance_name')->nullable();
			$table->string('soat_policy_number')->nullable();

			// Vehículo de la institución que atendió
			$table->foreignId('vehicle_id')->nullable()->constrained('vehicles'); // lista placas
			$table->foreignId('responsible_user_id')->nullable()->constrained('users'); // lista usuarios (carga cédula)
			$table->string('responsible_document')->nullable();

			$table->text('general_observations')->nullable();

			$table->timestamps();
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('traffic_accident_forms');
    }
};
