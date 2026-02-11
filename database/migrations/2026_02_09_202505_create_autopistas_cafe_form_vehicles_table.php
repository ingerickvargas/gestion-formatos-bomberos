<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('autopistas_cafe_form_vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('form_id')
                ->constrained('autopistas_cafe_forms')
                ->cascadeOnDelete();

            $table->string('plate')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();

            $table->string('color')->nullable();
            $table->string('trailer')->nullable();
            $table->string('internal_number')->nullable();
            $table->string('route')->nullable();

            $table->string('driver_name')->nullable();
            $table->string('driver_doc_type')->nullable();
            $table->string('driver_document')->nullable();
            $table->string('driver_phone')->nullable();
            $table->unsignedInteger('driver_age')->nullable();
            $table->string('driver_address')->nullable();
            $table->text('presents')->nullable();

            $table->string('transferred')->nullable();
            $table->string('destination')->nullable();
            $table->string('radicado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autopistas_cafe_form_vehicles');
    }
};
