<?php

namespace App\DTOs;

use App\Models\User;
use Carbon\Carbon; // Importamos la librería de fechas de Laravel

class UsuarioDTO
{
    public static function fromModel(User $usuario): array
    {
        // Convertimos la fecha de forma segura sin importar cómo venga de la BD
        $fecha = null;
        if ($usuario->fecha_registro) {
            $fecha = Carbon::parse($usuario->fecha_registro)->format('d/m/Y H:i');
        }

        return [
            'id_usuario' => $usuario->id_usuario,
            'nombres' => $usuario->nombres,
            'apellido_paterno' => $usuario->apellido_paterno,
            'apellido_materno' => $usuario->apellido_materno,
            'nombre_completo' => trim("{$usuario->nombres} {$usuario->apellido_paterno} {$usuario->apellido_materno}"),
            'email' => $usuario->email,
            'rol' => $usuario->rol,
            'activo' => $usuario->activo,
            'fecha_registro' => $fecha,
        ];
    }
}