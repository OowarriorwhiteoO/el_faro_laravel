<?php

namespace App\Models;

// Importaciones necesarias para la autenticación y funcionalidades Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importante: Extender esta clase
use Illuminate\Notifications\Notifiable;
// Si planeas añadir relaciones (ej: artículos escritos por el usuario), impórtalas aquí
// use Illuminate\Database\Eloquent\Relations\HasMany;

// La clase Usuario debe extender Authenticatable para funcionar con Auth::login()
class Usuario extends Authenticatable
{
    // Traits estándar de Laravel para funcionalidades útiles
    use HasFactory, Notifiable;

    /**
     * El nombre de la tabla asociada con el modelo.
     * Especificamos 'usuarios' porque no es el plural por defecto de 'Usuario' ('usuarios' vs 'usuario').
     * Laravel lo adivinaría correctamente en español, pero es bueno ser explícito.
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * La clave primaria asociada con la tabla.
     * Especificamos 'idUsuario' porque no es 'id'.
     * @var string
     */
    protected $primaryKey = 'idUsuario';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Es crucial definir esto para que Usuario::create() funcione en el RegisterController.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre', // Corresponde al campo 'nombre' del formulario/tabla
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse en las serializaciones (ej: al convertir a JSON).
     * Importante para no exponer la contraseña.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Campo usado por la función "Recordarme" de Laravel
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Campo para verificación de email
            'password' => 'hashed', // Asegura que la contraseña siempre se hashee al asignarla (buena práctica)
        ];
    }

     /**
      * Opcional: Define la relación "tiene muchos" con el modelo Articulo.
      * Un Usuario (autor) puede tener muchos Articulos.
      */
     // public function articulos(): HasMany
     // {
           // Asume que la clave foránea en 'articulos' es 'idUsuarioAutor'
           // y la clave primaria en 'usuarios' es 'idUsuario'
     //     return $this->hasMany(Articulo::class, 'idUsuarioAutor', 'idUsuario');
     // }
}
