<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function __construct()
    {
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

    /**
     * Almacena un nuevo artículo en la base de datos usando un procedimiento almacenado.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'descripcion' => 'required|string|max:500', // Hecho 'required' como en el SP
            'contenido' => 'nullable|string',
            'imagenUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'imagenAlt' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:100',
            'fechaPublicacion' => 'nullable|date',
            'idSeccion' => 'required|exists:seccions,idSeccion',
        ]);

        // El título se convertirá a mayúsculas dentro del SP, así que no es necesario aquí.
        // $validatedData['titulo'] = Str::upper($validatedData['titulo']);

        $imagePathForDB = null; // Variable para almacenar la ruta de la imagen
        if ($request->hasFile('imagenUrl')) {
            $path = $request->file('imagenUrl')->store('img/articulos', 'public');
            $imagePathForDB = $path;
        }

        try {
            DB::statement('CALL InsertarArticulo(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validatedData['titulo'],
                $validatedData['descripcion'],
                $validatedData['contenido'] ?? null, // Asegurar que sea null si no está presente
                $imagePathForDB, // Usar la variable que contiene la ruta o null
                $validatedData['imagenAlt'] ?? null,
                $validatedData['categoria'] ?? null,
                $validatedData['fechaPublicacion'] ?? now()->toDateString(), // Usar fecha actual si no se provee
                $validatedData['idSeccion'],
                Auth::id(), // ID del usuario autenticado
            ]);

            return redirect()->route('home')->with('success', 'Artículo creado exitosamente usando SP.'); // mensaje para confirmar

        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error("Error al ejecutar SP 'InsertarArticulo': " . $ex->getMessage());
            // Si hubo un error con el SP, y se subió una imagen
            if ($imagePathForDB && Storage::disk('public')->exists($imagePathForDB)) {
                Storage::disk('public')->delete($imagePathForDB);
            }
            return redirect()->back()->with('error', 'Ocurrió un error al crear el artículo. Por favor, inténtalo de nuevo.')->withInput();
        } catch (\Exception $e) { // Captura general
            Log::error("Error general en ArticuloController@store con SP: " . $e->getMessage());
            if ($imagePathForDB && Storage::disk('public')->exists($imagePathForDB)) {
                Storage::disk('public')->delete($imagePathForDB);
            }
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }

    public function mostrar($id)
    {
        $articulo = Articulo::with(['seccion', 'autor'])->findOrFail($id);
        return view('articulos.detalle', compact('articulo'));
    }

    public function edit(Articulo $articulo)
    {
        Gate::authorize('update-articulo', $articulo);
        $secciones = Seccion::all();
        return view('articulos.edit', compact('articulo', 'secciones'));
    }

    public function update(Request $request, Articulo $articulo)
    {
        Gate::authorize('update-articulo', $articulo);

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
        return redirect()->route('articulo.detalle', ['articulo' => $articulo->idArticulo])->with('success', 'Artículo actualizado exitosamente.');
    }

    public function destroy(Articulo $articulo)
    {
        Gate::authorize('delete-articulo', $articulo);

        if ($articulo->imagenUrl) {
            Storage::disk('public')->delete($articulo->imagenUrl);
        }
        $articulo->delete();
        return redirect()->route('home')->with('success', 'Artículo eliminado exitosamente.');
    }
}
