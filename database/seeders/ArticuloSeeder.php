<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // Para leer archivos
use Illuminate\Support\Facades\Log;  // Para registrar errores
use App\Models\Seccion;             // Importa el modelo Seccion
use App\Models\Articulo;            // Importa el modelo Articulo
use Carbon\Carbon;                  // Para manejar fechas fácilmente

class ArticuloSeeder extends Seeder
{
    /**
     * Ejecuta los seeds para la tabla articulos.
     * Lee noticias.json, busca la sección correspondiente en la BD,
     * e inserta o actualiza cada artículo asociándolo a su sección.
     */
    public function run(): void
    {
        // Ruta al archivo JSON
        $jsonPath = public_path('js/noticias.json');
        $noticiasData = [];

        // Verificar si el archivo existe
        if (!File::exists($jsonPath)) {
            Log::error("Seeder Articulos: El archivo noticias.json no se encontró en public/js/");
            $this->command->error("El archivo noticias.json no se encontró en public/js/");
            return;
        }

        // Leer el contenido del archivo
        $jsonContent = File::get($jsonPath);

        // Decodificar el JSON
        try {
            $noticiasData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            Log::error("Seeder Articulos: Error al decodificar noticias.json: " . $e->getMessage());
            $this->command->error("Error al decodificar noticias.json: " . $e->getMessage());
            return;
        }

        // Verificar que $noticiasData sea un array
        if (!is_array($noticiasData)) {
             Log::error("Seeder Articulos: El contenido de noticias.json no es un array válido.");
             $this->command->error("El contenido de noticias.json no es un array válido.");
             return;
        }

        // Itera sobre cada sección principal del JSON
        foreach ($noticiasData as $slugSeccion => $seccionInfo) {
            // Busca la sección en la base de datos usando el slug
            $seccionDB = Seccion::where('slug', $slugSeccion)->first();

            // Si no se encuentra la sección en la BD, muestra un aviso y continúa con la siguiente
            if (!$seccionDB) {
                Log::warning("Seeder Articulos: No se encontró la sección con slug '{$slugSeccion}' en la base de datos. Omitiendo sus artículos.");
                $this->command->warn("No se encontró la sección con slug '{$slugSeccion}' en la BD. Omitiendo artículos.");
                continue; // Pasa a la siguiente sección del JSON
            }

            // Verifica si la sección actual en el JSON tiene artículos y si es un array
            if (!isset($seccionInfo['articles']) || !is_array($seccionInfo['articles'])) {
                Log::warning("Seeder Articulos: No se encontraron artículos o no es un array para la sección '{$slugSeccion}'.");
                 $this->command->warn("No se encontraron artículos para la sección '{$slugSeccion}'.");
                continue;
            }

            // Itera sobre cada artículo dentro de la sección actual del JSON
            foreach ($seccionInfo['articles'] as $articuloJson) {
                // Intenta convertir la fecha del JSON a un formato YYYY-MM-DD
                $fechaPublicacion = null;
                if (!empty($articuloJson['date'])) {
                    try {
                        $fechaPublicacion = Carbon::parse($articuloJson['date'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        Log::error("Seeder Articulos: Fecha inválida '{$articuloJson['date']}' para artículo '{$articuloJson['title']}'. Se guardará como NULL.");
                        // $fechaPublicacion se mantiene como null
                    }
                }

                // Usa updateOrCreate para evitar duplicados si se ejecuta el seeder varias veces.
                // Buscará un artículo con el mismo título Y la misma idSeccion.
                // Si lo encuentra, lo actualizará; si no, lo creará.
                Articulo::updateOrCreate(
                    [
                        'titulo' => $articuloJson['title'], // Criterio de búsqueda
                        'idSeccion' => $seccionDB->idSeccion // Criterio de búsqueda
                    ],
                    [ // Datos para crear o actualizar
                        'descripcion' => $articuloJson['description'] ?? null,
                        'contenido' => $articuloJson['details'] ?? null, // Usamos 'details' del JSON para 'contenido'
                        'imagenUrl' => $articuloJson['img'] ?? null,
                        'imagenAlt' => $articuloJson['alt-img'] ?? $articuloJson['title'], // Usa alt-img o el título como fallback
                        'categoria' => $articuloJson['category'] ?? null,
                        'fechaPublicacion' => $fechaPublicacion,
                        // 'idSeccion' ya está en los criterios de búsqueda/creación
                    ]
                );
            }
             $this->command->info("Artículos para la sección '{$seccionDB->nombreSeccion}' procesados.");
        }

         $this->command->info('¡Seeder de Artículos completado!');
    }
}
