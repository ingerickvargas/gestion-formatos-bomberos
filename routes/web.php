<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccessLogController;
use App\Http\Controllers\Admin\SupplyController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Formats\VehicleInventoryController;
use App\Http\Controllers\Formats\VehicleEnvironmentLogController;
use App\Http\Controllers\Formats\VehicleShiftHandoffController;
use App\Http\Controllers\Formats\VehicleCleaningController;
use App\Http\Controllers\Formats\PatientRecordController;
use App\Http\Controllers\Formats\VehicleExitReportController;
use App\Http\Controllers\VehiclePreoperationalCheckController;
use App\Http\Controllers\Formats\PatientCareFormController;
use App\Http\Controllers\Formats\TrafficAccidentFormController;
use App\Http\Controllers\Formats\AutopistasCafeFormController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'active'])->group(function () {
	Route::prefix('preoperacional')->name('modules.')->group(function () {
		Route::get('vehicle-preoperational-checks', [VehiclePreoperationalCheckController::class, 'index'])
			->name('vehicle-preoperational-checks.index');
		Route::get('vehicle-preoperational-checks/create', [VehiclePreoperationalCheckController::class, 'create'])
			->name('vehicle-preoperational-checks.create');
		Route::post('vehicle-preoperational-checks', [VehiclePreoperationalCheckController::class, 'store'])
			->name('vehicle-preoperational-checks.store');
		Route::get('vehicle-preoperational-checks/{check}', [VehiclePreoperationalCheckController::class, 'show'])
			->name('vehicle-preoperational-checks.show');
	});
		
    Route::prefix('formatos')->name('formats.')->group(function () {
		Route::resource('traffic-accident-forms', TrafficAccidentFormController::class)
        ->parameters(['traffic-accident-forms' => 'form']);
		Route::get('traffic-accident-forms/{form}/export-pdf', [TrafficAccidentFormController::class,'exportPdf'])
		->name('traffic-accident-forms.export-pdf');
		
		Route::resource('patient-care-forms', PatientCareFormController::class)->except(['destroy']);
		Route::get('patient-care-forms/{patient_care_form}', [PatientCareFormController::class, 'show'])
		->name('patient-care-forms.show');
		Route::get('formatos/patient-care-forms/export-pdf', [PatientCareFormController::class, 'exportPdf'])
		->name('patient-care-forms.export-pdf');
		Route::get('patient-care-forms/{form}/attachment', [PatientCareFormController::class, 'downloadAttachment'])
        ->name('patient-care-forms.attachment');
		Route::delete('patient-care-forms/{form}/attachment', [PatientCareFormController::class, 'deleteAttachment'])
        ->name('patient-care-forms.attachment.delete');
		
		Route::resource('patient-records', PatientRecordController::class)->except(['destroy']);
		Route::get('formatos/patient-records/export-pdf', [PatientRecordController::class, 'exportPdf'])
		->name('patient-records.export-pdf');

		Route::resource('vehicle-environment-logs', VehicleEnvironmentLogController::class)->except(['destroy']);
		Route::get('formatos/vehicle-environment-logs/export',[VehicleEnvironmentLogController::class, 'export']
)		->name('vehicle-environment-logs.export');

		Route::resource('vehicle-shift-handoffs', VehicleShiftHandoffController::class)->except(['destroy']);
		Route::get('formatos/vehicle-shift-handoffs/export', [VehicleShiftHandoffController::class, 'export'])
    	->name('vehicle-shift-handoffs.export');
		
		Route::resource('vehicle-cleanings', VehicleCleaningController::class)->except(['destroy']);
		Route::get('formatos/vehicle-cleanings/export', [VehicleCleaningController::class, 'export'])
    	->name('vehicle-cleanings.export');
		
		Route::get('vehicle-inventories', [VehicleInventoryController::class, 'index'])
		->name('vehicle-inventories.index');
		Route::get('vehicle-inventories/create', [VehicleInventoryController::class, 'create'])
		->name('vehicle-inventories.create');
		Route::post('vehicle-inventories', [VehicleInventoryController::class, 'store'])
		->name('vehicle-inventories.store');
		Route::get('vehicle-inventories/{vehicleInventory}', [VehicleInventoryController::class, 'show'])
		->name('vehicle-inventories.show');

		Route::resource('autopistas-cafe-forms', AutopistasCafeFormController::class)
        ->only(['index','create','store','edit','update','show']);

    	Route::get('autopistas-cafe-forms/{autopistas_cafe_form}/pdf', [AutopistasCafeFormController::class, 'pdf'])
        ->name('autopistas-cafe-forms.pdf');

		Route::get('vehicles/{vehicle}/json', [VehicleInventoryController::class, 'vehicleJson'])
		->name('vehicles.json');
		
		Route::middleware('role:admin')->group(function () {
			Route::get('vehicle-inventories/{vehicleInventory}/edit', [VehicleInventoryController::class, 'edit'])
			->name('vehicle-inventories.edit');
			Route::put('vehicle-inventories/{vehicleInventory}', [VehicleInventoryController::class, 'update'])
			->name('vehicle-inventories.update');
		});
		Route::get('vehicle-exit-reports', [VehicleExitReportController::class, 'index'])
		->name('vehicle-exit-reports.index');
		Route::get('vehicle-exit-reports/create', [VehicleExitReportController::class, 'create'])
		->name('vehicle-exit-reports.create');
		Route::post('vehicle-exit-reports', [VehicleExitReportController::class, 'store'])
		->name('vehicle-exit-reports.store');
		Route::get('vehicle-exit-reports/{report}', [VehicleExitReportController::class, 'show'])
		->name('vehicle-exit-reports.show');
		Route::get('vehicle-exit-reports-pending', [VehicleExitReportController::class, 'pending'])
		->name('vehicle-exit-reports.pending');
		Route::get('vehicle-exit-reports/{report}/driver', [VehicleExitReportController::class, 'driverForm'])
		->name('vehicle-exit-reports.driver-form');
		Route::put('vehicle-exit-reports/{report}/driver', [VehicleExitReportController::class, 'driverUpdate'])
		->name('vehicle-exit-reports.driver-update');
	});

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
		Route::get('supplies/export', [SupplyController::class, 'export'])->name('supplies.export');
        Route::resource('users', UserController::class);
		Route::get('/access-logs', [AccessLogController::class, 'index'])->name('access-logs.index');
		Route::resource('supplies', SupplyController::class)->except(['show']);
		Route::resource('vehicles', VehicleController::class)->except(['show']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
