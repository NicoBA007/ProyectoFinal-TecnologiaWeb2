<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController; // Cambiado de ActorController a PersonaController
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Ruta principal (Cartelera pública)
Route::get('/', function () {
    return view('welcome');
});

// 2. Dashboard (Panel de bienvenida)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// 3. Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    
    // --- Gestión de Perfil de Usuario (Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- CRUD de Usuarios (Administración) ---
    Route::resource('usuarios', UsuarioController::class);

    // --- CRUD de Personas (Talento/Staff) ---
    // Esto reemplaza todas las rutas manuales de 'actores' por las de 'personas'
    Route::resource('personas', PersonaController::class);
    
});

require __DIR__ . '/auth.php';