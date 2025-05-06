@extends('layouts.layout')

@section('title', 'El Faro - Inicio')

@section('content')

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
            {{-- Primer item del carrusel --}}
            @isset($noticiasNacionales[0])
                @php
                    $item1 = $noticiasNacionales[0];
                    if ($item1->imagenUrl && Str::contains($item1->imagenUrl, '/')) {
                        $carouselImgPath1 = asset('storage/' . $item1->imagenUrl);
                    } elseif ($item1->imagenUrl) {
                        $carouselImgPath1 = asset('assets/img/' . $item1->imagenUrl);
                    } else {
                        $carouselImgPath1 = asset('assets/img/placeholder.jpg');
                    }
                @endphp
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="{{ $carouselImgPath1 }}" class="d-block w-100" alt="{{ $item1->imagenAlt ?? $item1->titulo }}"
                        style="max-height: 500px; object-fit: cover; background-color: #eee;" />
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5>{{ $item1->titulo }}</h5>
                        <p>{{ Str::limit($item1->descripcion, 100) }}</p>
                        {{-- Enlace corregido usando el ID --}}
                        <a href="{{ route('articulo.detalle', ['articulo' => $item1->idArticulo]) }}"
                            class="btn btn-primary btn-sm">Leer más</a>
                    </div>
                </div>
            @endisset

            {{-- Segundo item del carrusel --}}
            @isset($noticiasNacionales[1])
                @php
                    $item2 = $noticiasNacionales[1];
                    if ($item2->imagenUrl && Str::contains($item2->imagenUrl, '/')) {
                        $carouselImgPath2 = asset('storage/' . $item2->imagenUrl);
                    } elseif ($item2->imagenUrl) {
                        $carouselImgPath2 = asset('assets/img/' . $item2->imagenUrl);
                    } else {
                        $carouselImgPath2 = asset('assets/img/placeholder.jpg');
                    }
                @endphp
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="{{ $carouselImgPath2 }}" class="d-block w-100" alt="{{ $item2->imagenAlt ?? $item2->titulo }}"
                        style="max-height: 500px; object-fit: cover; background-color: #eee;" />
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5>{{ $item2->titulo }}</h5>
                        <p>{{ Str::limit($item2->descripcion, 100) }}</p>
                        {{-- Enlace corregido usando el ID --}}
                        <a href="{{ route('articulo.detalle', ['articulo' => $item2->idArticulo]) }}"
                            class="btn btn-primary btn-sm">Leer más</a>
                    </div>
                </div>
            @endisset

            {{-- Tercer item del carrusel --}}
            @isset($noticiasTecnologia[0])
                @php
                    $item3 = $noticiasTecnologia[0];
                    if ($item3->imagenUrl && Str::contains($item3->imagenUrl, '/')) {
                        $carouselImgPath3 = asset('storage/' . $item3->imagenUrl);
                    } elseif ($item3->imagenUrl) {
                        $carouselImgPath3 = asset('assets/img/' . $item3->imagenUrl);
                    } else {
                        $carouselImgPath3 = asset('assets/img/placeholder.jpg');
                    }
                @endphp
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="{{ $carouselImgPath3 }}" class="d-block w-100" alt="{{ $item3->imagenAlt ?? $item3->titulo }}"
                        style="max-height: 500px; object-fit: cover; background-color: #eee;" />
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5>{{ $item3->titulo }}</h5>
                        <p>{{ Str::limit($item3->descripcion, 100) }}</p>
                        {{-- Enlace corregido usando el ID --}}
                        <a href="{{ route('articulo.detalle', ['articulo' => $item3->idArticulo]) }}"
                            class="btn btn-primary btn-sm">Leer más</a>
                    </div>
                </div>
            @endisset
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselNoticias" data-bs-slide="prev"> <span
                class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselNoticias" data-bs-slide="next"> <span
                class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Siguiente</span>
        </button>
    </section>
    <section id="contacto" class="mb-5 p-4 bg-light rounded shadow-sm border">
        {{-- ... (Código Form Contacto sin cambios) ... --}}
        <div class="text-center"> <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseContacto"
                aria-expanded="{{ $errors->hasAny(['name', 'email', 'message']) ? 'true' : 'false' }}"
                aria-controls="collapseContacto"> <i class="fas fa-envelope me-1"></i> Contáctanos / Ocultar Formulario
            </button> </div>
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
                            </ul> <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <form id="formulario-contacto" method="POST" action="{{ route('contacto.enviar') }}"> @csrf <div
                            class="mb-3"> <label for="contact-name" class="form-label">Nombre:</label> <input
                                id="contact-name" name="name" type="text"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                placeholder="Tu Nombre" value="{{ old('name') }}" required> @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3"> <label for="contact-email" class="form-label">Email:</label> <input
                                id="contact-email" name="email" type="email"
                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                placeholder="tu@email.com" value="{{ old('email') }}" required> @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3"> <label for="contact-message" class="form-label">Mensaje:</label>
                            <textarea id="contact-message" name="message"
                                class="form-control form-control-sm @error('message') is-invalid @enderror" rows="3"
                                placeholder="Escribe tu mensaje aquí" required>{{ old('message') }}</textarea> @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end"> <button type="submit"
                                class="btn btn-primary btn-sm">Enviar Mensaje</button> </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section id="general" class="articles-section mb-5">
        <h2 class="border-bottom pb-2 mb-4">
            Noticias Generales
            <span id="general-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['general']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['general']->articulos_count ?? 0) !== 1 ? 's' : '' }} </span>
        </h2>
        <div class="row g-4" id="general-articles-container">
            @forelse ($noticiasGenerales as $index => $articulo)
                @php
                    $columnClasses = $index == 0 ? 'col-md-6 col-lg-8' : 'col-md-6 col-lg-4';
                    $imgHeight = $index == 0 ? '280px' : '180px';
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
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
                                class="badge bg-primary mb-2 align-self-start">{{ $articulo->categoria ?? 'General' }}</span>
                            <p class="card-text small flex-grow-1">{{ $articulo->descripcion }}</p>
                            <div class="mt-auto text-end">
                                {{-- Enlace corregido usando el ID del artículo --}}
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
    <section id="nacional" class="articles-section my-5 bg-light p-4 rounded border">
        <h2 class="border-bottom pb-2 mb-4">
            Nacional (Chile)
            <span id="nacional-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['nacional']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['nacional']->articulos_count ?? 0) !== 1 ? 's' : '' }} </span>
        </h2>
        <div class="row g-4" id="nacional-articles-container">
            @forelse ($noticiasNacionales as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
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
                            <p class="card-text small flex-grow-1">{{ $articulo->descripcion }}</p>
                            <div class="mt-auto text-end">
                                {{-- Enlace corregido usando el ID del artículo --}}
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
    <section id="tecnologia" class="articles-section my-5">
        <h2 class="border-bottom pb-2 mb-4">
            Tecnología
            <span id="tecnologia-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['tecnologia']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['tecnologia']->articulos_count ?? 0) !== 1 ? 's' : '' }} </span>
        </h2>
        <div class="row g-4" id="tecnologia-articles-container">
            @forelse ($noticiasTecnologia as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
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
                            <p class="card-text small flex-grow-1">{{ $articulo->descripcion }}</p>
                            <div class="mt-auto text-end">
                                {{-- Enlace corregido usando el ID del artículo --}}
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
    <section id="multimedia" class="multimedia my-5 p-4 bg-light rounded border">
        <h2 class="text-center mb-4">Multimedia Destacada</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-2 text-center small">GUERRA | Rusia y Ucrania pactan alto el fuego</h5>
                <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden"> <iframe
                        src="https://www.youtube.com/embed/gR9w9xLrz6E?si=25pFWIGxuC1u29oN"
                        title="YouTube video player: GUERRA | Rusia y Ucrania pactan alto el fuego" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-2 text-center small">LORENZO RAMÍREZ: Plan de EEUU para aislar a China</h5>
                <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden"> <iframe
                        src="https://www.youtube.com/embed/Q2v7iXdbZYQ?si=wC-9lfQvzqcz0Q3t"
                        title="YouTube video player: LORENZO RAMÍREZ: Plan de EEUU para aislar a China" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="mb-2 text-center small">Delincuentes roban bicicletas en Providencia</h5>
                <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden"> <iframe
                        src="https://www.youtube.com/embed/3K9tXzOwAwQ?si=Y5iCvI2VVo7yWTrX"
                        title="YouTube video player: Delincuentes roban bicicletas en Providencia" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </div>
            </div>
        </div>
    </section>
    <section id="podcast" class="podcast my-5 text-center">
        <img src="{{ asset('assets/img/podcastimages.jpg') }}" width="100"
            alt="Micrófono y auriculares: logo podcast" class="mb-2 rounded-circle" />
        <h3 class="h5">Podcast: El rol de la ciencia en la era de las fake news</h3> <audio controls
            class="mt-2 w-75">
            <source src="{{ asset('assets/al/Cap. 1 .mp3') }}" type="audio/mpeg"> Tu navegador no soporta reproducción de
            audio.
        </audio>
    </section>
    <section id="deportes" class="articles-section my-5">
        <h2 class="border-bottom pb-2 mb-4">
            Deportes
            <span id="deportes-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['deportes']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['deportes']->articulos_count ?? 0) !== 1 ? 's' : '' }} </span>
        </h2>
        <div class="row g-4" id="deportes-articles-container">
            @forelse ($noticiasDeportes as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
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
                            <p class="card-text small flex-grow-1">{{ $articulo->descripcion }}</p>
                            <div class="mt-auto text-end">
                                {{-- Enlace corregido usando el ID del artículo --}}
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
    <section id="negocios" class="articles-section my-5 bg-light p-4 rounded border">
        <h2 class="border-bottom pb-2 mb-4">
            Negocios y Emprendimiento
            <span id="negocios-articles-number" class="badge bg-secondary fw-normal">
                {{ $seccionesCompletas['negocios']->articulos_count ?? 0 }}
                articulo{{ ($seccionesCompletas['negocios']->articulos_count ?? 0) !== 1 ? 's' : '' }} </span>
        </h2>
        <div class="row g-4" id="negocios-articles-container">
            @forelse ($noticiasNegocios as $index => $articulo)
                @php
                    $columnClasses = 'col-md-4';
                    $imgHeight = '180px';
                    if ($articulo->imagenUrl && Str::contains($articulo->imagenUrl, '/')) {
                        $imgPath = asset('storage/' . $articulo->imagenUrl);
                    } elseif ($articulo->imagenUrl) {
                        $imgPath = asset('assets/img/' . $articulo->imagenUrl);
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
                            <p class="card-text small flex-grow-1">{{ $articulo->descripcion }}</p>
                            <div class="mt-auto text-end">
                                {{-- Enlace corregido usando el ID del artículo --}}
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
    @auth
        <section id="nueva-noticia" class="my-5 p-4 bg-light rounded shadow-sm border">
            {{-- ... (Código Form Agregar Noticia sin cambios) ... --}}
            <div class="text-center mb-4"> <button class="btn btn-success" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNuevaNoticia"
                    aria-expanded="{{ $errors->hasAny(['section', 'category', 'title', 'description', 'imagen', 'contenido']) ? 'true' : 'false' }}"
                    aria-controls="collapseNuevaNoticia"> <i class="fas fa-plus me-1"></i> Agregar Nueva Noticia / Ocultar
                </button> </div>
            <div class="collapse {{ $errors->hasAny(['section', 'category', 'title', 'description', 'imagen', 'contenido']) ? 'show' : '' }}"
                id="collapseNuevaNoticia">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        @if ($errors->any() && $errors->hasAny(['section', 'category', 'title', 'description', 'imagen', 'contenido']))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Por favor
                                    corrige los siguientes errores:</strong>
                                <ul>
                                    @foreach ($errors->only(['section', 'category', 'title', 'description', 'imagen', 'contenido']) as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul> <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form id="formulario-nueva-noticia" class="row g-3" method="POST"
                            action="{{ route('articulo.store') }}" enctype="multipart/form-data"> @csrf <div
                                class="col-md-6"> <label for="news-section" class="form-label">Sección:</label> <select
                                    id="news-section" name="section"
                                    class="form-select @error('section') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('section') ? '' : 'selected' }}>-- Selecciona una
                                        Sección --</option> @isset($secciones)
                                        @foreach ($secciones as $seccion)
                                            <option value="{{ $seccion->idSeccion }}"
                                                {{ old('section') == $seccion->idSeccion ? 'selected' : '' }}>
                                                {{ $seccion->nombreSeccion }} </option>
                                        @endforeach
                                    @endisset
                                </select> @error('section')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6"> <label for="news-category" class="form-label">Categoría
                                    (Opcional):</label> <input id="news-category" name="category" type="text"
                                    class="form-control @error('category') is-invalid @enderror"
                                    placeholder="Ej: Política, IA, Fútbol" value="{{ old('category') }}"> @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12"> <label for="news-title" class="form-label">Título:</label> <input
                                    id="news-title" name="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Título de la noticia" value="{{ old('title') }}" required> @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12"> <label for="news-description" class="form-label">Descripción Breve:</label>
                                <textarea id="news-description" name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Descripción breve que aparecerá en la tarjeta y al inicio del artículo" required>{{ old('description') }}</textarea> @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12"> <label for="news-contenido" class="form-label">Contenido Completo
                                    (Opcional):</label>
                                <textarea id="news-contenido" name="contenido" class="form-control @error('contenido') is-invalid @enderror"
                                    rows="6"
                                    placeholder="Escribe aquí el cuerpo completo de la noticia. Puedes usar HTML básico (ej: <p>, <ul>, <h3>).">{{ old('contenido') }}</textarea> @error('contenido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12"> <label for="news-imagen" class="form-label">Imagen de Portada
                                    (Opcional):</label> <input class="form-control @error('imagen') is-invalid @enderror"
                                    type="file" id="news-imagen" name="imagen"
                                    accept="image/jpeg,image/png,image/gif,image/webp"> @error('imagen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror <div id="imagenHelp" class="form-text">Sube una imagen (JPG, PNG, GIF, WEBP). Máx
                                    2MB.</div>
                            </div>
                            <div class="col-12 text-end"> <button type="submit" class="btn btn-success"> <i
                                        class="fas fa-save me-1"></i> Guardar Noticia </button> </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endauth
@endsection

@section('scripts')
    {{-- Scripts específicos si fueran necesarios --}}
@endsection
