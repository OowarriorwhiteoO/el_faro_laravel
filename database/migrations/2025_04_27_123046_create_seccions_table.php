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
        Schema::create('seccions', function (Blueprint $table) {
            $table->id('idSeccion'); // Esto crea un BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nombreSeccion')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
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
