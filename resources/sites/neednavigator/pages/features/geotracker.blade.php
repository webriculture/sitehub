@extends('site::partials.layout')

@section('title', 'Street Outreach Tracking Software | Need Navigator')
@section('description', 'Log street outreach in one tap — GPS-stamped encounters, places your team names, a supervisor map with filters, Excel export, and a strong PIT count tool.')

@php
    $faqs = [
        [
            'q' => 'How does logging work in the field?',
            'a' => "From the client's profile on a phone, one tap on the quick-action menu creates a location log with a GPS stamp and a timestamp, with the client's record attached — and a task attached when the worker wants a follow-up. There is no form to fill out and no address to invent for a tent site or an underpass.",
        ],
        [
            'q' => 'What is a place, and who controls the list?',
            'a' => 'When location logs land within roughly 250 feet of each other, GeoTracker clusters them into a place automatically. Your staff give each place the name the team actually uses, and dissolve a place when it stops being one. Named places then work as a filter on the supervisor map.',
        ],
        [
            'q' => 'What do funders actually get?',
            'a' => 'Location-stamped service verification: each log records where and when a service contact happened, tied to a client and a worker. Supervisors filter the map by worker, client, task list, place, or date range, and location logs export to Excel for home-visiting and outreach reporting.',
        ],
        [
            'q' => 'Can we run our Point-in-Time count with it?',
            'a' => 'Yes — GeoTracker is a strong PIT count tool. The Point-in-Time (PIT) count is the one-night count of people experiencing homelessness that HUD, the U.S. Department of Housing and Urban Development, asks communities to conduct. Count-night teams log each contact where it happens; afterward, the map shows what ground was covered and the Excel export supports the tally.',
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
            {{-- IMAGE SLOT: geotracker-supervisor-map | replace with: real screenshot of the GeoTracker supervisor map, light theme, landscape — clustered markers with counts, at least one staff-named place label visible, and the filter controls (worker / task list / place / date range) in frame. Placeholder: stylized SVG map with clustered logs, two named places, and one unnamed cluster. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>GeoTracker — supervisor map</span></div>
                    <div class="uiframe-body">
                        <div class="ui-geomap">
                            <div class="geo-chips">
                                <span class="geo-chip"><strong>Worker:</strong> All outreach staff</span>
                                <span class="geo-chip"><strong>Client:</strong> All</span>
                                <span class="geo-chip"><strong>Task list:</strong> Street outreach</span>
                                <span class="geo-chip"><strong>Place:</strong> All</span>
                                <span class="geo-chip"><strong>Dates:</strong> Mar 2&ndash;8</span>
                            </div>
                            <svg viewBox="0 0 720 400" xmlns="http://www.w3.org/2000/svg" focusable="false">
                                <rect width="720" height="400" fill="#f1ede2"/>
                                {{-- park / greenway --}}
                                <path d="M0 0 H210 C180 60 150 90 90 110 C50 122 20 120 0 112 Z" fill="#e9efe8"/>
                                <path d="M720 260 C650 250 600 280 570 340 C555 370 560 390 570 400 H720 Z" fill="#e9efe8"/>
                                {{-- streets --}}
                                <g stroke="#fffdf9" stroke-linecap="round" fill="none">
                                    <path d="M0 60 H720" stroke-width="5"/>
                                    <path d="M0 150 H720" stroke-width="12"/>
                                    <path d="M0 268 C120 260 240 276 360 268 S600 254 720 262" stroke-width="7"/>
                                    <path d="M170 0 V400" stroke-width="9"/>
                                    <path d="M300 150 V400" stroke-width="5"/>
                                    <path d="M430 0 V400" stroke-width="7"/>
                                    <path d="M598 0 C590 90 606 180 588 268" stroke-width="5"/>
                                </g>
                                {{-- highway --}}
                                <path d="M-10 396 C200 330 420 240 730 96" stroke="#fffdf9" stroke-width="16" fill="none"/>
                                <path d="M-10 396 C200 330 420 240 730 96" stroke="#f1ede2" stroke-width="1.5" stroke-dasharray="8 10" fill="none"/>
                                {{-- single location logs --}}
                                <g fill="#14382a">
                                    <circle cx="80" cy="212" r="5"/>
                                    <circle cx="500" cy="330" r="5"/>
                                    <circle cx="660" cy="150" r="5"/>
                                </g>
                                <g fill="#f5f2ea">
                                    <circle cx="80" cy="212" r="1.6"/>
                                    <circle cx="500" cy="330" r="1.6"/>
                                    <circle cx="660" cy="150" r="1.6"/>
                                </g>
                                {{-- cluster: named place on the highway --}}
                                <circle cx="222" cy="316" r="27" fill="none" stroke="#1e4d3a" stroke-opacity="0.3" stroke-width="1.5"/>
                                <circle cx="222" cy="316" r="18" fill="#1e4d3a"/>
                                <text x="222" y="316" text-anchor="middle" dy="0.35em" font-size="13" font-weight="700" fill="#f5f2ea">14</text>
                                <g>
                                    <rect x="256" y="288" width="140" height="24" rx="6" fill="#fffdf9" stroke="rgba(32,36,31,0.16)"/>
                                    <text x="266" y="304" font-size="11" font-weight="600" fill="#20241f">Riverbend underpass</text>
                                </g>
                                {{-- cluster: named place near the intersection --}}
                                <circle cx="466" cy="128" r="21" fill="none" stroke="#1e4d3a" stroke-opacity="0.3" stroke-width="1.5"/>
                                <circle cx="466" cy="128" r="14" fill="#1e4d3a"/>
                                <text x="466" y="128" text-anchor="middle" dy="0.35em" font-size="12" font-weight="700" fill="#f5f2ea">6</text>
                                <g>
                                    <rect x="490" y="98" width="112" height="24" rx="6" fill="#fffdf9" stroke="rgba(32,36,31,0.16)"/>
                                    <text x="500" y="114" font-size="11" font-weight="600" fill="#20241f">Oak &amp; 5th camp</text>
                                </g>
                                {{-- cluster: not yet named --}}
                                <circle cx="120" cy="104" r="11" fill="#1e4d3a"/>
                                <text x="120" y="104" text-anchor="middle" dy="0.35em" font-size="11" font-weight="700" fill="#f5f2ea">3</text>
                                <g>
                                    <rect x="140" y="80" width="104" height="22" rx="6" fill="#fffdf9" stroke="rgba(32,36,31,0.16)" stroke-dasharray="3 3"/>
                                    <text x="150" y="95" font-size="11" font-style="italic" fill="#565c55">unnamed place</text>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the GeoTracker supervisor map: one team's week of location logs, clustered into places — two named by staff, one still waiting for a name.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What GeoTracker does</h2>
                <p class="muted">Not a roadmap item — this module is in heavy daily field use at a large Oregon agency, and it shows in the details.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6-4.8-6-9.5a6 6 0 0 1 12 0C18 16.2 12 21 12 21Z"/><circle cx="12" cy="11" r="2.2"/><path d="M4 4l1.5 1.5M20 4l-1.5 1.5"/></svg></span>
                    <h3>Log it in one tap</h3>
                    <p>From the client's profile, one tap on the quick-action menu records a location log with a Global Positioning System (GPS) stamp — the client's record attached, and a task attached when you want one. No form, no typing an address that doesn't exist.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 9.5V20h12V9.5"/><circle cx="12" cy="13.5" r="2.2"/><path d="M12 15.7V18"/></svg></span>
                    <h3>Home visits, verified</h3>
                    <p>For home-visit programs, creating a task can capture a GPS location automatically — so field tasks carry a location stamp without anyone thinking about it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8" stroke-dasharray="2 3.2"/><circle cx="9.2" cy="9.5" r="1.6"/><circle cx="14.6" cy="11" r="1.6"/><circle cx="10.8" cy="14.5" r="1.6"/></svg></span>
                    <h3>Logs become places</h3>
                    <p>Locations within about 250 feet of each other cluster into a place automatically. Staff give it the name the team actually uses — the underpass, the camp behind the fairgrounds — and dissolve it when it no longer applies.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2Z"/><path d="M9 4v14M15 6v14"/></svg></span>
                    <h3>The week on one map</h3>
                    <p>Supervisors see every log on a map with marker clustering, filtered by worker, client, task list, place, or date range. Coverage, gaps, and patterns are visible at a glance instead of assembled from memory.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M9 5V3.5A1.5 1.5 0 0 1 10.5 2h3A1.5 1.5 0 0 1 15 3.5V5"/><circle cx="12" cy="12" r="2"/><path d="M12 14v3.5"/></svg></span>
                    <h3>Proof for funders</h3>
                    <p>When a home-visiting or outreach funder asks you to verify where services happened, every log is a location-stamped answer — and the whole set exports to Excel.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13.5A8 8 0 1 1 10.5 4a6.5 6.5 0 0 0 9.5 9.5Z"/><circle cx="13" cy="20.5" r="1.1" fill="currentColor" stroke="none"/><circle cx="16.5" cy="20.5" r="1.1" fill="currentColor" stroke="none"/><circle cx="20" cy="20.5" r="1.1" fill="currentColor" stroke="none"/></svg></span>
                    <h3>Ready for the PIT count</h3>
                    <p>The Point-in-Time (PIT) count — the one-night count of people experiencing homelessness that HUD (the U.S. Department of Housing and Urban Development) asks communities to run — is field logging at its most intense. Count teams log each contact where it happens; the map shows what ground was covered.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Tuesday, 7 a.m., under the overpass</h3>
                <p>An outreach worker finds a client they've been checking on for weeks. Phone already in hand, they open the profile, tap the quick-action menu, and log the location — record attached, follow-up task attached. They're back in the conversation in seconds, because the software's job is to not interrupt it.</p>
                <p>Friday afternoon, their supervisor opens the map and filters to the team's week. The logs have already clustered into the places the team works — one they've named, one new cluster waiting for a name. When the program director asks where outreach happened this month, the answer is a map, and behind it, an Excel file.</p>
            </aside>
            {{-- [TESTIMONIAL: outreach supervisor at a large multi-service agency — GeoTracker in daily field use / PIT count] — replace this comment with a real, approved quote block when one exists. --}}
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
    <section class="section" style="padding-top: 0">
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

    @include('site::partials.cta', ['heading' => 'See it from the sidewalk', 'blurb' => 'Bring your outreach routes to the demo — we\'ll log a visit from a phone and pull up the map the way a supervisor would on Friday afternoon.'])

@endsection
