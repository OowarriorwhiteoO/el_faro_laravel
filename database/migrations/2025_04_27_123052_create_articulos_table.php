<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones para crear la tabla 'articulos'.
     */
    public function up(): void
    {
        // Define la estructura de la tabla 'articulos'.
        Schema::create('articulos', function (Blueprint $table) {
            // Define la clave primaria autoincremental 'idArticulo'.
            $table->id('idArticulo');
            // Define la columna para el título del artículo.
            $table->string('titulo');
            // Define la columna para la descripción corta (permite nulos).
            $table->text('descripcion')->nullable();
            // Define la columna para el contenido completo (permite nulos y texto largo).
            $table->longText('contenido')->nullable();
            // Define la columna para la URL o nombre de archivo de la imagen (permite nulos).
            $table->string('imagenUrl')->nullable();
            // Define la columna para el texto alternativo de la imagen (permite nulos).
            $table->string('imagenAlt')->nullable();
            // Define la columna para la categoría específica (permite nulos).
            $table->string('categoria')->nullable();
            // Define la columna para la fecha de publicación (permite nulos).
            $table->date('fechaPublicacion')->nullable();

            // Define la columna para la clave foránea 'idSeccion'.
            $table->unsignedBigInteger('idSeccion');
            // Establece la restricción de clave foránea hacia la tabla 'secciones'.
            $table->foreign('idSeccion')
                  ->references('idSeccion')->on('secciones')
                  // Define que si se elimina una sección, sus artículos asociados también se eliminarán.
                  ->onDelete('cascade');

            // Define las columnas estándar 'created_at' y 'updated_at'.
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones, eliminando la tabla 'articulos'.
     */
    public function down(): void
    {
        // Elimina la tabla 'articulos' si existe.
        Schema::dropIfExists('articulos');
    }
};
