@extends('site::partials.layout')

@section('title', 'Buscar Apoyo | FRAN')
@section('description', 'Explore los proveedores locales asociados con FRAN — organizaciones de salud, vivienda, crianza, educación temprana y apoyo comunitario que sirven a las familias del noreste de Salem.')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Encuentre apoyo con FRAN</p>
            <h1 class="section-title">Explore Proveedores Locales</h1>
            <p class="lead">Seleccione un proveedor para conocer más sobre sus servicios y comunicarse directamente con ellos.</p>
        </div>
    </section>

    <section class="section" id="providers">
        <div class="container">
            <div class="provider-grid partner-grid find-support-grid">
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="/es/about">Fostering Hope Initiative</a>
                    <p>Una iniciativa vecinal de impacto colectivo de Catholic Community Services; ofrecemos servicios comunitarios de salud, residenciales y de embarazo. Nuestra misión es impulsar el desarrollo positivo de niños y adultos, fortalecer a las familias y construir comunidad.</p>
                    <p class="partner-categories">Alimentos, Salud y Bienestar | Vivienda y Servicios Básicos | Apoyo para Padres y Educación Temprana | Apoyo Comunitario y Referencias</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a>
                    <p>Manteniendo a los niños seguros y a las familias unidas, somos la guardería de alivio que sirve a los condados de Marion y Polk, trabajando junto a las familias para prevenir el abuso y la negligencia infantil.</p>
                    <p class="partner-categories">Alimentos, Salud y Bienestar | Apoyo para Padres y Educación Temprana | Apoyo Comunitario y Referencias</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.jdhealthandwellness.com/" target="_blank" rel="noopener">JD Health &amp; Wellness</a>
                    <p>Más que una clínica, somos una comunidad de sanadores, mentores y guías que caminan a su lado. Ya sea que busque liberarse de una adicción, apoyo para la salud mental de su adolescente o un aliado de confianza en el bienestar continuo de su familia, nuestro equipo le recibe con compasión, respeto y comprensión.</p>
                    <p class="partner-categories">Alimentos, Salud y Bienestar</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a>
                    <p>Brindamos acceso a servicios y creamos alianzas para promover comunidades saludables, incluyendo salud conductual, salud pública, servicios para discapacidades intelectuales y del desarrollo, y más.</p>
                    <p class="partner-categories">Alimentos, Salud y Bienestar | Apoyo Comunitario y Referencias</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.co.marion.or.us/HA" target="_blank" rel="noopener">Marion County Housing Authority</a>
                    <p>Nuestra misión es hacer del condado de Marion un mejor lugar para vivir, desarrollando, administrando y manteniendo viviendas seguras, dignas y asequibles para sus residentes.</p>
                    <p class="partner-categories">Vivienda y Servicios Básicos</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a>
                    <p>Creemos que la atención médica es un derecho humano y mantenemos nuestro compromiso de tratar a todos con dignidad, amabilidad y respeto. Ofrecemos servicios médicos, dentales, de salud mental y sociales.</p>
                    <p class="partner-categories">Alimentos, Salud y Bienestar | Apoyo Comunitario y Referencias</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://oregonaeyc.org/" target="_blank" rel="noopener">Oregon Association for the Education of Young Children</a>
                    <p>Nuestra misión es promover una educación temprana de alta calidad para todos los niños pequeños, desde el nacimiento hasta los 8 años, conectando la práctica, las políticas y la investigación de la primera infancia. Impulsamos una profesión de primera infancia diversa y dinámica, y apoyamos a todas las personas que cuidan, educan y trabajan en favor de los niños pequeños.</p>
                    <p class="partner-categories">Apoyo para Padres y Educación Temprana</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://punxwithpurpose.org/" target="_blank" rel="noopener">Punx With Purpose</a>
                    <p>Empoderamos a los jóvenes en riesgo de los condados de Marion y Polk, encontrándolos donde están y buscando ofrecer espacios más seguros donde nuestros jóvenes puedan reunirse y recibir los recursos que necesitan para tener éxito y convertirse en miembros plenos de la comunidad.</p>
                    <p class="partner-categories">Apoyo Comunitario y Referencias</p>
                </article>
            </div>
            <p class="provider-more text-center"><em>¡Más socios comunitarios próximamente!</em></p>
        </div>
    </section>
@endsection
