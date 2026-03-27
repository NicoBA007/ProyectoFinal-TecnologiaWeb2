<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de edición del perfil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Llenamos el modelo con los datos validados (nombres, apellidos, email)
        $user = $request->user();
        $user->fill($request->validated());

        // 2. Si el email cambió, podríamos marcarlo como no verificado 
        // (Solo si decides implementar verificación de email después)
        if ($user->isDirty('email')) {
            // $user->email_verified_at = null; // Opcional según tu esquema SQL
        }

        // 3. Guardamos los cambios
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Desactiva la cuenta del usuario (Borrado Lógico).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validamos la contraseña actual por seguridad
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cerramos la sesión del usuario antes de desactivarlo
        Auth::logout();

        // CAMBIO CLAVE: Desactivación lógica para mantener historial de compras/críticas
        $user->activo = false;
        $user->save();

        // Invalidamos la sesión y regeneramos el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}