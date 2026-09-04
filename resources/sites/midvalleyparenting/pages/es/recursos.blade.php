@extends('site::partials.layout')

@section('title', 'Recursos en Español | Mid-Valley Parenting')
@section('description', 'Guías de desarrollo infantil en español y recursos de confianza para familias en los condados de Polk y Yamhill.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Recursos familiares</p>
        <h1>Recursos en español</h1>
        <p class="page-intro">Guías, actividades e información para apoyar el desarrollo de sus hijos desde el nacimiento hasta los primeros años.</p>
    </section>

    <div class="page-wrap wide prose">
        <h2>Guías de Desarrollo por Edad</h2>
        <p>Estos libros tienen recursos, actividades e información para apoyar a los padres en el desarrollo de sus hijos desde el nacimiento hasta los 5 años. Puede descargar y compartir los libros aquí:</p>

        <div class="doc-grid">
            <div class="doc-card">
                <strong>Aprendiendo con Su Bebé</strong>
                <span>Del nacimiento a los 2 años</span>
                <span class="doc-links">
                    <a href="/sites/midvalleyparenting/docs/toolkit-birth-2-es.pdf">Español (PDF)</a>
                </span>
            </div>
            <div class="doc-card">
                <strong>Preparándose para la Escuela Paso a Paso</strong>
                <span>2–3 años</span>
                <span class="doc-links">
                    <a href="/sites/midvalleyparenting/docs/toolkit-2-3-es.pdf">Español (PDF)</a>
                </span>
            </div>
            <div class="doc-card">
                <strong>Preparándose para el Éxito en Kínder</strong>
                <span>4–5 años</span>
                <span class="doc-links">
                    <span class="doc-unavailable">Versión en español no disponible actualmente — <a href="/sites/midvalleyparenting/docs/toolkit-4-5-en.pdf" lang="en">English (PDF)</a></span>
                </span>
            </div>
        </div>

        <h2>Más Recursos</h2>
        <ul class="resource-list">
            <li><a href="https://www.211info.org/" rel="noopener">211info</a><p>Encuentre los recursos necesarios para sus necesidades específicas — disponible en español.</p></li>
            <li><a href="https://www.zerotothree.org/parenting-resources/" rel="noopener">Zero to Three</a><p>Información enfocada en el desarrollo temprano de su hijo.</p></li>
            <li><a href="https://www.pbs.org/parents/" rel="noopener">PBS Parents</a><p>Recursos para padres de un sitio amigable y acogedor.</p></li>
        </ul>

        <h2>Clases en Español</h2>
        <p>Mid-Valley Parenting ofrece clases para padres en español durante el año. <a href="/classes">Vea las clases actuales</a> o <a href="/contact">contáctenos</a> para más información.</p>
    </div>

    <section class="cta-band">
        <h2>¿Necesita ayuda?</h2>
        <p>Contacte a una coordinadora de educación para padres y le ayudaremos a encontrar la clase o el recurso adecuado.</p>
        <a class="btn btn-primary" href="/contact">Contáctenos</a>
    </section>
@endsection
