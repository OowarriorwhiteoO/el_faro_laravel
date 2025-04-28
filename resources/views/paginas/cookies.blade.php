@extends('layouts.layout')

@section('title', 'Política de Cookies - El Faro')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Política de Cookies</h1>

                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>

                <h2>1. ¿Qué son las Cookies?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Las cookies son pequeños archivos de texto que
                    los sitios web colocan en su dispositivo mientras navega.</p>

                <h2>2. ¿Cómo Utilizamos las Cookies?</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Utilizamos cookies para:</p>
                <ul>
                    <li>Mejorar la funcionalidad del sitio web.</li>
                    <li>Analizar el tráfico y uso del sitio.</li>
                    <li>Recordar sus preferencias.</li>
                    <li>(Opcional) Mostrar publicidad relevante.</li>
                </ul>

                <h2>3. Tipos de Cookies que Utilizamos</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                <ul>
                    <li>**Cookies Esenciales:** Necesarias para el funcionamiento del sitio.</li>
                    <li>**Cookies de Rendimiento/Análisis:** Nos ayudan a entender cómo interactúan los visitantes.</li>
                    <li>**Cookies de Funcionalidad:** Recuerdan elecciones que usted hace.</li>
                    <li>**Cookies de Publicidad (si aplica):** Utilizadas para mostrar anuncios relevantes.</li>
                </ul>


                <h2>4. Gestión de Cookies</h2>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. Puede administrar las cookies
                    a través de la configuración de su navegador.</p>

                <h2>5. Cambios a esta Política</h2>
                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Podemos
                    actualizar nuestra Política de Cookies ocasionalmente.</p>

                <h2>6. Más Información</h2>
                <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam. Si tiene
                    preguntas, contáctenos.</p>

            </div>
        </div>
    </div>
@endsection
