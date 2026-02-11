<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('autopistas_cafe_forms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->date('event_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('site_time')->nullable();
            $table->time('return_time')->nullable();

            $table->unsignedInteger('km_initial')->nullable();
            $table->unsignedInteger('km_event')->nullable();
            $table->unsignedInteger('km_final')->nullable();

            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');

            $table->string('event')->nullable();
            $table->string('kilometer')->nullable();
            $table->string('event_site')->nullable();
            $table->string('reference_point')->nullable();

            $table->string('authorized')->nullable();
            $table->time('authorized_departure_time')->nullable();
            $table->time('authorized_site_time')->nullable();
            $table->time('authorized_return_time')->nullable();

            $table->unsignedInteger('authorized_km_initial')->nullable();
            $table->unsignedInteger('authorized_km_event')->nullable();
            $table->unsignedInteger('authorized_km_final')->nullable();

            $table->foreignId('authorized_vehicle_id')->nullable()->constrained('vehicles');

            $table->string('reporting_officer')->nullable();
            $table->string('road_inspector')->nullable();
            $table->string('receiving_hospital')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('crew_member')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autopistas_cafe_forms');
    }
};
