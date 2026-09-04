@extends('site::partials.layout')

@section('title', 'Events & Classes | FRAN')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Events at FRAN</p>
            <h1 class="section-title">Happening Soon</h1>
            <p class="lead">Explore and register for workshops, classes and community events for the whole family. If you would like more information about events at FRAN, please email <a href="mailto:Info@FranSalem.com">Info@FranSalem.com</a>.</p>
        </div>
    </section>

    <section class="section">
        <div class="container narrow">
            <x-site-events />
        </div>
    </section>
@endsection
