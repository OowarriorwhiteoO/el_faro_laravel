<?php

namespace App\Models;

// Importaciones de clases y traits necesarios.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Clase base para modelos autenticables.
use Illuminate\Notifications\Notifiable; // Trait para funcionalidades de notificación.

/**
 * Modelo Eloquent que representa la tabla 'usuarios'.
 * Incluye funcionalidades de autenticación de Laravel.
 */
// La clase Usuario extiende la clase base de usuario autenticable de Laravel.
class Usuario extends Authenticatable
{
    // Incluye traits para factory (creación de datos de prueba) y notificaciones.
    use HasFactory, Notifiable;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'usuarios'; // Especifica el nombre de la tabla en la base de datos.

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'idUsuario'; // Define 'idUsuario' como la clave primaria.

    /**
     * Los atributos que se pueden asignar de forma masiva.
     * Define qué campos se pueden rellenar usando métodos como create() o update().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre', // Campo para el nombre del usuario.
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
