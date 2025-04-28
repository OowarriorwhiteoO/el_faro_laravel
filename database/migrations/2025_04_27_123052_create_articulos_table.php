<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     * Crea la tabla 'articulos'.
     */
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idArticulo'); // Columna ID autoincremental, clave primaria
            $table->string('titulo'); // Título del artículo
            $table->text('descripcion')->nullable(); // Descripción corta (TEXT permite más caracteres)
            $table->longText('contenido')->nullable(); // Contenido completo del artículo (LONGTEXT)
            $table->string('imagenUrl')->nullable(); // Nombre del archivo de imagen (o URL completa)
            $table->string('imagenAlt')->nullable(); // Texto alternativo para la imagen
            $table->string('categoria')->nullable(); // Categoría específica dentro de la sección
            $table->date('fechaPublicacion')->nullable(); // Fecha de publicación (solo fecha)

            // Clave foránea para la relación con la tabla 'secciones'
            $table->unsignedBigInteger('idSeccion'); // Debe ser del mismo tipo que idSeccion en 'secciones'
            $table->foreign('idSeccion')
                  ->references('idSeccion')->on('secciones')
                  ->onDelete('cascade'); // Opcional: si se borra una sección, se borran sus artículos

            // Clave foránea para el autor (relación con usuarios - opcional por ahora)
            // $table->unsignedBigInteger('idUsuarioAutor')->nullable();
            // $table->foreign('idUsuarioAutor')
            //       ->references('idUsuario')->on('usuarios')
            //       ->onDelete('set null'); // Opcional: si se borra el autor, el artículo queda sin autor

            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Revierte las migraciones.
     * Elimina la tabla 'articulos'.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
