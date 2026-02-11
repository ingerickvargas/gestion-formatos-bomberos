<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('autopistas_cafe_form_vehicle_companions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('form_vehicle_id')
                ->constrained('autopistas_cafe_form_vehicles')
                ->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('doc_number')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('presents')->nullable();

            $table->string('transferred')->nullable(); 
            $table->string('radicado')->nullable();
            $table->string('destination')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autopistas_cafe_form_vehicle_companions');
    }
};
