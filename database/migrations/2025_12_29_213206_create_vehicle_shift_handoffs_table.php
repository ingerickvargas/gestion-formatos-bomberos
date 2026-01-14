<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_shift_handoffs', function (Blueprint $table) {
		  $table->id();

		  $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();

		  $table->enum('action', ['ENTREGA', 'RECIBE']);
		  $table->text('notes')->nullable();

		  $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
		  $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

		  $table->timestamps();

		  $table->index(['vehicle_id', 'action', 'created_at']);
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_shift_handoffs');
    }
};
