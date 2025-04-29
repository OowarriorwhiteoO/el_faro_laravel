@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Iniciar Sesión') {{-- Define el título de la pestaña del navegador --}}

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">

                        {{-- Formulario para el inicio de sesión --}}
                        <form method="POST" action="{{ route('login.attempt') }}">
                            @csrf {{-- Incluye el token CSRF para protección --}}

                            {{-- Campo para el Correo Electrónico --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                {{-- Muestra el valor anterior del email si la validación falla --}}
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                {{-- Muestra mensajes de error de validación para el campo email --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo para la Contraseña --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                {{-- Muestra mensajes de error de validación para el campo password --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Checkbox opcional para "Recordarme" --}}
                            <div class="mb-3 form-check">
                                {{-- El atributo 'checked' se añade si el valor 'remember' existía previamente --}}
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Recordarme en este equipo
                                </label>
                            </div>

                            {{-- Botón para enviar el formulario --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary">
                                    Iniciar Sesión
                                </button>
                            </div>

                            {{-- Enlace opcional al formulario de registro --}}
                            <div class="text-center mt-3">
                                @if (Route::has('register.form'))
                                    <a class="btn btn-link btn-sm" href="{{ route('register.form') }}">
                                        ¿No tienes cuenta? Regístrate
                                    </a>
                                @endif
                            </div>

                        </form> {{-- Fin del formulario de login --}}
                    </div> {{-- Fin del card-body --}}
                </div> {{-- Fin del card --}}
            </div> {{-- Fin de la columna --}}
        </div> {{-- Fin de la fila --}}
    </div> {{-- Fin del contenedor --}}
@endsection
