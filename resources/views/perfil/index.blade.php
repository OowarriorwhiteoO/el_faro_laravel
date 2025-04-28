@extends('layouts.layout')

@section('title', 'Mi Perfil - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Usamos @auth para asegurar (aunque la ruta ya está protegida) --}}
                @auth
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Mi Perfil</h4>
                        </div>
                        <div class="card-body">
                            {{-- Muestra un mensaje de bienvenida --}}
                            <p>Bienvenido/a, <strong>{{ $usuario->nombre }}</strong>.</p>

                            {{-- Muestra la información básica --}}
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Nombre:</strong> {{ $usuario->nombre }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Email:</strong> {{ $usuario->email }}
                                </li>
                                <li class="list-group-item">
                                    {{-- Muestra la fecha de registro usando el objeto Carbon --}}
                                    <strong>Miembro desde:</strong> {{ $usuario->created_at->isoFormat('LL') }}
                                    ({{ $usuario->created_at->diffForHumans() }})
                                    {{-- Muestra hace cuánto tiempo --}}
                                </li>
                            </ul>

                            {{-- Aquí podrías añadir botones/formularios para editar perfil o cambiar contraseña en el futuro --}}
                            {{-- <div class="mt-4">
                            <a href="#" class="btn btn-sm btn-outline-primary">Editar Perfil</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Cambiar Contraseña</a>
                        </div> --}}

                        </div>
                    </div>
                @else
                    {{-- Mensaje si por alguna razón un usuario no autenticado llega aquí --}}
                    <p class="text-center">Debes <a href="{{ route('login') }}">iniciar sesión</a> para ver tu perfil.</p>
                @endauth
            </div>
        </div>
    </div>
@endsection
