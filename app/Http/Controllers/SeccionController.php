<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // No se usa directamente, pero es buena práctica tenerlo.
use App\Models\Seccion;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SeccionController extends Controller
{
    /**
     * Muestra la página de una sección específica con sus artículos paginados.
     *
     * @param string $slug Identificador único de la sección en la URL.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrar(string $slug): View|RedirectResponse
    {
        try {
            $seccion = Seccion::where('slug', $slug)->firstOrFail();

            // Obtiene los artículos asociados a esta sección,
            // cargando también la relación 'autor', ordenados y paginados.
            $articulos = $seccion->articulos()      // Accede a la relación
                                ->with('autor')     // <--- AÑADIDO: Cargar la relación del autor
                                ->orderBy('fechaPublicacion', 'desc')
                                ->paginate(9);      // O el número de artículos por página que desees

            return view('seccion.mostrar', [
                'tituloSeccion' => $seccion->nombreSeccion,
                'articulos' => $articulos, // Ahora es un objeto Paginator que incluye autores
                'slugSeccion' => $seccion->slug,
                'seccion' => $seccion
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Sección no encontrada con slug: {$slug}");
            abort(404, 'Sección no encontrada');
        } catch (\Exception $e) {
            Log::error("Error al cargar la sección '{$slug}': " . $e->getMessage());
            return redirect()->route('home')->with('error', 'Ocurrió un error al cargar la sección.');
        }
    }
}
