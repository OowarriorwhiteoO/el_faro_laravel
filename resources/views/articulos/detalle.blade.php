@extends('layouts.layout')

@section('title', $articulo->titulo . ' - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        <article class="articulo-detalle bg-white p-4 p-md-5 shadow-sm rounded border">

            <h1 class="display-5 mb-3">{{ $articulo->titulo }}</h1>

            <div class="mb-4 text-muted border-bottom pb-3">
                @if ($articulo->categoria)
                    <span class="badge bg-info text-dark me-2">{{ $articulo->categoria }}</span> |
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
                @php
                    // Determina la ruta correcta de la imagen
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg');
                    }
                @endphp
                <img src="{{ $imgPath }}" alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                    class="img-fluid rounded shadow-sm" style="max-height: 500px; width: auto; background-color: #eee;">
            </div>


            @if ($articulo->descripcion)
                <p class="lead fst-italic mb-4">{{ $articulo->descripcion }}</p>
            @endif

            <div class="articulo-contenido">
                {!! $articulo->contenido !!}
            </div>

        </article>
    </div>
@endsection

@section('styles')
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
