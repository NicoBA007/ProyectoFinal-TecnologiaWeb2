<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    // 1. Apuntamos a la tabla exacta
    protected $table = 'pais';

    // 2. Definimos su llave primaria
    protected $primaryKey = 'id_pais';

    // 3. Sin timestamps automáticos
    public $timestamps = false;

    // 4. Campos permitidos para inserción masiva
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
        return $this->belongsToMany(Pelicula::class, 'pelicula_pais', 'id_pais', 'id_pelicula');
    }
}