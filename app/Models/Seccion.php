<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importar HasMany

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones'; // Especifica el nombre de la tabla
    // Especificar clave primaria si no es 'id'
    protected $primaryKey = 'idSeccion';

    // Permitir asignación masiva
    protected $fillable = [
        'nombreSeccion',
        'slug',
    ];

    /**
     * Define la relación "tiene muchos" con el modelo Articulo.
     * Una Seccion tiene muchos Articulos.
     */
    public function articulos(): HasMany
    {
        // El segundo argumento es la clave foránea en la tabla relacionada (articulos)
        // El tercer argumento es la clave primaria en esta tabla (secciones)
        return $this->hasMany(Articulo::class, 'idSeccion', 'idSeccion');
    }
}
