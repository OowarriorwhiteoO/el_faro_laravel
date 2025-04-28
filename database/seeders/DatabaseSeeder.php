<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Importa los seeders que creaste
use Database\Seeders\SeccionSeeder;
use Database\Seeders\ArticuloSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders de la aplicación.
     */
    public function run(): void
    {
        // Llama a los seeders específicos en el orden deseado
        $this->call([
            SeccionSeeder::class, // Ejecuta primero el Seeder de Secciones
            ArticuloSeeder::class, // Luego ejecuta el Seeder de Artículos
            // Puedes añadir aquí otros seeders en el futuro si los necesitas
            // Por ejemplo, para crear un usuario administrador inicial:
            // UserSeeder::class,
        ]);

         $this->command->info('¡Todos los seeders principales han sido ejecutados!');
    }
}
