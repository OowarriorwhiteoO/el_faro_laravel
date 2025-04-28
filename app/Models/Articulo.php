<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articulo extends Model
{
    use HasFactory;

    protected $primaryKey = 'idArticulo';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Asegúrate de que todos los campos que asignas en ArticuloController@store
     * estén listados aquí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'contenido',        // Asegúrate que esté (lo usamos en el controlador)
        'imagenUrl',      // ¡Importante que esté!
        'imagenAlt',      // ¡Importante que esté!
        'categoria',
        'fechaPublicacion',
        'idSeccion',
        // 'idUsuarioAutor', // Si se usa después
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fechaPublicacion' => 'date',
    ];

    /**
     * Define la relación "pertenece a" con el modelo Seccion.
     */
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'idSeccion', 'idSeccion');
    }

    /**
     * Opcional: Define la relación "pertenece a" con el modelo Usuario (autor).
     */
    // public function autor(): BelongsTo
    // {
    //     return $this->belongsTo(Usuario::class, 'idUsuarioAutor', 'idUsuario'); // O User::class si usas el modelo estándar
    // }
}
