<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActorController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard de Usuarios
Route::get('/dashboard', function () {
    $usuarios = User::all();
    return view('dashboard', compact('usuarios'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de Usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD de Actores
Route::middleware(['auth'])->group(function () {
    Route::get('/actores', [ActorController::class, 'index'])->name('actores.index');
    Route::get('/actores/nuevo', [ActorController::class, 'create'])->name('actores.create'); // Ruta para mostrar form de crear
    Route::post('/actores', [ActorController::class, 'store'])->name('actores.store');
    Route::get('/actores/{id}/editar', [ActorController::class, 'edit'])->name('actores.edit'); // Ruta para mostrar form de editar
    Route::put('/actores/{id}', [ActorController::class, 'update'])->name('actores.update');
    Route::delete('/actores/{id}', [ActorController::class, 'destroy'])->name('actores.destroy');
});

require __DIR__ . '/auth.php';
