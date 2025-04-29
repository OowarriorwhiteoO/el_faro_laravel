<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Clase para retornar respuestas de vista.

class PaginaEstaticaController extends Controller
{
    /**
     * Muestra la página de Política de Privacidad.
     *
     * @return \Illuminate\View\View
     */
    public function privacidad(): View
    {
        // Retorna la vista Blade correspondiente a la política de privacidad.
        return view('paginas.privacidad');
    }

    /**
     * Muestra la página de Términos de Uso.
     *
     * @return \Illuminate\View\View
     */
    public function terminos(): View
    {
        // Retorna la vista Blade correspondiente a los términos de uso.
        return view('paginas.terminos');
    }

    /**
     * Muestra la página de Política de Cookies.
     *
     * @return \Illuminate\View\View
     */
    public function cookies(): View
    {
        // Retorna la vista Blade correspondiente a la política de cookies.
        return view('paginas.cookies');
    }
}
