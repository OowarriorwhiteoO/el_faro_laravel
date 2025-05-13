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
        Schema::table('articulos', function (Blueprint $table) {
            // Añadir la columna idUsuario después de idSeccion (o donde prefieras)
            // Puede ser nullable si permites artículos sin autor (ej. importados)
            // o si los artículos antiguos no tendrán autor asignado.
            // Si todos los artículos DEBEN tener un autor, no lo hagas nullable y ajusta seeders.
            $table->unsignedBigInteger('idUsuario')->nullable()->after('idSeccion');

            // Definir la clave foránea
            $table->foreign('idUsuario')
                  ->references('idUsuario')->on('usuarios') // Asume que tu PK en usuarios es 'idUsuario'
                  ->onDelete('set null'); // O 'cascade' si quieres borrar los artículos si el usuario se elimina
                                         // o 'restrict' para prevenir borrar usuarios con artículos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropForeign(['idUsuario']); // Elimina la clave foránea
            $table->dropColumn('idUsuario');    // Elimina la columna
        });
    }
};
