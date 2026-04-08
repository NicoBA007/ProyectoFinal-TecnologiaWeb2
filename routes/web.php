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

// 2. Nueva ruta para ver el catálogo completo de películas (cliente)
Route::get('/catalogo-peliculas', [PeliculaController::class, 'index'])->name('peliculas.catalogo.cliente');

Route::get('/api/peliculas-datos', [PeliculaController::class, 'index'])->name('api.peliculas.index');

// 3. Detalles de una película en específico
Route::get('/cartelera/{id}', [CarteleraController::class, 'show'])->name('cartelera.show');

// 4. NUEVA RUTA: Catálogo de Celebridades
Route::get('/celebridades', [CarteleraController::class, 'celebridades'])->name('celebridades.index');

// Detalle de una celebridad específica
Route::get('/celebridades/{id}', [CarteleraController::class, 'detalleCelebridad'])->name('celebridades.show');

Route::get('/generos/{id}', [CarteleraController::class, 'peliculasPorGenero'])->name('genero.show');

Route::get('/clasificaciones/{id}', [CarteleraController::class, 'showClasificacion'])
    ->name('clasificacion.show');

Route::get('/buscar', [CarteleraController::class, 'search'])->name('cartelera.search');
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
    Route::patch('/usuarios/{id}/reactivar', [UsuarioController::class, 'reactivar'])->name('usuarios.reactivar');
    Route::resource('usuarios', UsuarioController::class);

    // CRUD de Personas (Talento/Staff)
    Route::patch('/personas/{id}/reactivar', [PersonaController::class, 'reactivar'])->name('personas.reactivar');
    Route::resource('personas', PersonaController::class);

    // Catálogos (Géneros, Países, Clasificaciones)
    Route::patch('/generos/{id}/reactivar', [GeneroController::class, 'reactivar'])->name('generos.reactivar');
    Route::resource('generos', GeneroController::class);
    Route::patch('/paises/{id}/reactivar', [PaisController::class, 'reactivar'])->name('paises.reactivar');
    Route::resource('paises', PaisController::class);
    Route::patch('/clasificaciones/{id}/reactivar', [ClasificacionController::class, 'reactivar'])->name('clasificaciones.reactivar');
    Route::resource('clasificaciones', ClasificacionController::class);

    // Gestión de Críticas / Reseñas
    Route::resource('criticas', CriticaController::class)->except(['create', 'edit', 'show']);

    // EL JEFE FINAL: CRUD de Películas
    Route::patch('/peliculas/{id}/reactivar', [PeliculaController::class, 'reactivar'])->name('peliculas.reactivar');
    Route::resource('peliculas', PeliculaController::class);
    Route::get('/peliculas/{pelicula}/detalles', [PeliculaController::class, 'detalles'])->name('peliculas.detalles');
    // Rutas personalizadas para manejar la tabla pivote (Elenco)
    Route::post('/peliculas/{pelicula}/elenco', [PeliculaController::class, 'agregarElenco'])->name('peliculas.elenco.store');
    Route::delete('/peliculas/{pelicula}/elenco/{pivot}', [PeliculaController::class, 'removerElenco'])->name('peliculas.elenco.destroy');
});

// Archivo que contiene las rutas de Login, Registro y Logout
require __DIR__ . '/auth.php';
