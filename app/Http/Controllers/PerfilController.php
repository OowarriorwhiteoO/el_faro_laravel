<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Necesario para obtener el usuario autenticado
use Illuminate\View\View; // Para el tipo de retorno

class PerfilController extends Controller
{
    /**
     * Muestra la página del perfil del usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Obtiene el objeto completo del usuario que ha iniciado sesión actualmente
        $usuario = Auth::user();

        // Si por alguna razón no se encuentra el usuario (aunque el middleware 'auth' debería prevenir esto)
        if (!$usuario) {
            // Redirige al login si no hay usuario autenticado (como medida de seguridad extra)
            return redirect()->route('login');
        }

        // Pasa el objeto $usuario a la vista 'perfil.index'
        // La vista estará en resources/views/perfil/index.blade.php
        return view('perfil.index', [
            'usuario' => $usuario
        ]);
    }

    // Aquí podrías añadir métodos para ACTUALIZAR el perfil en el futuro
    // public function update(Request $request) { ... }
}
