<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    // 1. Apuntamos al nombre exacto de tu tabla en MySQL
    protected $table = 'pais_origen'; 

    // 2. Le indicamos cuál es la llave primaria
    protected $primaryKey = 'id_pais_origen';

    // 3. Apagamos los timestamps si tu tabla no tiene created_at / updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'activo'
    ];
}