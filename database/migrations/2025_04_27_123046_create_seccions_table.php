<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     * Crea la tabla 'secciones'.
     */
    public function up(): void
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id('idSeccion'); // Columna ID autoincremental, clave primaria
            $table->string('nombreSeccion')->unique(); // Nombre de la sección (ej: Nacional), único
            $table->string('slug')->unique(); // Versión 'amigable para URL' del nombre (ej: nacional), único
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Revierte las migraciones.
     * Elimina la tabla 'secciones'.
     */
    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};
