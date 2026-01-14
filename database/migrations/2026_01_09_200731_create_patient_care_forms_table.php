<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_care_forms', function (Blueprint $table) {
            $table->id();

            // Auditoría
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            // ===== Encabezado =====
            $table->date('filled_date');                // Fecha diligenciamiento
            $table->time('departure_time');             // Hora de salida
            $table->foreignId('vehicle_id')->constrained('vehicles'); // solo lista, no carga más info

            $table->string('location_type', 1);         // U,R,O
            $table->string('event_class', 2);           // EG, AT, AL, R, O
            $table->string('event_address');
            $table->string('event_city');
            $table->string('event_department');

            // ===== 1. Información general del paciente =====
            $table->string('patient_name');
            $table->string('patient_doc_type');         // CC, TI, RC, CE
            $table->string('patient_doc_number');
            $table->string('patient_address');
            $table->unsignedInteger('patient_age');
            $table->string('patient_phone')->nullable();
            $table->string('patient_occupation')->nullable();

            // ===== 2. Valoración del paciente =====
            $table->string('v_pulse')->nullable();
            $table->string('v_respiration')->nullable();
            $table->string('v_pa')->nullable();         // p/a
            $table->string('v_spo2')->nullable();
            $table->string('v_ro')->nullable();
            $table->string('v_rv')->nullable();
            $table->string('v_rm')->nullable();
            $table->string('v_total')->nullable();
            $table->string('v_temperature')->nullable();
            $table->text('v_general_observation')->nullable();

            // ===== 3. Procedimientos =====
            $table->json('procedures')->nullable();     // checks
            $table->string('ssn_09')->nullable();       // SSN ,9%
            $table->string('lactato')->nullable();      // g/m (texto)
            $table->string('dextrosa')->nullable();     // g/m (texto)
            $table->text('procedure_description')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();
            $table->text('pathologies')->nullable();
            $table->string('lividity')->nullable();
            $table->string('environment')->nullable();
            $table->text('general_notes')->nullable();

            // ===== 4. Transporte =====
            $table->string('delivery_status');          // vivo | muerto
            $table->time('delivery_time')->nullable();
            $table->boolean('belongings')->default(false);
            $table->string('receiver_name')->nullable();
            $table->string('receiver_document')->nullable();
            $table->string('transported_to')->nullable();
            $table->string('transport_city')->nullable();
            $table->string('transport_code')->nullable();

            // ===== 5. Acompañante y/o responsable =====
            $table->string('companion_name')->nullable();
            $table->string('companion_document')->nullable();
            $table->string('companion_phone')->nullable();

            // ===== 6. Responsable de la atención =====
            $table->foreignId('driver_user_id')->nullable()->constrained('users');
            $table->string('driver_document')->nullable();

            $table->foreignId('crew1_user_id')->nullable()->constrained('users');
            $table->string('crew1_document')->nullable();

            $table->foreignId('crew2_user_id')->nullable()->constrained('users');
            $table->string('crew2_document')->nullable();

            // ===== 7. Evaluación del servicio (E,B,R,M) =====
            $table->json('service_evaluation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_care_forms');
    }
};