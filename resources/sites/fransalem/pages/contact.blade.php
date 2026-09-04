@extends('site::partials.layout')

@section('title', 'Contact | FRAN')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Contact Us</p>
            <h1 class="section-title">Questions about FRAN?</h1>
            <p class="lead">Send us an email and we’ll help point you in the right direction.</p>
        </div>
    </section>

    <section class="section">
        <div class="container grid cols-2 contact-page-layout">
            <div class="stack">
                {{-- FRAN is new construction and doesn't reliably surface in map searches
                     yet, so the embedded map does the wayfinding the search box can't. --}}
                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps?q=3803+Lancaster+Dr+NE,+Salem,+OR+97305&output=embed"
                        title="Map showing the location of FRAN at 3803 Lancaster Dr NE, Salem, Oregon"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
                <figure class="rounded-photo contact-page-photo">
                    <img src="/sites/fransalem/assets/photos/fran-windows.jpg" alt="The FRAN building facade with rows of awning-covered windows">
                </figure>
            </div>
            <div class="stack">
                <a class="notice notice-link" href="https://www.google.com/maps/search/?api=1&query=3803+Lancaster+Dr+NE,+Salem,+OR+97305" target="_blank" rel="noopener"><strong>Visit FRAN</strong><br>3803 Lancaster Dr NE<br>Salem, OR 97305</a>
                <div class="notice"><strong>Email</strong><br><a href="mailto:Info@FranSalem.com">Info@FranSalem.com</a></div>
                <a class="notice notice-link" href="/find-support"><strong>Looking for a provider?</strong><br>Browse community partners and resources available at FRAN.</a>
                <a class="notice notice-link" href="/events"><strong>Looking for community events and classes?</strong><br>Explore what's coming up at FRAN.</a>
            </div>
        </div>
    </section>
@endsection
