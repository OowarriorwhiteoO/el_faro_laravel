@extends('layouts.layout')

@section('title', 'Política de Privacidad - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Política de Privacidad</h1>

                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>
                {{-- Fecha actual --}}

                <h2>1. Introducción</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat.</p>

                <h2>2. Información que Recopilamos</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                    laborum.</p>
                <ul>
                    <li>Información de registro (nombre, email, etc.)</li>
                    <li>Datos de uso y navegación.</li>
                    <li>Cookies y tecnologías similares.</li>
                </ul>

                <h2>3. Uso de la Información</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                    rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                    explicabo.</p>

                <h2>4. Cookies</h2>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                    dolores eos qui ratione voluptatem sequi nesciunt.</p>

                <h2>5. Seguridad</h2>
                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia
                    non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>

                <h2>6. Cambios a esta Política</h2>
                <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid
                    ex ea commodi consequatur?</p>

                <h2>7. Contacto</h2>
                <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur,
                    vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                <p>Puedes contactarnos en: <a href="mailto:contacto@elfaro.cl">contacto@elfaro.cl</a></p>

            </div>
        </div>
    </div>
@endsection
