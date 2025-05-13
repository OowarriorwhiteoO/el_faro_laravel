<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario; // <-- AÑADIR para crear el usuario admin
use Illuminate\Support\Facades\Hash; // <-- AÑADIR para hashear la contraseña

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Iniciando Seeder Principal...');

        // Crear/Actualizar Usuario Admin
        Usuario::updateOrCreate(
            ['email' => 'admin@elfaro.test'], // Criterio para buscar (email único)
            [
                'nombre' => 'Administrador El Faro',
                'password' => Hash::make('Dale30albo'), // Hashear la contraseña
                'role' => 'admin',
                'email_verified_at' => now(), // Opcional: marcar como verificado
            ]
        );
        $this->command->info('Usuario Admin creado/actualizado: admin@elfaro.test');

        // Llama primero al Seeder de Secciones
        $this->call(SeccionSeeder::class);
        // $this->command->info('Seeder de Secciones ejecutado.'); // Ya lo tienes en SeccionSeeder

        // Luego llama al Seeder de Artículos
        $this->call(ArticuloSeeder::class);
        // $this->command->info('Seeder de Artículos ejecutado.'); // Ya lo tienes en ArticuloSeeder

        $this->command->info('¡Todos los seeders principales han sido ejecutados!');
    }
}
