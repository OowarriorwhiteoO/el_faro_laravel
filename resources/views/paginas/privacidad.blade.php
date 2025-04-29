@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Política de Privacidad - El Faro') {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Política de Privacidad</h1>

                {{-- Muestra la fecha de la última actualización --}}
                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>

                <h2>1. Introducción</h2>
                <p>Bienvenido a Periódico "El Faro". Su privacidad es importante para nosotros. Esta Política de Privacidad
                    explica cómo recopilamos, usamos, divulgamos y protegemos su información personal cuando visita nuestro
                    sitio web y utiliza nuestros servicios.</p>
                <p>Al acceder o utilizar nuestro sitio web, usted acepta las prácticas descritas en esta política. Si no
                    está de acuerdo con esta política, por favor no utilice nuestro sitio web.</p>

                <h2>2. Información que Recopilamos</h2>
                <p>Podemos recopilar diferentes tipos de información en relación con su uso de nuestro sitio web:</p>
                <ul>
                    <li><strong>Información Personal Identificable (IPI):</strong> Información que usted nos proporciona
                        voluntariamente, como su nombre, dirección de correo electrónico y cualquier otra información que
                        decida compartir al registrarse, contactarnos o participar en encuestas.</li>
                    <li><strong>Información de Uso y Técnica:</strong> Información que se recopila automáticamente cuando
                        navega por el sitio, como su dirección IP, tipo de navegador, sistema operativo, páginas visitadas,
                        tiempo de visita y datos de flujo de clics.</li>
                    <li><strong>Cookies y Tecnologías Similares:</strong> Utilizamos cookies para mejorar su experiencia,
                        analizar el tráfico y personalizar el contenido. Consulte nuestra <a
                            href="{{ route('paginas.cookies') }}">Política de Cookies</a> para más detalles.</li>
                </ul>

                <h2>3. Uso de la Información</h2>
                <p>Utilizamos la información recopilada para diversos fines, incluyendo:</p>
                <ul>
                    <li>Proveer, operar y mantener nuestro sitio web.</li>
                    <li>Mejorar, personalizar y expandir nuestro sitio web y servicios.</li>
                    <li>Entender y analizar cómo utiliza nuestro sitio web.</li>
                    <li>Desarrollar nuevos productos, servicios, características y funcionalidades.</li>
                    <li>Comunicarnos con usted, ya sea directamente o a través de uno de nuestros socios, incluso para
                        servicio al cliente, para proporcionarle actualizaciones y otra información relacionada con el sitio
                        web, y con fines promocionales y de marketing (siempre con su consentimiento cuando sea requerido).
                    </li>
                    <li>Procesar sus transacciones (si aplica en el futuro, ej. suscripciones).</li>
                    <li>Prevenir el fraude y garantizar la seguridad del sitio.</li>
                    <li>Cumplir con obligaciones legales.</li>
                </ul>

                <h2>4. Compartir Información</h2>
                <p>No compartimos su Información Personal Identificable con terceros, excepto en las siguientes
                    circunstancias:</p>
                <ul>
                    <li>Con su consentimiento explícito.</li>
                    <li>Con proveedores de servicios externos que nos ayudan a operar nuestro sitio web y negocio (ej.
                        análisis, hosting), siempre bajo acuerdos de confidencialidad.</li>
                    <li>Para cumplir con obligaciones legales, procesos judiciales o solicitudes gubernamentales.</li>
                    <li>Para proteger nuestros derechos, propiedad o seguridad, o los de nuestros usuarios u otros.</li>
                    <li>En caso de una fusión, adquisición o venta de activos, donde su información podría ser transferida.
                    </li>
                </ul>

                <h2>5. Seguridad de la Información</h2>
                <p>Implementamos medidas de seguridad razonables para proteger su información personal contra el acceso no
                    autorizado, alteración, divulgación o destrucción. Sin embargo, ningún método de transmisión por
                    Internet o almacenamiento electrónico es 100% seguro, por lo que no podemos garantizar su seguridad
                    absoluta.</p>
                <p>La seguridad de su contraseña es su responsabilidad. Le recomendamos utilizar una contraseña única y
                    segura y no compartirla con nadie.</p>

                <h2>6. Derechos del Usuario</h2>
                <p>Dependiendo de su jurisdicción, usted puede tener ciertos derechos sobre su información personal, como el
                    derecho a acceder, corregir, actualizar o solicitar la eliminación de sus datos. Si desea ejercer estos
                    derechos, por favor contáctenos.</p>

                <h2>7. Privacidad de Menores</h2>
                <p>Nuestro sitio web no está dirigido a menores de 13 años (o la edad mínima requerida por la ley aplicable)
                    y no recopilamos intencionalmente información personal de niños. Si descubrimos que hemos recopilado
                    información de un menor sin el consentimiento parental, tomaremos medidas para eliminarla.</p>

                <h2>8. Cambios a esta Política</h2>
                <p>Podemos actualizar esta Política de Privacidad ocasionalmente. Le notificaremos cualquier cambio
                    publicando la nueva política en esta página y actualizando la fecha de "Última actualización". Le
                    recomendamos revisar esta política periódicamente.</p>

                <h2>9. Contacto</h2>
                <p>Si tiene alguna pregunta sobre esta Política de Privacidad, puede contactarnos a través de nuestro
                    formulario de contacto o por correo electrónico:</p>
                <p><a href="mailto:contacto@elfaro.cl">contacto@elfaro.cl</a></p>

            </div> {{-- Fin card-body --}}
        </div> {{-- Fin card --}}
    </div> {{-- Fin container --}}
@endsection {{-- Fin de la sección de contenido principal --}}
