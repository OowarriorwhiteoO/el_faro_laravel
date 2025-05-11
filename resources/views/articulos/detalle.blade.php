@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', $articulo->titulo . ' - El Faro') {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}
    <div class="container mt-4 mb-5">
        <article class="articulo-detalle bg-white p-4 p-md-5 shadow-sm rounded border">

            {{-- Muestra el título principal del artículo --}}
            <h1 class="display-5 mb-3">{{ $articulo->titulo }}</h1>

            {{-- Muestra metadatos: categoría, sección, autor (placeholder) y fecha de publicación formateada --}}
            <div class="mb-4 text-muted border-bottom pb-3">
                @if ($articulo->seccion)
                    <span class="badge bg-success text-dark me-2">{{ $articulo->seccion->nombreSeccion }}</span> |
                @endif
                @if ($articulo->categoria)
                    <span class="badge bg-info text-dark me-2">{{ $articulo->categoria }}</span> |
                @endif
                {{-- Placeholder para el nombre del autor - Se implementará en el Paso 4 --}}
                {{-- @if ($articulo->autor)
                    <i class="fas fa-user me-1"></i> Por: {{ $articulo->autor->nombre }} |
                @endif --}}
                <i class="fas fa-calendar-alt me-1"></i> Publicado:
                @php
                    // Formatea la fecha de publicación si está disponible.
                    $fecha = 'Fecha no disponible';
                    if (!empty($articulo->fechaPublicacion)) {
                        try {
                            $fechaPublicacionObj = \Carbon\Carbon::parse($articulo->fechaPublicacion);
                            // Formato más simple y localizado por Carbon si es posible, o tu formato manual.
                            // Para tu formato manual específico:
                            $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                            $fecha = $fechaPublicacionObj->format('j') . ' de ' . $meses[intval($fechaPublicacionObj->format('n')) - 1] . ' de ' . $fechaPublicacionObj->format('Y');
                        } catch (\Exception $e) {
                            // Mantiene 'Fecha no disponible' si hay error.
                        }
                    }
                    echo $fecha;
                @endphp
            </div>

            {{-- Muestra la imagen principal del artículo --}}
            <div class="text-center mb-4">
                @if ($articulo->imagenUrl)
                    {{-- MODIFICACIÓN AQUÍ para la imagen principal --}}
                    <img src="{{ Storage::disk('public')->url($articulo->imagenUrl) }}" alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                        class="img-fluid rounded shadow-sm" style="max-height: 500px; width: auto; background-color: #eee;">
                @else
                    {{-- Imagen por defecto si no hay imagenUrl --}}
                    <img src="{{ asset('assets/img/Logo1.jpeg') }}" alt="{{ $articulo->titulo }}"
                        class="img-fluid rounded shadow-sm" style="max-height: 500px; width: auto; background-color: #eee;">
                @endif
            </div>

            {{-- Muestra la descripción breve (entradilla) si existe --}}
            @if ($articulo->descripcion)
                <p class="lead fst-italic mb-4">{{ $articulo->descripcion }}</p>
            @endif

            {{-- Muestra el contenido completo del artículo (renderiza HTML) --}}
            <div class="articulo-contenido">
                {!! $articulo->contenido !!} {{-- Cuidado con {!! !!} si el contenido no es 100% confiable o sanitizado al guardar --}}
            </div>

            {{-- Botones de Acción (Volver, Editar, Eliminar) --}}
            <div class="mt-4 pt-3 border-top">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>

                {{-- Botones de Editar y Eliminar (se mostrarán condicionalmente en Paso 4) --}}
                @auth
                    {{-- Ejemplo usando Gate (preferido) - Definirás 'update-articulo' y 'delete-articulo' Gates/Policies --}}
                    {{-- @can('update', $articulo) --}}
                    @if(Gate::allows('update-articulo', $articulo)) {{-- Placeholder para la lógica de autorización --}}
                        <a href="{{ route('articulos.edit', $articulo->idArticulo) }}" class="btn btn-outline-primary btn-sm ms-2">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    @endif
                    {{-- @endcan --}}

                    {{-- @can('delete', $articulo) --}}
                    @if(Gate::allows('delete-articulo', $articulo)) {{-- Placeholder para la lógica de autorización --}}
                        <form action="{{ route('articulos.destroy', $articulo->idArticulo) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este artículo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash-alt me-1"></i> Eliminar
                            </button>
                        </form>
                    @endif
                    {{-- @endcan --}}
                @endauth
            </div>

        </article>
    </div>
@endsection {{-- Fin de la sección de contenido principal --}}

@section('styles') {{-- Inicio de la sección para estilos CSS específicos --}}
    <style>
        /* Estilos para imágenes dentro del contenido del artículo */
        .articulo-detalle .articulo-contenido img {
            max-width: 100%;
            height: auto;
            margin-top: 1rem;
            margin-bottom: 1rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 0.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Estilos para encabezados dentro del contenido del artículo */
        .articulo-detalle .articulo-contenido h1,
        .articulo-detalle .articulo-contenido h2,
        .articulo-detalle .articulo-contenido h3,
        .articulo-detalle .articulo-contenido h4,
        .articulo-detalle .articulo-contenido h5,
        .articulo-detalle .articulo-contenido h6 {
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            font-weight: 600;
        }

        /* Estilos para párrafos dentro del contenido del artículo */
        .articulo-detalle .articulo-contenido p {
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }

        /* Estilos para listas dentro del contenido del artículo */
        .articulo-detalle .articulo-contenido ul,
        .articulo-detalle .articulo-contenido ol {
            padding-left: 2rem;
            margin-bottom: 1.25rem;
        }
    </style>
@endsection {{-- Fin de la sección para estilos CSS específicos --}}
