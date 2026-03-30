<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // 1. Nombre exacto de la tabla en la base de datos
    protected $table = 'persona';

    // 2. Llave primaria personalizada
    protected $primaryKey = 'id_persona';

    // 3. Desactivamos los timestamps (ya que no los pusiste en el script SQL)
    public $timestamps = false;

    // 4. Campos que se pueden llenar masivamente desde un formulario
    protected $fillable = [
        'nombre_completo',
        'foto_url',
        'activo'
    ];

    /**
     * Define cómo se deben transformar los datos al leer/guardar
     */
    protected function casts(): array
    {
        return [
            'activo' => 'boolean', // Transforma el 1/0 de MySQL a true/false en PHP
        ];
    }

    // --- RELACIONES ELOQUENT ---

    /**
     * Relación Muchos a Muchos (N:M): 
     * Una persona participa en muchas películas.
     */
    public function peliculas()
    {
        // belongsToMany(ModeloDestino, TablaIntermedia, LlaveLocal, LlaveForanea)
        return $this->belongsToMany(Pelicula::class, 'pelicula_personal', 'id_persona', 'id_pelicula')
            // withPivot trae también los datos adicionales de la relación
            ->withPivot('rol_en_pelicula', 'papel_personaje');
    }
}