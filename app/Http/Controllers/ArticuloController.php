<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate; // <-- AÑADIR ESTA LÍNEA

class ArticuloController extends Controller
{
    public function __construct()
    {
        // Aplicar middleware de autenticación a todos los métodos excepto los de visualización
        $this->middleware('auth')->except(['index', 'mostrar']);
    }

    public function index()
    {
        $articulos = Articulo::with(['seccion', 'autor'])->orderBy('fechaPublicacion', 'desc')->paginate(10);
        return view('articulos.index', compact('articulos'));
    }

    public function create()
    {
        $secciones = Seccion::all();
        return view('articulos.create', compact('secciones'));
    }

    public function store(Request $request)
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

        $validatedData['titulo'] = Str::upper($validatedData['titulo']);

        if ($request->hasFile('imagenUrl')) {
            $path = $request->file('imagenUrl')->store('img/articulos', 'public');
            $validatedData['imagenUrl'] = $path;
        } else {
            $validatedData['imagenUrl'] = null;
        }

        $validatedData['idUsuario'] = Auth::id();
        Articulo::create($validatedData);
        return redirect()->route('home')->with('status', 'Artículo creado exitosamente.');
    }

    public function mostrar($id)
    {
        $articulo = Articulo::with(['seccion', 'autor'])->findOrFail($id);
        return view('articulos.detalle', compact('articulo'));
    }

    public function edit(Articulo $articulo)
    {
        // Autorización usando Gate
        // Esto lanzará una excepción de autorización (403 Forbidden) si el Gate devuelve false.
        Gate::authorize('update-articulo', $articulo); // <--- MODIFICACIÓN AQUÍ

        $secciones = Seccion::all();
        return view('articulos.edit', compact('articulo', 'secciones'));
    }

    public function update(Request $request, Articulo $articulo)
    {
        // Autorización usando Gate
        Gate::authorize('update-articulo', $articulo); // <--- MODIFICACIÓN AQUÍ

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

        $validatedData['titulo'] = Str::upper($validatedData['titulo']);

        if ($request->hasFile('imagenUrl')) {
            if ($articulo->imagenUrl) {
                Storage::disk('public')->delete($articulo->imagenUrl);
            }
            $path = $request->file('imagenUrl')->store('img/articulos', 'public');
            $validatedData['imagenUrl'] = $path;
        }

        $articulo->update($validatedData);
        return redirect()->route('articulo.detalle', ['articulo' => $articulo->idArticulo])->with('status', 'Artículo actualizado exitosamente.');
    }

    public function destroy(Articulo $articulo)
    {
        // Autorización usando Gate
        Gate::authorize('delete-articulo', $articulo); // <--- MODIFICACIÓN AQUÍ

        if ($articulo->imagenUrl) {
            Storage::disk('public')->delete($articulo->imagenUrl);
        }
        $articulo->delete();
        return redirect()->route('home')->with('status', 'Artículo eliminado exitosamente.');
    }
}
