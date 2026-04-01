<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\DTOs\PaisDTO;
use App\Http\Requests\StorePaisAjaxRequest;
use App\Http\Requests\UpdatePaisAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaisController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $datos = Pais::orderBy('nombre', 'asc')->get();
                $dtos = $datos->map(fn($item) => PaisDTO::fromModel($item));
                return response()->json(['success' => true, 'data' => $dtos]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al cargar datos.'], 500);
            }
        }
        return view('paises.index');
    }

    public function store(StorePaisAjaxRequest $request): JsonResponse
    {
        try {
            $pais = Pais::create(['nombre' => $request->nombre, 'activo' => true]);
            return response()->json(['success' => true, 'message' => 'Creado.', 'data' => PaisDTO::fromModel($pais)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar.'], 500);
        }
    }

    public function update(UpdatePaisAjaxRequest $request, string $id): JsonResponse
    {
        try {
            $pais = Pais::findOrFail($id);
            $pais->update(['nombre' => $request->nombre]);
            return response()->json(['success' => true, 'message' => 'Actualizado.', 'data' => PaisDTO::fromModel($pais)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            Pais::findOrFail($id)->update(['activo' => false]);
            return response()->json(['success' => true, 'message' => 'Desactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al desactivar.'], 500);
        }
    }

    public function reactivar(string $id): JsonResponse
    {
        try {
            Pais::findOrFail($id)->update(['activo' => true]);
            return response()->json(['success' => true, 'message' => 'Reactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al reactivar.'], 500);
        }
    }
}