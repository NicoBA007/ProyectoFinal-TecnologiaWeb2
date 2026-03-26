<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController; // Tus rutas
use App\Http\Controllers\ActorController; // Las rutas de tu compañero
use Illuminate\Support\Facades\Route;

// Ruta principal (Cartelera)
Route::get('/', function () {
    return view('welcome');
});

// El Dashboard ahora es solo un panel de bienvenida (ya no carga la tabla pesada aquí)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Las 7 rutas de tu CRUD de Usuarios
Route::resource('usuarios', UsuarioController::class)->middleware(['auth']);

// Rutas del Perfil de usuario (No tocar)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD de Actores (Lo que hizo tu compañero)
Route::middleware(['auth'])->group(function () {
    Route::get('/actores', [ActorController::class, 'index'])->name('actores.index');
    Route::get('/actores/nuevo', [ActorController::class, 'create'])->name('actores.create');
    Route::post('/actores', [ActorController::class, 'store'])->name('actores.store');
    Route::get('/actores/{id}/editar', [ActorController::class, 'edit'])->name('actores.edit');
    Route::put('/actores/{id}', [ActorController::class, 'update'])->name('actores.update');
    Route::delete('/actores/{id}', [ActorController::class, 'destroy'])->name('actores.destroy');
});

require __DIR__ . '/auth.php';