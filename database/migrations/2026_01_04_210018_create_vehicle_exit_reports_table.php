<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_exit_reports', function (Blueprint $table) {
            $table->id();

            $table->string('status')->default('PENDING_DRIVER'); // PENDING_DRIVER | COMPLETED
            $table->foreignId('guard_user_id')->constrained('users');
            $table->foreignId('driver_user_id')->nullable()->constrained('users');

            $table->timestamp('guard_completed_at')->nullable();
            $table->timestamp('driver_completed_at')->nullable();

            // Sección guardia
            $table->string('vehicle_type'); // AMBULANCIA, etc
            $table->foreignId('vehicle_id')->constrained('vehicles'); // placa
            $table->string('event_type');

            $table->string('department');
            $table->string('city');
            $table->string('neighborhood')->nullable();
            $table->string('vereda')->nullable();
            $table->string('nomenclature')->nullable();
            $table->time('departure_time');

            // Sección conductor (B/R/M)
            $table->char('mechanical_status', 1)->nullable();
            $table->char('electrical_status', 1)->nullable();
            $table->char('lights_status', 1)->nullable();
            $table->char('emergency_lights_status', 1)->nullable();
            $table->char('siren_status', 1)->nullable();
            $table->char('communications_status', 1)->nullable();
            $table->char('tires_status', 1)->nullable();
            $table->char('brakes_status', 1)->nullable();

            $table->unsignedInteger('odometer')->nullable();
            $table->text('route_description')->nullable();
            $table->text('movement_description')->nullable();
            $table->text('general_observations')->nullable();

            $table->timestamps();

            $table->index(['status', 'driver_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_exit_reports');
    }
};
