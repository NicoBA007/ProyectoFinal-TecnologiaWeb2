<?php
namespace App\DTOs;
use App\Models\Persona;

class PersonaDTO
{
    public static function fromModel(Persona $persona): array
    {
        return [
            'id_persona' => $persona->id_persona,
            'nombre_completo' => $persona->nombre_completo,
            'foto_url' => $persona->foto_url,
            'activo' => $persona->activo,
        ];
    }
}