<?php

// Importaciones de clases de controladores y modelos necesarios.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\PaginaEstaticaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController; // <-- Importar UsuarioController
use App\Models\Articulo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rutas Principales, Secciones, Artículos ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/seccion/{slug}', [SeccionController::class, 'mostrar'])->name('seccion.mostrar');
Route::get('/articulo/{articulo}', [ArticuloController::class, 'mostrar'])->name('articulo.detalle');
Route::post('/articulo/guardar', [ArticuloController::class, 'store'])->middleware('auth')->name('articulo.store');

// --- Rutas Formulario de Contacto ---
Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');
Route::get('/contacto/gracias', [ContactoController::class, 'mostrarGracias'])->name('contacto.gracias');

// --- Rutas de Registro / Login / Logout ---
Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/registro', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Rutas Páginas Estáticas (Políticas) ---
Route::get('/politica-privacidad', [PaginaEstaticaController::class, 'privacidad'])->name('paginas.privacidad');
Route::get('/terminos-uso', [PaginaEstaticaController::class, 'terminos'])->name('paginas.terminos');
Route::get('/politica-cookies', [PaginaEstaticaController::class, 'cookies'])->name('paginas.cookies');

// --- Ruta Perfil de Usuario ---
Route::get('/perfil', [PerfilController::class, 'index'])->middleware('auth')->name('perfil.index');

// --- RUTA LISTADO DE USUARIOS ---
// Ruta para mostrar la lista de usuarios registrados.
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index'); // <-- AÑADIDA
// NOTA: En una aplicación real, esta ruta debería estar protegida (ej: ->middleware('admin'))
