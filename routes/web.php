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
use App\Models\Articulo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Define las rutas accesibles a través del navegador web.
| Estas rutas son cargadas por RouteServiceProvider dentro de un grupo
| que aplica el middleware 'web'.
|--------------------------------------------------------------------------
*/

// --- Rutas Principales, Secciones y Artículos ---

// Ruta para la página de inicio.
Route::get('/', [HomeController::class, 'index'])->name('home');
// Ruta para mostrar los artículos de una sección específica por su slug.
Route::get('/seccion/{slug}', [SeccionController::class, 'mostrar'])->name('seccion.mostrar');
// Ruta para mostrar el detalle de un artículo específico usando Route Model Binding.
Route::get('/articulo/{articulo}', [ArticuloController::class, 'mostrar'])->name('articulo.detalle');
// Ruta para guardar un nuevo artículo (protegida por autenticación).
Route::post('/articulo/guardar', [ArticuloController::class, 'store'])->middleware('auth')->name('articulo.store');

// --- Rutas Formulario de Contacto ---

// Ruta para procesar el envío del formulario de contacto.
Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');
// Ruta para mostrar la página de agradecimiento del formulario de contacto.
Route::get('/contacto/gracias', [ContactoController::class, 'mostrarGracias'])->name('contacto.gracias');

// --- Rutas de Registro / Login / Logout ---

// Ruta para mostrar el formulario de registro.
Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
// Ruta para procesar el formulario de registro.
Route::post('/registro', [RegisterController::class, 'register'])->name('register.submit');
// Ruta para mostrar el formulario de inicio de sesión.
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Ruta para procesar el intento de inicio de sesión.
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
// Ruta para cerrar la sesión del usuario.
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Rutas Páginas Estáticas (Políticas) ---

// Ruta para la página de Política de Privacidad.
Route::get('/politica-privacidad', [PaginaEstaticaController::class, 'privacidad'])->name('paginas.privacidad');
// Ruta para la página de Términos de Uso.
Route::get('/terminos-uso', [PaginaEstaticaController::class, 'terminos'])->name('paginas.terminos');
// Ruta para la página de Política de Cookies.
Route::get('/politica-cookies', [PaginaEstaticaController::class, 'cookies'])->name('paginas.cookies');

// --- RUTA PERFIL DE USUARIO ---

// Ruta para mostrar la página del perfil del usuario logueado (protegida por autenticación).
Route::get('/perfil', [PerfilController::class, 'index'])
        ->middleware('auth') // Aplica el middleware de autenticación.
        ->name('perfil.index'); // Nombre de la ruta para fácil referencia.

