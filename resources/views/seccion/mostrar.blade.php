@extends('layouts.layout')

@section('title', 'El Faro - ' . $tituloSeccion)

@section('content')
    <div class="container mt-4 mb-5">
        <h1 class="h3 mb-4 text-center">
            {{ $tituloSeccion }}
<<<<<<< HEAD
            {{-- CORRECCIÓN AQUÍ: Usar count() en lugar de total() --}}
=======
            {{-- Usar count() en lugar de total() --}}
>>>>>>> 9f99c68cadc2b1654bfd2fb3d45946636c0b8260
            <span class="badge bg-secondary fw-normal">{{ $articulos->count() }}
                articulo{{ $articulos->count() !== 1 ? 's' : '' }}</span>
        </h1>

        <div id="articles-container-{{ $slugSeccion }}" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse ($articulos as $articulo)
                @php
                    $fecha = 'Fecha no disponible';
                    if (!empty($articulo->fechaPublicacion)) {
                        try {
                            // Asegurarse que fechaPublicacion sea un objeto Carbon si viene del SP como string
                            $fechaPublicacionObj =
                                $articulo->fechaPublicacion instanceof \Carbon\Carbon
                                    ? $articulo->fechaPublicacion
                                    : \Carbon\Carbon::parse($articulo->fechaPublicacion);
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
                                "Fecha inválida para artículo ID {$articulo->idArticulo}: " .
                                    $articulo->fechaPublicacion,
                            );
                        }
                    }

                    // Para el nombre del autor, el SP ya lo devuelve como 'nombreAutor'
                    $nombreDelAutor = $articulo->nombreAutor ?? null;
                @endphp

                <div class="col">
                    <article id="article-{{ $slugSeccion }}-{{ $articulo->idArticulo ?? $loop->index }}"
                        class="card h-100 shadow-sm article-card">
                        @if ($articulo->imagenUrl)
                            <img src="{{ Storage::disk('public')->url($articulo->imagenUrl) }}"
                                class="card-img-top article-image" alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}">
                        @else
                            <img src="{{ asset('assets/img/Logo1.jpeg') }}" class="card-img-top article-image"
                                alt="Imagen no disponible">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                {{-- Asumiendo que idArticulo está presente en los datos del SP --}}
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo ?? 0]) }}"
                                    class="text-decoration-none stretched-link">
                                    {{ $articulo->titulo }}
                                </a>
                            </h5>
                            <p class="card-text small text-muted mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $fecha }}
                                @if (!empty($articulo->categoria))
                                    | <span class="badge bg-info text-dark">{{ $articulo->categoria }}</span>
                                @endif
                            </p>
                            {{-- MOSTRAR AUTOR AQUÍ (usando la columna nombreAutor del SP) --}}
                            @if ($nombreDelAutor)
                                <p class="card-text small text-muted mb-1"><i
                                        class="fas fa-user fa-sm me-1"></i>{{ $nombreDelAutor }}</p>
                            @else
                                {{-- Opcional: si quieres mostrar algo si no hay autor --}}
                                {{-- <p class="card-text small text-muted mb-1"><i class="fas fa-user-slash fa-sm me-1"></i>Autor no disponible</p> --}}
                            @endif
                            <p class="card-text flex-grow-1">{{ Str::limit($articulo->descripcion, 100) }}</p>
                            {{-- Asumiendo que idArticulo está presente en los datos del SP --}}
                            <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo ?? 0]) }}"
                                class="btn btn-primary btn-sm mt-auto align-self-start">Leer Más</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic mt-5">No hay artículos disponibles en esta sección.</p>
                </div>
            @endforelse
        </div>

        {{-- La paginación estándar de Laravel no funcionará directamente aquí con DB::select() --}}
        {{-- Si usaste la paginación manual en el controlador, aquí llamarías a $articulosPaginados->links() --}}
        {{-- Por ahora, como no implementamos paginación manual en el controlador para DB::select, comentamos esto:
        <div class="mt-4 d-flex justify-content-center">
            {{ $articulos->links() }}
        </div>
        --}}
    </div>
@endsection

@section('styles')
    <style>
        .article-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
