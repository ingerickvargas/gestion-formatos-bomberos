<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_environment_logs', function (Blueprint $table) {
		  $table->id();

		  $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();

		  $table->decimal('temperature', 5, 1);

		  $table->unsignedTinyInteger('humidity');

		  $table->dateTime('logged_at');

		  $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
		  $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

		  $table->timestamps();

		  $table->index(['vehicle_id', 'logged_at']);
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_environment_logs');
    }
};
