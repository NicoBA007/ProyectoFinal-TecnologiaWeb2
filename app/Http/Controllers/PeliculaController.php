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

        return view('cliente.peliculas', compact('backdrop', 'peliculaAleatoria', 'peliculas'));
    }

    public function store(StorePeliculaAjaxRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['activo'] = true;
            $pelicula = Pelicula::create($data);

            $pelicula->generos()->sync($request->generos);
            $pelicula->paises()->sync($request->paises);

            return response()->json(['success' => true, 'message' => 'Creada con géneros y países.', 'data' => PeliculaDTO::fromModel($pelicula)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar.'], 500);
        }
    }

    public function update(UpdatePeliculaAjaxRequest $request, string $id): JsonResponse
    {
        try {
            $pelicula = Pelicula::findOrFail($id);
            $pelicula->update($request->validated());

            $pelicula->generos()->sync($request->generos);
            $pelicula->paises()->sync($request->paises);

            return response()->json(['success' => true, 'message' => 'Actualizada con éxito.', 'data' => PeliculaDTO::fromModel($pelicula)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            Pelicula::findOrFail($id)->update(['activo' => false]);
            return response()->json(['success' => true, 'message' => 'Desactivada.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error.'], 500);
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
            $request->validate([
                'id_persona' => 'required|exists:persona,id_persona',
                'rol_en_pelicula' => 'required|string|max:50',
                'papel_personaje' => 'nullable|string|max:100'
            ]);

            $pelicula = Pelicula::findOrFail($id);

            // Validamos que no se duplique el mismo rol para la misma persona (Tu UNIQUE de BD)
            $existe = $pelicula->personas()
                ->where('pelicula_personal.id_persona', $request->id_persona)
                ->where('pelicula_personal.rol_en_pelicula', $request->rol_en_pelicula)
                ->exists();

            if ($existe) {
                return response()->json(['success' => false, 'message' => 'Esta persona ya tiene este rol registrado en la película.'], 400);
            }

            $pelicula->personas()->attach($request->id_persona, [
                'rol_en_pelicula' => $request->rol_en_pelicula,
                'papel_personaje' => $request->papel_personaje
            ]);

            return response()->json(['success' => true, 'message' => 'Talento añadido al elenco correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al añadir talento.'], 500);
        }
    }

    public function removerElenco(string $id_pelicula, string $pivot_id): JsonResponse
    {
        try {
            // Eliminamos usando el ID único de la tabla pivote que creaste en tu DB
            \Illuminate\Support\Facades\DB::table('pelicula_personal')->where('id', $pivot_id)->delete();
            return response()->json(['success' => true, 'message' => 'Rol removido del elenco.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al remover talento.'], 500);
        }
    }
}
