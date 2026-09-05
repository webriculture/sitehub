@extends('site::partials.layout')

@section('title', 'Street Outreach Tracking Software | Need Navigator')
@section('description', 'Log street outreach in one tap: GPS-stamped encounters, places your team names, a supervisor map with filters, Excel export, and a strong PIT count tool.')

@php
    $faqs = [
        [
            'q' => 'How does logging work in the field?',
            'a' => "From the client's profile on a phone, one tap on the quick-action menu creates a location log with a GPS stamp and a timestamp, with the client's record attached, and a task attached when the worker wants a follow-up. There is no form to fill out and no address to invent for a tent site or an underpass.",
        ],
        [
            'q' => 'What is a place, and who controls the list?',
            'a' => 'When location logs land within roughly 250 feet of each other, GeoTracker clusters them into a place automatically. Your staff give each place the name the team actually uses, freeze its center so it stops drifting as new logs arrive, reposition it by hand, and remove one once it holds nothing. Named places then work as a filter on the supervisor map.',
        ],
        [
            'q' => 'What do funders actually get?',
            'a' => 'Location-stamped service verification: each log records where and when a service contact happened, tied to a client and a worker. Supervisors filter the map by worker, client, task list, place, or date range, and location logs export to Excel for home-visiting and outreach reporting.',
        ],
        [
            'q' => 'Can we run our Point-in-Time count with it?',
            'a' => 'Yes. GeoTracker is a strong PIT count tool. The Point-in-Time (PIT) count is the one-night count of people experiencing homelessness that HUD, the U.S. Department of Housing and Urban Development, asks communities to conduct. Count-night teams log each contact where it happens; afterward, the map shows what ground was covered and the Excel export supports the tally.',
        ],
    ];

    $faqJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];

    $host = \App\Tenancy\Tenancy::current()?->primaryDomain()?->hostname ?? request()->getHost();
    $breadcrumbJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://'.$host.'/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Features', 'item' => 'https://'.$host.'/features'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'GeoTracker'],
        ],
    ];
@endphp

