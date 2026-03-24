<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // 1. Conexión con tu tabla personalizada
    protected $table = 'usuarios';

    // 2. Tu llave primaria personalizada
    protected $primaryKey = 'id_usuario';

    // 3. ¡LA SOLUCIÓN! Apagamos las fechas para que MySQL maneje "fecha_registro"
    public $timestamps = false;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Borré 'email_verified_at' porque tu tabla SQL no tiene esa columna
            // y te daría otro error más adelante.
            'password' => 'hashed',
        ];
    }
}