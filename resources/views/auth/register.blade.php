@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Registro de Usuario') {{-- Define el título de la pestaña del navegador --}}

@section('content')
    <div class="container mt-4 mb-5"> {{-- Contenedor principal con márgenes superior e inferior --}}
        <div class="row justify-content-center"> {{-- Fila para centrar el contenido --}}
            <div class="col-md-8 col-lg-6"> {{-- Define el ancho de la columna en diferentes tamaños de pantalla --}}
                <div class="card shadow-sm"> {{-- Tarjeta Bootstrap con sombra suave --}}
                    <div class="card-header bg-primary text-white"> {{-- Cabecera de la tarjeta --}}
                        <h4 class="mb-0">Registro de Nuevo Usuario</h4>
                    </div>
                    <div class="card-body"> {{-- Cuerpo de la tarjeta --}}

                        {{-- Formulario de registro que envía datos vía POST a la ruta 'register.submit' --}}
                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf {{-- Token CSRF para protección contra ataques --}}

                            {{-- Campo para el Nombre Completo --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                {{-- Input para el nombre, muestra valor anterior si hay error de validación --}}
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ old('nombre') }}" required autocomplete="name" autofocus>
                                {{-- Muestra mensaje de error si la validación del campo 'nombre' falla --}}
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo para el Correo Electrónico --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                {{-- Input para el email, muestra valor anterior si hay error --}}
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                {{-- Muestra mensaje de error si la validación del campo 'email' falla --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo para la Contraseña --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                {{-- Input para la contraseña --}}
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                                {{-- Muestra mensaje de error si la validación del campo 'password' falla --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Campo para confirmar la Contraseña --}}
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                {{-- Input para la confirmación de contraseña ('password_confirmation' requerido por la regla 'confirmed') --}}
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            {{-- Botón para enviar el formulario de registro --}}
                            <div class="d-grid"> {{-- Hace que el botón ocupe el ancho completo --}}
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>

                            {{-- Enlace opcional al formulario de inicio de sesión (actualmente comentado) --}}
                            {{-- <div class="text-center mt-3">
                            <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión</a>
                        </div> --}}

                        </form> {{-- Fin del formulario de registro --}}
                    </div> {{-- Fin del card-body --}}
                </div> {{-- Fin del card --}}
            </div> {{-- Fin de la columna --}}
        </div> {{-- Fin de la fila --}}
    </div> {{-- Fin del contenedor principal --}}
@endsection
