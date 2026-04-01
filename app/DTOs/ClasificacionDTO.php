<?php
namespace App\DTOs;
use App\Models\Clasificacion;

class ClasificacionDTO
{
    public static function fromModel(Clasificacion $clasificacion): array
    {
        return [
            'id_clasificacion' => $clasificacion->id_clasificacion,
            'codigo' => $clasificacion->codigo,
            'descripcion' => $clasificacion->descripcion,
            'activo' => $clasificacion->activo,
        ];
    }
}