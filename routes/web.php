<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\CriticaController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\CarteleraController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 🟢 RUTAS PÚBLICAS (Cualquiera puede entrar)
// ==========================================

// 1. Ruta principal: Ahora muestra la cartelera conectada a la Base de Datos
Route::get('/', [CarteleraController::class, 'index'])->name('cartelera.index');

// 2. Detalles de una película en específico
Route::get('/cartelera/{id}', [CarteleraController::class, 'show'])->name('cartelera.show');



// ==========================================
// 🔴 RUTAS PROTEGIDAS (Requieren iniciar sesión)
// ==========================================
Route::middleware('auth')->group(function () {

    // --- Dashboard (Panel de bienvenida para el Admin) ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // --- ACCIONES DEL CLIENTE ---
    // Rutas exclusivas para dejar una reseña (debes estar logueado para verlas)
    Route::get('/cartelera/{id}/calificar', [CarteleraController::class, 'crearCritica'])->name('cartelera.calificar');
    Route::post('/cartelera/{id}/calificar', [CarteleraController::class, 'guardarCritica'])->name('cartelera.guardar_critica');


    // --- ADMINISTRACIÓN (CRUDs) ---
    // Gestión de Perfil de Usuario (Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // CRUD de Personas (Talento/Staff)
    Route::resource('personas', PersonaController::class);

    // Catálogos (Géneros, Países, Clasificaciones)
    Route::resource('generos', GeneroController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('clasificaciones', ClasificacionController::class);

    // Gestión de Críticas / Reseñas
    Route::resource('criticas', CriticaController::class)->except(['create', 'edit', 'show']);

    // EL JEFE FINAL: CRUD de Películas
    Route::resource('peliculas', PeliculaController::class);

    // Rutas personalizadas para manejar la tabla pivote (Elenco)
    Route::post('/peliculas/{pelicula}/elenco', [PeliculaController::class, 'agregarElenco'])->name('peliculas.elenco.store');
    Route::delete('/peliculas/{pelicula}/elenco/{pivot_id}', [PeliculaController::class, 'removerElenco'])->name('peliculas.elenco.destroy');

});

// Archivo que contiene las rutas de Login, Registro y Logout
require __DIR__ . '/auth.php';