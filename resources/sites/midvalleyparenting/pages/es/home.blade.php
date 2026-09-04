@extends('site::partials.layout')

@section('title', 'Sobre Nosotros | Mid-Valley Parenting')
@section('description', 'Mid-Valley Parenting es un centro de educación para padres que sirve a los condados de Polk y Yamhill con clases y recursos en español.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Sobre nosotros</p>
        <h1>Mid-Valley Parenting</h1>
        <p class="page-intro">Apoyo, clases y recursos para padres y cuidadores en los condados de Polk y Yamhill.</p>
    </section>

    <div class="page-wrap prose">
        <p>Mid-Valley Parenting es un centro de educación para padres en dos condados por el <a href="https://orparenting.org/" rel="noopener">Oregon Parenting Education Collaborative (OPEC)</a> que incluye los condados de Polk y Yamhill. Mid-Valley Parenting se enfoca en la colaboración con socios para proveer educación para padres basada en la evidencia en inglés y español por toda la región. Trabajamos para normalizar la educación para padres con mensajes positivos y programación para la participación familiar que promueven actividades sanas para la familia y el aprendizaje temprano.</p>

        <h2>Nuestra Misión</h2>
        <p>La misión de Mid-Valley Parenting es proveer la educación para todos los padres, resultando en comunidades conectadas y florecientes. Nuestra visión es que los socios comunitarios colaboren para asegurar el aprendizaje de toda la vida para mejorar el ciclo de resultados familiares.</p>

        <h2>Áreas de Enfoque</h2>
        <ul>
            <li>Proveer servicios y apoyo coordinados a las familias</li>
            <li>Crecer el conocimiento de los padres sobre el desarrollo infantil y expectativas realísticas</li>
            <li>Conectar a los padres entre ellos para construir una fuerte red de apoyo</li>
            <li>Fomentar la disposición de los niños para aprender</li>
            <li>Normalizar la educación para padres</li>
        </ul>

        <h2>Para Más Información</h2>
        <p>Para contactar a uno de nuestros coordinadores de educación para padres:</p>
        <div class="county-grid">
            <div class="county-card">
                <h3>Condado de Polk</h3>
                <p class="role">Abby Warren</p>
                <p><a href="tel:+15037511644">503-751-1644</a></p>
                <p><a href="mailto:warren.abby@co.polk.or.us">warren.abby@co.polk.or.us</a></p>
            </div>
            <div class="county-card">
                <h3>Condado de Yamhill</h3>
                <p class="role">Shealyn Wippert</p>
                <p><a href="tel:+19714610532">971-461-0532</a></p>
                <p><a href="mailto:swippert@yamhillcco.org">swippert@yamhillcco.org</a></p>
            </div>
        </div>

        <p style="margin-top: 2em;">¡Denos me gusta en <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook</a>! Encuéntrenos al facebook.com/MidValleyParenting, o busque Mid-Valley Parenting.</p>
    </div>

    <section class="cta-band">
        <h2>Recursos en español</h2>
        <p>Guías de desarrollo para descargar y recursos de confianza para las familias.</p>
        <a class="btn btn-primary" href="/es/recursos">Ver Recursos</a>
    </section>
@endsection
