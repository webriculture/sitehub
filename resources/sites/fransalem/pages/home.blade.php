@extends('site::partials.layout')

@section('title', 'FRAN — Family Resource Advocacy Network | Northeast Salem')

@section('hero')
    <section class="hero">
        <div class="wrap">
            <h1>A welcoming place for Northeast Salem families</h1>
            <p>FRAN is a community gathering space and a hub for navigating social services and self-sufficiency programs — with trusted partner organizations under one roof.</p>
            <a class="cta" href="/partners">See who's here to help</a>
        </div>
    </section>
@endsection

@section('content')
    <h2>What you'll find at FRAN</h2>
    <ul class="cards">
        <li><h3>Service navigation</h3><p>Friendly help finding the right program, from housing to food to family support.</p></li>
        <li><h3>Partner organizations</h3><p>Local organizations providing outreach and services on site, every week.</p></li>
        <li><h3>Classes &amp; events</h3><p>Free workshops, classes, and community events for the whole family.</p></li>
    </ul>

    <h2>Happening soon</h2>
    <x-site-events />
@endsection
