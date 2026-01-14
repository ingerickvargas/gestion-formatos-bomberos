<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('patient_care_forms', function (Blueprint $table) {
			$table->string('attachment_path')->nullable()->after('service_evaluation');
		});
	}

	public function down(): void
	{
		Schema::table('patient_care_forms', function (Blueprint $table) {
			$table->dropColumn('attachment_path');
		});
	}
};
