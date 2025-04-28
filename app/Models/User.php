<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importar HasMany

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especificar clave primaria si la cambiaste en la migración
    // protected $primaryKey = 'idUsuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Cambiado a 'name'
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define la relación "tiene muchos" con el modelo Articulo.
     * Un Usuario (autor) puede tener muchos Articulos.
     */
    // public function articulos(): HasMany
    // {
          // Asume que la clave foránea en 'articulos' es 'idUsuarioAutor'
    //     return $this->hasMany(Articulo::class, 'idUsuarioAutor', 'idUsuario'); // Ajusta 'idUsuario' si usas 'id'
    // }
}
