<?php

namespace App\Http\Controllers;

use App\Models\Critica;
use App\DTOs\CriticaDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CriticaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                // Usamos 'with' para traer los datos del usuario y película de golpe y no saturar la BD
                $datos = Critica::with(['usuario', 'pelicula'])->orderBy('fecha_publicacion', 'desc')->get();
                $dtos = $datos->map(fn($item) => CriticaDTO::fromModel($item));
                return response()->json(['success' => true, 'data' => $dtos]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al cargar críticas.'], 500);
            }
        }
        return view('criticas.index');
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            // Como no hay campo 'activo', borramos el registro físicamente de la base de datos
            Critica::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Crítica eliminada permanentemente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la crítica.'], 500);
        }
    }
}