<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_records', function (Blueprint $table) {
		  $table->id();

		  // Clasificación del formato
		  $table->string('tipo_formato'); // ANCIANATO | ALCALDIA | BOMBEROS

		  // Datos del paciente / beneficiario
		  $table->string('patient_name');
		  $table->string('document')->nullable();
		  $table->unsignedInteger('age')->nullable();
		  $table->string('phone')->nullable();
		  $table->string('address')->nullable();

		  // Datos de atención/servicio
		  $table->date('service_date')->nullable();
		  $table->time('service_time')->nullable(); // si aplica
		  $table->string('service_type')->nullable(); // “TAB”, etc.
		  $table->string('consultation_type')->nullable(); // si aplica
		  $table->string('procedure')->nullable(); // si aplica

		  // Responsable / auxiliar / quien realiza
		  $table->string('responsible_name')->nullable();
		  $table->string('responsible_document')->nullable();

		  // Observaciones
		  $table->text('observations')->nullable();

		  // Campos específicos por formato (flexible)
		  $table->json('extras')->nullable();

		  // Auditoría
		  $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
		  $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

		  $table->timestamps();

		  $table->index(['tipo_formato', 'service_date']);
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_records');
    }
};
