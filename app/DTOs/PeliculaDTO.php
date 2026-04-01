<?php
namespace App\DTOs;
use App\Models\Pelicula;
use Carbon\Carbon;

class PeliculaDTO
{
    public static function fromModel(Pelicula $pelicula): array
    {
        return [
            'id_pelicula' => $pelicula->id_pelicula,
            'titulo' => $pelicula->titulo,
            'sinopsis' => $pelicula->sinopsis,
            'clasificacion' => $pelicula->clasificacion ? $pelicula->clasificacion->codigo : 'N/A',
            'id_clasificacion' => $pelicula->id_clasificacion,
            'duracion_min' => $pelicula->duracion_min,
            'estado' => $pelicula->estado,
            'poster_url' => $pelicula->poster_url,
            'trailer_url' => $pelicula->trailer_url,
            'fecha_estreno' => $pelicula->fecha_estreno ? Carbon::parse($pelicula->fecha_estreno)->format('Y-m-d') : '',
            'activo' => $pelicula->activo,
        ];
    }
}