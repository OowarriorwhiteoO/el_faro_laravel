<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodcastController extends Controller
{
    /**
     * Muestra la página de podcast.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Por ahora, solo retornamos la vista.
        // Más adelante, si necesitas cargar datos específicos de podcasts
        // (ej. desde la base de datos), lo harías aquí.
        return view('podcast.index');
    }
}
