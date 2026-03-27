<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    // 1. Nombre exacto de la tabla
    protected $table = 'clasificacion';

    // 2. Llave primaria 
    protected $primaryKey = 'id_clasificacion';

    // 3. Desactivamos los timestamps automáticos de Laravel
    public $timestamps = false;

    // 4. Campos que permitimos llenar masivamente
    protected $fillable = [
        'codigo',
        'descripcion',
        'activo'
    ];

    /**
     * 5. Casteos: Laravel convierte el 1/0 a true/false
     */
    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    // ==========================================
    // RELACIONES ELOQUENT
    // ==========================================

    /**
     * Relación 1:N (Una clasificación tiene MUCHAS películas asignadas)
     */
    public function peliculas()
    {
        // hasMany(ModeloDestino, LlaveForaneaDestino, LlaveLocal)
        return $this->hasMany(Pelicula::class, 'id_clasificacion', 'id_clasificacion');
    }
}