<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\DTOs\PersonaDTO;
use App\Http\Requests\StorePersonaAjaxRequest;
use App\Http\Requests\UpdatePersonaAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $datos = Persona::orderBy('nombre_completo', 'asc')->get();
                $dtos = $datos->map(fn($item) => PersonaDTO::fromModel($item));
                return response()->json(['success' => true, 'data' => $dtos]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error al cargar datos.'], 500);
            }
        }
        return view('personas.index');
    }

    public function store(StorePersonaAjaxRequest $request): JsonResponse
    {
        try {
            $persona = Persona::create([
                'nombre_completo' => $request->nombre_completo,
                'foto_url' => $request->foto_url,
                'activo' => true
            ]);
            return response()->json(['success' => true, 'message' => 'Creado.', 'data' => PersonaDTO::fromModel($persona)], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar.'], 500);
        }
    }

    public function update(UpdatePersonaAjaxRequest $request, string $id): JsonResponse
    {
        try {
            $persona = Persona::findOrFail($id);
            $persona->update([
                'nombre_completo' => $request->nombre_completo,
                'foto_url' => $request->foto_url
            ]);
            return response()->json(['success' => true, 'message' => 'Actualizado.', 'data' => PersonaDTO::fromModel($persona)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            Persona::findOrFail($id)->update(['activo' => false]);
            return response()->json(['success' => true, 'message' => 'Desactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al desactivar.'], 500);
        }
    }

    public function reactivar(string $id): JsonResponse
    {
        try {
            Persona::findOrFail($id)->update(['activo' => true]);
            return response()->json(['success' => true, 'message' => 'Reactivado.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al reactivar.'], 500);
        }
    }
}