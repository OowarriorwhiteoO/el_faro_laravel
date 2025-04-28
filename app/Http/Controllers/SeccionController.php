<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion; // <-- Importa el modelo Seccion
use Illuminate\Support\Facades\Log; // Para registrar errores si algo falla

class SeccionController extends Controller
{
    /**
     * Muestra la página de una sección de noticias específica.
     * Carga la sección y TODOS sus artículos desde la base de datos usando el slug.
     *
     * @param string $slug El identificador de la sección (ej: 'nacional', 'deportes')
     * @return \Illuminate\Contracts\View\View
     */
    public function mostrar($slug)
    {
        try {
            // Busca la sección por su 'slug' en la base de datos.
            // Carga previamente ('with') todos los artículos relacionados ('articulos')
            // ordenándolos por fecha de publicación descendente.
            // firstOrFail() encontrará la primera sección que coincida o lanzará un error 404 si no existe.
            $seccion = Seccion::where('slug', $slug)
                              ->with(['articulos' => function($query) {
                                  $query->orderBy('fechaPublicacion', 'desc');
                              }])
                              ->firstOrFail(); // Lanza 404 si no encuentra la sección

            // Accede a los artículos ya cargados a través de la relación definida en el modelo Seccion
            $articulos = $seccion->articulos;

            // Retorna la vista 'seccion.mostrar' (resources/views/seccion/mostrar.blade.php)
            // Pasa el objeto $seccion completo (que incluye el nombre y slug) y la colección de $articulos.
            return view('seccion.mostrar', [
                'tituloSeccion' => $seccion->nombreSeccion, // Obtiene el nombre desde el objeto $seccion
                'articulos' => $articulos,
                'slugSeccion' => $seccion->slug // Pasa el slug también (útil para IDs en la vista)
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             // Esto ya no es estrictamente necesario porque firstOrFail() maneja el 404,
             // pero lo dejamos por si quieres un log específico o manejo diferente.
            Log::warning("Sección no encontrada con slug: {$slug}");
            abort(404, 'Sección no encontrada'); // Muestra la página 404 estándar

        } catch (\Exception $e) {
            // Captura cualquier otro error de base de datos o inesperado
            Log::error("Error al cargar la sección '{$slug}': " . $e->getMessage());
            // Puedes mostrar una vista de error personalizada o redirigir con un mensaje
            // session()->flash('error', 'Ocurrió un error al cargar la sección.');
            return redirect()->route('home')->with('error', 'Ocurrió un error al cargar la sección.');
        }
    }

     // Ya no necesitamos el método cargarNoticiasDesdeJson()
}
