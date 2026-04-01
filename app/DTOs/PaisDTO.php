<?php
namespace App\DTOs;
use App\Models\Pais;

class PaisDTO
{
  public static function fromModel(Pais $pais): array
  {
    return [
      // Extraemos el id_pais_origen real de tu BD, pero lo mandamos como id_pais para que el JS no se rompa
      'id_pais' => $pais->id_pais_origen,
      'nombre' => $pais->nombre,
      'activo' => $pais->activo,
    ];
  }
}