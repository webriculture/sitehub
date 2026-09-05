@extends('site::partials.layout')

@section('title', 'Case Management Software for Homeless Shelters')
@section('description', 'For shelters and housing programs: beds you can see, family check-in, exit reasons, GPS-stamped street outreach, and stay records your reporting runs on.')

@php
    $faqs = [
        [
            'q' => 'Is Need Navigator an HMIS?',
            'a' => 'No, and we say that plainly. HMIS (Homeless Management Information System) is the record-keeping standard many homeless-services funders require; Need Navigator uses an HMIS-adjacent data model instead: the HMIS number is a first-class field and duplicate key on every client record, stays keep bed nights and categorized exit reasons, and reservations are a first-class report type. Reports are assembled in the flexible report builder and export to Excel, which supports your funder reporting. We do not make federal compliance claims on your behalf.',
        ],
        [
            'q' => 'Can our outreach team use it for the Point-in-Time count?',
            'a' => 'Yes. GeoTracker is well-suited to Point-in-Time (PIT) count fieldwork, the annual single-night count of people experiencing homelessness. Field staff log a GPS-stamped location in one tap, locations cluster automatically into places a supervisor can name, and the map filters by worker, place, and date range. When it is time to tally, every location log exports to Excel.',
        ],
        [
            'q' => 'How do you protect people fleeing violence or in crisis?',
            'a' => 'Every staff view of a client record is logged (who, when, from where), and eight toggleable rules flag unusual access patterns, such as repeated views of one person or access outside assigned programs, for an administrator to resolve. Notes, documents, and folders carry record-level visibility, so a sensitive note can be limited to a program or team. The record itself can carry a domestic-violence-survivor flag and colored alert banners staff see the moment it opens.',
        ],
        [
            'q' => 'What gets recorded when someone leaves?',
            'a' => 'Check-out captures an exit reason your agency defined, grouped into categories, and an automation can act on it, including closing the client\'s program enrollment. The stay keeps its bed nights, actual and planned-versus-actual, and the enrollment episode keeps entry and exit dates and who recorded them. Reservations are a first-class report type, so stays, exits, and bed nights land in reports you can schedule and export.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions', 'item' => 'https://'.$host.'/solutions'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Shelters & housing'],
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
                    <li><a href="/solutions">Solutions</a></li>
                    <li aria-current="page">Shelters &amp; housing</li>
                </ol>
            </nav>
            <p class="eyebrow">For shelters &amp; housing programs</p>
            <h1>Tonight's beds, tomorrow's report</h1>
            <p class="lede">Case management software for homeless shelters is judged at the front desk, on the coldest night of the year. Need Navigator shows staff what is open right now, checks whole families in together, captures an exit reason on every check-out, and keeps the stay records (bed nights, entries, exits) that your reporting runs on. And when the work leaves the building, it comes along: outreach staff log GPS-stamped encounters in one tap.</p>
        </div>
    </section>

    {{-- ================= Reservation screenshot ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: shelters-housing-checkout | filled 2026-09-04 with a real screenshot: img/screens/reservation-floor-plan (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>New reservation</span></div>
                    @include('site::partials.screen', ['name' => 'reservation-floor-plan', 'alt' => 'A new reservation form: program, permission level, status and shelter selects, an individual search, a strip of check-in dates, first and second floor tabs, and a floor plan with rooms 101 to 105 each showing four of four beds free', 'width' => 1665, 'height' => 740])
                </div>
                <figcaption class="ui-caption">Booking a stay on a test instance: choose the program and shelter, find the person, pick the check-in date from the strip, then pick the bed from the floor plan, where each room shows how many beds are free. The same record carries the stay through check-out.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Workflow sections ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Built for the rhythm of shelter work</h2>
                <p class="muted">Six pieces of Need Navigator that carry the load for shelters and housing programs. The shelter module itself (floor plans, the bed matrix, maintenance tracking) has <a href="/features/shelters">its own page</a>.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V8l6-4 6 4v12"/><path d="M9 12h6M9 16h6"/></svg></span>
                    <h3>Beds you can see, families kept together</h3>
                    <p>Multi-floor floor plans show every bed and its status, a week-at-a-time matrix reads occupancy as spans, and a visual bed picker places people fast. Families book as a group and check in (or out) in one action, so keeping two kids next to their parents never means juggling four reservations.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5"/><path d="M4 12h10M10 8l4 4-4 4"/></svg></span>
                    <h3>Exits that close the loop</h3>
                    <p>Check-out captures an exit reason your agency defined, grouped into categories. Automations can act on it: closing the program enrollment, sending an email, creating a task. The enrollment episode keeps its entry and exit dates and who recorded them.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-5.3-6.5-10a6.5 6.5 0 0 1 13 0c0 4.7-6.5 10-6.5 10Z"/><circle cx="12" cy="11" r="2.5"/></svg></span>
                    <h3>Street outreach on the record</h3>
                    <p>Field staff log a GPS-stamped location from the client's record in one tap. Locations cluster automatically into places supervisors can name, the map filters by worker, client, place, and date range, and every log exports to Excel. All of it is well-suited to Point-in-Time (PIT) count fieldwork.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4L7 20M17 4l-2 16M4 9h17M3 15h17"/></svg></span>
                    <h3>An HMIS-adjacent data model: our words, chosen carefully</h3>
                    <p>HMIS (Homeless Management Information System) is the record-keeping standard many funders require. Need Navigator treats the HMIS number as a first-class field and duplicate key, stays keep bed nights and categorized exit reasons, and reservations are a first-class report type. But we make no federal compliance claims. The reports are yours to assemble, and they support your funder reporting.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.6-3 8.4-7 10-4-1.6-7-5.4-7-10V6Z"/><path d="M9 11.5c.8-1.1 1.8-1.7 3-1.7s2.2.6 3 1.7c-.8 1.1-1.8 1.7-3 1.7s-2.2-.6-3-1.7Z"/><circle cx="12" cy="11.5" r=".7" fill="currentColor" stroke="none"/></svg></span>
                    <h3>Privacy worthy of the people you serve</h3>
                    <p>Every staff view of a client record is logged: who, when, from where. Eight toggleable rules flag unusual patterns, from night-hours access to sequential record walking, for administrators to review. Notes, documents, and folders carry record-level visibility, and each agency runs on its own private database.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-4M11 17V9M15 17v-6M19 17V7"/></svg></span>
                    <h3>Stays and bed nights, reportable</h3>
                    <p>Bed nights are tracked per stay, actual and planned-versus-actual. Build reports on reservations, filtered by shelter, program, exit reason, or date range. Set a redaction level so personally identifiable information (PII) stays out of a board packet, then schedule delivery weekly or monthly with Excel export.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A cold-weather surge night</h3>
                <p>The county calls a cold-weather advisory at 4 p.m. The overnight coordinator brings the winter-overflow beds back from offline status, and the floor plan fills in as reservations land: a household of four booked as a group and checked in with one action, two more guests placed with the visual bed picker. By 10 p.m. the bed-by-date matrix reads as one solid block of spans, and the single bed still down for maintenance carries a comment so nobody offers it twice.</p>
                <p>Outside, the outreach team works the cold. For each person who declines to come in, they open the client's record and log a GPS-stamped location in one tap; by morning the pins have clustered into places the supervisor can name and filter. When the director asks how the night went, the answer is already a report built from the records staff made while it was happening: bed nights by shelter, exits by reason.</p>
            </aside>
            {{-- [TESTIMONIAL: shelter or housing-program director - on running surge nights without paper and reporting bed nights to the county] --}}
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions shelters and housing programs ask</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">Dig into the modules</p>
            <div class="crosslinks">
                <a href="/features/shelters">Shelters &amp; bed reservations</a>
                <a href="/features/geotracker">GeoTracker field logging</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/security">Security &amp; audit trail</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See it handle a full house', 'blurb' => 'Bring a hard night\'s questions: who is where, what is open, who left and why. We will book a family, check them in together, and show you the report their stay lands in.'])

@endsection
