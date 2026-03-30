<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Critica extends Model
{
    // 1. Nombre exacto de la tabla
    protected $table = 'critica';

    // 2. Llave primaria personalizada
    protected $primaryKey = 'id_critica';

    // 3. Desactivamos los timestamps automáticos (usamos nuestro propio fecha_publicacion)
    public $timestamps = false;

    // 4. Campos que permitimos llenar masivamente
    protected $fillable = [
        'id_usuario',
        'id_pelicula',
        'puntuacion',
        'comentario',
    ];

    /**
     * 5. Casteos: Laravel convierte los datos automáticamente
     */
    protected function casts(): array
    {
        return [
            'puntuacion' => 'integer',
            'fecha_publicacion' => 'datetime', // Lo tratamos como un objeto de fecha y hora
        ];
    }

    // ==========================================
    // RELACIONES ELOQUENT
    // ==========================================

    /**
     * Relación 1:N Inversa (Una crítica fue escrita por UN usuario)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación 1:N Inversa (Una crítica pertenece a UNA película)
     */
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula', 'id_pelicula');
    }
}