@extends('layouts.layout')

@section('title', 'Editar Artículo: ' . $articulo->titulo)

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <h1 class="mb-4 text-center">Editar Artículo</h1>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="formulario-editar-noticia" class="row g-3 p-4 bg-light rounded shadow-sm border" method="POST"
                    action="{{ route('articulos.update', $articulo->idArticulo) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Para indicar que es una solicitud PUT para actualizar --}}

                    <div class="col-md-6">
                        <label for="idSeccion" class="form-label">Sección:</label>
                        <select id="idSeccion" name="idSeccion" class="form-select @error('idSeccion') is-invalid @enderror"
                            required>
                            <option value="" disabled>-- Selecciona una Sección --</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion->idSeccion }}"
                                    {{ old('idSeccion', $articulo->idSeccion) == $seccion->idSeccion ? 'selected' : '' }}>
                                    {{ $seccion->nombreSeccion }}
                                </option>
                            @endforeach
                        </select>
                        @error('idSeccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="categoria" class="form-label">Categoría (Opcional):</label>
                        <input id="categoria" name="categoria" type="text"
                            class="form-control @error('categoria') is-invalid @enderror"
                            placeholder="Ej: Política, IA, Fútbol" value="{{ old('categoria', $articulo->categoria) }}">
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="titulo" class="form-label">Título:</label>
                        <input id="titulo" name="titulo" type="text"
                            class="form-control @error('titulo') is-invalid @enderror" placeholder="Título de la noticia"
                            value="{{ old('titulo', $articulo->titulo) }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción Breve:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                            rows="3" placeholder="Descripción breve" required>{{ old('descripcion', $articulo->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="contenido" class="form-label">Contenido Completo (Opcional):</label>
                        <textarea id="contenido" name="contenido" class="form-control @error('contenido') is-invalid @enderror" rows="6"
                            placeholder="Cuerpo completo de la noticia.">{{ old('contenido', $articulo->contenido) }}</textarea>
                        @error('contenido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="imagenUrl" class="form-label">Imagen de Portada (Opcional - dejar vacío para no
                            cambiar):</label>
                        <input class="form-control @error('imagenUrl') is-invalid @enderror" type="file" id="imagenUrl"
                            name="imagenUrl" accept="image/jpeg,image/png,image/gif,image/webp">
                        @error('imagenUrl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sube una nueva imagen para reemplazar la actual. Máx 4MB.</div>
                        @if ($articulo->imagenUrl)
                            <div class="mt-2">
                                <p class="mb-1">Imagen actual:</p>
                                <img src="{{ Storage::disk('public')->url($articulo->imagenUrl) }}" alt="Imagen actual"
                                    style="max-height: 100px; border-radius: 0.25rem;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="imagenAlt" class="form-label">Texto Alternativo Imagen (Opcional):</label>
                        <input id="imagenAlt" name="imagenAlt" type="text"
                            class="form-control @error('imagenAlt') is-invalid @enderror"
                            placeholder="Descripción breve de la imagen"
                            value="{{ old('imagenAlt', $articulo->imagenAlt) }}">
                        @error('imagenAlt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="fechaPublicacion" class="form-label">Fecha de Publicación (Opcional):</label>
                        <input id="fechaPublicacion" name="fechaPublicacion" type="date"
                            class="form-control @error('fechaPublicacion') is-invalid @enderror"
                            value="{{ old('fechaPublicacion', $articulo->fechaPublicacion ? \Carbon\Carbon::parse($articulo->fechaPublicacion)->format('Y-m-d') : '') }}">
                        @error('fechaPublicacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 text-end mt-3">
                        <a href="{{ route('articulo.detalle', $articulo->idArticulo) }}"
                            class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Noticia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
