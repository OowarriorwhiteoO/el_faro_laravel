@extends('layouts.layout')
@section('title', 'Podcast - El Faro')
@section('content')
    <div class="container my-5">
        <div id="podcast-content">
            <section id="podcast-section" class="py-5"> {{-- Cambié el id para evitar confusión con la antigua id "podcast" si aún existe en algún CSS/JS --}}
                <div class="container">
                    <h1 class="text-center mb-4">Nuestros Podcasts</h1> {{-- Título Principal de la página de Podcast --}}

                    {{-- Tarjeta para un podcast específico --}}
                    <div class="row justify-content-center"> {{-- Para centrar la tarjeta si solo hay una --}}
                        <div class="col-md-8 col-lg-6 mb-4"> {{-- Ajusta el ancho de la columna como prefieras --}}
                            <div class="card shadow-sm">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQek7x_szyWIDtT5VwpnccUaedroWVtFllS8nGz48z0vlFgVTFp"
                                    class="card-img-top" style="max-height: 300px; object-fit: cover;"
                                    alt="Carátula Podcast El Faro">
                                <div class="card-body text-center"> {{-- Centrar contenido de la tarjeta --}}
                                    <h5 class="card-title">El rol de la divulgación científica en la era de las fake news
                                    </h5>
                                    <p class="card-text small text-muted">
                                        ¿Qué tan reciente es el fenómeno de las fake news? ¿cuáles son los ejemplos más
                                        flagrantes de nuestra época? ¿cómo combatir su rápida viralización? Los invitamos a
                                        escuchar el primer capítulo de ”El rol de la divulgación científica en la era de las
                                        fake news”, junto a la periodista Pascale Fuentes.
                                    </p>
                                    <audio controls class="w-100 mt-3">
                                        {{-- RUTA CORREGIDA DEL AUDIO --}}
                                        <source src="{{ asset('assets/audio/Cap_1.mp3') }}" type="audio/mpeg">
                                        {{-- También es buena práctica tener el tipo correcto: audio/mpeg para mp3 --}}
                                        Tu navegador no soporta el elemento de audio.
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Aquí podrías agregar más podcasts en el futuro, siguiendo una estructura similar --}}
                </div>
            </section>
        </div>
    </div>
@endsection
