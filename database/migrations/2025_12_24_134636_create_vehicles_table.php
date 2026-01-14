<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('plate')->unique();               // Placa
            $table->string('vehicle_type');                  // Tipo (dropdown)
            $table->string('brand')->nullable();             // Marca
            $table->string('model')->nullable();             // Modelo

            $table->string('insurance_company')->nullable(); // Compañía seguro
            $table->string('insurance_number')->nullable();  // Número seguro
            $table->date('insurance_expires_at')->nullable();// Vence seguro

            $table->string('tech_review_number')->nullable(); // N° tecnomecánica
            $table->date('tech_review_expires_at')->nullable();// Vence tecnomecánica

            // Auditoría básica (igual a supplies)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['vehicle_type']);
            $table->index(['insurance_expires_at']);
            $table->index(['tech_review_expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
