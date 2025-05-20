<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    /**
     * Muestra la página de multimedia.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Por ahora, solo retornamos la vista.
        // Más adelante, si necesitas cargar datos específicos de multimedia
        // (ej. desde la base de datos), lo harías aquí.
        return view('multimedia.index');
    }
}
