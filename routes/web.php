<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
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

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
