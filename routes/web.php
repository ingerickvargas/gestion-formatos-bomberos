<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccessLogController;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'active'])->group(function () {
	Route::view('/preoperacional', 'modules.placeholder')->name('preoperacional.index');
    Route::view('/inventario', 'modules.placeholder')->name('inventario.index');
    Route::view('/formatos', 'modules.placeholder')->name('formatos.index');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
		Route::get('/access-logs', [AccessLogController::class, 'index'])->name('admin.access-logs.index');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
