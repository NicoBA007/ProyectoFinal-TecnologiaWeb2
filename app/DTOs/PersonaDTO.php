<?php

namespace App\DTOs;

use App\Models\Persona;

class PersonaDTO
{
    public static function fromModel(Persona $persona): array
    {
        return [
            'id_persona'      => $persona->id_persona,
            'nombre_completo' => $persona->nombre_completo,
            'foto_url'        => $persona->foto_url,
            'activo'          => $persona->activo,

            // Extraemos los datos del pivote (tabla pelicula_personal)
            'rol'       => $persona->pivot ? $persona->pivot->rol_en_pelicula : 'No asignado',
            'personaje' => $persona->pivot ? $persona->pivot->papel_personaje : 'N/A',
        ];
    }
}
