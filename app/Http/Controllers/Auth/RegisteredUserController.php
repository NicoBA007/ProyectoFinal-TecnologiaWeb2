<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws ValidationException
   */
  public function store(Request $request): RedirectResponse
  {
    // 1. Validaciones
    $request->validate([
      'nombres' => ['required', 'string', 'max:100'],
      'apellido_paterno' => ['required', 'string', 'max:100'],
      'apellido_materno' => ['nullable', 'string', 'max:100'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // 2. Creación del usuario (nace como 'cliente' por defecto gracias a la BD)
    $user = User::create([
      'nombres' => $request->nombres,
      'apellido_paterno' => $request->apellido_paterno,
      'apellido_materno' => $request->apellido_materno,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect()->route('cartelera.index');
  }
}
