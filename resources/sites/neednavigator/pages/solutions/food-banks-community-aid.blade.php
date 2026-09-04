@extends('site::partials.layout')

@section('title', 'Food Pantry Client Tracking Software | Need Navigator')
@section('description', 'For food banks and pantries: fast check-in without re-typing, household visit records, a catalog for every distribution, and referrals that close the loop.')

@php
    $faqs = [
        [
            'q' => 'How fast is check-in on a busy distribution day?',
            'a' => 'Returning clients come up by typing a few letters of a name, a date of birth, or a phone number, with matched text highlighted. A smart button your agency configures records the standard distribution — the visit and the food-box request together, pre-filled — in one tap. New applicants\' forms land in a live grid where a matching engine ranks likely existing records, so staff confirm a match or create the person in one click instead of re-typing.',
        ],
        [
            'q' => 'Does it track households or individuals?',
            'a' => 'Both. Each person has their own record, and records group into typed households with a head of household and member relationships. One visit can include multiple clients, so a single entry records the whole household\'s stop, and a family application can match or create every member in one guided pass.',
        ],
        [
            'q' => 'Can it track distributions that aren\'t money?',
            'a' => 'Yes. Your agency defines its own catalog of resources, financial or non-financial — food boxes, hygiene kits, diapers, utility help — and each request is logged against it with a type and quantity. Reports then show resources distributed, alongside demographic breakdowns by race, ethnicity, gender, language, and ZIP code.',
        ],
        [
            'q' => 'How do referrals to partner agencies work?',
            'a' => 'You keep a directory of partner organizations with their services, areas served, hours, and languages spoken, and refer a client to a specific organization and contact. The printed referral carries a QR code; the receiving provider scans it — no login needed — and records who received the client and their feedback, which completes the referral with a timestamp. If a partner also runs Need Navigator, your agencies can opt in to send referrals directly between systems.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Food banks & community aid'],
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
                    <li aria-current="page">Food banks &amp; community aid</li>
                </ol>
            </nav>
            <p class="eyebrow">For food banks &amp; community aid</p>
            <h1>Keep the line moving — and the record complete</h1>
            <p class="lede">Food pantry client tracking software earns its keep on distribution day. Need Navigator checks returning neighbors in with a tap, builds new households from a single form without re-typing, logs what each household received — from food boxes to utility help — and closes the loop on referrals to your partners.</p>
        </div>
    </section>

    {{-- ================= Distribution-day grid UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: fbca-distribution-grid | replace with: real screenshot of the Quick Forms submissions grid worked during a distribution day, light theme, landscape — match badges, household details, and request statuses visible. Placeholder: stylized HTML recreation of the grid. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Quick Forms — Saturday distribution check-in</span></div>
                    <div class="uiframe-body">
                        <div class="ui-fooddist">
                            <div class="fd-live"><i></i>2 staff working this grid</div>
                            <table>
                                <thead>
                                    <tr><th scope="col">Checked in</th><th scope="col">Household</th><th scope="col">Match</th><th scope="col">Receiving</th><th scope="col">Status</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>9:02 a.m.</td>
                                        <td><strong>Household of 4</strong> · returning</td>
                                        <td><span class="fd-badge is-match">Exact match</span></td>
                                        <td>Food box — large</td>
                                        <td><span class="fd-status">Finalized</span></td>
                                    </tr>
                                    <tr>
                                        <td>9:04 a.m.</td>
                                        <td><strong>Household of 2</strong></td>
                                        <td><span class="fd-badge is-probable">Probable — confirm</span></td>
                                        <td>Food box — small</td>
                                        <td><span class="fd-status">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td>9:07 a.m.</td>
                                        <td><strong>Household of 1</strong> · first visit</td>
                                        <td><span class="fd-badge is-new">New individual</span></td>
                                        <td>Food box + hygiene kit</td>
                                        <td><span class="fd-status">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>9:09 a.m.</td>
                                        <td><strong>Household of 5</strong> · returning</td>
                                        <td><span class="fd-badge is-match">Exact match</span></td>
                                        <td>Food box — large, diapers</td>
                                        <td><span class="fd-status">Approved</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the live submissions grid on a distribution morning: each row carries its match result, the household, what they received, and the request's status.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Workflow sections ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Built for distribution day and everything after</h2>
                <p class="muted">Six jobs a food bank or pantry runs every week, and how Need Navigator handles them.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 4.5 13.5H11L9.5 22 18 10.5H12z"/></svg></span>
                    <h3>Check-in without re-typing</h3>
                    <p>Find a returning client by name, date of birth, or phone, with matched text highlighted. New applications are classified as an exact match, probable match, or new individual, and staff confirm or create in one click. Exact duplicates are blocked at save, a fuzzy matcher warns about likely ones, and if a duplicate slips through anyway, a merge consolidates both records' history onto one.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V10l8-6 8 6v11"/><path d="M4 21h16"/><circle cx="9.5" cy="14" r="2"/><circle cx="14.5" cy="14" r="2"/><path d="M6.5 21c.4-1.8 1.6-2.8 3-2.8s2.3.8 2.5 2M12 20.2c.2-1.2 1.3-2 2.5-2s2.6 1 3 2.8"/></svg></span>
                    <h3>One stop records the household</h3>
                    <p>Clients group into typed households with a head of household and member relationships, and one visit can include the whole family — a single entry records the household's stop. A family application builds every member through a guided stepper, and when an address changes, staff are prompted to copy it across selected members in one step.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v8l9 5 9-5z"/><path d="M3 8l9 5 9-5M12 13v8"/></svg></span>
                    <h3>A catalog of everything you distribute</h3>
                    <p>Your agency defines its own catalog of resources — financial or non-financial — and every distribution is logged against it with a type and quantity. Requests move through a clear status ladder that staff can update right from the live grid, and a smart button records your standard distribution — the visit and the request together, pre-filled — in one tap.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3h-3zM21 14v1M14 20v1M18 21h3v-3"/></svg></span>
                    <h3>Referrals your partners actually complete</h3>
                    <p>Refer a neighbor to a partner from a directory that knows each organization's services, areas served, hours, and languages spoken. The printed referral carries a QR code the receiving provider scans — no login needed — to record who received the client and their feedback, completing the loop with a timestamp. Message threads attach to each referral for follow-up.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8.5 15.5l2.5 2.5 4.5-4.5"/></svg></span>
                    <h3>Food drives and volunteer days</h3>
                    <p>Publish an event page with the schedule, location, and capacity; people register online inside the window you set, with duplicate-registration prevention, and ticketless events take a free name-and-email signup. On the day, staff check people in by QR code, register walk-ins, and mark no-shows.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-4M11 17V8M15 17v-6M19 17V11"/></svg></span>
                    <h3>The numbers behind the food</h3>
                    <p>Built-in breakdowns show resources distributed and demographics by race, ethnicity, gender, language, and ZIP code — the shape of your service area, straight from the records staff already made at check-in. Build your own reports across clients, households, visits, needs, and referrals, export to Excel, and schedule delivery so the board packet is done before anyone asks. Per-report redaction levels keep sensitive identifiers out of shared copies.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A Saturday morning at the pantry</h3>
                <p>The line forms before the doors open. At the check-in table, an intake volunteer types three letters of a returning neighbor's name and the record is up — household of four, last visit two weeks ago. One smart button their agency set up records the stop and the standard food box together, pre-filled, and the next person steps forward. A first-time family fills out the intake form on a tablet in Spanish; their submission appears in the grid, and the coordinator working it from the back room confirms the match the engine suggests for the parent, then lets household capture build the rest of the family — no duplicate records, nothing typed twice.</p>
                <p>Halfway through the morning, a neighbor mentions an electric shut-off notice. The volunteer creates a referral to the energy-assistance partner and hands over the printed sheet; when the partner scans its QR code next week, the referral completes with a timestamp and their feedback. By the time the doors close, the morning's distributions are already in the system — no data-entry afternoon — ready for the resources-distributed report and the ZIP-code breakdown the director sends the regional food bank.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions food banks ask</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">Dig into the modules</p>
            <div class="crosslinks">
                <a href="/features/intake-management">Intake &amp; the live grid</a>
                <a href="/features/emergency-assistance">Assistance requests &amp; the resource catalog</a>
                <a href="/features/referrals-partners">Referrals &amp; partners</a>
                <a href="/features/events">Events &amp; drives</a>
                <a href="/reporting">Reports &amp; dashboards</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a Saturday run through it', 'blurb' => 'Bring your busiest distribution morning to the demo — we will check in a returning household, build a new one from a single form, and print a referral with its loop-closure QR code.'])

@endsection
