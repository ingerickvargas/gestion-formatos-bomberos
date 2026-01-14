<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_preoperational_checks', function (Blueprint $table) {
		$table->id();

		// auditoría
		$table->foreignId('created_by')->constrained('users');

		// vehículo
		$table->foreignId('vehicle_id')->constrained('vehicles');
		$table->string('vehicle_type')->nullable();
		$table->date('tech_review_expires_at')->nullable();
		$table->date('insurance_expires_at')->nullable();

		// conductor seleccionado (aunque el que diligencia sea otro)
		$table->foreignId('driver_user_id')->nullable()->constrained('users');
		$table->string('driver_document')->nullable();

		// generales
		$table->date('filled_date');
		$table->time('filled_time');
		$table->integer('odometer')->nullable();
		$table->boolean('property_card')->default(false);
		$table->string('license_category')->nullable(); // A1,A2,B1...

		// módulos en JSON (más fácil de mantener)
		$table->json('kit_emergency')->nullable();
		$table->text('kit_observations')->nullable();

		$table->json('lights')->nullable();
		$table->text('lights_observations')->nullable();

		$table->json('brakes')->nullable();
		$table->text('brakes_observations')->nullable();

		$table->json('mirrors_glass')->nullable();
		$table->text('mirrors_observations')->nullable();

		$table->json('fluids')->nullable();
		$table->text('fluids_observations')->nullable();

		$table->json('general_state')->nullable();
		$table->text('general_observations')->nullable();

		$table->timestamps();

		$table->index(['filled_date']);
		$table->index(['vehicle_id', 'filled_date']);
	});
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_preoperational_checks');
    }
};
