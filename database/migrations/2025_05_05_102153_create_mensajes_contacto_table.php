<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones para crear la tabla 'mensajes_contacto'.
     */
    public function up(): void
    {
        // Define la estructura de la tabla 'mensajes_contacto'.
        Schema::create('mensajes_contacto', function (Blueprint $table) {
            // Define la clave primaria autoincremental estándar 'id'.
            $table->id();
            // Define la columna para el nombre del remitente.
            $table->string('nombre');
            // Define la columna para el email del remitente.
            $table->string('email');
            // Define la columna para el contenido del mensaje (tipo TEXT para mensajes más largos).
            $table->text('mensaje');
            // Define las columnas estándar 'created_at' y 'updated_at' para registro de tiempo.
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones, eliminando la tabla 'mensajes_contacto'.
     */
    public function down(): void
    {
        // Elimina la tabla 'mensajes_contacto' si existe.
        Schema::dropIfExists('mensajes_contacto');
    }
};
