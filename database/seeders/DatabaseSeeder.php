<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Importa las clases de los seeders específicos que se ejecutarán.
use Database\Seeders\SeccionSeeder;
use Database\Seeders\ArticuloSeeder;

/**
 * Seeder principal que orquesta la ejecución de otros seeders.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders definidos para poblar la base de datos.
     * El orden de ejecución es importante si hay dependencias (ej: secciones antes que artículos).
     */
    public function run(): void
    {
        // Llama al método run() de los seeders especificados en el array.
        $this->call([
            SeccionSeeder::class, // Ejecuta el seeder para poblar la tabla 'secciones'.
            ArticuloSeeder::class, // Ejecuta el seeder para poblar la tabla 'articulos'.
        ]);

        // Muestra un mensaje informativo en la consola al finalizar.
        $this->command->info('¡Todos los seeders principales han sido ejecutados!');
    }
}
