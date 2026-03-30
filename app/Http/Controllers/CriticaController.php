<?php

namespace App\Http\Controllers;

use App\Models\Critica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CriticaController extends Controller
{
    /**
     * Muestra todas las críticas (Ideal para el panel del Administrador)
     */
    public function index()
    {
        // Traemos las críticas incluyendo los datos del usuario y la película
        $criticas = Critica::with(['usuario', 'pelicula'])
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        return view('criticas.index', compact('criticas'));
    }

    /**
     * Guarda una nueva crítica hecha por un cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelicula' => 'required|exists:pelicula,id_pelicula',
            'puntuacion' => 'required|integer|min:1|max:5', // Asumiendo sistema de 1 a 5 estrellas
            'comentario' => 'nullable|string|max:1000'
        ]);

        // 1. Verificamos la regla UNIQUE de tu BD para que no dé error SQL
        $criticaExistente = Critica::where('id_usuario', Auth::user()->id_usuario)
            ->where('id_pelicula', $request->id_pelicula)
            ->first();

        if ($criticaExistente) {
            return redirect()->back()->with('error', 'Ya has publicado una reseña para esta película.');
        }

        // 2. Guardamos la crítica
        Critica::create([
            'id_usuario' => Auth::user()->id_usuario,
            'id_pelicula' => $request->id_pelicula,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            // 'fecha_publicacion' se llena sola gracias a tu DEFAULT CURRENT_TIMESTAMP
        ]);

        return redirect()->back()->with('success', '¡Tu crítica ha sido publicada con éxito!');
    }

    /**
     * Actualiza la crítica si el cliente quiere cambiar de opinión.
     */
    public function update(Request $request, $id)
    {
        $critica = Critica::findOrFail($id);

        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000'
        ]);

        $critica->update([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario
        ]);

        return redirect()->back()->with('success', 'Tu reseña ha sido actualizada.');
    }

    /**
     * Elimina la crítica de la base de datos.
     */
    public function destroy($id)
    {
        $critica = Critica::findOrFail($id);

        // Aquí SÍ usamos delete() porque tu tabla 'critica' no tiene columna 'activo'
        $critica->delete();

        return redirect()->back()->with('success', 'Reseña eliminada permanentemente.');
    }
}