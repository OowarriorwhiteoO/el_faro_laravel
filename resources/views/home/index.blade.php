@extends('layouts.layout')

@section('title', 'El Faro - Inicio')

@section('content')

    {{-- Carrusel de Noticias Destacadas --}}
    <section id="carouselNoticias" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @if (isset($noticiasNacionales) && $noticiasNacionales->count() > 0)
                @foreach ($noticiasNacionales->take(3) as $index => $articulo)
                    <button type="button" data-bs-target="#carouselNoticias" data-bs-slide-to="{{ $index }}"
                        class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="Noticia {{ $index + 1 }}"></button>
                @endforeach
            @endif
        </div>
        <div class="carousel-inner">
            @php
                // Asegura que $noticiasNacionales sea una colección para el carrusel
                $carouselItems =
                    isset($noticiasNacionales) && $noticiasNacionales instanceof \Illuminate\Support\Collection
                        ? $noticiasNacionales
                        : collect();
            @endphp
            @if ($carouselItems->count() > 0)
                @foreach ($carouselItems->take(3) as $index => $item)
                    @php
                        // Determina la ruta de la imagen para el carrusel, usando un placeholder si no hay imagen
                        if ($item->imagenUrl) {
                            $carouselImgPath = Storage::disk('public')->url($item->imagenUrl);
                        } else {
                            $carouselImgPath = asset('assets/img/placeholder.jpg'); // Placeholder genérico
                        }
                    @endphp
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="3000">
                        <img src="{{ $carouselImgPath }}" class="d-block w-100"
                            alt="{{ $item->imagenAlt ?? $item->titulo }}"
                            style="max-height: 500px; object-fit: cover; background-color: #eee;" />
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                            <h5>{{ $item->titulo }}</h5>
                            <p>{{ Str::limit($item->descripcion, 100) }}</p>
                            @if ($item->autor)
                                <p class="small mb-0" style="font-size: 0.8em;"><i
                                        class="fas fa-user fa-sm me-1"></i>{{ $item->autor->nombre }}</p>
                            @endif
                            <a href="{{ route('articulo.detalle', ['articulo' => $item->idArticulo]) }}"
                                class="btn btn-primary btn-sm mt-1">Leer más</a>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Slide por defecto si no hay noticias para el carrusel --}}
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="{{ asset('assets/img/placeholder.jpg') }}" class="d-block w-100" alt="Noticia Destacada"
                        style="max-height: 500px; object-fit: cover; background-color: #eee;" />
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5>Bienvenido a El Faro</h5>
                        <p>Las últimas noticias directamente para ti.</p>
                    </div>
                </div>
            @endif
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselNoticias" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselNoticias" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </section>

    {{-- Sección Formulario de Contacto --}}
    <section id="contacto" class="mb-5 p-4 bg-light rounded shadow-sm border">
        <div class="text-center">
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseContacto"
                aria-expanded="{{ $errors->hasAny(['name', 'email', 'message']) ? 'true' : 'false' }}"
                aria-controls="collapseContacto">
                <i class="fas fa-envelope me-1"></i> Contáctanos / Ocultar Formulario
            </button>
        </div>
        <div class="collapse mt-4 {{ $errors->hasAny(['name', 'email', 'message']) ? 'show' : '' }}" id="collapseContacto">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    @if ($errors->any() && $errors->hasAny(['name', 'email', 'message']))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">Por favor corrige los siguientes errores:</h5>
                            <ul>
                                @foreach ($errors->only(['name', 'email', 'message']) as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form id="formulario-contacto" method="POST" action="{{ route('contacto.enviar') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="contact-name" class="form-label">Nombre:</label>
                            <input id="contact-name" name="name" type="text"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                placeholder="Tu Nombre" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact-email" class="form-label">Email:</label>
                            <input id="contact-email" name="email" type="email"
                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                placeholder="tu@email.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact-message" class="form-label">Mensaje:</label>
                            <textarea id="contact-message" name="message"
                                class="form-control form-control-sm @error('message') is-invalid @enderror" rows="3"
                                placeholder="Escribe tu mensaje aquí" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-sm">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Sección Noticias Generales --}}
    <section id="general" class="articles-section mb-5">
        <h2 class="border-bottom pb-2 mb-4">
            Noticias Generales
            <span id="general-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['general']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['general']->articulos_count ?? 0) !== 1 ? 's' : '' }}
            </span>
        </h2>
        <div class="row g-4" id="general-articles-container">
            @forelse ($noticiasGenerales as $index => $articulo)
                @php
                    // Clases de columna y altura de imagen dinámicas para la primera noticia
                    $columnClasses = $index == 0 ? 'col-md-6 col-lg-8' : 'col-md-6 col-lg-4';
                    $imgHeight = $index == 0 ? '280px' : '180px';
                    if ($articulo->imagenUrl) {
                        $imgPath = Storage::disk('public')->url($articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg'); // Placeholder específico del proyecto
                    }
                @endphp
                <div class="{{ $columnClasses }} mb-4">
                    <div class="card news-card h-100 shadow-sm overflow-hidden">
                        <img src="{{ $imgPath }}" class="card-img-top"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                            style="height: {{ $imgHeight }}; object-fit: cover; background-color: #eee;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6">{{ $articulo->titulo }}</h5>
                            <span
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'General' }}</span>
                            @if ($articulo->autor)
                                <p class="card-text small text-muted mb-1">
                                    <i class="fas fa-user fa-sm me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif
                            <p class="card-text small flex-grow-1">{{ Str::limit($articulo->descripcion, 70) }}</p>
                            <div class="mt-auto text-end">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                                    class="btn btn-outline-primary btn-sm">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic">No hay noticias generales disponibles.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('seccion.mostrar', 'general') }}" class="btn btn-outline-primary">Ver todas las Noticias
                Generales</a>
        </div>
    </section>

    {{-- Sección Nacional --}}
    <section id="nacional" class="articles-section my-5 bg-light p-4 rounded border">
        <h2 class="border-bottom pb-2 mb-4">
            Nacional (Chile)
            <span id="nacional-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['nacional']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['nacional']->articulos_count ?? 0) !== 1 ? 's' : '' }}
            </span>
        </h2>
        <div class="row g-4" id="nacional-articles-container">
            @forelse ($noticiasNacionales as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4'; // Columnas estándar para esta sección
                    $imgHeight = '180px'; // Altura de imagen estándar
                    if ($articulo->imagenUrl) {
                        $imgPath = Storage::disk('public')->url($articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg');
                    }
                @endphp
                <div class="{{ $columnClasses }} mb-4">
                    <div class="card news-card h-100 shadow-sm overflow-hidden">
                        <img src="{{ $imgPath }}" class="card-img-top"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                            style="height: {{ $imgHeight }}; object-fit: cover; background-color: #eee;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6">{{ $articulo->titulo }}</h5>
                            <span
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'Nacional' }}</span>
                            @if ($articulo->autor)
                                <p class="card-text small text-muted mb-1">
                                    <i class="fas fa-user fa-sm me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif
                            <p class="card-text small flex-grow-1">{{ Str::limit($articulo->descripcion, 70) }}</p>
                            <div class="mt-auto text-end">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                                    class="btn btn-outline-primary btn-sm">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic">No hay noticias nacionales disponibles.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('seccion.mostrar', 'nacional') }}" class="btn btn-outline-primary">Ver todas las Noticias
                Nacionales</a>
        </div>
    </section>

    {{-- Sección Tecnología --}}
    <section id="tecnologia" class="articles-section my-5">
        <h2 class="border-bottom pb-2 mb-4">
            Tecnología
            <span id="tecnologia-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['tecnologia']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['tecnologia']->articulos_count ?? 0) !== 1 ? 's' : '' }}
            </span>
        </h2>
        <div class="row g-4" id="tecnologia-articles-container">
            @forelse ($noticiasTecnologia as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl) {
                        $imgPath = Storage::disk('public')->url($articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg');
                    }
                @endphp
                <div class="{{ $columnClasses }} mb-4">
                    <div class="card news-card h-100 shadow-sm overflow-hidden">
                        <img src="{{ $imgPath }}" class="card-img-top"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                            style="height: {{ $imgHeight }}; object-fit: cover; background-color: #eee;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6">{{ $articulo->titulo }}</h5>
                            <span
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'Tecnología' }}</span>
                            @if ($articulo->autor)
                                <p class="card-text small text-muted mb-1">
                                    <i class="fas fa-user fa-sm me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif
                            <p class="card-text small flex-grow-1">{{ Str::limit($articulo->descripcion, 70) }}</p>
                            <div class="mt-auto text-end">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                                    class="btn btn-outline-primary btn-sm">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic">No hay noticias de tecnología disponibles.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('seccion.mostrar', 'tecnologia') }}" class="btn btn-outline-primary">Ver todas las Noticias
                de Tecnología</a>
        </div>
    </section>

    {{-- SECCIÓN MULTIMEDIA ELIMINADA DE AQUÍ --}}
    {{-- SECCIÓN PODCAST ELIMINADA DE AQUÍ --}}

    {{-- Sección Deportes --}}
    <section id="deportes" class="articles-section my-5">
        <h2 class="border-bottom pb-2 mb-4">
            Deportes
            <span id="deportes-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['deportes']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['deportes']->articulos_count ?? 0) !== 1 ? 's' : '' }}
            </span>
        </h2>
        <div class="row g-4" id="deportes-articles-container">
            @forelse ($noticiasDeportes as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl) {
                        $imgPath = Storage::disk('public')->url($articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg');
                    }
                @endphp
                <div class="{{ $columnClasses }} mb-4">
                    <div class="card news-card h-100 shadow-sm overflow-hidden">
                        <img src="{{ $imgPath }}" class="card-img-top"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                            style="height: {{ $imgHeight }}; object-fit: cover; background-color: #eee;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6">{{ $articulo->titulo }}</h5>
                            <span
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'Deportes' }}</span>
                            @if ($articulo->autor)
                                <p class="card-text small text-muted mb-1">
                                    <i class="fas fa-user fa-sm me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif
                            <p class="card-text small flex-grow-1">{{ Str::limit($articulo->descripcion, 70) }}</p>
                            <div class="mt-auto text-end">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                                    class="btn btn-outline-primary btn-sm">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic">No hay noticias de deportes disponibles.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('seccion.mostrar', 'deportes') }}" class="btn btn-outline-primary">Ver todas las Noticias
                de Deportes</a>
        </div>
    </section>

    {{-- Sección Negocios --}}
    <section id="negocios" class="articles-section my-5 bg-light p-4 rounded border">
        <h2 class="border-bottom pb-2 mb-4">
            Negocios y Emprendimiento
            <span id="negocios-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['negocios']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['negocios']->articulos_count ?? 0) !== 1 ? 's' : '' }}
            </span>
        </h2>
        <div class="row g-4" id="negocios-articles-container">
            @forelse ($noticiasNegocios as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl) {
                        $imgPath = Storage::disk('public')->url($articulo->imagenUrl);
                    } else {
                        $imgPath = asset('assets/img/Logo1.jpeg');
                    }
                @endphp
                <div class="{{ $columnClasses }} mb-4">
                    <div class="card news-card h-100 shadow-sm overflow-hidden">
                        <img src="{{ $imgPath }}" class="card-img-top"
                            alt="{{ $articulo->imagenAlt ?? $articulo->titulo }}"
                            style="height: {{ $imgHeight }}; object-fit: cover; background-color: #eee;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6">{{ $articulo->titulo }}</h5>
                            <span
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'Negocios' }}</span>
                            @if ($articulo->autor)
                                <p class="card-text small text-muted mb-1">
                                    <i class="fas fa-user fa-sm me-1"></i>{{ $articulo->autor->nombre }}
                                </p>
                            @endif
                            <p class="card-text small flex-grow-1">{{ Str::limit($articulo->descripcion, 70) }}</p>
                            <div class="mt-auto text-end">
                                <a href="{{ route('articulo.detalle', ['articulo' => $articulo->idArticulo]) }}"
                                    class="btn btn-outline-primary btn-sm">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted fst-italic">No hay noticias de negocios disponibles.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('seccion.mostrar', 'negocios') }}" class="btn btn-outline-primary">Ver todas las Noticias
                de Negocios</a>
        </div>
    </section>

    {{-- Sección para agregar nueva noticia (solo para usuarios autenticados) --}}
    @auth
        <section id="nueva-noticia" class="my-5 p-4 bg-light rounded shadow-sm border">
            <div class="text-center mb-4">
                <button class="btn btn-success" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNuevaNoticia"
                    aria-expanded="{{ $errors->hasAny(['idSeccion', 'categoria', 'titulo', 'descripcion', 'imagenUrl', 'contenido', 'imagenAlt', 'fechaPublicacion']) ? 'true' : 'false' }}"
                    aria-controls="collapseNuevaNoticia">
                    <i class="fas fa-plus me-1"></i> Agregar Nueva Noticia / Ocultar
                </button>
            </div>
            <div class="collapse {{ $errors->hasAny(['idSeccion', 'categoria', 'titulo', 'descripcion', 'imagenUrl', 'contenido', 'imagenAlt', 'fechaPublicacion']) ? 'show' : '' }}"
                id="collapseNuevaNoticia">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        @if (
                            $errors->any() &&
                                $errors->hasAny([
                                    'idSeccion',
                                    'categoria',
                                    'titulo',
                                    'descripcion',
                                    'imagenUrl',
                                    'contenido',
                                    'imagenAlt',
                                    'fechaPublicacion',
                                ]))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Por favor corrige los siguientes errores:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form id="formulario-nueva-noticia" class="row g-3" method="POST"
                            action="{{ route('articulo.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="news-section" class="form-label">Sección:</label>
                                <select id="news-section" name="idSeccion"
                                    class="form-select @error('idSeccion') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('idSeccion') ? '' : 'selected' }}>-- Selecciona una
                                        Sección --</option>
                                    @isset($secciones)
                                        @foreach ($secciones as $seccion)
                                            <option value="{{ $seccion->idSeccion }}"
                                                {{ old('idSeccion') == $seccion->idSeccion ? 'selected' : '' }}>
                                                {{ $seccion->nombreSeccion }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('idSeccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="news-category" class="form-label">Categoría (Opcional):</label>
                                <input id="news-category" name="categoria" type="text"
                                    class="form-control @error('categoria') is-invalid @enderror"
                                    placeholder="Ej: Política, IA, Fútbol" value="{{ old('categoria') }}">
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="news-title" class="form-label">Título:</label>
                                <input id="news-title" name="titulo" type="text"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    placeholder="Título de la noticia" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="news-description" class="form-label">Descripción Breve:</label>
                                <textarea id="news-description" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                    rows="3" placeholder="Descripción breve que aparecerá en la tarjeta y al inicio del artículo" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="news-contenido" class="form-label">Contenido Completo (Opcional):</label>
                                <textarea id="news-contenido" name="contenido" class="form-control @error('contenido') is-invalid @enderror"
                                    rows="6" placeholder="Escribe aquí el cuerpo completo de la noticia.">{{ old('contenido') }}</textarea>
                                @error('contenido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="news-imagen" class="form-label">Imagen de Portada (Opcional):</label>
                                <input class="form-control @error('imagenUrl') is-invalid @enderror" type="file"
                                    id="news-imagen" name="imagenUrl" accept="image/jpeg,image/png,image/gif,image/webp">
                                @error('imagenUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="imagenHelp" class="form-text">Sube una imagen (JPG, PNG, GIF, WEBP). Máx 4MB.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="news-imagenAlt" class="form-label">Texto Alternativo Imagen (Opcional):</label>
                                <input id="news-imagenAlt" name="imagenAlt" type="text"
                                    class="form-control @error('imagenAlt') is-invalid @enderror"
                                    placeholder="Descripción breve de la imagen" value="{{ old('imagenAlt') }}">
                                @error('imagenAlt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="news-fechaPublicacion" class="form-label">Fecha de Publicación (Opcional):</label>
                                <input id="news-fechaPublicacion" name="fechaPublicacion" type="date"
                                    class="form-control @error('fechaPublicacion') is-invalid @enderror"
                                    value="{{ old('fechaPublicacion', date('Y-m-d')) }}">
                                @error('fechaPublicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Guardar Noticia
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endauth
@endsection

@section('scripts')
    {{-- Scripts específicos para la página de inicio si fueran necesarios en el futuro --}}
@endsection
