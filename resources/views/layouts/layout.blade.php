<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'El Faro - Noticias')</title>

    {{-- Framework Bootstrap CSS (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Font Awesome para iconos (CDN) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Hoja de estilos personalizada (desde la carpeta public/css) --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @yield('styles')
</head>

<body>

    {{-- ======================= ENCABEZADO ======================= --}}
    <header class="container-fluid bg-light pt-2 shadow-sm">
        {{-- ... (Reloj, Logo, Título sin cambios) ... --}}
        <div class="container text-end small"> <i class="fas fa-clock me-1"></i><label id="label-time">Cargando
                hora...</label> </div>
        <div class="container text-center py-3"> <a href="{{ route('home') }}"> <img
                    src="{{ asset('assets/img/Logo1.jpeg') }}" width="150"
                    alt="Logo de El Faro: faro sobre acantilado" class="logo img-fluid mb-2" /> </a>
            <h1 id="titulo" class="display-4">Periódico "El Faro"</h1>
        </div>

        {{-- Barra de Navegación Principal --}}
        <nav class="navbar navbar-expand-lg bg-body-tertiary border-top border-bottom">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    {{-- Menú Principal Izquierdo (sin cambios) --}}
                    <ul class="navbar-nav nav-pills">
                        <li class="nav-item"> <a class="nav-link {{ Request::is('/') ? 'active' : '' }}"
                                href="{{ route('home') }}">Inicio</a> </li>
                        <li class="nav-item"> <a class="nav-link {{ Request::is('seccion/general') ? 'active' : '' }}"
                                href="{{ route('seccion.mostrar', 'general') }}">Noticias</a> </li>
                        <li class="nav-item"> <a class="nav-link {{ Request::is('seccion/nacional') ? 'active' : '' }}"
                                href="{{ route('seccion.mostrar', 'nacional') }}">Nacional</a> </li>
                        <li class="nav-item"> <a
                                class="nav-link {{ Request::is('seccion/tecnologia') ? 'active' : '' }}"
                                href="{{ route('seccion.mostrar', 'tecnologia') }}">Tecnología</a> </li>
                        <li class="nav-item"> <a class="nav-link {{ Request::is('seccion/deportes') ? 'active' : '' }}"
                                href="{{ route('seccion.mostrar', 'deportes') }}">Deportes</a> </li>
                        <li class="nav-item"> <a class="nav-link {{ Request::is('seccion/negocios') ? 'active' : '' }}"
                                href="{{ route('seccion.mostrar', 'negocios') }}">Negocios</a> </li>
                        <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"> Más Secciones </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('home') }}#multimedia">Multimedia</a></li>
                                <li><a class="dropdown-item" href="{{ route('home') }}#podcast">Podcast</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('home') }}#contacto">Contacto</a></li>
                            </ul>
                        </li>
                    </ul>

                    {{-- Bloque de Menú Lado Derecho (Autenticación - CON ENLACE A PERFIL) --}}
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('login') ? 'active' : '' }}"
                                        href="{{ route('login') }}">Iniciar Sesión</a>
                                </li>
                            @endif
                            @if (Route::has('register.form'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('register.form') ? 'active' : '' }}"
                                        href="{{ route('register.form') }}">Registrarse</a>
                                </li>
                            @endif
                        @else
                            {{-- Menú Desplegable para Usuario Autenticado --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>
                                    {{ Auth::user()->nombre }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- <<< ENLACE AÑADIDO/CORREGIDO >>> --}}
                                    <a class="dropdown-item" href="{{ route('perfil.index') }}">
                                        Mi Perfil
                                    </a>
                                    {{-- <<< FIN ENLACE >>> --}}

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    {{-- Fin Bloque de Menú Lado Derecho --}}
                </div>
            </div>
        </nav>
    </header>
    {{-- =================== FIN ENCABEZADO =================== --}}


    {{-- ================= CONTENIDO PRINCIPAL ================= --}}
    <main class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>
    {{-- ================= FIN CONTENIDO PRINCIPAL ================= --}}


    {{-- ===================== PIE DE PÁGINA ===================== --}}
    <footer id="footer" class="bg-dark text-white py-5 mt-5">
        {{-- ... (Contenido del Footer sin cambios) ... --}}
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4"> <a href="{{ route('home') }}"> <img
                            src="{{ asset('assets/img/Logo1.jpeg') }}" width="80" class="logo mb-3 rounded"
                            alt="Logo El Faro Footer" /> </a>
                    <p class="text-white-50">Periódico El Faro. Mantente informado.</p>
                    <p class="small text-white-50"> © {{ date('Y') }} El Faro. Todos los derechos reservados. </p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="text-uppercase mb-3 text-warning small">Secciones</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="{{ route('home') }}"
                                class="nav-link p-0 text-white-50">Inicio</a></li>
                        <li class="nav-item mb-2"><a href="{{ route('seccion.mostrar', 'general') }}"
                                class="nav-link p-0 text-white-50">Noticias</a></li>
                        <li class="nav-item mb-2"><a href="{{ route('seccion.mostrar', 'nacional') }}"
                                class="nav-link p-0 text-white-50">Nacional</a></li>
                        <li class="nav-item mb-2"><a href="{{ route('seccion.mostrar', 'tecnologia') }}"
                                class="nav-link p-0 text-white-50">Tecnología</a></li>
                        <li class="nav-item mb-2"><a href="{{ route('seccion.mostrar', 'deportes') }}"
                                class="nav-link p-0 text-white-50">Deportes</a></li>
                        <li class="nav-item mb-2"><a href="{{ route('seccion.mostrar', 'negocios') }}"
                                class="nav-link p-0 text-white-50">Negocios</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase mb-3 text-warning small">Información y Contacto</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Acerca de</a>
                        </li>
                        <li class="nav-item mb-2"><a href="{{ route('home') }}#contacto"
                                class="nav-link p-0 text-white-50">Contacto</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white-50">Publicidad</a>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <p class="small text-white-50 mb-1"><i class="fas fa-home me-2"></i> Maipú, Santiago, Chile
                        </p>
                        <p class="small text-white-50 mb-1"><i class="fas fa-envelope me-2"></i> contacto@elfaro.cl
                        </p>
                        <p class="small text-white-50"><i class="fas fa-phone me-2"></i> +56 9 3333 4444</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-uppercase mb-3 text-warning small">Políticas</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"> <a href="{{ route('paginas.privacidad') }}"
                                class="nav-link p-0 text-white-50">Política de Privacidad</a> </li>
                        <li class="nav-item mb-2"> <a href="{{ route('paginas.terminos') }}"
                                class="nav-link p-0 text-white-50">Términos de Uso</a> </li>
                        <li class="nav-item mb-2"> <a href="{{ route('paginas.cookies') }}"
                                class="nav-link p-0 text-white-50">Política de Cookies</a> </li>
                    </ul>
                    <div class="mt-4">
                        <h6 class="text-uppercase mb-2 text-warning small">Síguenos</h6> <a href="#"
                            class="text-white me-2" style="text-decoration: none; font-size: 1.2rem"><i
                                class="fab fa-facebook-f"></i></a> <a href="#" class="text-white me-2"
                            style="text-decoration: none; font-size: 1.2rem"><i class="fab fa-twitter"></i></a> <a
                            href="#" class="text-white me-2"
                            style="text-decoration: none; font-size: 1.2rem"><i class="fab fa-instagram"></i></a> <a
                            href="#" class="text-white" style="text-decoration: none; font-size: 1.2rem"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div> <button class="btn btn-outline-warning btn-sm mt-4 w-100"
                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"> <i
                            class="fas fa-arrow-up me-1"></i> Ir Arriba </button>
                </div>
            </div>
        </div>
    </footer>
    {{-- =================== FIN PIE DE PÁGINA =================== --}}


    {{-- ======================= SCRIPTS JS ======================= --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/clock-time.js') }}"></script>

    @yield('scripts')
    {{-- ===================== FIN SCRIPTS JS ===================== --}}

</body>

</html>
