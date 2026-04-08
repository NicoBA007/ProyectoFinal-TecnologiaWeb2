<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Clasificacion;
use App\DTOs\PeliculaDTO;
use App\Http\Requests\StorePeliculaAjaxRequest;
use App\Http\Requests\UpdatePeliculaAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PeliculaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            // 1. Cargamos relaciones necesarias y calculamos el promedio (rating)
            // Incluimos 'paises' para que el DTO pueda procesarlos
            $paginacion = Pelicula::with(['clasificacion', 'generos', 'paises'])
                ->withAvg('criticas as rating', 'puntuacion')
                ->where('activo', true)
                ->paginate(20);

            // 2. Transformamos los items a DTOs
            // El DTO ahora recibirá el atributo 'rating' gracias al withAvg
            $dtos = collect($paginacion->items())->map(fn($item) => \App\DTOs\PeliculaDTO::fromModel($item));

            return response()->json([
                'success' => true,
                'data' => $dtos,
                'pagination' => [
                    'total'        => $paginacion->total(),
                    'count'        => $paginacion->count(),
                    'per_page'     => $paginacion->perPage(),
                    'current_page' => $paginacion->currentPage(),
                    'total_pages'  => $paginacion->lastPage()
                ]
            ]);
        }

        // --- Lógica para la Vista (Blade) ---

        // Películas paginadas para la cartelera (incluimos relaciones por si las usas en el render inicial)
        $peliculas = Pelicula::with(['clasificacion', 'paises'])
            ->withAvg('criticas as rating', 'puntuacion')
            ->where('activo', true)
            ->paginate(20);

        // Seleccionamos una película aleatoria para el fondo (Backdrop)
        $peliculaAleatoria = Pelicula::where('activo', true)->inRandomOrder()->first();
        $backdrop = null;

        if ($peliculaAleatoria) {
            try {
                $apiKey = config('services.tmdb.key');
                if ($apiKey) {
                    $fechaLocal = \Carbon\Carbon::parse($peliculaAleatoria->fecha_estreno);
                    $tituloBusqueda = preg_replace('/\s+\d+$/', '', $peliculaAleatoria->titulo);

                    $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://api.themoviedb.org/3/search/movie", [
                        'api_key'              => $apiKey,
                        'query'                => $tituloBusqueda,
                        'language'             => 'es-MX',
                        'primary_release_year' => $fechaLocal->year,
                        'region'               => 'MX',
                    ]);

                    if ($response->successful() && count($response->json()['results']) > 0) {
                        $resultados = $response->json()['results'];
                        $mejorCoincidencia = collect($resultados)->first(function ($item) use ($fechaLocal) {
                            return ($item['release_date'] ?? '') === $fechaLocal->format('Y-m-d');
                        }) ?? $resultados[0];

                        if (isset($mejorCoincidencia['backdrop_path'])) {
                            $backdrop = 'https://image.tmdb.org/t/p/original' . $mejorCoincidencia['backdrop_path'];
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error TMDB en Index: " . $e->getMessage());
            }
        }

        // SI LA RUTA ES DE ADMINISTRACIÓN:
        if ($request->is('admin/*')) {
            // 1. Cargamos los datos necesarios para los formularios (Selects)
            $clasificaciones = \App\Models\Clasificacion::where('activo', true)->get();
            $generos = \App\Models\Genero::where('activo', true)->get();
            $paises = \App\Models\Pais::where('activo', true)->get();

            // 2. Retornamos la vista de gestión pasando todas las variables
            return view('peliculas.index', compact(
                'peliculas',
                'clasificaciones',
                'generos',
                'paises'
            ));
        }

        // SI NO ES ADMIN, MANDA A LA CARTELERA CLIENTE:
        return view('cliente.peliculas', compact('backdrop', 'peliculaAleatoria', 'peliculas'));
    }

    public function store(StorePeliculaAjaxRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['activo'] = true; // Forzamos activo por defecto

            $pelicula = Pelicula::create($data);

            // Sincronizamos las tablas pivote
            if ($request->has('generos')) $pelicula->generos()->sync($request->generos);
            if ($request->has('paises')) $pelicula->paises()->sync($request->paises);

            // Importante: Cargar relaciones para que el DTO no de error
            $pelicula->load(['clasificacion', 'generos', 'paises']);

            return response()->json([
                'success' => true,
                'message' => 'Título catalogado correctamente.',
                'data' => PeliculaDTO::fromModel($pelicula)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdatePeliculaAjaxRequest $request, string $id): JsonResponse
    {
        try {
            // 1. Buscamos la película o fallamos
            $pelicula = Pelicula::findOrFail($id);

            // 2. Actualizamos los datos propios de la tabla 'pelicula'
            // validated() solo tomará los campos definidos en tu UpdatePeliculaAjaxRequest
            $pelicula->update($request->validated());

            // 3. Sincronizamos las relaciones N:M (Tablas intermedias)
            // Usamos el operador null coalescing ?? [] por seguridad si no vienen datos
            $pelicula->generos()->sync($request->input('generos', []));
            $pelicula->paises()->sync($request->input('paises', []));

            // 4. RECARGAMOS las relaciones en la instancia para que el DTO las vea
            $pelicula->load(['generos', 'paises', 'clasificacion']);

            return response()->json([
                'success' => true,
                'message' => 'Cinta y activos digitales actualizados con éxito.',
                'data'    => \App\DTOs\PeliculaDTO::fromModel($pelicula)
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: La película con ID ' . $id . ' no existe en el inventario.'
            ], 404);
        } catch (\Exception $e) {
            // Log para debug interno, mensaje genérico para el usuario
            \Illuminate\Support\Facades\Log::error("Error en Update Película: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'SYSTEM_ERROR: Fallo en la persistencia de datos relacionales.'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $pelicula = Pelicula::findOrFail($id);

            // BAJA LÓGICA: Cambiamos el estado
            $pelicula->activo = false;
            $pelicula->save();

            return response()->json([
                'success' => true,
                'message' => 'Pelicula desactivada correctamente del sistema.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar dar de baja.'
            ], 500);
        }
    }

    public function reactivar(string $id): JsonResponse
    {
        try {
            Pelicula::findOrFail($id)->update(['activo' => true]);
            return response()->json(['success' => true, 'message' => 'Reactivada.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error.'], 500);
        }
    }

    // --- GESTIÓN DE RELACIONES (PIVOTES) ---

    public function detalles(string $id): JsonResponse
    {
        try {
            $pelicula = Pelicula::with(['personas'])->findOrFail($id);
            // Traemos solo las personas activas para el selector
            $personas = \App\Models\Persona::where('activo', true)->orderBy('nombre_completo', 'asc')->get();

            return response()->json([
                'success' => true,
                'elenco' => $pelicula->personas,
                'personas_disponibles' => $personas
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al cargar detalles.'], 500);
        }
    }

    public function agregarElenco(Request $request, string $id): JsonResponse
    {
        try {
            // 1. Validación estricta con los valores del ENUM de tu DB
            $request->validate([
                'id_persona' => 'required|exists:persona,id_persona',
                'rol_en_pelicula' => 'required|in:actor,director', // Solo permite estos dos
                'papel_personaje' => 'nullable|string|max:100'
            ], [
                'rol_en_pelicula.in' => 'El rol debe ser actor o director.',
                'id_persona.exists' => 'La persona seleccionada no existe en el registro.'
            ]);

            $pelicula = Pelicula::findOrFail($id);

            // 2. Verificación de duplicados (Respetando tu restricción UNIQUE de la DB)
            // Es importante especificar la tabla en el where para evitar ambigüedad
            $existe = $pelicula->personas()
                ->where('pelicula_personal.id_persona', $request->id_persona)
                ->where('pelicula_personal.rol_en_pelicula', $request->rol_en_pelicula)
                ->exists();

            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este talento ya está registrado con ese mismo rol en esta película.'
                ], 422); // 422 es más apropiado para errores de validación lógica
            }

            // 3. Inserción en la tabla pivote
            $pelicula->personas()->attach($request->id_persona, [
                'rol_en_pelicula' => $request->rol_en_pelicula,
                'papel_personaje' => $request->papel_personaje
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Talento vinculado al reparto exitosamente.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura errores de validación de Laravel (ej: campos vacíos)
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Captura cualquier otro error (BD, conexión, etc.)
            return response()->json([
                'success' => false,
                'message' => 'Error de sistema: No se pudo procesar la asignación.'
            ], 500);
        }
    }

    public function removerElenco(string $id_pelicula, string $pivot_id): JsonResponse
    {
        try {
            // Eliminamos directamente de la tabla usando el ID del pivot
            $eliminado = \Illuminate\Support\Facades\DB::table('pelicula_personal')
                ->where('id', $pivot_id)
                ->delete();

            if ($eliminado) {
                return response()->json([
                    'success' => true,
                    'message' => 'Talento removido del reparto correctamente.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se encontró el registro para eliminar.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error crítico al remover talento.'
            ], 500);
        }
    }
}
