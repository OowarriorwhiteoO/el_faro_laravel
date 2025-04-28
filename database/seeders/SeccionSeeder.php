<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Para leer archivos
use Illuminate\Support\Facades\Log;  // Para registrar errores
use Illuminate\Support\Str;         // Para generar slugs (aunque usamos la clave directamente)
use App\Models\Seccion;             // Importa el modelo Seccion

class SeccionSeeder extends Seeder
{
    /**
     * Ejecuta los seeds para la tabla secciones.
     * Lee el archivo noticias.json, extrae las secciones y las guarda en la BD.
     */
    public function run(): void
    {
        // Ruta al archivo JSON
        $jsonPath = public_path('js/noticias.json');
        $noticiasData = [];

        // Verificar si el archivo existe
        if (!File::exists($jsonPath)) {
            Log::error("Seeder: El archivo noticias.json no se encontró en public/js/");
            $this->command->error("El archivo noticias.json no se encontró en public/js/"); // Muestra error en consola
            return; // Detiene la ejecución del seeder
        }

        // Leer el contenido del archivo
        $jsonContent = File::get($jsonPath);

        // Decodificar el JSON
        try {
            $noticiasData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            Log::error("Seeder: Error al decodificar noticias.json: " . $e->getMessage());
             $this->command->error("Error al decodificar noticias.json: " . $e->getMessage());
            return; // Detiene la ejecución
        }

        // Verificar que $noticiasData sea un array
        if (!is_array($noticiasData)) {
             Log::error("Seeder: El contenido de noticias.json no es un array válido.");
             $this->command->error("El contenido de noticias.json no es un array válido.");
             return;
        }

        // Itera sobre cada elemento principal del JSON (cada sección)
        // $slug será la clave (ej: "general", "nacional")
        // $seccionInfo será el valor (el objeto con "title", "articles", etc.)
        foreach ($noticiasData as $slug => $seccionInfo) {
            // Verifica que la sección tenga un título
            if (isset($seccionInfo['title'])) {
                // Intenta encontrar la sección por su 'slug' o créala si no existe
                Seccion::firstOrCreate(
                    ['slug' => $slug], // Busca por este campo (clave única)
                    [
                        'nombreSeccion' => $seccionInfo['title'], // Campo a rellenar si se crea
                        // 'slug' ya está definido en el primer array, así que no hace falta aquí
                    ]
                );
                 $this->command->info("Sección '{$seccionInfo['title']}' ('{$slug}') procesada."); // Mensaje en consola
            } else {
                 Log::warning("Seeder: La sección con slug '{$slug}' no tiene un título definido en noticias.json.");
                 $this->command->warn("Sección con slug '{$slug}' omitida por no tener título.");
            }
        }

        $this->command->info('¡Seeder de Secciones completado!'); // Mensaje final en consola
    }
}
