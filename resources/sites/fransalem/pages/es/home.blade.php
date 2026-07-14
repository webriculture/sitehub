@extends('site::partials.layout')

@section('title', 'FRAN — Red de Defensa de Recursos Familiares | Noreste de Salem')

@section('hero')
    <section class="hero">
        <div class="wrap">
            <h1>Un lugar acogedor para las familias del noreste de Salem</h1>
            <p>FRAN es un espacio comunitario y un centro para navegar servicios sociales y programas de autosuficiencia — con organizaciones asociadas de confianza bajo un mismo techo.</p>
            <a class="cta" href="/es/partners">Conozca quién está aquí para ayudar</a>
        </div>
    </section>
@endsection

@section('content')
    <h2>Lo que encontrará en FRAN</h2>
    <ul class="cards">
        <li><h3>Navegación de servicios</h3><p>Ayuda amable para encontrar el programa adecuado: vivienda, alimentos, apoyo familiar y más.</p></li>
        <li><h3>Organizaciones asociadas</h3><p>Organizaciones locales que brindan servicios y alcance comunitario en el centro, cada semana.</p></li>
        <li><h3>Clases y eventos</h3><p>Talleres, clases y eventos comunitarios gratuitos para toda la familia.</p></li>
    </ul>

    <h2>Próximamente</h2>
    <x-site-events />
@endsection
