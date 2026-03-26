<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Ruta principal (Cartelera)
Route::get('/', function () {
    return view('welcome');
});

// El Dashboard ahora es solo un panel de bienvenida (ya no carga la tabla pesada aquí)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// AQUÍ ESTÁ LA MAGIA: Las 7 rutas de tu CRUD de Usuarios
Route::resource('usuarios', UsuarioController::class)->middleware(['auth']);

// Rutas del Perfil de usuario (No tocar)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';