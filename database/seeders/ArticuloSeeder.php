<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Seccion;
use App\Models\Articulo;
use App\Models\Usuario; // <-- AÑADIR para buscar el usuario
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticuloSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = public_path('js/noticias.json');
        // ... (resto del código para cargar JSON sin cambios) ...

        if (!File::exists($jsonPath)) {
            Log::error("Seeder Articulos: Archivo de datos no encontrado en {$jsonPath}");
            $this->command->error("Archivo de datos no encontrado en {$jsonPath}");
            return;
        }
        $jsonContent = File::get($jsonPath);
        try {
            $noticiasData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            Log::error("Seeder Articulos: Error al decodificar JSON: " . $e->getMessage());
            $this->command->error("Error al decodificar JSON: " . $e->getMessage());
            return;
        }
        if (!is_array($noticiasData)) {
            Log::error("Seeder Articulos: El contenido del JSON no es un array válido.");
            $this->command->error("El contenido del JSON no es un array válido.");
            return;
        }

        $this->command->info('Iniciando Seeder de Artículos...');

        // Obtener un usuario por defecto para asignar como autor
        // Puedes buscar por email, o simplemente el primer usuario, o crear uno específico.
        // Opción 1: Usar el primer usuario encontrado.
        $usuarioPorDefecto = Usuario::first();
        $idAutorPorDefecto = $usuarioPorDefecto ? $usuarioPorDefecto->idUsuario : null;

        if (!$idAutorPorDefecto) {
            $this->command->warn("ArticuloSeeder: No se encontró un usuario por defecto. Los artículos del seeder no tendrán autor.");
            // Opcional: Podrías crear un usuario aquí si lo deseas
            // $usuarioPorDefecto = Usuario::factory()->create(['nombre' => 'Admin El Faro', 'email' => 'admin@elfaro.com']);
            // $idAutorPorDefecto = $usuarioPorDefecto->idUsuario;
        } else {
            $this->command->info("Artículos del seeder se asignarán al usuario: ID {$idAutorPorDefecto} ({$usuarioPorDefecto->nombre})");
        }


        foreach ($noticiasData as $slugSeccion => $seccionInfo) {
            $seccionDB = Seccion::where('slug', $slugSeccion)->first();

            if (!$seccionDB) {
                Log::warning("Seeder Articulos: Sección '{$slugSeccion}' no encontrada en BD. Omitiendo artículos.");
                $this->command->warn("Sección '{$slugSeccion}' no encontrada en BD. Omitiendo artículos.");
                continue;
            }

            if (!isset($seccionInfo['articles']) || !is_array($seccionInfo['articles'])) {
                Log::warning("Seeder Articulos: No hay array 'articles' para la sección '{$slugSeccion}'.");
                $this->command->warn("No hay array 'articles' para la sección '{$slugSeccion}'.");
                continue;
            }

            foreach ($seccionInfo['articles'] as $articuloJson) {
                $fechaPublicacion = null;
                if (!empty($articuloJson['date'])) {
                    try {
                        $fechaPublicacion = Carbon::parse($articuloJson['date'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        Log::error("Seeder Articulos: Fecha inválida '{$articuloJson['date']}' para artículo '{$articuloJson['title']}'. Se guardará como NULL.");
                    }
                }

                $nuevaImagenUrl = null;
                if (!empty($articuloJson['img'])) {
                    $nombreArchivoOriginal = $articuloJson['img'];
                    $rutaOrigen = public_path('assets/img/' . $nombreArchivoOriginal);

                    if (File::exists($rutaOrigen)) {
                        $extension = File::extension($rutaOrigen);
                        $nombreArchivoStorage = Str::random(40) . '.' . $extension;
                        $rutaDestinoEnStorage = 'img/articulos/' . $nombreArchivoStorage;
                        $contenidoArchivo = File::get($rutaOrigen);
                        Storage::disk('public')->put($rutaDestinoEnStorage, $contenidoArchivo);
                        $nuevaImagenUrl = $rutaDestinoEnStorage;
                        $this->command->info("Imagen '{$nombreArchivoOriginal}' copiada a '{$nuevaImagenUrl}'");
                    } else {
                        $this->command->warn("Imagen '{$nombreArchivoOriginal}' no encontrada en 'public/assets/img/' para el artículo '{$articuloJson['title']}'.");
                    }
                }

                Articulo::updateOrCreate(
                    [
                        'titulo' => Str::upper($articuloJson['title']), // Guardar título en mayúsculas también para el seeder
                        'idSeccion' => $seccionDB->idSeccion
                    ],
                    [
                        'descripcion' => $articuloJson['description'] ?? null,
                        'contenido' => $articuloJson['details'] ?? null,
                        'imagenUrl' => $nuevaImagenUrl,
                        'imagenAlt' => $articuloJson['alt-img'] ?? Str::upper($articuloJson['title']),
                        'categoria' => $articuloJson['category'] ?? null,
                        'fechaPublicacion' => $fechaPublicacion,
                        'idUsuario' => $idAutorPorDefecto, // <--- AÑADIR ID DE AUTOR
                    ]
                );
            }
            $this->command->info("Artículos para la sección '{$seccionDB->nombreSeccion}' procesados.");
        }
        $this->command->info('¡Seeder de Artículos completado!');
    }
}
