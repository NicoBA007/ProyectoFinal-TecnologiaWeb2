<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UsuarioDTO;
use App\Http\Requests\StoreUsuarioAjaxRequest;
use App\Http\Requests\UpdateUsuarioAjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
  // Devuelve la vista HTML o el JSON con la lista de usuarios (Punto 3.8.2 y DTO)
  public function index(Request $request)
  {
    if ($request->wantsJson()) {
      try {
        $usuarios = User::orderBy('id_usuario', 'desc')->get();
        // Pasamos la data por el DTO por seguridad antes de enviarla
        $dtos = $usuarios->map(fn($u) => UsuarioDTO::fromModel($u));

        return response()->json(['success' => true, 'data' => $dtos]);
      } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error al cargar usuarios.'], 500);
      }
    }

    return view('usuarios.index');
  }

  // Guarda un nuevo usuario validado y devuelve JSON (Puntos 3.8.3, 3.9.2, 3.9.3)
  public function store(StoreUsuarioAjaxRequest $request): JsonResponse
  {
    try {
      $datos = $request->validated();
      $datos['password'] = Hash::make($datos['password']);
      $datos['activo'] = true;

      $usuario = User::create($datos);

      return response()->json([
        'success' => true,
        'message' => 'Usuario creado exitosamente.',
        'data' => UsuarioDTO::fromModel($usuario)
      ], 201);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error del servidor al guardar.'], 500);
    }
  }

  // Actualiza un usuario y devuelve JSON
  public function update(UpdateUsuarioAjaxRequest $request, string $id): JsonResponse
  {
    try {
      $usuario = User::findOrFail($id);
      $datos = $request->validated();

      if ($request->filled('password')) {
        $datos['password'] = Hash::make($datos['password']);
      } else {
        unset($datos['password']);
      }

      $usuario->update($datos);

      return response()->json([
        'success' => true,
        'message' => 'Usuario actualizado.',
        'data' => UsuarioDTO::fromModel($usuario)
      ]);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error del servidor al actualizar.'], 500);
    }
  }

  // Desactiva un usuario (Soft Delete lógico) y devuelve JSON
  public function destroy(string $id): JsonResponse
  {
    try {
      $usuario = User::findOrFail($id);
      $usuario->update(['activo' => false]);

      return response()->json(['success' => true, 'message' => 'Usuario desactivado correctamente.']);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error del servidor al eliminar.'], 500);
    }
  }
  // Reactiva un usuario y devuelve JSON
  public function reactivar(string $id): JsonResponse
  {
    try {
      $usuario = User::findOrFail($id);
      $usuario->update(['activo' => true]);

      return response()->json(['success' => true, 'message' => 'Usuario reactivado correctamente.']);

    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => 'Error del servidor al reactivar.'], 500);
    }
  }
}