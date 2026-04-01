<?php

namespace App\DTOs;
use App\Models\Genero;

class GeneroDTO
{
    public static function fromModel(Genero $genero): array
    {
        return [
            'id_genero' => $genero->id_genero,
            'nombre' => $genero->nombre,
            'activo' => $genero->activo,
        ];
    }
}