<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Clasificacion;
use App\DTOs\PeliculaDTO;
use App\Http\Requests\StorePeliculaAjaxRequest;
use App\Http\Requests\UpdatePeliculaAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PeliculaController extends Controller
{
  public function index(Request $request)
  {
    if ($request->wantsJson()) {
      try {
        $datos = Pelicula::with(['clasificacion', 'generos', 'paises'])->orderBy('id_pelicula', 'desc')->get();
        $dtos = $datos->map(fn($item) => PeliculaDTO::fromModel($item));
        return response()->json(['success' => true, 'data' => $dtos]);
      } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
      }
    }
    // Traemos los catálogos activos para inyectarlos en los Checkboxes del formulario
    $clasificaciones = Clasificacion::where('activo', true)->get();
    $generos = \App\Models\Genero::where('activo', true)->orderBy('nombre', 'asc')->get();
    $paises = \App\Models\Pais::where('activo', true)->orderBy('nombre', 'asc')->get();

    return view('peliculas.index', compact('clasificaciones', 'generos', 'paises'));
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