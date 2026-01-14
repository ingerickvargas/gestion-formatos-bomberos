<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();

            $table->string('name');                       // Nombre
            $table->string('group')->nullable();          // Grupo
            $table->unsignedInteger('quantity')->default(0); // Cantidad

            $table->string('serial')->nullable();         // Serie
            $table->string('commercial_presentation')->nullable(); // Presentación comercial
            $table->string('batch')->nullable();          // Lote
            $table->date('expires_at')->nullable();       // Fecha vencimiento
            $table->string('manufacturer_lab')->nullable(); // Laboratorio fabricante

            // Auditoría básica
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Índices útiles
            $table->index(['name', 'group']);
            $table->index('expires_at');
        });
    }
	
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
