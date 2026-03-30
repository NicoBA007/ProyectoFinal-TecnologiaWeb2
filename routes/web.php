<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\CriticaController;
use App\Http\Controllers\PeliculaController; // ¡Agregado el Jefe Final!
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
    Route::resource('personas', PersonaController::class);

    // --- Catálogos (Géneros, Países, Clasificaciones) ---
    Route::resource('generos', GeneroController::class);
    Route::resource('paises', PaisController::class);
    Route::resource('clasificaciones', ClasificacionController::class);

    // --- Gestión de Críticas / Reseñas ---
    // Excluimos create, edit y show porque las críticas se hacen directo en la vista de la película
    Route::resource('criticas', CriticaController::class)->except(['create', 'edit', 'show']);

    // --- EL JEFE FINAL: CRUD de Películas ---
    Route::resource('peliculas', PeliculaController::class);

    // Rutas personalizadas para manejar la tabla pivote (Elenco) directamente
    Route::post('/peliculas/{pelicula}/elenco', [PeliculaController::class, 'agregarElenco'])->name('peliculas.elenco.store');
    Route::delete('/peliculas/{pelicula}/elenco/{pivot_id}', [PeliculaController::class, 'removerElenco'])->name('peliculas.elenco.destroy');
});

require __DIR__ . '/auth.php';