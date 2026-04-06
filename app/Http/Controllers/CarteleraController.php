<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Critica;
use App\Models\Persona; // Añadido
use App\Models\Genero;  // Añadido
use App\DTOs\PeliculaDTO; // Añadido
use App\DTOs\PersonaDTO;  // Añadido
use App\DTOs\GeneroDTO;   // Añadido
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CarteleraController extends Controller
{
    /**
     * 1. LA CARTELERA: Muestra todas las películas disponibles, celebridades y géneros
     */
    public function index()
    {
        // 1. Películas: ÚNICAMENTE las que están "En Emision" (Últimas 10)
        $peliculasRaw = Pelicula::where('activo', true)
            ->where('estado', 'En Emision') // Cambiado de whereIn a where simple
            ->withAvg('criticas', 'puntuacion')
            ->orderBy('id_pelicula', 'desc')
            ->take(10)
            ->get();

        $peliculas = $peliculasRaw->map(fn($p) => PeliculaDTO::fromModel($p));

        // 2. Celebridades: Últimas 10
        $celebridades = Persona::where('activo', true)
            ->orderBy('id_persona', 'desc')
            ->take(10)
            ->get()
            ->map(fn($per) => PersonaDTO::fromModel($per));

        // 3. Géneros: Últimos 10
        $generos = Genero::where('activo', true)
            ->orderBy('id_genero', 'desc')
            ->take(10)
            ->get()
            ->map(fn($g) => GeneroDTO::fromModel($g));

        // --- LÓGICA DE PUENTE TMDB ---
        $apiKey = config('services.tmdb.key');
        $carouselItems = [];

        foreach ($peliculasRaw as $pelicula) {
            try {
                // Obtenemos el año para que la búsqueda sea precisa
                $year = $pelicula->fecha_estreno ? \Carbon\Carbon::parse($pelicula->fecha_estreno)->year : null;

                $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                    'api_key'  => $apiKey,
                    'query'    => $pelicula->titulo,
                    'language' => 'es-ES',
                ]);

                if ($response->successful() && isset($response->json()['results'][0])) {
                    $data = $response->json()['results'][0];

                    if (!empty($data['backdrop_path'])) {
                        $carouselItems[] = [
                            'id_pelicula' => $pelicula->id_pelicula,
                            'titulo'      => $pelicula->titulo,
                            'backdrop'    => 'https://image.tmdb.org/t/p/original' . $data['backdrop_path'],
                            'resumen'     => $data['overview'] ?? 'Sin descripción disponible.',
                        ];
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return view('cliente.cartelera', compact('peliculas', 'carouselItems', 'celebridades', 'generos'));
    }
    /**
     * 2. DETALLES DE LA PELÍCULA: Muestra la info, el elenco y las reseñas
     */
    public function show($id)
    {
        $pelicula = Pelicula::with(['clasificacion', 'generos', 'paises', 'personas', 'criticas.usuario'])
            ->withAvg('criticas', 'puntuacion')
            ->findOrFail($id);

        $yaCalifico = false;

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
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000'
        ]);

        Critica::create([
            'id_usuario' => Auth::user()->id_usuario,
            'id_pelicula' => $id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('cartelera.show', $id)
            ->with('success', '¡Gracias por tu reseña! Tu calificación ha sido guardada.');
    }
}
