<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioAjaxRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true; // Permitimos la petición, la seguridad de rol la pondremos en las rutas
  }

  public function rules(): array
  {
    return [
      'nombres' => 'required|string|max:100',
      'apellido_paterno' => 'required|string|max:100',
      'apellido_materno' => 'nullable|string|max:100',
      'email' => 'required|email|unique:usuario,email',
      'password' => 'required|string|min:8|confirmed',
      'rol' => 'required|in:admin,cliente'
    ];
  }
}