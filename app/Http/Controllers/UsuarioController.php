<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; // Importa el modelo Usuario.
use Illuminate\Contracts\View\View; // Importa la interfaz View.

/**
 * Controlador para gestionar operaciones relacionadas con los usuarios.
 */
class UsuarioController extends Controller
{
    /**
     * Muestra una lista paginada de los usuarios registrados.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        // Obtiene los usuarios de la base de datos, ordenados por nombre.
        // Utiliza paginate() para mostrar un número limitado por página (ej. 15).
        $usuarios = Usuario::orderBy('nombre', 'asc')->paginate(15);

        // Retorna la vista 'usuarios.index' pasando la colección paginada de usuarios.
        // La vista se creará en: resources/views/usuarios/index.blade.php
        return view('usuarios.index', [
            'usuarios' => $usuarios
        ]);
    }

    // Otros métodos relacionados con usuarios (mostrar perfil, editar, etc.) podrían ir aquí.
}
