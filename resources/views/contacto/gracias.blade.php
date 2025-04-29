@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Mensaje Enviado') {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}
<div class="row justify-content-center mt-5 mb-5"> {{-- Fila centrada con márgenes superior e inferior --}}
    <div class="col-md-8 text-center"> {{-- Columna centrada y con texto alineado al centro --}}

        {{-- Verifica si existe un mensaje de éxito en la sesión --}}
        @if (session('success'))
            {{-- Muestra un cuadro de alerta de éxito --}}
            <div class="alert alert-success shadow-sm" role="alert">
                <h4 class="alert-heading">
                    <i class="fas fa-check-circle me-2"></i>¡Mensaje Enviado! {{-- Título de la alerta con icono --}}
                </h4>
                <p>{{ session('success') }}</p> {{-- Muestra el mensaje de éxito específico --}}
                <hr> {{-- Línea divisoria --}}
                <p class="mb-0">
                    {{-- Enlace para regresar a la página de inicio --}}
                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-home me-1"></i> Volver al Inicio
                    </a>
                </p>
            </div>
        @else
            {{-- Muestra una advertencia si se accede a la página sin un mensaje de éxito --}}
            <div class="alert alert-warning" role="alert">
                <p class="mb-0">No hay mensaje para mostrar. <a href="{{ route('home') }}" class="alert-link">Volver al inicio</a>.</p>
            </div>
        @endif

    </div> {{-- Fin de la columna --}}
</div> {{-- Fin de la fila --}}
@endsection {{-- Fin de la sección de contenido principal --}}
