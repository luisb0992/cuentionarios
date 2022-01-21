<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PhaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Auth::routes();

/**
 * Grupo de rutas para la página de inicio.
 */
Route::group(['middleware' => ['web']], function () {

    // Ruta para la página de inicio.
    Route::get('/', [LandingController::class, 'index'])->name('landing');

    // Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/**
 * Grupo de rutas que requieren autenticación.
 */
Route::group(['middleware' => ['auth']], function () {

    // Rutas para la gestión de fases
    Route::resource('phases', PhaseController::class);

    // Obtener las faces por medio de un objeto json
    Route::get('/getphases', [PhaseController::class, 'getPhases'])->name('phases.getPhases');

    // eliminar las fases seleccionadas
    Route::post('/deleteselectedphases', [PhaseController::class, 'destroySelected'])->name('phases.destroySelected');

    // actualizar una fase
    Route::post('/updatePhase/{phase}', [PhaseController::class, 'updatePhase'])->name('phases.updatePhase');
});
