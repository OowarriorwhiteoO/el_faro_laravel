@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'El Faro - ' . $tituloSeccion) {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}

    {{-- Título de la página de sección, incluye el conteo de artículos --}}
    <div class="container mt-4 mb-5"> {{-- Envuelve todo en un container para consistencia --}}
        <h1 class="h3 mb-4 text-center">
            {{ $tituloSeccion }}
            <span class="badge bg-secondary fw-normal">{{ $articulos->total() }} {{-- Usa total() para colecciones paginadas --}}
                articulo{{ $articulos->total() !== 1 ? 's' : '' }}</span>
        </h1>

        {{-- Contenedor para la lista de artículos --}}
        <div id="articles-container-{{ $slugSeccion }}" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            {{-- Itera sobre la colección de artículos o muestra mensaje si está vacía --}}
            @forelse ($articulos as $articulo)
                @php
                    // Formatea la fecha de publicación para mostrarla.
                    $fecha = 'Fecha no disponible';
                    if (!empty($articulo->fechaPublicacion)) {
                        try {
                            $fechaPublicacionObj = \Carbon\Carbon::parse($articulo->fechaPublicacion);
                            $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                            $fecha = $fechaPublicacionObj->format('j') . ' de ' . $meses[intval($fechaPublicacionObj->format('n')) - 1] . ' de ' . $fechaPublicacionObj->format('Y');
                        } catch (\Exception $e) {
                            Log::warning("Fecha inválida para artículo ID {$articulo->idArticulo}: " . $articulo->fechaPublicacion);
                        }
                    }
                @endphp

                {{-- Estructura HTML para mostrar un artículo individual en formato de tarjeta --}}
                <div class="col">
                    <article id="article-{{ $slugSeccion }}-{{ $articulo->idArticulo }}" class="card h-100 shadow-sm article-card">
                        @if ($articulo->imagenUrl)
                            {{-- MODIFICACIÓN AQUÍ para la imagen --}}
                            <img src="{{ Storage::disk('public')->url($articulo->imagenUrl) }}" class="card-img-top article-image" alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}">
                        @else
                            {{-- Imagen por defecto si no hay imagenUrl --}}
                            <img src="{{ asset('assets/img/Logo1.jpeg') }}" class="card-img-top article-image" alt="Imagen no disponible">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}" class="text-decoration-none stretched-link">
                                    {{ $articulo->titulo }}
                                </a>
                            </h5>
                            <p class="card-text small text-muted mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $fecha }}
                                @if (!empty($articulo->categoria))
                                    | <span class="badge bg-info text-dark">{{ $articulo->categoria }}</span>
                                @endif
                            </p>
                            <p class="card-text flex-grow-1">{{ Str::limit($articulo->descripcion, 100) }}</p>
                             {{-- Placeholder para nombre del autor - Se implementará en Paso 4 --}}
                            {{-- @if ($articulo->autor)
                                <p class="card-text small text-muted mb-2">
                                    <i class="fas fa-user me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif --}}
                            <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}" class="btn btn-primary btn-sm mt-auto align-self-start">Leer Más</a>
                        </div>
                    </article>
                </div>

            @empty {{-- Bloque que se muestra si la colección $articulos está vacía --}}
                <div class="col-12">
                    <p class="text-center text-muted fst-italic mt-5">No hay artículos disponibles en esta sección.</p>
                </div>
            @endforelse {{-- Fin del bucle @forelse --}}
        </div> {{-- Fin del contenedor de artículos --}}

        {{-- Paginación --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $articulos->links() }}
        </div>
    </div>
@endsection {{-- Fin de la sección de contenido principal --}}

@section('styles') {{-- Inicio de la sección para estilos CSS específicos --}}
    <style>
        .article-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .article-image {
            height: 200px; /* Altura fija para las imágenes de las tarjetas */
            object-fit: cover; /* Asegura que la imagen cubra el espacio sin deformarse */
        }

        /* Estilos para elementos dentro del contenido HTML del artículo (si se mostrara aquí) */
        .article-details img {
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
        /* ... (otros estilos que tenías para .article-details si fueran necesarios aquí también) ... */
    </style>
@endsection {{-- Fin de la sección para estilos CSS específicos --}}
