@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'El Faro - ' . $tituloSeccion) {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}

    {{-- Título de la página de sección, incluye el conteo de artículos --}}
    <h1 class="h3 mb-4 text-center">
        {{ $tituloSeccion }}
        <span class="badge bg-secondary fw-normal">{{ count($articulos) }}
            articulo{{ count($articulos) !== 1 ? 's' : '' }}</span>
    </h1>

    {{-- Contenedor para la lista de artículos --}}
    <div id="articles-container-{{ $slugSeccion }}">
        {{-- Itera sobre la colección de artículos o muestra mensaje si está vacía --}}
        @forelse ($articulos as $index => $articulo)
            @php
                // Formatea la fecha de publicación para mostrarla.
                $fecha = 'Fecha no disponible';
                if (!empty($articulo->fechaPublicacion)) {
                    try {
                        $fechaPublicacionObj = \Carbon\Carbon::parse($articulo->fechaPublicacion);
                        $meses = [
                            'enero',
                            'febrero',
                            'marzo',
                            'abril',
                            'mayo',
                            'junio',
                            'julio',
                            'agosto',
                            'septiembre',
                            'octubre',
                            'noviembre',
                            'diciembre',
                        ];
                        $fecha =
                            $fechaPublicacionObj->format('j') .
                            ' de ' .
                            $meses[intval($fechaPublicacionObj->format('n')) - 1] .
                            ' de ' .
                            $fechaPublicacionObj->format('Y');
                    } catch (\Exception $e) {
                        Log::warning(
                            "Fecha inválida para artículo ID {$articulo->idArticulo}: " . $articulo->fechaPublicacion,
                        );
                    }
                }

                // Determina la ruta de la imagen a mostrar (storage o assets).
                if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                    $imgPath = Illuminate\Support\Facades\Storage::disk('s3')->url($articulo->imagenUrl);
                } elseif ($articulo->imagenUrl) {
                    $imgPath = asset('assets/img/' . $articulo->imagenUrl);
                } else {
                    $imgPath = asset('assets/img/Logo1.jpeg'); // Ruta de imagen por defecto.
                }

                // Genera un ID único para el elemento article HTML.
                $articleId = 'article-' . $slugSeccion . '-' . $index;
            @endphp

            {{-- Estructura HTML para mostrar un artículo individual --}}
            <article id="{{ $articleId }}"
                class="news-card {{ $loop->even ? 'bg-light' : 'bg-white' }} p-4 mb-4 shadow-sm rounded border">
                <div class="text-center">
                    {{-- Título del artículo como enlace a la página de detalle --}}
                    <h2 class="mb-3 h4">
                        <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                            class="text-decoration-none text-dark stretched-link">
                            {{ $articulo->titulo }}
                        </a>
                    </h2>
                    {{-- Muestra metadatos del artículo (fecha, categoría) --}}
                    <p class="text-muted small mb-3">
                        <i class="fas fa-calendar-alt me-1"></i>Publicado: {{ $fecha }}
                        @if (!empty($articulo->categoria))
                            | <span class="badge bg-info text-dark">{{ $articulo->categoria }}</span>
                        @endif
                    </p>
                    {{-- Muestra la imagen del artículo --}}
                    <img src="{{ $imgPath }}" alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                        class="img-fluid rounded mb-4 shadow-sm"
                        style="max-height: 450px; width: auto; background-color: #eee;">
                    {{-- Muestra la descripción breve del artículo --}}
                    <p class="lead text-start">{{ $articulo->descripcion }}</p>
                </div>
                {{-- Muestra el contenido completo si existe --}}
                @if (!empty($articulo->contenido))
                    <div class="article-details text-start mt-4 pt-4 border-top">
                        {!! $articulo->contenido !!} {{-- Renderiza HTML del contenido --}}
                    </div>
                @endif
            </article>

        @empty {{-- Bloque que se muestra si la colección $articulos está vacía --}}
            <div class="col-12">
                <p class="text-center text-muted fst-italic mt-5">No hay artículos disponibles en esta sección.</p>
            </div>
        @endforelse {{-- Fin del bucle @forelse --}}
    </div> {{-- Fin del contenedor de artículos --}}

@endsection {{-- Fin de la sección de contenido principal --}}

@section('styles') {{-- Inicio de la sección para estilos CSS específicos --}}
    <style>
        /* Estilo para el enlace del título al pasar el mouse */
        .news-card h2 a:hover {
            color: var(--bs-primary) !important;
        }


        /* Estilos para elementos dentro del contenido HTML del artículo */
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

        .article-details h1,
        .article-details h2,
        .article-details h3,
        .article-details h4,
        .article-details h5,
        .article-details h6 {
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            font-weight: 600;
        }

        .article-details p {
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }

        .article-details ul,
        .article-details ol {
            padding-left: 2rem;
            margin-bottom: 1.25rem;
        }
    </style>
@endsection {{-- Fin de la sección para estilos CSS específicos --}}
