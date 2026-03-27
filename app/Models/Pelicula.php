<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    // 1. Configuración básica de la tabla
    protected $table = 'pelicula';
    protected $primaryKey = 'id_pelicula';
    public $timestamps = false;

    // 2. Campos que podemos llenar al registrar una película nueva
    protected $fillable = [
        'titulo',
        'sinopsis',
        'id_clasificacion',
        'duracion_min',
        'estado',
        'poster_url',
        'trailer_url',
        'fecha_estreno',
        'activo'
    ];

    /**
     * 3. Casteos: Laravel convierte los datos automáticamente al formato correcto
     */
    protected function casts(): array
    {
        return [
            'fecha_estreno' => 'date',   // Lo trata como un objeto fecha (Carbon)
            'activo' => 'boolean',       // Convierte 1/0 a true/false
        ];
    }

    // ==========================================
    // RELACIONES ELOQUENT (El verdadero poder)
    // ==========================================

    /**
     * Relación 1:N Inversa (Una película pertenece a UNA clasificación)
     */
    public function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class, 'id_clasificacion', 'id_clasificacion');
    }

    /**
     * Relación N:M (Una película tiene MUCHOS géneros)
     */
    public function generos()
    {
        // belongsToMany(Modelo, TablaIntermedia, ForaneaOrigen, ForaneaDestino)
        return $this->belongsToMany(Genero::class, 'pelicula_genero', 'id_pelicula', 'id_genero');
    }

    /**
     * Relación N:M (Una película se grabó en MUCHOS países)
     */
    public function paises()
    {
        return $this->belongsToMany(Pais::class, 'pelicula_pais', 'id_pelicula', 'id_pais');
    }

    /**
     * Relación N:M (Una película tiene MUCHAS personas: Actores, Directores...)
     */
    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'pelicula_personal', 'id_pelicula', 'id_persona')
            ->withPivot('rol_en_pelicula', 'papel_personaje'); // Traemos los datos extra de la tabla pivote
    }

    /**
     * Relación 1:N (Una película recibe MUCHAS críticas de los usuarios)
     */
    public function criticas()
    {
        return $this->hasMany(Critica::class, 'id_pelicula', 'id_pelicula');
    }
}