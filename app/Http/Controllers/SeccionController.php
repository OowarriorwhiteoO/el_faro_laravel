<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Articulo; // <--- ASEGÚRATE QUE ESTA LÍNEA ESTÉ PRESENTE Y CORRECTA
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class SeccionController extends Controller
{
    /**
     * Muestra la página de una sección específica con sus artículos paginados,
     * ahora usando un procedimiento almacenado.
     *
     * @param string $slug Identificador único de la sección en la URL.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrar(string $slug): View|RedirectResponse
    {
        try {
            $seccion = Seccion::where('slug', $slug)->firstOrFail();
            $articulosArray = DB::select('CALL ObtenerArticulosPorSlugSeccion(?)', [$slug]);

            // Convertimos el array de resultados del SP en una colección de modelos Articulo.
            // Esto permite que en la vista puedas acceder a relaciones como ->autor si el SP devuelve idUsuario.
            // Nuestro SP devuelve 'nombreAutor' directamente, así que la hidratación
            // nos sirve para tratar los objetos como instancias de Articulo, aunque no usaremos ->autor.
            $articulos = Articulo::hydrate($articulosArray);
<<<<<<< HEAD

            // Si necesitas paginación, tendrás que implementarla manualmente con hydrate:
            // $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            // $perPage = 9; // O el número que desees
            // $currentPageItems = $articulos->slice(($currentPage - 1) * $perPage, $perPage)->all();
            // $articulosPaginados = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($articulos), $perPage, $currentPage, [
            //     'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            // ]);
=======
>>>>>>> 9f99c68cadc2b1654bfd2fb3d45946636c0b8260


            return view('seccion.mostrar', [
                'tituloSeccion' => $seccion->nombreSeccion,
                // 'articulos' => $articulosPaginados, // Si implementas paginación manual
                'articulos' => $articulos, // Por ahora, pasamos la colección completa
                'slugSeccion' => $seccion->slug,
                'seccion' => $seccion
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Sección no encontrada con slug: {$slug}");
            abort(404, 'Sección no encontrada');
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error("Error al ejecutar SP 'ObtenerArticulosPorSlugSeccion' para slug '{$slug}': " . $ex->getMessage());
            return redirect()->route('home')->with('error', 'Ocurrió un error al cargar la sección.');
        } catch (\Exception $e) {
            Log::error("Error general al cargar la sección '{$slug}': " . $e->getMessage());
            return redirect()->route('home')->with('error', 'Ocurrió un error al cargar la sección.');
        }
    }
}
