<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Critica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteleraController extends Controller
{
  /**
   * 1. LA CARTELERA: Muestra todas las películas disponibles
   */
  public function index()
  {
    // Traemos las películas activas. 
    // ¡LA MAGIA!: withAvg() le pide a la BD que calcule el promedio de la columna 'puntuacion' en la tabla 'criticas'
    $peliculas = Pelicula::where('activo', true)
      ->whereIn('estado', ['En Emision', 'Ya Emitida'])
      ->withAvg('criticas', 'puntuacion')
      ->orderBy('fecha_estreno', 'desc')
      ->get();

    return view('cliente.cartelera', compact('peliculas'));
  }

  /**
   * 2. DETALLES DE LA PELÍCULA: Muestra la info, el elenco y las reseñas
   */
  public function show($id)
  {
    // Traemos la película con su promedio (esto lo ven todos)
    $pelicula = Pelicula::with(['clasificacion', 'generos', 'paises', 'personas', 'criticas.usuario'])
      ->withAvg('criticas', 'puntuacion')
      ->findOrFail($id);

    // Por defecto asumimos que no ha calificado (o porque no ha entrado, o porque no lo ha hecho)
    $yaCalifico = false;

    // Validamos SI hay alguien logueado en este momento usando Auth::check()
    if (Auth::check()) {
      $usuario_id = Auth::user()->id_usuario;
      $yaCalifico = Critica::where('id_usuario', $usuario_id)
        ->where('id_pelicula', $id)
        ->exists();
    }

    return view('cliente.detalle', compact('pelicula', 'yaCalifico'));
  }

  /**
   * 3. FORMULARIO DE CRÍTICA: Muestra la vista para calificar
   */
  public function crearCritica($id)
  {
    $pelicula = Pelicula::findOrFail($id);
    return view('cliente.critica-form', compact('pelicula'));
  }

  /**
   * 4. GUARDAR CRÍTICA: Recibe los datos del formulario y los guarda en la BD
   */
  public function guardarCritica(Request $request, $id)
  {
    // Validamos que la puntuación sea entre 1 y 5
    $request->validate([
      'puntuacion' => 'required|integer|min:1|max:5',
      'comentario' => 'nullable|string|max:1000'
    ]);

    // Guardamos la crítica relacionándola con el usuario logueado y la película
    Critica::create([
      'id_usuario' => Auth::user()->id_usuario,
      'id_pelicula' => $id,
      'puntuacion' => $request->puntuacion,
      'comentario' => $request->comentario,
      // La fecha_publicacion se pone sola gracias a la BD
    ]);

    // Redirigimos de vuelta a los detalles de la película con un mensaje de éxito
    return redirect()->route('cartelera.show', $id)
      ->with('success', '¡Gracias por tu reseña! Tu calificación ha sido guardada.');
  }
}