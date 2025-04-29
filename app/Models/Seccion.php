<?php

namespace App\Models;

// Importaciones de clases Eloquent.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Eloquent para representar la tabla 'secciones'.
 */
class Seccion extends Model
{
    // Habilita el uso de factories para este modelo.
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'secciones';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'idSeccion';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombreSeccion',
        'slug',
    ];

    /**
     * Define la relación "uno a muchos" con el modelo Articulo.
     * Indica que una sección puede tener muchos artículos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articulos(): HasMany
    {
        // Especifica el modelo relacionado (Articulo), la clave foránea en la tabla 'articulos' ('idSeccion'),
        // y la clave primaria en esta tabla ('secciones', 'idSeccion').
        return $this->hasMany(Articulo::class, 'idSeccion', 'idSeccion');
    }
}
