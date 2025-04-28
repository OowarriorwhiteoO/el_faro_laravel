@extends('layouts.layout')

@section('title', 'Términos de Uso - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Términos y Condiciones de Uso</h1>

                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>

                <h2>1. Aceptación de los Términos</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Al utilizar este sitio web, usted acepta estar
                    sujeto a estos Términos y Condiciones de Uso.</p>

                <h2>2. Uso del Sitio</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Se
                    le concede una licencia limitada para acceder y hacer uso personal de este sitio.</p>

                <h2>3. Cuentas de Usuario</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. Usted
                    es responsable de mantener la confidencialidad de su cuenta y contraseña.</p>

                <h2>4. Propiedad Intelectual</h2>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. Todo el contenido incluido en
                    este sitio es propiedad de El Faro o sus proveedores de contenido.</p>

                <h2>5. Limitación de Responsabilidad</h2>
                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. El Faro no
                    será responsable por ningún daño directo o indirecto.</p>

                <h2>6. Modificaciones</h2>
                <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam. Nos reservamos
                    el derecho de modificar estos términos en cualquier momento.</p>

                <h2>7. Ley Aplicable</h2>
                <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.
                    Estos términos se regirán e interpretarán de acuerdo con las leyes de Chile.</p>

            </div>
        </div>
    </div>
@endsection
