<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;              // Modelo para interactuar con la tabla 'secciones'.
use Illuminate\Support\Facades\Log;  // Facade para registrar logs.
use Illuminate\Contracts\View\View;  // Interfaz para respuestas de vista.
use Illuminate\Http\RedirectResponse; // Clase para respuestas de redirección.
use Illuminate\Database\Eloquent\ModelNotFoundException; // Excepción específica para firstOrFail.

class SeccionController extends Controller
{
    /**
     * Muestra la página de una sección específica con sus artículos.
     * Carga la sección y sus artículos asociados desde la base de datos.
     *
     * @param string $slug Identificador único de la sección en la URL.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrar(string $slug): View|RedirectResponse // Define los posibles tipos de retorno.
    {
        try {
            // Busca la sección por su 'slug', cargando previamente los artículos relacionados.
            // Los artículos se ordenan por fecha de publicación descendente.
            // firstOrFail lanza una excepción ModelNotFoundException si no encuentra la sección.
            $seccion = Seccion::where('slug', $slug)
                              ->with(['articulos' => function($query) {
                                  $query->orderBy('fechaPublicacion', 'desc');
                              }])
                              ->firstOrFail();

            // Obtiene la colección de artículos cargados a través de la relación.
            $articulos = $seccion->articulos;

            // Retorna la vista 'seccion.mostrar', pasando los datos de la sección y sus artículos.
            return view('seccion.mostrar', [
                'tituloSeccion' => $seccion->nombreSeccion,
                'articulos' => $articulos,
                'slugSeccion' => $seccion->slug
            ]);

        } catch (ModelNotFoundException $e) {
            // Maneja el caso específico en que la sección no se encuentra.
            Log::warning("Sección no encontrada con slug: {$slug}");
            // Muestra la página de error 404 estándar de Laravel.
            abort(404, 'Sección no encontrada');

        } catch (\Exception $e) {
            // Captura cualquier otro error inesperado durante la consulta o procesamiento.
            Log::error("Error al cargar la sección '{$slug}': " . $e->getMessage());
            // Redirige a la página de inicio con un mensaje de error general.
            return redirect()->route('home')->with('error', 'Ocurrió un error al cargar la sección.');
        }
    }
}
