<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Seccion; // Asegúrate de que Seccion esté importado si lo usas aquí directamente.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <--- IMPORTANTE: Añade esta línea

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lógica para mostrar una lista de artículos si es necesario
        $articulos = Articulo::with('seccion')->orderBy('fechaPublicacion', 'desc')->paginate(10);
        return view('articulos.index', compact('articulos')); // Asumiendo que tienes una vista articulos.index
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Lógica para mostrar el formulario de creación
        // Necesitarás pasar las secciones al formulario si tienes un selector de secciones
        $secciones = Seccion::all();
        return view('articulos.create', compact('secciones')); // Asumiendo que tienes una vista articulos.create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'descripcion' => 'nullable|string|max:500', // Ajusta el max según necesidad
            'contenido' => 'nullable|string',
            'imagenUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096', // Acepta webp, max 4MB
            'imagenAlt' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:100',
            'fechaPublicacion' => 'nullable|date',
            'idSeccion' => 'required|exists:seccions,idSeccion',
        ]);

        if ($request->hasFile('imagenUrl')) {
            // Guarda la imagen en storage/app/public/img/articulos
            // El método store devuelve la ruta relativa como 'img/articulos/nombrearchivoaleatorio.jpg'
            $path = $request->file('imagenUrl')->store('img/articulos', 'public');
            $validatedData['imagenUrl'] = $path;
        } else {
            $validatedData['imagenUrl'] = null; // O una imagen por defecto si lo prefieres
        }

        // Si tienes un sistema de usuarios y quieres asignar el autor:
        // if (auth()->check()) {
        //     $validatedData['idUsuario'] = auth()->id(); // Asumiendo que tienes una columna idUsuario en tu tabla articulos
        // }

        Articulo::create($validatedData);

        // Redirige a donde sea más apropiado, por ejemplo, la página de inicio o el detalle del artículo.
        // La ruta 'home.index' es un ejemplo, cámbiala si es necesario.
        return redirect()->route('home.index')->with('status', 'Artículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        $articulo = Articulo::with('seccion')->findOrFail($id);
        return view('articulos.detalle', compact('articulo'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Articulo  $articulo  // Usando Route Model Binding
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo) // Laravel puede inyectar el modelo directamente si la variable coincide con el parámetro de la ruta
    {
        $secciones = Seccion::all(); // Necesario para el selector de secciones en el formulario de edición
        // El nombre del parámetro en la ruta debe ser {articulo}, ej: Route::get('/articulos/{articulo}/editar', ...)
        return view('articulos.edit', compact('articulo', 'secciones')); // Asumiendo que tienes una vista articulos.edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articulo  $articulo // Usando Route Model Binding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'descripcion' => 'nullable|string|max:500',
            'contenido' => 'nullable|string',
            'imagenUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'imagenAlt' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:100',
            'fechaPublicacion' => 'nullable|date',
            'idSeccion' => 'required|exists:seccions,idSeccion',
        ]);

        if ($request->hasFile('imagenUrl')) {
            // 1. Eliminar la imagen anterior si existe y no es una imagen por defecto
            if ($articulo->imagenUrl) {
                // Comprueba que no sea una imagen por defecto que no quieras borrar
                // if ($articulo->imagenUrl !== 'path/to/default.jpg') {
                Storage::disk('public')->delete($articulo->imagenUrl);
                // }
            }

            // 2. Guardar la nueva imagen
            $path = $request->file('imagenUrl')->store('img/articulos', 'public');
            $validatedData['imagenUrl'] = $path;
        }
        // Si no se sube una nueva imagen, $validatedData['imagenUrl'] no se establecerá,
        // por lo que el valor actual en $articulo->imagenUrl se conservará al hacer update,
        // a menos que explícitamente quieras permitir "quitar" la imagen.
        // Si quieres permitir quitar la imagen (asignar null), necesitarías un campo adicional
        // en el formulario, por ejemplo, un checkbox "eliminar_imagen_actual".

        $articulo->update($validatedData);

        // Redirigir al detalle del artículo actualizado o a una lista.
        return redirect()->route('articulos.mostrar', ['id' => $articulo->idArticulo])->with('status', 'Artículo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articulo  $articulo // Usando Route Model Binding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        // Eliminar la imagen asociada si existe
        if ($articulo->imagenUrl) {
            Storage::disk('public')->delete($articulo->imagenUrl);
        }

        $articulo->delete();

        // Redirigir a la lista de artículos o a la página de inicio
        return redirect()->route('home.index')->with('status', 'Artículo eliminado exitosamente.');
    }
}
