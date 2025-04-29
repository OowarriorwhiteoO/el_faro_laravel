<?php

namespace App\Models;

// Importaciones de clases Eloquent necesarias.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para representar la tabla 'articulos'.
 */
class Articulo extends Model
{
    // Habilita el uso de factories para este modelo.
    use HasFactory;

    /**
     * La clave primaria asociada con la tabla.
     * Se especifica porque no sigue la convención de Laravel ('id').
     *
     * @var string
     */
    protected $primaryKey = 'idArticulo';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     * Protege contra vulnerabilidades de asignación masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'contenido',
        'imagenUrl',
        'imagenAlt',
        'categoria',
        'fechaPublicacion',
        'idSeccion',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Facilita el manejo de fechas como objetos Carbon.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fechaPublicacion' => 'date', // Convierte 'fechaPublicacion' a objeto Carbon/Date.
    ];

    /**
     * Define la relación inversa "uno a muchos" con el modelo Seccion.
     * Indica que un artículo pertenece a una sección.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seccion(): BelongsTo
    {
        // Especifica el modelo relacionado (Seccion), la clave foránea en esta tabla ('idSeccion'),
        // y la clave primaria en la tabla relacionada ('idSeccion').
        return $this->belongsTo(Seccion::class, 'idSeccion', 'idSeccion');
    }
}
