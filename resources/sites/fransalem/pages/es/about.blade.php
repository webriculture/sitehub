@extends('site::partials.layout')

@section('title', 'Quiénes Somos | FRAN')
@section('description', 'FRAN — la Red de Defensa de Recursos Familiares — es un centro de recursos y apoyo para las familias del noreste de Salem, creado por la Fundación Familiar Larry y Jeanette Epping y administrado por la Fostering Hope Initiative de Catholic Community Services.')

@section('content')
    <section class="section" id="about">
        <div class="container grid cols-2 about-layout">
            <div class="panel orange illustrated-panel">
                <p class="eyebrow text-black">Quiénes somos</p>
                <h1 class="section-title small">Red de Defensa de Recursos Familiares</h1>
                <p class="about-subtitle">Un centro de recursos y apoyo para las familias del noreste de Salem.</p>
                <p>Administrada profesionalmente por la Fostering Hope Initiative de Catholic Community Services, la Red de Defensa de Recursos Familiares (FRAN) fue creada por la Fundación Familiar Larry y Jeanette Epping como un espacio comunitario acogedor y una puerta de entrada a los servicios sociales y programas de autosuficiencia en los que confían las familias del noreste de Salem.</p>
                <p>En lugar de enviar a las familias de una oficina a otra por toda la ciudad, FRAN reúne a las organizaciones asociadas en un solo lugar, donde los defensores le ayudan a navegar programas, clases y recursos con dignidad y sin complicaciones. El lema de FRAN, <em>Apoyando juntos al noreste de Salem</em>, refleja la misión de ofrecer un solo lugar donde las familias puedan recibir apoyo, crear conexiones y formar comunidad.</p>
                <blockquote class="about-quote">
                    <p>&ldquo;FRAN es un centro comunitario de servicios sociales fundado en el entendimiento de que todos, en algún momento de la vida, enfrentamos adversidades. Nuestra meta es ofrecer un espacio seguro y acogedor donde las personas y las familias puedan navegar esos desafíos y comenzar a superarlos. Ya sea que alguien llegue buscando estabilidad, apoyo, educación o simplemente un momento de tranquilidad, queremos que cada persona que cruce nuestras puertas sienta una cosa de inmediato: todo va a estar bien. A través de servicios de navegación, recursos de autosuficiencia, apoyo social y conductual, y oportunidades de salud y bienestar, FRAN ayuda a los jóvenes y a las familias a desarrollar resiliencia y crear caminos de oportunidad para toda la vida.&rdquo;</p>
                    <footer>&mdash;Gary Epping<br>Presidente, Fundación Familiar Larry y Jeanette Epping</footer>
                </blockquote>
            </div>
            <div class="stack">
                <h2 class="mini-heading">Lo Que Puede Hacer Aquí</h2>
                <a class="notice notice-link" href="/es/find-support"><strong>Conéctese con apoyo local.</strong><br>Encuentre organizaciones comunitarias que sirven a las familias del noreste de Salem, explore opciones de servicios y comuníquese directamente con los proveedores participantes.</a>
                <a class="notice notice-link" href="/es/contact"><strong>Dé su primer paso.</strong><br>¿No sabe por dónde empezar? Contáctenos o visite FRAN para explorar qué recursos y socios comunitarios son los adecuados para usted.</a>
                <a class="notice notice-link" href="/es/events"><strong>Participe en su comunidad.</strong><br>Explore eventos, talleres y clases en FRAN y únase a otras personas de su comunidad para aprender y conectarse.</a>
                <figure class="rounded-photo about-page-photo">
                    <img src="/sites/fransalem/assets/photos/fran-building.jpg" alt="El exterior del edificio de FRAN con su letrero vertical de FRAN">
                </figure>
            </div>
        </div>
    </section>
@endsection
