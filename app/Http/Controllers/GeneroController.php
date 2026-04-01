<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\DTOs\GeneroDTO;
use App\Http\Requests\StoreGeneroAjaxRequest;
use App\Http\Requests\UpdateGeneroAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeneroController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $generos = Genero::orderBy('nombre', 'asc')->get();
                $dtos = $generos->map(fn($g) => GeneroDTO::fromModel($g));
                return response()->json(['success' => true, 'data' => $dtos]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al cargar géneros.'], 500);
            }
        }
        return view('generos.index');
    }

    public function store(StoreGeneroAjaxRequest $request): JsonResponse
    {
        try {
            $genero = Genero::create(['nombre' => $request->nombre, 'activo' => true]);
            return response()->json(['success' => true, 'message' => 'Género creado.', 'data' => GeneroDTO::fromModel($genero)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar.'], 500);
        }
    }

    public function update(UpdateGeneroAjaxRequest $request, string $id): JsonResponse
    {
        try {
            $genero = Genero::findOrFail($id);
            $genero->update(['nombre' => $request->nombre]);
            return response()->json(['success' => true, 'message' => 'Género actualizado.', 'data' => GeneroDTO::fromModel($genero)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            Genero::findOrFail($id)->update(['activo' => false]);
            return response()->json(['success' => true, 'message' => 'Género desactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al desactivar.'], 500);
        }
    }

    public function reactivar(string $id): JsonResponse
    {
        try {
            Genero::findOrFail($id)->update(['activo' => true]);
            return response()->json(['success' => true, 'message' => 'Género reactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al reactivar.'], 500);
        }
    }
}