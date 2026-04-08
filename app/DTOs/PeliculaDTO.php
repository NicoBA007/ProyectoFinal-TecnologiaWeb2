<?php

namespace App\DTOs;

use App\Models\Pelicula;
use Carbon\Carbon;

class PeliculaDTO
{
    public static function fromModel(Pelicula $pelicula): array
    {
        /**
         * IMPORTANTE:
         * Si en el controlador usaste: ->withAvg('criticas as rating', 'puntuacion')
         * La propiedad se llama $pelicula->rating.
         * Si no usaste alias, se llamaría $pelicula->criticas_avg_puntuacion.
         * Usamos ?? para soportar ambos casos y evitar el 0 cuando no hay críticas.
         */
        $promedio = $pelicula->rating ?? $pelicula->criticas_avg_puntuacion ?? 0;

        return [
            'id_pelicula'          => $pelicula->id_pelicula,
            'titulo'               => $pelicula->titulo,
            'sinopsis'             => $pelicula->sinopsis,
            'clasificacion_codigo' => $pelicula->clasificacion ? $pelicula->clasificacion->codigo : 'N/A',
            'id_clasificacion'     => $pelicula->id_clasificacion,
            'duracion_min'         => $pelicula->duracion_min,
            'estado'               => $pelicula->estado,
            'poster_url'           => $pelicula->poster_url,
            'trailer_url'          => $pelicula->trailer_url,
            'fecha_estreno'        => $pelicula->fecha_estreno ? Carbon::parse($pelicula->fecha_estreno)->format('Y-m-d') : '',
            'anio'                 => $pelicula->fecha_estreno ? Carbon::parse($pelicula->fecha_estreno)->year : 'N/A',

            // Forzamos que sea un float con 1 decimal para el JS
            'rating'               => (float)number_format((float)$promedio, 1, '.', ''),

            'activo'               => $pelicula->activo,

            'generos' => $pelicula->generos->map(fn($g) => [
                'id_genero' => $g->id_genero,
                'nombre'    => $g->nombre
            ]),
            'paises' => $pelicula->paises->map(fn($p) => [
                'id_pais_origen' => $p->id_pais_origen,
                'nombre' => $p->nombre,
            ]),
            'reparto'       => $pelicula->personas->map(fn($per) => PersonaDTO::fromModel($per)),
            'total_reparto' => $pelicula->personas->count(),
        ];
    }
}
