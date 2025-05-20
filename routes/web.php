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
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\PodcastController;
// use App\Models\Articulo; // No necesitas importar modelos en el archivo de rutas generalmente

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rutas Principales ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Rutas de Artículos ---
// Es buena práctica agrupar las rutas de un recurso.
// También puedes usar Route::resource si tu controlador sigue todas las convenciones.

// Mostrar el detalle de un artículo (ya la tenías)
Route::get('/articulo/{articulo}', [ArticuloController::class, 'mostrar'])->name('articulo.detalle');

// Formulario para crear un nuevo artículo (si no está en la página de inicio)
Route::get('/articulos/crear', [ArticuloController::class, 'create'])->middleware('auth')->name('articulos.create');

// Guardar un nuevo artículo (ya la tenías, nombre 'articulo.store')
Route::post('/articulo/guardar', [ArticuloController::class, 'store'])->middleware('auth')->name('articulo.store');
// Si quieres seguir la convención plural 'articulos.store', la URL sería POST /articulos

// Formulario para editar un artículo existente
Route::get('/articulos/{articulo}/editar', [ArticuloController::class, 'edit'])->middleware('auth')->name('articulos.edit'); // <--- RUTA IMPORTANTE PARA EL ERROR ACTUAL

// Actualizar un artículo existente
Route::put('/articulos/{articulo}', [ArticuloController::class, 'update'])->middleware('auth')->name('articulos.update');

// Eliminar un artículo existente
Route::delete('/articulos/{articulo}', [ArticuloController::class, 'destroy'])->middleware('auth')->name('articulos.destroy');


// --- Rutas Secciones ---
Route::get('/seccion/{slug}', [SeccionController::class, 'mostrar'])->name('seccion.mostrar');


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
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

Route::get('/multimedia', [MultimediaController::class, 'index'])->name('multimedia.index');
Route::get('/podcast', [PodcastController::class, 'index'])->name('podcast.index');
