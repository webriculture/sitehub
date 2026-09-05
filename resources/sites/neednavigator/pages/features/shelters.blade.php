@extends('site::partials.layout')

@section('title', 'Homeless Shelter Bed Management Software | Need Navigator')
@section('description', 'Run shelter beds visually: floor plans, a week-at-a-glance bed matrix, family check-in and check-out, exit reasons, and stay records for reporting.')

@php
    $faqs = [
        [
            'q' => 'Can families be checked in and out together?',
            'a' => 'Yes. A family or group books together, and staff check the whole group in or out in a single action. Each member keeps their own stay record, so bed nights (actual and planned-versus-actual) and categorized exit reasons stay accurate per person.',
        ],
        [
            'q' => 'How do staff see what is open tonight?',
            'a' => 'Three ways: a week-at-a-time bed-by-date matrix with occupant spans, per-date room summaries, and a visual bed picker with live status colors on the floor plan itself. Bed status updates as reservations move through their lifecycle.',
        ],
        [
            'q' => 'What happens when a bed is out of service?',
            'a' => 'Mark it under maintenance or offline with a comment, and it drops out of availability until it is resolved. The resolution history is kept, so you can show a funder or facilities team exactly when a bed was down and why.',
        ],
        [
            'q' => 'How does this relate to HMIS?',
            'a' => 'HMIS (Homeless Management Information System) is the record-keeping standard many homeless-services funders expect. Need Navigator uses an HMIS-adjacent data model: the HMIS number is a first-class field on every client record, stays capture bed nights and categorized exit reasons, and reservations are a first-class report type. We do not make federal compliance claims. Reports are assembled in the flexible report builder, with breakdowns and Excel exports that support your funder reporting.',
        ],
        [
            'q' => 'Can it handle multiple shelters, buildings, and floors?',
            'a' => 'Yes. Each shelter has its own eligibility attributes (age range, veteran-only, household size limits), check-in and check-out times, and multi-floor layout. A bulk builder creates floors, rooms, and beds in one step, and every floor-plan change is saved as a version with its author and reason.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Shelters & bed reservations'],
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
                    <li aria-current="page">Shelters &amp; bed reservations</li>
                </ol>
            </nav>
            <p class="eyebrow">Shelters &amp; bed reservations</p>
            <h1>Every bed, every night, accounted for</h1>
            <p class="lede">Homeless shelter bed management software should mirror the building itself. Need Navigator gives you floors, rooms, and beds you can actually see, along with a reservation workflow that runs from booking to check-out, keeps families together, and leaves behind the stay records your reporting needs.</p>
        </div>
    </section>

    {{-- ================= Bed matrix UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: shelters-bed-matrix | filled 2026-09-04 with a real screenshot: img/screens/reservation-floor-plan (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>New reservation</span></div>
                    @include('site::partials.screen', ['name' => 'reservation-floor-plan', 'alt' => 'A new reservation form: program, permission level, status and shelter selects, an individual search, a strip of check-in dates, first and second floor tabs, and a floor plan with rooms 101 to 105 each showing four of four beds free', 'width' => 1665, 'height' => 740])
                </div>
                <figcaption class="ui-caption">A new reservation on a test instance: choose the program, shelter and permission level, find the person, pick the check-in date from the strip, then pick the bed from the floor plan, where each room shows how many beds are free.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the shelter module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 12h9V3M12 12v9M12 16h9"/></svg></span>
                    <h3>A floor plan you can draw</h3>
                    <p>Lay out multi-floor buildings with live bed-status colors: available, occupied, maintenance, offline. Every change is saved as a new version with its author and reason, so the plan has a history you can stand behind.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V9l6-5 6 5v11"/><path d="M9 20v-4h6v4M9 12h.01M15 12h.01"/></svg></span>
                    <h3>Set up a building in minutes</h3>
                    <p>A bulk builder creates floors &times; rooms &times; beds in one step. Each shelter carries its own eligibility attributes (age range, veteran-only, household size limits) and typical check-in and check-out times.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7-3-3-7 7v3z"/><path d="M18 13l-3-3M4 21h4M3 8c1.5 0 2.5-1 2.5-2.5C5.5 7 6.5 8 8 8c-1.5 0-2.5 1-2.5 2.5C5.5 9 4.5 8 3 8Z"/></svg></span>
                    <h3>A drafting assistant for the plan</h3>
                    <p>One of exactly two AI features in Need Navigator: describe your rooms and beds, and the assistant drafts a to-scale floor plan for you to edit. It saves an afternoon of drawing. The layout stays yours.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h4l2-6 4 12 2-6h4"/></svg></span>
                    <h3>The whole stay, one workflow</h3>
                    <p>Reservations move from pending to confirmed to checked in to checked out, with cancel and no-show where reality intervenes, and open-ended stays where your shelter allows them.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="16.5" cy="9.5" r="2.2"/><path d="M3.5 19c0-2.8 2.3-4.6 5.5-4.6s5.5 1.8 5.5 4.6"/><path d="M15 16.7c.6-1.6 2-2.4 3.7-2.4 1 0 1.8.3 2.4.8"/></svg></span>
                    <h3>Families stay together</h3>
                    <p>Book a family as a group and check everyone in, or out, in one action. No juggling four separate reservations to keep two kids next to their parents.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4M7 14h3M12 14h3M7 17.5h3"/></svg></span>
                    <h3>This week at a glance</h3>
                    <p>The bed-by-date matrix shows a week of occupancy as spans you can read in a second, navigable week by week, with per-date room summaries and a visual bed picker when it's time to place someone.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 6.5a4 4 0 0 0-5.6 5L4 16.4V20h3.6l4.9-4.9a4 4 0 0 0 5-5.6l-2.6 2.6-2.4-2.4Z"/></svg></span>
                    <h3>Beds go down: track it</h3>
                    <p>Take a bed offline or mark it for maintenance with a comment. It leaves availability until resolved, and the full history of downtime and resolutions is kept.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M14 16l5-4-5-4M19 12H9"/></svg></span>
                    <h3>Check-out that finishes the record</h3>
                    <p>Check-out captures a categorized exit reason your agency defined, and automations can act on it, including closing the client's program enrollment. Bed nights, actual and planned-versus-actual, are tracked per stay.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A night at the front desk</h3>
                <p>A family of four arrives at 9 p.m. The overnight coordinator checks the matrix: two adjoining rooms open on floor two. They book the family as a group: one action, four people, both rooms. The beds flip to occupied on the floor plan behind them.</p>
                <p>Weeks later at check-out, the coordinator records the exit reason ("moved to transitional housing," one their agency defined), and an automation closes the family's shelter-program enrollment. The stay's bed nights are already sitting in the report their director sends the county.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions shelters ask</h2>
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
                <a href="/features/geotracker">GeoTracker for street outreach</a>
                <a href="/features/casework">Visits, notes &amp; goals</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/solutions/shelters-housing">For shelters &amp; housing programs</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See your building in it', 'blurb' => 'Bring a floor plan to the demo. We will draft it live and walk a reservation from booking to check-out.'])

@endsection
