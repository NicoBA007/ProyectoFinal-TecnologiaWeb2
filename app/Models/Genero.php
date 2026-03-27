<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    // 1. Nombre exacto de la tabla
    protected $table = 'genero';

    // 2. Llave primaria personalizada
    protected $primaryKey = 'id_genero';

    // 3. Desactivamos los timestamps automáticos
    public $timestamps = false;

    // 4. Campos permitidos para inserción
    protected $fillable = [
        'nombre',
        'activo'
    ];

    /**
     * 5. Casteos automáticos
     */
    protected function casts(): array
    {
        return [
            'activo' => 'boolean', // Mapea el 1/0 a true/false
        ];
    }

    // ==========================================
    // RELACIONES ELOQUENT
    // ==========================================

    /**
     * Relación N:M Inversa (Un género abarca MUCHAS películas)
     */
    public function peliculas()
    {
        // belongsToMany(ModeloDestino, TablaIntermedia, ForaneaLocal, ForaneaDestino)
        return $this->belongsToMany(Pelicula::class, 'pelicula_genero', 'id_genero', 'id_pelicula');
    }
}