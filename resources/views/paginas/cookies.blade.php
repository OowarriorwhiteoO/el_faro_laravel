@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Política de Cookies - El Faro') {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Política de Cookies</h1>

                {{-- Muestra la fecha de la última actualización --}}
                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>

                <h2>1. ¿Qué son las Cookies?</h2>
                <p>Una cookie es un pequeño archivo de texto que un sitio web almacena en su navegador cuando lo visita. Las
                    cookies permiten que el sitio web recuerde información sobre su visita, como su idioma preferido y otras
                    opciones, lo que puede facilitar su próxima visita y hacer que el sitio le resulte más útil.</p>
                <p>En Periódico "El Faro", utilizamos cookies para mejorar su experiencia de navegación y ofrecerle un
                    servicio más personalizado.</p>

                <h2>2. ¿Cómo Utilizamos las Cookies?</h2>
                <p>Utilizamos cookies propias y de terceros con diversos fines, entre los que se incluyen:</p>
                <ul>
                    <li><strong>Funcionamiento del sitio:</strong> Cookies esenciales que permiten la navegación y el uso de
                        funciones básicas, como el acceso a áreas seguras o el mantenimiento de la sesión de usuario.</li>
                    <li><strong>Análisis y Rendimiento:</strong> Cookies que nos ayudan a entender cómo interactúan los
                        visitantes con nuestro sitio web, recopilando información de forma anónima (ej. Google Analytics).
                        Esto nos permite medir y mejorar el rendimiento de nuestro sitio.</li>
                    <li><strong>Funcionalidad y Preferencias:</strong> Cookies que permiten recordar información que cambia
                        el aspecto o el comportamiento del sitio web, como su idioma preferido, región o personalizaciones
                        de usuario.</li>
                    <li><strong>Publicidad (si aplica):</strong> Podríamos utilizar cookies para mostrar publicidad que
                        consideremos relevante para sus intereses, basándonos en sus hábitos de navegación. Actualmente,
                        este uso puede ser limitado o inexistente.</li>
                </ul>

                <h2>3. Tipos de Cookies que Utilizamos</h2>
                <p>A continuación, detallamos los tipos de cookies que pueden ser utilizadas en nuestro sitio:</p>
                <ul>
                    <li><strong>Cookies de Sesión:</strong> Son temporales y se eliminan de su dispositivo cuando cierra el
                        navegador. Se utilizan para mantener el estado de su sesión mientras navega.</li>
                    <li><strong>Cookies Persistentes:</strong> Permanecen en su dispositivo durante un período de tiempo
                        determinado o hasta que usted las elimine manualmente. Ayudan a recordar sus preferencias para
                        futuras visitas.</li>
                    <li><strong>Cookies Propias:</strong> Son establecidas y gestionadas directamente por Periódico "El
                        Faro".</li>
                    <li><strong>Cookies de Terceros:</strong> Son establecidas por dominios distintos al nuestro, por
                        ejemplo, por servicios de análisis (Google Analytics) o redes sociales, si integramos sus
                        funcionalidades.</li>
                </ul>


                <h2>4. Gestión de Cookies</h2>
                <p>Usted tiene el derecho de decidir si acepta o rechaza las cookies. La mayoría de los navegadores web
                    aceptan cookies automáticamente, pero normalmente puede modificar la configuración de su navegador para
                    rechazarlas si lo prefiere.</p>
                <p>Puede bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones
                    del navegador instalado en su ordenador. Tenga en cuenta que si deshabilita las cookies, es posible que
                    algunas funcionalidades de nuestro sitio web no estén disponibles o no funcionen correctamente.</p>
                <p>Para más información sobre cómo gestionar las cookies en los navegadores más comunes, puede consultar los
                    siguientes enlaces:</p>
                <ul>
                    <li><a href="https://support.google.com/chrome/answer/95647?hl=la" target="_blank"
                            rel="noopener noreferrer">Google Chrome</a></li>
                    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias"
                            target="_blank" rel="noopener noreferrer">Mozilla Firefox</a></li>
                    <li><a href="https://support.microsoft.com/es-es/windows/eliminar-y-administrar-cookies-168dab11-0753-043d-7c16-ede5947fc64d"
                            target="_blank" rel="noopener noreferrer">Internet Explorer / Edge</a></li>
                    <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank"
                            rel="noopener noreferrer">Safari</a></li>
                </ul>

                <h2>5. Cambios a esta Política</h2>
                <p>Podemos actualizar nuestra Política de Cookies periódicamente para reflejar, por ejemplo, cambios en las
                    cookies que utilizamos o por otras razones operativas, legales o reglamentarias. Por ello, le
                    recomendamos revisar esta política regularmente para mantenerse informado sobre nuestro uso de cookies y
                    tecnologías relacionadas.</p>

                <h2>6. Más Información</h2>
                <p>Si tiene alguna pregunta sobre nuestro uso de cookies u otras tecnologías, por favor, póngase en contacto
                    con nosotros a través de nuestro formulario de contacto o enviando un correo electrónico a <a
                        href="mailto:contacto@elfaro.cl">contacto@elfaro.cl</a>.</p>

            </div> {{-- Fin card-body --}}
        </div> {{-- Fin card --}}
    </div> {{-- Fin container --}}
@endsection {{-- Fin de la sección de contenido principal --}}
