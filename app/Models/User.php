<?php

namespace App\Models;

// Importaciones de clases y traits necesarios.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Clase base para modelos autenticables.
use Illuminate\Notifications\Notifiable; // Trait para funcionalidades de notificación.

/**
 * Modelo Eloquent que representa la tabla de usuarios.
 * Incluye funcionalidades de autenticación de Laravel.
 */
// Asegúrate de que el nombre de la clase coincida con tu archivo (User o Usuario).
// Extiende la clase base de usuario autenticable de Laravel.
class User extends Authenticatable
{
    // Incluye traits para factory (creación de datos de prueba) y notificaciones.
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar de forma masiva.
     * Define qué campos se pueden rellenar usando métodos como create() o update().
     * (Asegúrate que 'name' coincida con tu columna en BD y el campo en RegisterController, podría ser 'nombre').
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse al serializar el modelo (ej., al convertir a JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Token utilizado por la funcionalidad "Recordarme".
    ];

    /**
     * Define las conversiones de tipo para los atributos del modelo.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // Define cómo deben ser tratados ciertos atributos.
        return [
            'email_verified_at' => 'datetime', // Convierte a objeto Carbon para manejo de fechas.
            'password' => 'hashed', // Asegura que el atributo password se hashee automáticamente.
        ];
    }
}
