<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{
    /**
     * Muestra la página de detalle de un artículo específico.
     */
    public function mostrar(Articulo $articulo)
    {
        return view('articulos.detalle', [
            'articulo' => $articulo
        ]);
    }

    /**
     * Guarda un nuevo artículo enviado desde el formulario en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación (añadido 'contenido')
        $validator = Validator::make($request->all(), [
            'section' => 'required|integer|exists:secciones,idSeccion',
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:255|unique:articulos,titulo',
            'description' => 'required|string|min:10',
            'contenido' => 'nullable|string', // <-- AÑADIDO: Contenido es opcional, tipo string
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            // Mensajes personalizados (sin cambios necesarios aquí por ahora)
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

        // Si la validación falla...
        if ($validator->fails()) {
            return redirect(route('home') . '#nueva-noticia')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 2. Si la validación es exitosa...
        try {
            $validatedData = $validator->validated();
            $imagePath = null;

            // Procesar la imagen si se subió
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $imagePath = $request->file('imagen')->store('articulos', 'public');
            }

            // Crear el artículo en la base de datos
            Articulo::create([
                'titulo' => $validatedData['title'],
                'descripcion' => $validatedData['description'],
                'categoria' => $validatedData['category'] ?? null,
                'idSeccion' => $validatedData['section'],
                'fechaPublicacion' => Carbon::now(),
                'imagenUrl' => $imagePath, // Puede ser null si no se subió imagen
                'imagenAlt' => $imagePath ? ('Imagen para ' . $validatedData['title']) : null, // Alt text o null
                'contenido' => $validatedData['contenido'] ?? null, // <-- ACTUALIZADO: Usa el campo 'contenido' validado, o null si está vacío
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('home')->with('success', '¡Noticia agregada con éxito!');

        } catch (\Exception $e) {
            Log::error("Error al guardar el artículo: " . $e->getMessage());
            if (isset($imagePath) && $imagePath && Storage::disk('public')->exists($imagePath)) {
                 Storage::disk('public')->delete($imagePath);
            }
            return redirect(route('home') . '#nueva-noticia')
                        ->with('error', 'Ocurrió un error al guardar la noticia. Inténtalo de nuevo.')
                        ->withInput();
        }
    }
}
