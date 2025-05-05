@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Listado de Usuarios Registrados - El Faro') {{-- Define el título de la pestaña --}}

@section('content') {{-- Inicio de la sección de contenido --}}
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10"> {{-- Columna un poco más ancha para la tabla --}}
                <h1 class="h3 mb-4 text-center">Usuarios Registrados</h1>

                <div class="card shadow-sm">
                    <div class="card-body">
                        {{-- Tabla para mostrar los usuarios --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm"> {{-- Clases de Bootstrap para estilo --}}
                                <thead class="table-dark"> {{-- Cabecera oscura --}}
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Fecha de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Itera sobre la colección paginada de usuarios --}}
                                    @forelse ($usuarios as $usuario)
                                        <tr>
                                            <th scope="row">{{ $usuario->idUsuario }}</th> {{-- Muestra el ID --}}
                                            <td>{{ $usuario->nombre }}</td> {{-- Muestra el nombre --}}
                                            <td>{{ $usuario->email }}</td> {{-- Muestra el email --}}
                                            <td>{{ $usuario->created_at->isoFormat('LL') }}</td> {{-- Muestra fecha de registro formateada --}}
                                            {{-- Podrías añadir acciones como ver perfil, editar, eliminar aquí (si tuvieras esas rutas y permisos) --}}
                                            {{-- <td>
                                            <a href="#" class="btn btn-info btn-sm">Ver</a>
                                            <a href="#" class="btn btn-warning btn-sm">Editar</a>
                                        </td> --}}
                                        </tr>
                                    @empty
                                        {{-- Mensaje si no hay usuarios registrados --}}
                                        <tr>
                                            <td colspan="4" class="text-center text-muted fst-italic">No hay usuarios
                                                registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> {{-- Fin table-responsive --}}

                        {{-- Renderiza los enlaces de paginación generados por ->paginate() en el controlador --}}
                        <div class="d-flex justify-content-center mt-3">
                            {{ $usuarios->links() }}
                        </div>

                    </div> {{-- Fin card-body --}}
                </div> {{-- Fin card --}}
            </div> {{-- Fin col --}}
        </div> {{-- Fin row --}}
    </div> {{-- Fin container --}}
@endsection {{-- Fin de la sección de contenido --}}
