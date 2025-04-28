@extends('layouts.layout') {{-- Indica que esta vista usará la plantilla base 'layout.blade.php' --}}

@section('title', 'Mensaje Enviado') {{-- Define el título específico para esta página --}}

@section('content') {{-- Comienza la sección de contenido --}}
    <div class="row justify-content-center mt-5 mb-5"> {{-- Añade margen superior e inferior --}}
        <div class="col-md-8 text-center">

            {{-- Verifica si existe un mensaje de éxito en la sesión flash --}}
            @if (session('success'))
                {{-- Muestra un cuadro de alerta de éxito --}}
                <div class="alert alert-success shadow-sm" role="alert">
                    <h4 class="alert-heading">
                        <i class="fas fa-check-circle me-2"></i>¡Mensaje Enviado! {{-- Icono de éxito --}}
                    </h4>
                    <p>{{ session('success') }}</p> {{-- Muestra el mensaje específico enviado desde el controlador --}}
                    <hr>
                    <p class="mb-0">
                        {{-- Enlace para volver a la página de inicio --}}
                        <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-home me-1"></i> Volver al Inicio
                        </a>
                    </p>
                </div>
            @else
                {{-- Mensaje por si alguien llega a esta URL directamente sin el mensaje de éxito --}}
                <div class="alert alert-warning" role="alert">
                    <p class="mb-0">No hay mensaje para mostrar. <a href="{{ route('home') }}" class="alert-link">Volver
                            al inicio</a>.</p>
                </div>
            @endif

        </div>
    </div>
@endsection {{-- Fin de la sección de contenido --}}
