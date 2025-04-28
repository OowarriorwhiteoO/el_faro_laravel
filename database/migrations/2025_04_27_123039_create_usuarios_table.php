<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     * Crea la tabla 'usuarios'.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('idUsuario'); // Columna ID autoincremental, clave primaria (nombre personalizado)
            $table->string('nombre'); // Columna para el nombre del usuario (VARCHAR)
            $table->string('email')->unique(); // Columna para el email (VARCHAR), debe ser único
            $table->timestamp('email_verified_at')->nullable(); // Para verificación de email (opcional)
            $table->string('password'); // Columna para la contraseña (hasheada)
            $table->rememberToken(); // Columna para la función "Recordarme" (opcional)
            $table->timestamps(); // Crea automáticamente las columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Revierte las migraciones.
     * Elimina la tabla 'usuarios'.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
