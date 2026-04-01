<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioAjaxRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    // Rescatamos el ID del usuario que viene en la URL para ignorarlo en la regla "unique"
    $usuarioId = $this->route('usuario');

    return [
      'nombres' => 'required|string|max:100',
      'apellido_paterno' => 'required|string|max:100',
      'apellido_materno' => 'nullable|string|max:100',
      'email' => 'required|email|unique:usuario,email,' . $usuarioId . ',id_usuario',
      'rol' => 'required|in:admin,cliente',
      // La contraseña al actualizar es opcional, pero si la envían, debe validarse
      'password' => 'nullable|string|min:8|confirmed'
    ];
  }
}