<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idArticulo'); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->longText('contenido')->nullable();
            $table->string('imagenUrl')->nullable();
            $table->string('imagenAlt')->nullable();
            $table->string('categoria')->nullable(); // ejemplo: 'Fútbol', 'Política Local'
            $table->date('fechaPublicacion')->nullable();

            // Definición de la columna para la clave foránea
            $table->unsignedBigInteger('idSeccion'); // Tipo debe coincidir con la PK de seccions
            // $table->unsignedBigInteger('idUsuario')->nullable(); // Para la autoría, lo añadiremos después

            $table->timestamps();

            // Definición de la clave foránea
            // Asegúrate que la tabla 'seccions' y su columna 'idSeccion' existan
            // y que 'idSeccion' en 'seccions' sea una clave primaria o única.
            $table->foreign('idSeccion')
                  ->references('idSeccion')
                  ->on('seccions') // Nombre de la tabla referenciada
                  ->onDelete('cascade'); // Acción al eliminar una sección (ej: borrar artículos)
                  // ->onDelete('set null'); // Otra opción si idSeccion puede ser nullable

            // Si añadimos autoría:
            // $table->foreign('idUsuario')
            //       ->references('idUsuario')->on('usuarios')
            //       ->onDelete('set null'); // o 'cascade' si quieres borrar los artículos del usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
