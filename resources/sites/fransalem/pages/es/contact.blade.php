@extends('site::partials.layout')

@section('title', 'Contacto | FRAN')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Contáctenos</p>
            <h1 class="section-title">¿Preguntas sobre FRAN?</h1>
            <p class="lead">Envíenos un correo electrónico y le ayudaremos a encontrar la dirección correcta.</p>
        </div>
    </section>

    <section class="section">
        <div class="container grid cols-2 contact-page-layout">
            <div class="stack">
                {{-- FRAN es una construcción nueva y aún no aparece de forma confiable en
                     las búsquedas de mapas; el mapa integrado orienta donde el buscador no puede. --}}
                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps?q=3803+Lancaster+Dr+NE,+Salem,+OR+97305&output=embed"
                        title="Mapa que muestra la ubicación de FRAN en 3803 Lancaster Dr NE, Salem, Oregón"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
                <figure class="rounded-photo contact-page-photo">
                    <img src="/sites/fransalem/assets/photos/fran-windows.jpg" alt="La fachada del edificio de FRAN con filas de ventanas cubiertas por toldos">
                </figure>
            </div>
            <div class="stack">
                <a class="notice notice-link" href="https://www.google.com/maps/search/?api=1&query=3803+Lancaster+Dr+NE,+Salem,+OR+97305" target="_blank" rel="noopener"><strong>Visite FRAN</strong><br>3803 Lancaster Dr NE<br>Salem, OR 97305</a>
                <div class="notice"><strong>Correo electrónico</strong><br><a href="mailto:Info@FranSalem.com">Info@FranSalem.com</a></div>
                <a class="notice notice-link" href="/es/find-support"><strong>¿Busca un proveedor?</strong><br>Explore los socios comunitarios y recursos disponibles en FRAN.</a>
                <a class="notice notice-link" href="/es/events"><strong>¿Busca eventos y clases comunitarias?</strong><br>Explore lo que viene en FRAN.</a>
            </div>
        </div>
    </section>
@endsection
