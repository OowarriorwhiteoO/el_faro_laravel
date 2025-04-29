@extends('layouts.layout') {{-- Hereda de la plantilla base --}}

@section('title', 'Registro de Usuario') {{-- Título de la página --}}

@section('content')
    <div class="container mt-4 mb-5"> {{-- Contenedor principal con margen --}}
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm"> {{-- Tarjeta para enmarcar el formulario --}}
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registro de Nuevo Usuario</h4>
                    </div>
                    <div class="card-body">

                        {{-- Formulario de Registro --}}
                        {{-- Envía los datos por POST a la ruta nombrada 'register.submit' --}}
                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf {{-- Token CSRF obligatorio para seguridad --}}

                            {{-- Campo Nombre --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                {{-- name="nombre" debe coincidir con la validación en el controlador --}}
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ old('nombre') }}" required autocomplete="name" autofocus>
                                {{-- Muestra error si falla la validación para 'nombre' --}}
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                {{-- Muestra error si falla la validación para 'email' --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo Contraseña --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                                {{-- Muestra error si falla la validación para 'password' --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo Confirmar Contraseña --}}
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                {{-- name="password_confirmation" es el nombre esperado por la regla 'confirmed' --}}
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                {{-- No necesita mostrar error específico, la regla 'confirmed' lo maneja en el campo 'password' --}}
                            </div>

                            {{-- Botón de Envío --}}
                            <div class="d-grid"> {{-- d-grid hace que el botón ocupe todo el ancho --}}
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>

                            {{-- Enlace a Login (si ya existiera) --}}
                            {{-- <div class="text-center mt-3">
                            <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión</a>
                        </div> --}}

                        </form> {{-- Fin del formulario --}}
                    </div> {{-- Fin card-body --}}
                </div> {{-- Fin card --}}
            </div> {{-- Fin col --}}
        </div> {{-- Fin row --}}
    </div> {{-- Fin container --}}
@endsection
