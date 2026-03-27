<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'nombres',
    'apellido_paterno',
    'apellido_materno',
    'email',
    'password',
    'rol',
    'activo'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Apuntamos a tu nueva tabla en singular
    protected $table = 'usuario';

    // 2. Definimos tu llave primaria personalizada
    protected $primaryKey = 'id_usuario';

    // 3. Desactivamos los timestamps automáticos de Laravel
    public $timestamps = false;

    /**
     * Define cómo se deben transformar los datos al leer/guardar
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    // --- RELACIONES ELOQUENT ---

    /**
     * Un usuario puede escribir muchas críticas.
     */
    public function criticas()
    {
        return $this->hasMany(Critica::class, 'id_usuario', 'id_usuario');
    }
}