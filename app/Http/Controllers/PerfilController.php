<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Facade para acceder a la información de autenticación.
use Illuminate\View\View;            // Clase para retornar respuestas de vista.
use Illuminate\Http\RedirectResponse; // Clase para respuestas de redirección.

class PerfilController extends Controller
{
    /**
     * Muestra la página del perfil del usuario autenticado.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(): View|RedirectResponse // Define los posibles tipos de retorno.
    {
        // Obtiene el modelo del usuario actualmente autenticado.
        $usuario = Auth::user();

        // Verifica si se pudo obtener un usuario autenticado.
        if (!$usuario) {
            // Redirige a la ruta de login si no hay usuario (medida de seguridad adicional).
            return redirect()->route('login');
        }

        // Retorna la vista 'perfil.index' pasando el objeto del usuario.
        return view('perfil.index', [
            'usuario' => $usuario
        ]);
    }

    // Espacio reservado para futuros métodos relacionados con el perfil, como la actualización.
    // public function update(Request $request) { ... }
}
