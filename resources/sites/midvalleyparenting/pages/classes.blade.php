@extends('site::partials.layout')

@section('title', 'Find Classes | Mid-Valley Parenting')
@section('description', 'Upcoming parenting classes and parent discussion groups across Polk and Yamhill Counties, in person and online.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Upcoming classes</p>
        <h1>Parenting classes &amp; groups</h1>
        <p class="page-intro">Evidence-based classes, discussion groups, and family activities across Polk and Yamhill Counties — most are free, many are online.</p>
    </section>

    <div class="page-wrap wide prose">
        <x-site-events kind="class" />

        <p class="note-muted" style="margin-top: 28px;">Classes are added throughout the year — check back, or <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">follow us on Facebook</a> for announcements.</p>
    </div>

    <section class="cta-band">
        <h2>Not sure where to start?</h2>
        <p>Contact a Parent Education Coordinator and we'll help you find the class that fits your family.</p>
        <a class="btn btn-primary" href="/contact">Contact Us</a>
    </section>
@endsection
