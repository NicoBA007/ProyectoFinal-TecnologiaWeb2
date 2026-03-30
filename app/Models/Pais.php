<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    // 1. Apuntamos a la tabla exacta
    protected $table = 'pais_origen';

    protected $primaryKey = 'id_pais_origen';

    // 3. Sin timestamps automáticos
    public $timestamps = false;

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
            'activo' => 'boolean',
        ];
    }

    // ==========================================
    // RELACIONES ELOQUENT
    // ==========================================

    /**
     * Relación N:M Inversa (Un país tiene MUCHAS películas grabadas ahí)
     */
    public function peliculas()
    {
        // belongsToMany(ModeloDestino, TablaIntermedia, LlaveLocalEnPivote, LlaveForaneaEnPivote)
        return $this->belongsToMany(
            Pelicula::class,
            'pelicula_pais_origen', 
            'id_pais_origen', 
            'id_pelicula'          
        );
    }
}