<?php

namespace Database\Seeders;

// Importaciones de clases necesarias.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Facade para interactuar con el sistema de archivos.
use Illuminate\Support\Facades\Log;  // Facade para registrar logs.
use Illuminate\Support\Str;         // Helper para manipulación de strings (no se usa activamente aquí).
use App\Models\Seccion;             // Modelo Eloquent para la tabla 'secciones'.

/**
 * Seeder para poblar la tabla 'secciones' con datos iniciales desde un archivo JSON.
 */
class SeccionSeeder extends Seeder
{
    /**
     * Ejecuta el proceso de seeding para la tabla 'secciones'.
     */
    public function run(): void
    {
        // Define la ruta al archivo JSON fuente.
        $jsonPath = public_path('js/noticias.json');
        $noticiasData = []; // Inicializa el array para los datos.

        // Verifica la existencia del archivo JSON.
        if (!File::exists($jsonPath)) {
            Log::error("Seeder: Archivo de datos no encontrado en {$jsonPath}");
            $this->command->error("Archivo de datos no encontrado en {$jsonPath}");
            return; // Detiene si el archivo no existe.
        }

        // Lee el contenido del archivo.
        $jsonContent = File::get($jsonPath);

        // Intenta decodificar el contenido JSON.
        try {
            $noticiasData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            // Registra y muestra error si la decodificación falla.
            Log::error("Seeder: Error al decodificar JSON: " . $e->getMessage());
             $this->command->error("Error al decodificar JSON: " . $e->getMessage());
            return; // Detiene si el JSON es inválido.
        }

        // Verifica que los datos decodificados sean un array.
        if (!is_array($noticiasData)) {
             Log::error("Seeder: El contenido del JSON no es un array válido.");
             $this->command->error("El contenido del JSON no es un array válido.");
             return;
        }

        // Itera sobre cada sección encontrada en los datos JSON.
        foreach ($noticiasData as $slug => $seccionInfo) {
            // Procesa la sección solo si tiene un título definido en el JSON.
            if (isset($seccionInfo['title'])) {
                // Utiliza firstOrCreate para buscar por 'slug' y crear si no existe.
                Seccion::firstOrCreate(
                    ['slug' => $slug], // Atributos para buscar la sección.
                    ['nombreSeccion' => $seccionInfo['title']] // Atributos para asignar si se crea una nueva sección.
                );
                 // Informa en consola que la sección fue procesada.
                 $this->command->info("Sección '{$seccionInfo['title']}' ('{$slug}') procesada.");
            } else {
                 // Registra una advertencia si una sección del JSON no tiene título.
                 Log::warning("Seeder: La sección con slug '{$slug}' no tiene título en noticias.json.");
                 $this->command->warn("Sección con slug '{$slug}' omitida por no tener título.");
            }
        }
        // Informa en consola que el proceso ha finalizado.
        $this->command->info('Seeder de Secciones completado.');
    }
}
