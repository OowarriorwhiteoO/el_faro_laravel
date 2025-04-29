<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;              // Modelo para interactuar con la tabla 'secciones'.
use App\Models\Articulo;             // Modelo para interactuar con la tabla 'articulos'.
use Illuminate\Support\Facades\Log;  // Facade para registrar logs.
use Illuminate\View\View;            // Clase para respuestas de vista.
use Illuminate\Support\Collection;   // Clase para manejar colecciones.

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio del sitio web.
     * Carga datos relevantes para la portada desde la base de datos.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Define los slugs de las secciones a mostrar en la portada.
        $slugsPortada = ['general', 'nacional', 'tecnologia', 'deportes', 'negocios'];
        $datosPortada = []; // Almacenará los artículos limitados para cada sección de la portada.
        $seccionesCompletas = collect([]); // Almacenará todas las secciones con conteo de artículos.
        $seccionesParaFormulario = collect([]); // Almacenará todas las secciones para el formulario de agregar noticia.

        try {
            // Obtiene las secciones especificadas para la portada, cargando sus 3 artículos más recientes.
            $secciones = Seccion::whereIn('slug', $slugsPortada)
                                 ->with(['articulos' => function ($query) {
                                     // Ordena los artículos por fecha descendente y limita a 3 por sección.
                                     $query->orderBy('fechaPublicacion', 'desc')->limit(3);
                                 }])
                                 ->get()
                                 // Organiza la colección resultante usando el 'slug' como clave.
                                 ->keyBy('slug');

            // Prepara los artículos para cada sección de la portada.
            foreach ($slugsPortada as $slug) {
                // Asigna la colección de artículos o una colección vacía si la sección no se encontró.
                $datosPortada[$slug] = $secciones->get($slug)?->articulos ?? collect([]);
            }

            // Obtiene todas las secciones con el conteo de sus artículos asociados.
            $seccionesCompletas = Seccion::withCount('articulos')
                                         ->orderBy('nombreSeccion') // Ordena alfabéticamente por nombre.
                                         ->get()
                                         ->keyBy('slug'); // Organiza por slug.

            // Obtiene todas las secciones ordenadas para el selector del formulario.
            $seccionesParaFormulario = Seccion::orderBy('nombreSeccion')->get();

        } catch (\Exception $e) {
            // Registra cualquier error ocurrido durante la consulta a la base de datos.
            Log::error("Error al cargar datos para la portada: " . $e->getMessage());
            // Inicializa las variables como colecciones vacías en caso de error.
            foreach ($slugsPortada as $slug) {
                $datosPortada[$slug] = collect([]);
            }
            $seccionesCompletas = collect([]);
            $seccionesParaFormulario = collect([]);
        }

        // Retorna la vista 'home.index' pasando los datos necesarios.
        return view('home.index', [
            'noticiasGenerales' => $datosPortada['general'] ?? collect([]),
            'noticiasNacionales' => $datosPortada['nacional'] ?? collect([]),
            'noticiasTecnologia' => $datosPortada['tecnologia'] ?? collect([]),
            'noticiasDeportes' => $datosPortada['deportes'] ?? collect([]),
            'noticiasNegocios' => $datosPortada['negocios'] ?? collect([]),
            'seccionesCompletas' => $seccionesCompletas, // Para contadores en títulos de sección.
            'secciones' => $seccionesParaFormulario // Para el selector en el formulario de agregar noticia.
        ]);
    }
}
