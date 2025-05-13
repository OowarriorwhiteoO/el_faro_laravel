<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- AÑADIR

class Articulo extends Model
{
    use HasFactory;

    protected $primaryKey = 'idArticulo';

    protected $fillable = [
        'titulo',
        'descripcion',
        'contenido',
        'imagenUrl',
        'imagenAlt',
        'categoria',
        'fechaPublicacion',
        'idSeccion',
        'idUsuario', // <-- AÑADIR idUsuario a fillable
    ];

    /**
     * Obtiene la sección a la que pertenece el artículo.
     */
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'idSeccion', 'idSeccion');
    }

    /**
     * Obtiene el usuario (autor) que creó el artículo.
     */
    public function autor(): BelongsTo // O puedes llamarlo 'user' o 'usuario'
    {
        // Asume que tu modelo de Usuario se llama 'Usuario' y su PK es 'idUsuario'
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }

    // Si quieres que el título se guarde siempre en mayúsculas (Mutador):
    // protected function titulo(): Attribute // Requiere PHP 8+
    // {
    //     return Attribute::make(
    //         set: fn ($value) => strtoupper($value),
    //     );
    // }
    // O para versiones anteriores de PHP / Laravel < 9:
    // public function setTituloAttribute($value)
    // {
    //     $this->attributes['titulo'] = strtoupper($value);
    // }

}
