<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inventories', function (Blueprint $table) {
		  $table->id();
		  $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
		  $table->date('inventory_date'); // registro diario
		  $table->text('notes')->nullable();

		  // Auditoría
		  $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
		  $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

		  $table->timestamps();

		  // Evita duplicado por día y vehículo
		  $table->unique(['vehicle_id','inventory_date']);
		  $table->index(['inventory_date']);
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inventories');
    }
};
