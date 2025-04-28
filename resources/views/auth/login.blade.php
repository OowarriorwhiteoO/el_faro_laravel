@extends('layouts.layout') {{-- Hereda de la plantilla base --}}

@section('title', 'Iniciar Sesión') {{-- Título de la página --}}

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white"> {{-- Color diferente para distinguir de registro --}}
                        <h4 class="mb-0">Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">

                        {{-- Formulario de Login --}}
                        {{-- Envía los datos por POST a la ruta nombrada 'login.attempt' --}}
                        <form method="POST" action="{{ route('login.attempt') }}">
                            @csrf {{-- Token CSRF obligatorio --}}

                            {{-- Campo Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                {{-- name="email" --}}
                                {{-- old('email') recupera el email si la validación falla --}}
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                {{-- Muestra el error si falla la validación para 'email' (incluye el error de credenciales incorrectas) --}}
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
                                    autocomplete="current-password">
                                {{-- Muestra error si falla la validación para 'password' (normalmente solo si está vacío) --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Checkbox "Recordarme" (Opcional) --}}
                            <div class="mb-3 form-check">
                                {{-- name="remember" es usado por Auth::attempt() --}}
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Recordarme en este equipo
                                </label>
                            </div>

                            {{-- Botón de Envío --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary"> {{-- Botón con color secundario --}}
                                    Iniciar Sesión
                                </button>
                            </div>

                            {{-- Enlaces Adicionales (Opcional) --}}
                            <div class="text-center mt-3">
                                {{-- Enlace a Registro --}}
                                @if (Route::has('register.form'))
                                    <a class="btn btn-link btn-sm" href="{{ route('register.form') }}">
                                        ¿No tienes cuenta? Regístrate
                                    </a>
                                @endif
                                {{-- Enlace a Recuperar Contraseña (si se implementa) --}}
                                {{-- @if (Route::has('password.request'))
                                <br>
                                <a class="btn btn-link btn-sm" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif --}}
                            </div>

                        </form> {{-- Fin del formulario --}}
                    </div> {{-- Fin card-body --}}
                </div> {{-- Fin card --}}
            </div> {{-- Fin col --}}
        </div> {{-- Fin row --}}
    </div> {{-- Fin container --}}
@endsection
