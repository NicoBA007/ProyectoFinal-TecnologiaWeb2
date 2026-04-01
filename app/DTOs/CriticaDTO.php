<?php
namespace App\DTOs;

use App\Models\Critica;
use Carbon\Carbon;

class CriticaDTO
{
    public static function fromModel(Critica $critica): array
    {
        // Formateamos la fecha si existe, si no, devolvemos un texto seguro
        $fecha = $critica->fecha_publicacion 
            ? Carbon::parse($critica->fecha_publicacion)->format('d/m/Y H:i') 
            : 'Sin fecha';

        // Rescatamos los nombres usando las funciones de tu modelo (usuario() y pelicula())
        $nombreUsuario = $critica->usuario ? trim($critica->usuario->nombres . ' ' . $critica->usuario->apellido_paterno) : 'Usuario Eliminado';
        $nombrePelicula = $critica->pelicula ? $critica->pelicula->titulo : 'Película Desconocida'; // Asumimos que la columna en Pelicula se llama 'titulo'

        return [
            'id_critica' => $critica->id_critica,
            'usuario' => $nombreUsuario,
            'pelicula' => $nombrePelicula,
            'puntuacion' => $critica->puntuacion,
            'comentario' => $critica->comentario,
            'fecha_publicacion' => $fecha,
        ];
    }
}