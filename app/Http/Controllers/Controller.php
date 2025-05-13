<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Es bueno tener estos traits por defecto
use Illuminate\Foundation\Bus\DispatchesJobs;             // Para funcionalidades comunes de controlador
use Illuminate\Foundation\Validation\ValidatesRequests;   // Para funcionalidades comunes de controlador
use Illuminate\Routing\Controller as BaseController;      // Importa la clase base de controlador de Laravel

// class Controller extends BaseController // <--- ASÍ DEBE SER
abstract class Controller extends BaseController // <--- CORRECCIÓN: Añadir "extends BaseController"
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // Traits estándar de Laravel para controladores
}
