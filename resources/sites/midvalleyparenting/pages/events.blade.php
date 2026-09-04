@extends('site::partials.layout')

@section('title', 'Events | Mid-Valley Parenting')
@section('description', 'Workshops, family activities, and community events for families in Polk and Yamhill Counties.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Workshops &amp; activities</p>
        <h1>Events for Mid-Valley families</h1>
        <p class="page-intro">Family activities, workshops, and community events happen throughout the year across Polk and Yamhill Counties.</p>
    </section>

    <div class="page-wrap prose">
        <h2>Upcoming events</h2>
        <x-site-events kind="event" />
        <p class="note-muted">New events are added throughout the year and announced on our <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook page</a>.</p>

        <h2>What kinds of events?</h2>
        <ul>
            <li><strong>Family engagement events</strong> — like Fam Jam, a celebration of the transition from early learning to kindergarten, with games, giveaways, and local resource providers.</li>
            <li><strong>One-time workshops</strong> — parent education workshops hosted with community partners around the region.</li>
            <li><strong>Community activities</strong> — connect-and-play events, resource fairs, and seasonal celebrations.</li>
        </ul>

        <p>A full events calendar is coming to this page. In the meantime, upcoming events are announced on our <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook page</a>, and several current family activities are listed with our <a href="/classes">classes</a>.</p>

        <h2>Have an event to share?</h2>
        <p>If your organization has a family-friendly event in Polk or Yamhill County, we'd love to hear about it — <a href="/contact">contact us</a> with the details.</p>
    </div>

    <section class="cta-band">
        <h2>Don't miss what's next.</h2>
        <p>Follow Mid-Valley Parenting on Facebook for event announcements, or check the classes page for current activities.</p>
        <a class="btn btn-primary" href="/classes">See Current Classes</a>
    </section>
@endsection
