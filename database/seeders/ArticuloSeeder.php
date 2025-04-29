<?php

namespace Database\Seeders;

// Importaciones de clases necesarias.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Facade para interactuar con el sistema de archivos.
use Illuminate\Support\Facades\Log;  // Facade para registrar logs.
use App\Models\Seccion;             // Modelo Eloquent para la tabla 'secciones'.
use App\Models\Articulo;            // Modelo Eloquent para la tabla 'articulos'.
use Carbon\Carbon;                  // Clase para facilitar el manejo de fechas y horas.

/**
 * Seeder para poblar la tabla 'articulos' con datos iniciales desde un archivo JSON.
 */
class ArticuloSeeder extends Seeder
{
    /**
     * Ejecuta el proceso de seeding para la tabla 'articulos'.
     */
    public function run(): void
    {
        // Define la ruta al archivo JSON que contiene los datos de las noticias.
        $jsonPath = public_path('js/noticias.json');
        $noticiasData = []; // Inicializa el array para los datos decodificados.

        // Verifica si el archivo JSON existe en la ruta especificada.
        if (!File::exists($jsonPath)) {
            Log::error("Seeder Articulos: Archivo de datos no encontrado en {$jsonPath}");
            $this->command->error("Archivo de datos no encontrado en {$jsonPath}");
            return; // Detiene la ejecución si el archivo no existe.
        }

        // Lee el contenido completo del archivo JSON.
        $jsonContent = File::get($jsonPath);

        // Intenta decodificar el contenido JSON a un array asociativo de PHP.
        try {
            $noticiasData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            // Registra un error y detiene la ejecución si el JSON es inválido.
            Log::error("Seeder Articulos: Error al decodificar JSON: " . $e->getMessage());
            $this->command->error("Error al decodificar JSON: " . $e->getMessage());
            return;
        }

        // Verifica que los datos decodificados formen un array válido.
        if (!is_array($noticiasData)) {
             Log::error("Seeder Articulos: El contenido del JSON no es un array válido.");
             $this->command->error("El contenido del JSON no es un array válido.");
             return;
        }

        // Itera sobre cada sección definida en el array de datos.
        foreach ($noticiasData as $slugSeccion => $seccionInfo) {
            // Busca la sección correspondiente en la base de datos usando su 'slug'.
            $seccionDB = Seccion::where('slug', $slugSeccion)->first();

            // Si la sección no existe en la base de datos, omite sus artículos.
            if (!$seccionDB) {
                Log::warning("Seeder Articulos: Sección '{$slugSeccion}' no encontrada en BD. Omitiendo artículos.");
                $this->command->warn("Sección '{$slugSeccion}' no encontrada en BD. Omitiendo artículos.");
                continue; // Continúa con la siguiente sección.
            }

            // Verifica que la información de la sección contenga una clave 'articles' y que sea un array.
            if (!isset($seccionInfo['articles']) || !is_array($seccionInfo['articles'])) {
                Log::warning("Seeder Articulos: No hay array 'articles' para la sección '{$slugSeccion}'.");
                 $this->command->warn("No hay array 'articles' para la sección '{$slugSeccion}'.");
                continue; // Continúa con la siguiente sección.
            }

            // Itera sobre cada artículo dentro de la sección actual.
            foreach ($seccionInfo['articles'] as $articuloJson) {
                // Intenta procesar la fecha del artículo desde el JSON.
                $fechaPublicacion = null;
                if (!empty($articuloJson['date'])) {
                    try {
                        // Convierte la fecha a formato YYYY-MM-DD usando Carbon.
                        $fechaPublicacion = Carbon::parse($articuloJson['date'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Registra un error si la fecha es inválida.
                        Log::error("Seeder Articulos: Fecha inválida '{$articuloJson['date']}' para artículo '{$articuloJson['title']}'. Se guardará como NULL.");
                    }
                }

                // Utiliza updateOrCreate para insertar o actualizar el artículo.
                // Busca por título y idSeccion para evitar duplicados exactos.
                Articulo::updateOrCreate(
                    [
                        'titulo' => $articuloJson['title'],      // Criterio de búsqueda: título.
                        'idSeccion' => $seccionDB->idSeccion   // Criterio de búsqueda: ID de sección.
                    ],
                    [ // Datos a insertar o actualizar.
                        'descripcion' => $articuloJson['description'] ?? null,
                        'contenido' => $articuloJson['details'] ?? null, // Mapea 'details' del JSON a 'contenido'.
                        'imagenUrl' => $articuloJson['img'] ?? null,
                        'imagenAlt' => $articuloJson['alt-img'] ?? $articuloJson['title'], // Texto alternativo.
                        'categoria' => $articuloJson['category'] ?? null,
                        'fechaPublicacion' => $fechaPublicacion, // Fecha procesada o null.
                    ]
                );
            }
             // Informa en consola que los artículos de esta sección fueron procesados.
             $this->command->info("Artículos para la sección '{$seccionDB->nombreSeccion}' procesados.");
        }

         // Informa en consola que el seeder de artículos ha finalizado.
         $this->command->info('¡Seeder de Artículos completado!');
    }
}