@section('structured')
    <script type="application/ld+json">{!! json_encode($faqJsonLd, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($breadcrumbJsonLd, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')

    <section class="section" style="padding-bottom: clamp(2rem, 4vw, 3rem)">
        <div class="container">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li><a href="/features">Features</a></li>
                    <li aria-current="page">GeoTracker</li>
                </ol>
            </nav>
            <p class="eyebrow">GeoTracker</p>
            <h1>One tap in the field, the whole week on a map</h1>
            <p class="lede">Street outreach tracking software has to work with one thumb, standing on a sidewalk. GeoTracker logs where an encounter happened in one tap from the client's profile, gathers those logs into places your team names, and puts everyone's week on a supervisor's map. It's in heavy daily field use at a large Oregon agency.</p>
        </div>
    </section>

    {{-- ================= Supervisor map UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: geotracker-supervisor-map | filled 2026-09-04 with a real screenshot: img/screens/geotracker-map (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>GeoTracker: supervisor map</span></div>
                    @include('site::partials.screen', ['name' => 'geotracker-map', 'alt' => 'A map of Salem, Oregon with location logs clustered into numbered markers and place pins, beside a filter panel for task list, place, user, individual, and date range, with apply and export buttons', 'width' => 1680, 'height' => 709])
                </div>
                <figcaption class="ui-caption">The GeoTracker supervisor map on a test instance: location logs across Salem clustered into counted markers and named places, with filters for task list, place, worker, client, and date range, and an export of the underlying logs.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What GeoTracker does</h2>
                <p class="muted">Not a roadmap item. This module is in heavy daily field use at a large Oregon agency, and it shows in the details.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6-4.8-6-9.5a6 6 0 0 1 12 0C18 16.2 12 21 12 21Z"/><circle cx="12" cy="11" r="2.2"/><path d="M4 4l1.5 1.5M20 4l-1.5 1.5"/></svg></span>
                    <h3>Log it in one tap</h3>
                    <p>From the client's profile, one tap on the quick-action menu records a location log with a Global Positioning System (GPS) stamp. The client's record is attached, and a task is attached when you want one. No form, no typing an address that doesn't exist.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 9.5V20h12V9.5"/><circle cx="12" cy="13.5" r="2.2"/><path d="M12 15.7V18"/></svg></span>
                    <h3>Home visits, verified</h3>
                    <p>For home-visit programs, creating a task can capture a GPS location automatically, so field tasks carry a location stamp without anyone thinking about it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8" stroke-dasharray="2 3.2"/><circle cx="9.2" cy="9.5" r="1.6"/><circle cx="14.6" cy="11" r="1.6"/><circle cx="10.8" cy="14.5" r="1.6"/></svg></span>
                    <h3>Logs become places</h3>
                    <p>Locations within about 250 feet of each other cluster into a place automatically. Staff give it the name the team actually uses (the underpass, the camp behind the fairgrounds), then freeze its center so it stops drifting, or move it by hand when the map says otherwise.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2Z"/><path d="M9 4v14M15 6v14"/></svg></span>
                    <h3>The week on one map</h3>
                    <p>Supervisors see every log on a map with marker clustering, filtered by worker, client, task list, place, or date range. Coverage, gaps, and patterns are visible at a glance instead of assembled from memory.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M9 5V3.5A1.5 1.5 0 0 1 10.5 2h3A1.5 1.5 0 0 1 15 3.5V5"/><circle cx="12" cy="12" r="2"/><path d="M12 14v3.5"/></svg></span>
                    <h3>Proof for funders</h3>
                    <p>When a home-visiting or outreach funder asks you to verify where services happened, every log is a location-stamped answer, and the whole set exports to Excel.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13.5A8 8 0 1 1 10.5 4a6.5 6.5 0 0 0 9.5 9.5Z"/><circle cx="13" cy="20.5" r="1.1" fill="currentColor" stroke="none"/><circle cx="16.5" cy="20.5" r="1.1" fill="currentColor" stroke="none"/><circle cx="20" cy="20.5" r="1.1" fill="currentColor" stroke="none"/></svg></span>
                    <h3>Ready for the PIT count</h3>
                    <p>The Point-in-Time (PIT) count is field logging at its most intense. It is the one-night count of people experiencing homelessness that HUD (the U.S. Department of Housing and Urban Development) asks communities to run. Count teams log each contact where it happens; the map shows what ground was covered.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Tuesday, 7 a.m., under the overpass</h3>
                <p>An outreach worker finds a client they've been checking on for weeks. Phone already in hand, they open the profile, tap the quick-action menu, and log the location. Record attached, follow-up task attached. They're back in the conversation in seconds, because the software's job is to not interrupt it.</p>
                <p>Friday afternoon, their supervisor opens the map and filters to the team's week. The logs have already clustered into the places the team works: one they've named, one new cluster waiting for a name. When the program director asks where outreach happened this month, the answer is a map, and behind it, an Excel file.</p>
            </aside>
            {{-- [TESTIMONIAL: outreach supervisor at a large multi-service agency - GeoTracker in daily field use / PIT count] - replace this comment with a real, approved quote block when one exists. --}}
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions outreach teams ask</h2>
            </div>
            <div class="faq">
                @foreach ($faqs as $f)
                    <details class="faq-item">
                        <summary>{{ $f['q'] }}</summary>
                        <div class="faq-body"><p>{{ $f['a'] }}</p></div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= Cross-links ================= --}}
    <section class="section section--crosslinks">
        <div class="container">
            <p class="eyebrow" style="margin-bottom: 1rem">Works with</p>
            <div class="crosslinks">
                <a href="/features/shelters">Shelters &amp; bed reservations</a>
                <a href="/features/casework">Tasks, visits &amp; case notes</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/solutions/shelters-housing">For shelters &amp; housing programs</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See it from the sidewalk', 'blurb' => 'Bring your outreach routes to the demo. We\'ll log a visit from a phone and pull up the map the way a supervisor would on Friday afternoon.'])

@endsection
