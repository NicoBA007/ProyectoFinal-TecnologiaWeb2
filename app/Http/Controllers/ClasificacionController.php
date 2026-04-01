<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\DTOs\ClasificacionDTO;
use App\Http\Requests\StoreClasificacionAjaxRequest;
use App\Http\Requests\UpdateClasificacionAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClasificacionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $datos = Clasificacion::orderBy('codigo', 'asc')->get();
                $dtos = $datos->map(fn($item) => ClasificacionDTO::fromModel($item));
                return response()->json(['success' => true, 'data' => $dtos]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al cargar datos.'], 500);
            }
        }
        return view('clasificaciones.index');
    }

    public function store(StoreClasificacionAjaxRequest $request): JsonResponse
    {
        try {
            $clasificacion = Clasificacion::create([
                'codigo' => $request->codigo, 
                'descripcion' => $request->descripcion, 
                'activo' => true
            ]);
            return response()->json(['success' => true, 'message' => 'Creado.', 'data' => ClasificacionDTO::fromModel($clasificacion)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar.'], 500);
        }
    }

    public function update(UpdateClasificacionAjaxRequest $request, string $id): JsonResponse
    {
        try {
            $clasificacion = Clasificacion::findOrFail($id);
            $clasificacion->update([
                'codigo' => $request->codigo, 
                'descripcion' => $request->descripcion
            ]);
            return response()->json(['success' => true, 'message' => 'Actualizado.', 'data' => ClasificacionDTO::fromModel($clasificacion)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            Clasificacion::findOrFail($id)->update(['activo' => false]);
            return response()->json(['success' => true, 'message' => 'Desactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al desactivar.'], 500);
        }
    }

    public function reactivar(string $id): JsonResponse
    {
        try {
            Clasificacion::findOrFail($id)->update(['activo' => true]);
            return response()->json(['success' => true, 'message' => 'Reactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al reactivar.'], 500);
        }
    }
}