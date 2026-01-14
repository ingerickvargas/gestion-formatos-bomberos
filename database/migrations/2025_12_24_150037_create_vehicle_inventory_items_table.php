<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inventory_items', function (Blueprint $table) {
		  $table->id();
		  $table->foreignId('vehicle_inventory_id')->constrained('vehicle_inventories')->cascadeOnDelete();
		  $table->foreignId('supply_id')->constrained('supplies')->restrictOnDelete();

		  $table->unsignedInteger('quantity')->default(0);

		  // opcional: si luego lo quieres por lote/serie en el inventario del vehículo
		  $table->string('batch')->nullable();
		  $table->string('serial')->nullable();

		  $table->timestamps();

		  $table->index(['supply_id']);
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inventory_items');
    }
};
