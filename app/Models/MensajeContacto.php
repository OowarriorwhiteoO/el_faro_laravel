<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para representar la tabla 'mensajes_contacto'.
 */
class MensajeContacto extends Model
{
    use HasFactory; // Habilita el uso de factories.

    /**
     * El nombre de la tabla asociada con el modelo.
     * Es buena práctica especificarlo explícitamente.
     *
     * @var string
     */
    protected $table = 'mensajes_contacto';

    /**
     * La clave primaria asociada con la tabla.
     * Se asume 'id' por defecto si no se especifica.
     *
     * @var string
     */
    // protected $primaryKey = 'id'; // No es necesario si usas 'id' estándar.

    /**
     * Los atributos que se pueden asignar de forma masiva.
     * Necesario para usar el método create().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
    ];

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * Laravel los maneja automáticamente si la tabla los tiene.
     *
     * @var bool
     */
    // public $timestamps = true; // Es true por defecto.
}
