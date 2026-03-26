<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    // Nombre de la tabla en tu SQL
    protected $table = 'actores';

    // Llave primaria
    protected $primaryKey = 'id_actor';

    // Campos que permitimos llenar (Mass Assignment)
    protected $fillable = ['nombre_completo', 'nacionalidad'];

    // Desactivamos timestamps si tu tabla no tiene created_at/updated_at
    public $timestamps = false;
}
