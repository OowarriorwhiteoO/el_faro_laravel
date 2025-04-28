<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion; // <-- Importa el modelo Seccion
use App\Models\Articulo; // <-- Importa el modelo Articulo (aunque no se use directamente aquí, es bueno tenerlo si se necesita)
use Illuminate\Support\Facades\Log; // Todavía útil para registrar errores si algo falla

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio del sitio web.
     * Carga las secciones y las primeras noticias de cada una desde la base de datos.
     */
// Dentro de la clase HomeController

public function index()
{
    $slugsPortada = ['general', 'nacional', 'tecnologia', 'deportes', 'negocios'];
    $datosPortada = [];
    $seccionesCompletas = [];
    $seccionesParaFormulario = []; // <-- Variable para el formulario

    try {
        // --- Carga de noticias para la portada (como antes) ---
        $secciones = Seccion::whereIn('slug', $slugsPortada)
                             ->with(['articulos' => function ($query) {
                                 $query->orderBy('fechaPublicacion', 'desc')->limit(3);
                             }])
                             ->get()
                             ->keyBy('slug');

        foreach ($slugsPortada as $slug) {
            $datosPortada[$slug] = $secciones->get($slug)?->articulos ?? collect([]);
        }

        // --- Carga de secciones para contadores y formulario ---
        $seccionesCompletas = Seccion::withCount('articulos')->orderBy('nombreSeccion')->get()->keyBy('slug'); // Ordena por nombre
        $seccionesParaFormulario = Seccion::orderBy('nombreSeccion')->get(); // <-- Carga todas las secciones para el select

    } catch (\Exception $e) {
        Log::error("Error al cargar datos para la portada: " . $e->getMessage());
        foreach ($slugsPortada as $slug) {
            $datosPortada[$slug] = collect([]);
        }
        // Asegurarse que las otras variables sean colecciones vacías en caso de error
        $seccionesCompletas = collect([]);
        $seccionesParaFormulario = collect([]);
    }

    // Pasa todas las variables necesarias a la vista
    return view('home.index', [
        'noticiasGenerales' => $datosPortada['general'] ?? collect([]),
        'noticiasNacionales' => $datosPortada['nacional'] ?? collect([]),
        'noticiasTecnologia' => $datosPortada['tecnologia'] ?? collect([]),
        'noticiasDeportes' => $datosPortada['deportes'] ?? collect([]),
        'noticiasNegocios' => $datosPortada['negocios'] ?? collect([]),
        'seccionesCompletas' => $seccionesCompletas,
        'secciones' => $seccionesParaFormulario // <-- Pasa las secciones al formulario
    ]);
}

    // Ya no necesitamos el método cargarNoticiasDesdeJson()
}
