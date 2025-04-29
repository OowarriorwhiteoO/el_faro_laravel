@extends('layouts.layout') {{-- Hereda la estructura del layout principal --}}

@section('title', 'Términos de Uso - El Faro') {{-- Define el título de la pestaña del navegador --}}

@section('content') {{-- Inicio de la sección de contenido principal --}}
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title h2 border-bottom pb-3 mb-4">Términos y Condiciones de Uso</h1>

                {{-- Muestra la fecha de la última actualización --}}
                <p class="lead">Última actualización: {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>

                <h2>1. Aceptación de los Términos</h2>
                <p>Bienvenido a Periódico "El Faro". Al acceder y utilizar este sitio web (en adelante, "el Sitio"), usted
                    (en adelante, "el Usuario") acepta cumplir y estar legalmente obligado por los siguientes Términos y
                    Condiciones de Uso (en adelante, "los Términos"). Si no está de acuerdo con alguno de estos términos,
                    por favor, no utilice el Sitio.</p>
                <p>Nos reservamos el derecho de modificar estos Términos en cualquier momento, y dichas modificaciones
                    entrarán en vigor inmediatamente después de su publicación en el Sitio. Se recomienda revisar esta
                    página periódicamente.</p>

                <h2>2. Uso del Sitio</h2>
                <p>Periódico "El Faro" le concede una licencia limitada, no exclusiva, intransferible y revocable para
                    acceder y hacer uso personal y no comercial del Sitio y su contenido (textos, imágenes, videos, etc.),
                    sujeto al cumplimiento de estos Términos.</p>
                <p>El Usuario se compromete a no utilizar el Sitio para fines ilegales o prohibidos por estos Términos,
                    incluyendo, pero no limitándose a:</p>
                <ul>
                    <li>Realizar actividades que infrinjan derechos de propiedad intelectual.</li>
                    <li>Transmitir material difamatorio, obsceno, fraudulento o ilegal.</li>
                    <li>Interferir con el funcionamiento adecuado del Sitio o las redes conectadas.</li>
                    <li>Intentar obtener acceso no autorizado a sistemas o cuentas.</li>
                </ul>

                <h2>3. Cuentas de Usuario</h2>
                <p>Para acceder a ciertas funcionalidades, como agregar noticias, el Usuario debe registrarse y crear una
                    cuenta. El Usuario es el único responsable de mantener la confidencialidad de la información de su
                    cuenta, incluyendo su contraseña, y de todas las actividades que ocurran bajo su cuenta.</p>
                <p>El Usuario se compromete a notificar inmediatamente a Periódico "El Faro" sobre cualquier uso no
                    autorizado de su cuenta o cualquier otra violación de seguridad. Periódico "El Faro" no será responsable
                    por ninguna pérdida o daño derivado del incumplimiento de estas obligaciones por parte del Usuario.</p>
                <p>Nos reservamos el derecho de suspender o cancelar cuentas de usuario a nuestra discreción si se violan
                    estos Términos.</p>

                <h2>4. Propiedad Intelectual</h2>
                <p>Todo el contenido presente en el Sitio, incluyendo textos, gráficos, logos, iconos, imágenes, clips de
                    audio y video, y software, es propiedad exclusiva de Periódico "El Faro" o de sus licenciantes y está
                    protegido por las leyes de propiedad intelectual chilenas e internacionales.</p>
                <p>Queda estrictamente prohibida la reproducción, distribución, modificación, exhibición pública o cualquier
                    otro uso no autorizado del contenido sin el permiso previo y por escrito de Periódico "El Faro".</p>

                <h2>5. Limitación de Responsabilidad</h2>
                <p>El uso del Sitio es bajo el propio riesgo del Usuario. Periódico "El Faro" proporciona el Sitio y su
                    contenido "tal cual" y "según disponibilidad", sin garantías de ningún tipo, ya sean expresas o
                    implícitas.</p>
                <p>Periódico "El Faro" no garantiza que el Sitio esté libre de errores o interrupciones, ni que el contenido
                    sea preciso, completo o actualizado. En la máxima medida permitida por la ley, Periódico "El Faro"
                    renuncia a toda responsabilidad por cualquier daño directo, indirecto, incidental, consecuente o
                    punitivo que surja del acceso o uso del Sitio.</p>

                <h2>6. Enlaces a Terceros</h2>
                <p>El Sitio puede contener enlaces a sitios web de terceros que no son propiedad ni están controlados por
                    Periódico "El Faro". No tenemos control ni asumimos responsabilidad por el contenido, políticas de
                    privacidad o prácticas de sitios web de terceros. Le recomendamos leer los términos y políticas de
                    cualquier sitio de terceros que visite.</p>

                <h2>7. Modificaciones del Servicio</h2>
                <p>Nos reservamos el derecho de modificar, suspender o discontinuar, temporal o permanentemente, el Sitio o
                    cualquier servicio al que da acceso, con o sin previo aviso y sin responsabilidad alguna hacia el
                    Usuario.</p>

                <h2>8. Ley Aplicable y Jurisdicción</h2>
                <p>Estos Términos se regirán e interpretarán de conformidad con las leyes de la República de Chile, sin dar
                    efecto a ningún principio de conflicto de leyes.</p>
                <p>Cualquier disputa que surja en relación con estos Términos estará sujeta a la jurisdicción exclusiva de
                    los tribunales ordinarios de justicia con asiento en la ciudad de Santiago, Chile.</p>

                <h2>9. Contacto</h2>
                <p>Si tiene alguna pregunta sobre estos Términos y Condiciones de Uso, puede contactarnos a través de
                    nuestro formulario de contacto o por correo electrónico a <a
                        href="mailto:contacto@elfaro.cl">contacto@elfaro.cl</a>.</p>

            </div> {{-- Fin card-body --}}
        </div> {{-- Fin card --}}
    </div> {{-- Fin container --}}
@endsection {{-- Fin de la sección de contenido principal --}}
