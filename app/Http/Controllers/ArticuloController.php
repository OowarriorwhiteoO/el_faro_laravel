<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View; // Añadido para type hinting
use Illuminate\Http\RedirectResponse; // Añadido para type hinting

class ArticuloController extends Controller
{
    /**
     * Muestra la página de detalle de un artículo específico.
     * Utiliza Route Model Binding para inyectar el modelo Articulo.
     *
     * @param  \App\Models\Articulo $articulo
     * @return \Illuminate\View\View
     */
    public function mostrar(Articulo $articulo): View
    {
        // Retorna la vista de detalle pasando el artículo encontrado.
        return view('articulos.detalle', [
            'articulo' => $articulo
        ]);
    }

    /**
     * Valida y guarda un nuevo artículo en la base de datos.
     * Maneja la subida de una imagen opcional.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Define las reglas de validación para los datos del formulario.
        $validator = Validator::make($request->all(), [
            'section' => 'required|integer|exists:secciones,idSeccion', // Debe existir en la tabla secciones.
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:255|unique:articulos,titulo', // Título único en la tabla articulos.
            'description' => 'required|string|min:10',
            'contenido' => 'nullable|string', // Contenido completo opcional.
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Imagen opcional con validaciones de tipo y tamaño.
        ], [
            // Mensajes de error personalizados para una mejor experiencia de usuario.
            'section.required' => 'Debes seleccionar una sección.',
            'section.exists' => 'La sección seleccionada no es válida.',
            'title.required' => 'El título es obligatorio.',
            'title.unique' => 'Ya existe un artículo con este título.',
            'description.required' => 'La descripción breve es obligatoria.',
            'description.min' => 'La descripción debe tener al menos 10 caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, webp.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        // Si la validación falla, redirige de vuelta al formulario con errores y datos previos.
        if ($validator->fails()) {
            return redirect(route('home') . '#nueva-noticia')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Intenta guardar el artículo y la imagen.
        try {
            $validatedData = $validator->validated(); // Obtiene solo los datos que pasaron la validación.
            $imagePath = null; // Inicializa la ruta de la imagen.

            // Verifica si se subió un archivo de imagen válido y lo guarda.
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                // Almacena la imagen en 'storage/app/public/articulos' y obtiene su ruta relativa.
                $imagePath = $request->file('imagen')->store('articulos', 's3');            }

            // Crea el nuevo registro de artículo en la base de datos.
            Articulo::create([
                'titulo' => $validatedData['title'],
                'descripcion' => $validatedData['description'],
                'categoria' => $validatedData['category'] ?? null,
                'idSeccion' => $validatedData['section'],
                'fechaPublicacion' => Carbon::now(), // Asigna la fecha y hora actual.
                'imagenUrl' => $imagePath, // Guarda la ruta de la imagen o null.
                'imagenAlt' => $imagePath ? ('Imagen para ' . $validatedData['title']) : null,
                'contenido' => $validatedData['contenido'] ?? null, // Guarda el contenido completo o null.
            ]);

            // Redirige a la página de inicio con un mensaje de éxito.
            return redirect()->route('home')->with('success', '¡Noticia agregada con éxito!');

        } catch (\Exception $e) {
            // Registra cualquier error que ocurra durante el proceso.
            Log::error("Error al guardar el artículo: " . $e->getMessage());

            // Si se había guardado una imagen pero falló la BD, intenta borrar la imagen.
            if (isset($imagePath) && $imagePath && Storage::disk('public')->exists($imagePath)) {
                 Storage::disk('public')->delete($imagePath);
            }
            // Redirige de vuelta al formulario con un mensaje de error general.
            return redirect(route('home') . '#nueva-noticia')
                        ->with('error', 'Ocurrió un error al guardar la noticia. Inténtalo de nuevo.')
                        ->withInput();
        }
    }
}
