<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importante para la autenticación
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- AÑADIR

class Usuario extends Authenticatable // Asegúrate que extienda Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; // Ya lo tienes, está bien
    protected $primaryKey = 'idUsuario'; // Ya lo tienes, está bien

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role', // <-- AÑADIDO role

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
    protected function casts(): array // Sintaxis para Laravel 9+
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Para Laravel < 9, usarías:
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Define la relación "uno a muchos" con el modelo Articulo.
     * Indica que un usuario puede tener muchos artículos.
     */
    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class, 'idUsuario', 'idUsuario');
    }
}
