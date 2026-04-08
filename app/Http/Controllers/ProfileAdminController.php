<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileAdminController extends Controller
{
    /**
     * Muestra el formulario de edición del perfil exclusivo para el Panel Administrativo.
     * Vinculado a la carpeta: resources/views/profileAdmin/edit.blade.php
     */
    public function edit(Request $request): View
    {
        return view('profileAdmin.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil del administrador (nombres, apellidos, email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Llenamos el modelo con los datos validados del Request
        $user->fill($request->validated());

        // Si el email cambia, podrías manejar una lógica de verificación aquí si fuera necesario
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // REDIRECCIÓN ESTRATÉGICA: Retornamos a la ruta de ADMIN para no perder el Sidebar
        return Redirect::route('profileAdmin.edit')->with('status', 'profile-updated');
    }

    /**
     * Ejecuta la "Baja Lógica" del administrador del sistema.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validamos la contraseña actual por seguridad antes de permitir la baja
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // 1. Cerramos la sesión activa
        Auth::logout();

        // 2. Aplicamos BAJA LÓGICA (Tu columna 'activo' de la tabla 1: Usuario)
        // No usamos ->delete() para mantener la integridad referencial en Críticas
        $user->activo = false;
        $user->save();

        // 3. Invalidamos la sesión en el servidor y regeneramos el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Redirigimos al inicio o al login del cine
        return Redirect::to('/')->with('message', 'Cuenta administrativa desactivada correctamente.');
    }
}