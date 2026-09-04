@extends('site::partials.layout')

@section('title', 'FRAN | Red de Defensa de Recursos Familiares')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-shell">
                <div class="hero-banner" aria-label="Mensaje de apoyo familiar de FRAN">
                    <img src="/sites/fransalem/assets/photos/hero-family-piggyback.jpg" alt="Una cuidadora sonriendo mientras lleva a un niño a caballito">
                    <div class="stack hero-copy">
                        <p class="eyebrow">Red de Defensa de Recursos Familiares</p>
                        <h1>Familia.<br>Conexión.<br>Comunidad.</h1>
                        <p class="lead"><em>Apoyando juntos al noreste de Salem.</em></p>
                        <div class="hero-actions">
                            <a class="button primary" href="/es/find-support">Buscar Apoyo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="wave" aria-hidden="true"></div>

    <section class="section-tight intro-band">
        <div class="container panel sky">
            <div class="grid cols-2 intro-layout">
                <div class="intro-copy">
                    <p class="eyebrow">Bienvenido a FRAN</p>
                    <h2 class="section-title small">Un punto de partida amable para los servicios familiares locales</h2>
                    <p class="lead">Encuentre organizaciones locales, recursos y apoyo en un solo lugar acogedor. Ya sea que busque recursos de salud, educación temprana, conexiones comunitarias y más, FRAN puede ayudarle a encontrar el punto de partida.</p>
                    <div class="intro-actions">
                        <a class="button primary" href="/es/find-support">Socios Comunitarios</a>
                        <a class="button ghost" href="/es/about">Acerca de FRAN</a>
                    </div>
                </div>
                <figure class="rounded-photo intro-photo">
                    <img src="/sites/fransalem/assets/photos/family-photo.jpg" alt="Una familia de cinco riendo juntos en casa">
                </figure>
            </div>
        </div>
    </section>

    <section class="section support-section" id="support">
        <div class="container">
            <div class="text-center narrow">
                <p class="eyebrow">Cómo puede ayudar FRAN</p>
                <h2 class="section-title small">Encuentre el apoyo adecuado para su familia</h2>
            </div>
            <div class="grid cols-2">
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/healthcare-support.jpg" alt="Un niño recibiendo un chequeo médico">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/health-wellness.svg" alt="" aria-hidden="true"></div>
                    <h3>Alimentos, Salud y Bienestar</h3>
                    <p>Conéctese con recursos de salud, dentales, posparto, asistencia alimentaria y otros recursos de bienestar para niños y cuidadores.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORAR SOCIOS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/es/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://www.jdhealthandwellness.com/" target="_blank" rel="noopener">JD Health &amp; Wellness</a></li>
                            <li><a href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a></li>
                            <li><a href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/housing-utilities.jpg" alt="Un niño junto a la ventana de una casita de juegos">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/housing-utilities.svg" alt="" aria-hidden="true"></div>
                    <h3>Vivienda y Servicios Básicos</h3>
                    <p>Sepa a dónde acudir para recibir apoyo con la estabilidad del hogar, los servicios básicos y las necesidades esenciales.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORAR SOCIOS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/es/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://www.co.marion.or.us/HA" target="_blank" rel="noopener">Marion County Housing Authority</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/parenting-support.jpg" alt="Un adulto tomando de la mano a un niño con mochila">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/parenting-support.svg" alt="" aria-hidden="true"></div>
                    <h3>Apoyo para Padres y Educación Temprana</h3>
                    <p>Encuentre programas para fortalecer a las familias y explore recursos y organizaciones de educación temprana, cuidado infantil, preparación escolar y desarrollo infantil.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORAR SOCIOS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/es/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://oregonaeyc.org/" target="_blank" rel="noopener">Oregon Association for the Education of Young Children</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/laptop-resources.jpg" alt="Una defensora mostrando recursos en una computadora portátil a un miembro de la comunidad">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/community-referrals.svg" alt="" aria-hidden="true"></div>
                    <h3>Apoyo Comunitario y Referencias</h3>
                    <p>Encuentre organizaciones locales y apoyos que pueden guiarle hacia el siguiente paso útil.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORAR SOCIOS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/es/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://punxwithpurpose.org/" target="_blank" rel="noopener">Punx With Purpose</a></li>
                            <li><a href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a></li>
                            <li><a href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a></li>
                        </ul>
                    </details>
                </article>
            </div>
        </div>
    </section>

    <section class="section events-band" id="events">
        <div class="container">
            <div class="text-center narrow">
                <p class="eyebrow">Eventos en FRAN</p>
                <h2 class="section-title small">Próximamente</h2>
                <p class="lead">Talleres, clases y eventos comunitarios para toda la familia.</p>
            </div>
            <div class="events-teaser">
                <x-site-events limit="1" />
            </div>
            <p class="events-more text-center"><a class="button" href="/es/events">Todos los Eventos y Clases</a></p>
        </div>
    </section>
@endsection
