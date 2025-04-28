<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Importa la clase View

class PaginaEstaticaController extends Controller
{
    /**
     * Muestra la página de Política de Privacidad.
     *
     * @return \Illuminate\View\View
     */
    public function privacidad(): View
    {
        // Retorna la vista ubicada en resources/views/paginas/privacidad.blade.php
        return view('paginas.privacidad');
    }

    /**
     * Muestra la página de Términos de Uso.
     *
     * @return \Illuminate\View\View
     */
    public function terminos(): View
    {
        // Retorna la vista ubicada en resources/views/paginas/terminos.blade.php
        return view('paginas.terminos');
    }

    /**
     * Muestra la página de Política de Cookies.
     *
     * @return \Illuminate\View\View
     */
    public function cookies(): View
    {
        // Retorna la vista ubicada en resources/views/paginas/cookies.blade.php
        return view('paginas.cookies');
    }
}
