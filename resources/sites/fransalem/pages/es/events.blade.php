@extends('site::partials.layout')

@section('title', 'Eventos y Clases | FRAN')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Eventos en FRAN</p>
            <h1 class="section-title">Próximamente</h1>
            <p class="lead">Explore e inscríbase en talleres, clases y eventos comunitarios para toda la familia. Si desea más información sobre los eventos en FRAN, escríbanos a <a href="mailto:Info@FranSalem.com">Info@FranSalem.com</a>.</p>
        </div>
    </section>

    <section class="section">
        <div class="container narrow">
            <x-site-events />
        </div>
    </section>
@endsection
