@extends('layouts.layout')

@section('title', (isset($articulo) && $articulo->titulo ? $articulo->titulo : 'Artículo') . ' - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        @if (isset($articulo) && $articulo)
            <article class="articulo-detalle bg-white p-4 p-md-5 shadow-sm rounded border">

                <h1 class="display-5 mb-3">{{ $articulo->titulo }}</h1>
                {{-- ... (metadatos, imagen, contenido) ... --}}
                <div class="mb-4 text-muted border-bottom pb-3">
                    @if ($articulo->seccion)
                        <span class="badge bg-success text-dark me-2">{{ $articulo->seccion->nombreSeccion }}</span> |
                    @endif
                    @if ($articulo->categoria)
                        <span class="badge bg-info text-dark me-2">{{ $articulo->categoria }}</span> |
                    @endif
                    @if ($articulo->autor)
                        <i class="fas fa-user me-1"></i> Por: {{ $articulo->autor->nombre }} |
                    @else
                        <i class="fas fa-user-slash me-1"></i> Autor desconocido |
                    @endif
                    <i class="fas fa-calendar-alt me-1"></i> Publicado:
                    @php
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
                            }
                        }
                        echo $fecha;
                    @endphp
                </div>

                <div class="text-center mb-4">
                    @if ($articulo->imagenUrl)
                        <img src="{{ Storage::disk('public')->url($articulo->imagenUrl) }}"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}" class="img-fluid rounded shadow-sm"
                            style="max-height: 500px; width: auto; background-color: #eee;">
                    @else
                        <img src="{{ asset('assets/img/Logo1.jpeg') }}"
                            alt="{{ $articulo->titulo ?? 'Imagen por defecto' }}" class="img-fluid rounded shadow-sm"
                            style="max-height: 500px; width: auto; background-color: #eee;">
                    @endif
                </div>

                @if ($articulo->descripcion)
                    <p class="lead fst-italic mb-4">{{ $articulo->descripcion }}</p>
                @endif

                <div class="articulo-contenido">
                    {!! $articulo->contenido !!}
                </div>

                <div class="mt-4 pt-3 border-top">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>

                    @auth
                        @php
                            $updateResponse = Gate::inspect('update-articulo', $articulo);
                            $deleteResponse = Gate::inspect('delete-articulo', $articulo);
                        @endphp

                        @if ($updateResponse->allowed())
                            <a href="{{ route('articulos.edit', $articulo->idArticulo) }}"
                                class="btn btn-outline-primary btn-sm ms-2">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                        @endif

                        @if ($deleteResponse->allowed())
                            <form action="{{ route('articulos.destroy', $articulo->idArticulo) }}" method="POST"
                                class="d-inline ms-2"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este artículo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </article>
        @else
            <p class="text-center">Artículo no encontrado.</p>
        @endif
    </div>
@endsection

@section('styles')
    {{-- estilos aquí --}}
    <style>
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

        .articulo-detalle .articulo-contenido p {
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }

        .articulo-detalle .articulo-contenido ul,
        .articulo-detalle .articulo-contenido ol {
            padding-left: 2rem;
            margin-bottom: 1.25rem;
        }
    </style>
@endsection
