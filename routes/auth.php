<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Rutas para Registrarse
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rutas para Iniciar Sesión
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Ruta para cambiar la contraseña desde el panel de perfil
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // Ruta para Cerrar Sesión
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});