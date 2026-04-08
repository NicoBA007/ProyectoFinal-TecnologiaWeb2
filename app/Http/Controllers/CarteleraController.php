<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Critica;
use App\Models\Persona; // Añadido
use App\Models\Genero;  // Añadido
use App\Models\Clasificacion;
use App\DTOs\PeliculaDTO; // Añadido
use App\DTOs\PersonaDTO;  // Añadido
use App\DTOs\GeneroDTO;   // Añadido
use App\DTOs\ClasificacionDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CarteleraController extends Controller
{
    /**
     * 1. LA CARTELERA: Muestra todas las películas disponibles, celebridades y géneros
     */
    public function index()
    {
        // 1. Obtener Películas (Raw para el carrusel y transformadas para la lista)
        $peliculasRaw = Pelicula::where('activo', true)
            ->where('estado', 'En Emision')
            ->withAvg('criticas', 'puntuacion')
            ->orderBy('id_pelicula', 'desc')
            ->take(10)
            ->get();

        $peliculas = $peliculasRaw->map(fn($p) => PeliculaDTO::fromModel($p));

        // 2. Obtener Celebridades
        $celebridades = Persona::where('activo', true)
            ->orderBy('id_persona', 'desc')
            ->take(10)
            ->get()
            ->map(fn($per) => PersonaDTO::fromModel($per));

        // 3. Obtener Géneros
        $generos = Genero::where('activo', true)
            ->orderBy('id_genero', 'desc')
            ->take(10)
            ->get()
            ->map(fn($g) => GeneroDTO::fromModel($g));

        // 4. Obtener Clasificaciones (NUEVA SECCIÓN)
        $clasificaciones = Clasificacion::where('activo', true)
            ->orderBy('codigo', 'asc')
            ->get()
            ->map(fn($c) => ClasificacionDTO::fromModel($c));

        // 5. Lógica del Carrusel (TMDB API)
        $apiKey = config('services.tmdb.key');
        $carouselItems = [];

        foreach ($peliculasRaw as $pelicula) {
            try {
                $fecha = \Carbon\Carbon::parse($pelicula->fecha_estreno);

                $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                    'api_key'              => $apiKey,
                    'query'                => $pelicula->titulo,
                    'language'             => 'es-MX',
                    'primary_release_year' => $fecha->year,
                    'region'               => 'MX'
                ]);

                if ($response->successful() && isset($response->json()['results'][0])) {
                    $resultados = $response->json()['results'];

                    $data = collect($resultados)->first(function ($item) use ($fecha) {
                        return ($item['release_date'] ?? '') === $fecha->format('Y-m-d');
                    }) ?? $resultados[0];

                    if (!empty($data['backdrop_path'])) {
                        $carouselItems[] = [
                            'id_pelicula' => $pelicula->id_pelicula,
                            'titulo'      => $pelicula->titulo,
                            'backdrop'    => 'https://image.tmdb.org/t/p/original' . $data['backdrop_path'],
                            'resumen'     => $data['overview'] ?? 'Sin descripción.',
                        ];
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // 6. Retornar vista con todas las variables
        return view('cliente.cartelera', compact(
            'peliculas',
            'carouselItems',
            'celebridades',
            'generos',
            'clasificaciones'
        ));
    }
    /**
     * 2. DETALLES DE LA PELÍCULA: Muestra la info, el elenco y las reseñas
     */
    public function show($id)
    {
        // 1. Cargamos el modelo con sus relaciones y el promedio de críticas
        // Importante: withAvg añade el atributo 'criticas_avg_puntuacion' al modelo
        $peliculaModel = Pelicula::with([
            'clasificacion',
            'generos',
            'paises',
            'personas' // La relación en el modelo ya incluye ->withPivot(...)
        ])
            ->withAvg('criticas', 'puntuacion')
            ->findOrFail($id);

        // 2. Transformamos el Modelo a DTO (Array estructurado)
        // Ahora $pelicula es un array, por lo que usaremos $pelicula['campo']
        $pelicula = \App\DTOs\PeliculaDTO::fromModel($peliculaModel);

        // --- LÓGICA DE VISIBILIDAD Y BLOQUEO ---

        // Verificamos si es un estreno futuro usando la estructura del DTO
        $esProximamente = ($pelicula['estado'] === 'Proximamente');

        /**
         * Ajuste de visibilidad:
         * Si es 'Proximamente', ocultamos la sección de críticas.
         */
        $mostrarCriticas = !$esProximamente;

        // 3. Cargamos las críticas paginadas solo si la película ya se estrenó
        $criticas = collect();
        if ($mostrarCriticas) {
            $criticas = \App\Models\Critica::with('usuario')
                ->where('id_pelicula', $id)
                ->orderBy('fecha_publicacion', 'desc')
                ->paginate(6);
        }

        $yaCalifico = false;

        // Verificamos si el usuario autenticado ya dejó una reseña
        if ($mostrarCriticas && Auth::check()) {
            $yaCalifico = \App\Models\Critica::where('id_usuario', Auth::user()->id_usuario)
                ->where('id_pelicula', $id)
                ->exists();
        }

        // --- LÓGICA PARA EL BACKDROP (TMDB) ---
        $backdrop = null;
        try {
            $apiKey = config('services.tmdb.key');
            if ($apiKey) {
                // Usamos Carbon para parsear la fecha desde el array del DTO
                $fechaLocal = \Carbon\Carbon::parse($pelicula['fecha_estreno']);

                // Limpiamos el título de números al final para mejorar la búsqueda
                $tituloBusqueda = preg_replace('/\s+\d+$/', '', $pelicula['titulo']);

                $response = Http::timeout(3)->get("https://api.themoviedb.org/3/search/movie", [
                    'api_key'              => $apiKey,
                    'query'                => $tituloBusqueda,
                    'language'             => 'es-MX',
                    'primary_release_year' => $fechaLocal->year,
                    'region'               => 'MX'
                ]);

                if ($response->successful() && count($response->json()['results']) > 0) {
                    $resultados = $response->json()['results'];

                    // Buscamos coincidencia exacta por fecha o por título
                    $mejorCoincidencia = collect($resultados)->first(function ($item) use ($fechaLocal) {
                        return ($item['release_date'] ?? '') === $fechaLocal->format('Y-m-d');
                    }) ?? collect($resultados)->first(function ($item) use ($pelicula) {
                        return strtolower($item['title'] ?? '') === strtolower($pelicula['titulo']);
                    }) ?? $resultados[0];

                    if (isset($mejorCoincidencia['backdrop_path'])) {
                        $backdrop = 'https://image.tmdb.org/t/p/original' . $mejorCoincidencia['backdrop_path'];
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error TMDB en Detalle (Pelicula ID $id): " . $e->getMessage());
        }

        // 4. Retornamos la vista con todas las variables necesarias
        return view('cliente.detalle', compact(
            'pelicula',
            'yaCalifico',
            'backdrop',
            'mostrarCriticas',
            'criticas',
            'esProximamente'
        ));
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
        // 1. Cambiamos 'integer' por 'numeric' para aceptar decimales (4.5)
        // 2. Cambiamos 'min:1' por 'min:0' si quieres permitir calificación de cero
        $request->validate([
            'puntuacion' => 'required|numeric|min:0|max:5',
            'comentario' => 'nullable|string|max:1000'
        ]);

        try {
            // Aseguramos que el usuario esté autenticado
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'Debes iniciar sesión para calificar.');
            }

            // Creamos la crítica
            Critica::create([
                'id_usuario'  => Auth::user()->id_usuario,
                'id_pelicula' => $id,
                'puntuacion'  => $request->puntuacion, // Laravel se encarga de guardarlo como float/decimal
                'comentario'  => $request->comentario,
                'fecha_publicacion' => now(), // Asegúrate de que este campo exista o se llene solo
            ]);

            return redirect()->route('cartelera.show', $id)
                ->with('success', '¡Gracias por tu reseña! Tu calificación ha sido guardada.');
        } catch (\Exception $e) {
            // Log por si algo falla a nivel de base de datos
            Log::error("Error al guardar crítica: " . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al guardar tu reseña.');
        }
    }
    /**
     * 5. CELEBRIDADES: Muestra el catálogo completo de actores, directores, etc.
     */
    public function celebridades(Request $request)
    {
        $rolFiltrado = $request->query('rol');

        // 1. Iniciamos la consulta base
        $query = \App\Models\Persona::where('activo', true);

        // 2. Aplicamos el filtro de ROL antes de paginar
        if ($rolFiltrado && $rolFiltrado !== 'todos') {
            $query->whereHas('peliculas', function ($q) use ($rolFiltrado) {
                $q->where('rol_en_pelicula', 'like', '%' . $rolFiltrado . '%');
            });
        }

        // 3. Paginar y añadir el parámetro de la URL a los links
        $celebridadesRaw = $query->orderBy('nombre_completo', 'asc')
            ->with(['peliculas'])
            ->paginate(15)
            ->appends(['rol' => $rolFiltrado]);

        // 4. Transformamos la colección
        $celebridadesRaw->setCollection(
            $celebridadesRaw->getCollection()->map(function ($persona) {
                $dto = \App\DTOs\PersonaDTO::fromModel($persona);

                // Calculamos roles únicos
                $roles = $persona->peliculas->pluck('pivot.rol_en_pelicula')->unique()->filter();

                // --- CORRECCIÓN CRÍTICA ---
                // Nos aseguramos de que el ID esté disponible para la ruta de detalles
                // Usamos id_persona porque es el nombre de tu columna en la DB
                $dto['id'] = $persona->id_persona;

                $dto['total_peliculas'] = $persona->peliculas->count();
                $dto['rol'] = $roles->first() ?? 'Talento';
                $dto['roles_completos'] = $roles->implode(' ');

                return $dto;
            })
        );

        return view('cliente.celebridades', [
            'celebridades' => $celebridadesRaw,
            'currentRole' => $rolFiltrado ?? 'todos'
        ]);
    }

    public function detalleCelebridad($id)
    {
        $personaModel = \App\Models\Persona::with(['peliculas' => function ($q) {
            $q->where('pelicula.activo', true);
        }])->findOrFail($id);

        $personaDTO = \App\DTOs\PersonaDTO::fromModel($personaModel);
        $apiKey = config('services.tmdb.key');

        $redes = ['instagram' => null, 'twitter' => null, 'facebook' => null, 'tiktok' => null];
        $datosExtra = ['nacimiento' => null, 'lugar_nacimiento' => null];

        if ($apiKey) {
            try {
                $search = Http::timeout(3)->get("https://api.themoviedb.org/3/search/person", [
                    'api_key' => $apiKey,
                    'query'   => $personaDTO['nombre_completo']
                ]);

                if ($search->successful() && !empty($search->json()['results'])) {
                    $tmdbId = $search->json()['results'][0]['id'];

                    $ext = Http::get("https://api.themoviedb.org/3/person/{$tmdbId}/external_ids?api_key={$apiKey}")->json();
                    $redes = [
                        'instagram' => !empty($ext['instagram_id']) ? "https://instagram.com/{$ext['instagram_id']}" : null,
                        'twitter'   => !empty($ext['twitter_id']) ? "https://twitter.com/{$ext['twitter_id']}" : null,
                        'facebook'  => !empty($ext['facebook_id']) ? "https://facebook.com/{$ext['facebook_id']}" : null,
                        'tiktok'    => !empty($ext['tiktok_id']) ? "https://tiktok.com/@{$ext['tiktok_id']}" : null,
                    ];

                    $det = Http::get("https://api.themoviedb.org/3/person/{$tmdbId}?api_key={$apiKey}&language=es-MX")->json();
                    $datosExtra['nacimiento'] = $det['birthday'] ?? null;
                    $datosExtra['lugar_nacimiento'] = $det['place_of_birth'] ?? null;
                }
            } catch (\Exception $e) {
                Log::error("Error TMDB: " . $e->getMessage());
            }
        }

        $peliculasFinales = $personaModel->peliculas->map(function ($peli) use ($apiKey) {
            $peliDTO = \App\DTOs\PeliculaDTO::fromModel($peli);

            // Buscamos solo el backdrop para el diseño estético de la fila o el hero
            $backdrop = null;
            if ($apiKey) {
                try {
                    $searchPeli = Http::timeout(2)->get("https://api.themoviedb.org/3/search/movie", [
                        'api_key' => $apiKey,
                        'query'   => preg_replace('/\s+\d+$/', '', $peliDTO['titulo']),
                        'primary_release_year' => $peliDTO['anio']
                    ]);
                    if ($searchPeli->successful() && !empty($searchPeli->json()['results'])) {
                        $path = $searchPeli->json()['results'][0]['backdrop_path'];
                        $backdrop = $path ? 'https://image.tmdb.org/t/p/w1280' . $path : null;
                    }
                } catch (\Exception $e) {
                }
            }

            $posterFinal = !empty($peliDTO['poster_url'])
                ? (str_starts_with($peliDTO['poster_url'], 'http') ? $peliDTO['poster_url'] : asset('storage/' . $peliDTO['poster_url']))
                : asset('images/no-poster.jpg');

            return [
                'id'        => $peliDTO['id_pelicula'],
                'titulo'    => $peliDTO['titulo'],
                'poster'    => $posterFinal,
                'backdrop'  => $backdrop ?: $posterFinal,
                'anio'      => $peliDTO['anio'],
                'rol'       => $peli->pivot->rol_en_pelicula ?? 'Actor',
                'personaje' => $peli->pivot->papel_personaje ?? ''
            ];
        });

        $celebridad = [
            'id'               => $personaModel->id_persona,
            'nombre'           => $personaDTO['nombre_completo'],
            'foto_url'         => $personaDTO['foto_url'],
            'redes'            => $redes,
            'nacimiento'       => $datosExtra['nacimiento'],
            'lugar_nacimiento' => $datosExtra['lugar_nacimiento'],
            'peliculas'        => $peliculasFinales
        ];

        return view('cliente.celebridades_detalle', compact('celebridad'));
    }
    /**
     * 6. PELÍCULAS POR GÉNERO: Filtra y muestra las películas de un género específico
     */
    public function peliculasPorGenero($id)
    {
        // 1. Obtener el género actual
        $generoModel = \App\Models\Genero::where('activo', true)->findOrFail($id);

        // 2. Paginación de Películas (Importante: hacerlo desde el modelo Pelicula para que funcione ->total())
        $peliculasPaginadas = \App\Models\Pelicula::whereHas('generos', function ($q) use ($id) {
            $q->where('genero.id_genero', $id);
        })
            ->where('pelicula.activo', true)
            ->withAvg('criticas as rating', 'puntuacion')
            ->orderBy('fecha_estreno', 'desc')
            ->paginate(15);

        // Transformamos los items del paginador a DTOs sin romper la instancia del Paginator
        $peliculas = $peliculasPaginadas->getCollection()->map(fn($p) => \App\DTOs\PeliculaDTO::fromModel($p));
        $peliculasPaginadas->setCollection($peliculas);

        // 3. Lista de TODOS los géneros para el Modal
        $todosLosGeneros = \App\Models\Genero::where('activo', true)
            ->withCount(['peliculas' => function ($q) {
                $q->where('pelicula.activo', true);
            }])
            ->get();

        $genero = \App\DTOs\GeneroDTO::fromModel($generoModel);

        // 4. Backdrop Aleatorio (usamos los resultados actuales de la página)
        $backdrop = null;
        if ($peliculasPaginadas->isNotEmpty()) {
            // Obtenemos una película aleatoria de los resultados paginados para el fondo
            $peliculaParaFondo = \App\Models\Pelicula::find($peliculasPaginadas->random()['id_pelicula']);

            try {
                $apiKey = config('services.tmdb.key');
                if ($apiKey) {
                    $tituloBusqueda = preg_replace('/\s+\d+$/', '', $peliculaParaFondo->titulo);
                    $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://api.themoviedb.org/3/search/movie", [
                        'api_key' => $apiKey,
                        'query'   => $tituloBusqueda,
                        'language' => 'es-MX',
                        'primary_release_year' => \Carbon\Carbon::parse($peliculaParaFondo->fecha_estreno)->year,
                    ]);
                    if ($response->successful() && !empty($response->json()['results'])) {
                        $match = $response->json()['results'][0];
                        $backdrop = isset($match['backdrop_path']) ? 'https://image.tmdb.org/t/p/original' . $match['backdrop_path'] : null;
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error($e->getMessage());
            }
        }

        return view('cliente.genero_detalle', [
            'genero' => $genero,
            'peliculas' => $peliculasPaginadas, // Ahora es un Paginator con DTOs
            'todosLosGeneros' => $todosLosGeneros,
            'total' => $peliculasPaginadas->total(), // Ahora sí existe el método total()
            'backdrop' => $backdrop
        ]);
    }

    public function showClasificacion($id)
    {
        // 1. Obtener la clasificación base
        $clasificacionModel = \App\Models\Clasificacion::where('activo', true)->findOrFail($id);

        // 2. Paginación de Películas (Consultamos desde el modelo Pelicula para habilitar ->total())
        $peliculasPaginadas = \App\Models\Pelicula::where('id_clasificacion', $id)
            ->where('activo', true)
            ->withAvg('criticas as rating', 'puntuacion')
            ->orderBy('id_pelicula', 'desc')
            ->paginate(15); // <--- Habilitamos la paginación para la vista

        // 3. Mapear los items del paginador a DTOs manteniendo la estructura de paginación
        $peliculasDTO = $peliculasPaginadas->getCollection()->map(fn($p) => \App\DTOs\PeliculaDTO::fromModel($p));
        $peliculasPaginadas->setCollection($peliculasDTO);

        // 4. Todos los registros para el modal selector
        $todasLasClasificaciones = \App\Models\Clasificacion::where('activo', true)->get();

        // 5. Lógica de Backdrop (TMDB)
        $backdrop = null;

        // Usamos el paginador para ver si hay resultados
        if ($peliculasPaginadas->isNotEmpty()) {
            // Obtenemos una película aleatoria de la página actual para el fondo
            $peliculaParaFondoRaw = \App\Models\Pelicula::find($peliculasPaginadas->random()['id_pelicula']);

            try {
                $apiKey = config('services.tmdb.key');
                if ($apiKey) {
                    // Limpiar el título
                    $tituloBusqueda = preg_replace('/\s+\d+$/', '', $peliculaParaFondoRaw->titulo);

                    // Obtener el año
                    $anioEstreno = \Carbon\Carbon::parse($peliculaParaFondoRaw->fecha_estreno)->year;

                    // Petición a TMDB
                    $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://api.themoviedb.org/3/search/movie", [
                        'api_key'              => $apiKey,
                        'query'                => $tituloBusqueda,
                        'language'             => 'es-MX',
                        'primary_release_year' => $anioEstreno,
                    ]);

                    if ($response->successful() && !empty($response->json()['results'])) {
                        $results = $response->json()['results'];
                        $match = collect($results)->first(fn($item) => !empty($item['backdrop_path'])) ?? $results[0];

                        if (isset($match['backdrop_path'])) {
                            $backdrop = 'https://image.tmdb.org/t/p/original' . $match['backdrop_path'];
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error TMDB: " . $e->getMessage());
            }
        }

        return view('cliente.clasificacion_detalle', [
            'clasificacion' => $clasificacionModel,
            'peliculas' => $peliculasPaginadas, // Enviamos el objeto Paginator con DTOs dentro
            'todasLasClasificaciones' => $todasLasClasificaciones,
            'backdrop' => $backdrop
        ]);
    }

    /**
     * 7. BUSCADOR AJAX: Busca películas y celebridades en tiempo real
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // 1. Buscamos películas (usando el modelo Pelicula y filtrando activos)
        $peliculas = \App\Models\Pelicula::where('titulo', 'LIKE', "%{$query}%")
            ->where('activo', true)
            ->limit(5)
            ->get()
            ->map(fn($p) => \App\DTOs\PeliculaDTO::fromModel($p));

        // 2. Buscamos celebridades (En tu código usas el modelo Persona)
        $celebridades = \App\Models\Persona::where('nombre_completo', 'LIKE', "%{$query}%")
            ->where('activo', true)
            ->limit(5)
            ->get()
            ->map(fn($per) => \App\DTOs\PersonaDTO::fromModel($per));

        return response()->json([
            'peliculas' => $peliculas,
            'celebridades' => $celebridades,
        ]);
    }
}
