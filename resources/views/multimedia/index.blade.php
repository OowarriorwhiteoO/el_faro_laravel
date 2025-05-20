{{-- resources/views/multimedia/index.blade.php --}}
@extends('layouts.layout')
@section('title', 'Multimedia - El Faro')
@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-5">Galería Multimedia</h1> {{-- Título principal de la página --}}

        <div id="multimedia-content">
            {{-- Ya no necesitamos la section interna si toda la página es de multimedia --}}

            <div class="row g-4 justify-content-center">

                {{-- Video 1 --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-2 text-center small">LA BANDA DE FUJIAN</h5> {{-- Cambia este título --}}
                    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/22zgU4xdZa8?si=u8rHMTWB8g6mD1vq" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <p class="text-center small mt-2">¿Dónde está el líder de mafia china que operaba en Chile? |</p>
                    {{-- Opcional --}}
                </div>

                {{-- Video 2 --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-2 text-center small">Tras intenso temporal</h5> {{-- Cambia este título --}}
                    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/4_nzRhK6v5I?si=iSy-WpXg3sj48jZq" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <p class="text-center small mt-2">Captan el primer tornado de la temporada en la región del BioBío</p>
                    {{-- Opcional --}}
                </div>

                {{-- Video 3 --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-2 text-center small">Trump desata las alarmas en Europa</h5> {{-- Cambia este título --}}
                    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/5Ftup_0osWA?si=3FUvQ88iYDQ92wGz" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <p class="text-center small mt-2">LAS NOTICIAS | Rusia advierte a Ucrania y Europa amenaza </p>
                    {{-- Opcional --}}
                </div>

                {{-- Agrega más videos siguiendo el mismo patrón de columna --}}

            </div>
        </div>
    </div>
@endsection
