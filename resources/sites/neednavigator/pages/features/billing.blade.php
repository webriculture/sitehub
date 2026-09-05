@extends('site::partials.layout')

@section('title', 'Human Services Billing Software | Need Navigator')
@section('description', 'Turn visits and assistance requests into claim-ready billing: 8-minute rule units, coverage-date checks, and Excel batches for your biller to submit.')

@php
    $faqs = [
        [
            'q' => 'What is the Medicare 8-minute rule, and how does Need Navigator apply it?',
            'a' => 'The 8-minute rule is Medicare\'s standard for converting timed services into 15-minute billable units: a unit becomes billable once at least 8 minutes of service is delivered, and a remainder of 8 or more minutes past a full unit counts as an additional unit. Need Navigator applies the conversion for you when a batch is generated: each record\'s actual minutes become billable units, so a 52-minute visit comes out as 3 units without anyone doing the arithmetic by hand.',
        ],
        [
            'q' => 'What happens after we export a batch?',
            'a' => 'The exported Excel file is the hand-off: you send it to your biller or billing service, and they submit the claims. Need Navigator prepares claims; it does not submit them electronically or connect to a clearinghouse. As answers come back, staff update each record\'s status to submitted, paid, or rejected, so the system always shows where every record stands.',
        ],
        [
            'q' => 'How does insurance validation work?',
            'a' => 'Each client\'s insurance policies (carrier, member ID, and coverage dates) live on their client record. When you generate a batch, any record whose service date falls outside the client\'s coverage dates is excluded, and the insurance carrier is stamped on every line that goes through. Records with a coverage-date problem are kept out of the file you hand to your biller.',
        ],
        [
            'q' => 'Where do billing records come from?',
            'a' => 'Most are generated automatically: recording a visit creates billing records from the visit\'s reasons using the actual duration for each client, and assistance requests create them from their need types. Staff can also enter a record by hand, from the billing screens or straight from the quick-action menu on a client\'s profile. Either way, every record keeps full attribution of who created it.',
        ],
        [
            'q' => 'Can we define our own billing codes?',
            'a' => 'Yes. Billing codes are agency-defined, with categories, modifiers, regions, units, and expected unit costs, so your codes can mirror your contracts and your region. At batching, totals compute per client, code, and date with the carrier stamped on each line.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Billing'],
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
                    <li aria-current="page">Billing</li>
                </ol>
            </nav>
            <p class="eyebrow">Billing</p>
            <h1>From logged minutes to a claim-ready batch</h1>
            <p class="lede">Human services billing software should be honest about where its job ends. Need Navigator turns the visits and assistance you already record into billing records, converts minutes to units under Medicare's 8-minute rule, checks every line against insurance coverage dates, and exports a claim-ready batch to Excel. Your biller submits it from there. That hand-off is the design, not a gap.</p>
        </div>
    </section>

    {{-- ================= Billing batch screenshot ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: billing-batch | filled 2026-09-05 with a real screenshot: img/screens/billing-batch, from billing2 (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Viewing billing batch #2</span></div>
                    @include('site::partials.screen', ['name' => 'billing-batch', 'alt' => 'A submitted billing batch: created and submitted dates, a note that it was auto-generated from four billing records, two summary lines rolling the records into one unit and three units of code H2015 at 20 dollars each, and a table of the four records with date, minutes, code, client, staff member, note and outcome, each row locked', 'width' => 1667, 'height' => 810])
                </div>
                <figcaption class="ui-caption">A submitted batch on a test instance: four billing records for one client roll up into units under the 8-minute rule, 8 minutes becomes one unit and 39 minutes across three records becomes three, each priced at the rate in effect on its date of service. Once submitted the batch is frozen, which is the lock on every row.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the billing module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 3.5h7.6L21 13.4a1.6 1.6 0 0 1 0 2.3l-5.3 5.3a1.6 1.6 0 0 1-2.3 0L3.5 11.1Z"/><circle cx="8" cy="8" r="1.6"/></svg></span>
                    <h3>Codes your agency defines</h3>
                    <p>Billing codes are yours: categories, modifiers, regions, units, and expected unit costs, set up to match your contracts, including billing codes such as HRSN (health-related social needs) Outreach &amp; Engagement.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11a8 8 0 0 0-14.9-3"/><path d="M5 3v5h5"/><path d="M4 13a8 8 0 0 0 14.9 3"/><path d="M19 21v-5h-5"/></svg></span>
                    <h3>Records that create themselves</h3>
                    <p>Recording a visit generates billing records from its reasons, using the actual duration for each client in the room. Assistance requests generate them from their need types. No second round of data entry at month-end.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg></span>
                    <h3>Minutes to units, automatically</h3>
                    <p>Timed services convert to billable units under Medicare's 8-minute rule when you build a batch. The same arithmetic, applied the same way, record after record.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.4-2.8 8-7 10-4.2-2-7-5.6-7-10V6Z"/><path d="M9 12l2 2 4-4.5"/></svg></span>
                    <h3>Coverage checked at batching</h3>
                    <p>Records whose service date falls outside the client's insurance coverage dates are excluded from the batch, and the carrier is stamped on every line that goes through. Coverage-date problems surface before the file leaves the building.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/><path d="M7 12h3M14 12h3"/></svg></span>
                    <h3>A status for every record</h3>
                    <p>Records move from pending to batched to submitted to paid or rejected, with filtering, search, and export across all of it. When your biller reports back, the record's status says so.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 5H6l6 7-6 7h12"/></svg></span>
                    <h3>Totals that hold up</h3>
                    <p>Batch totals compute per client, per code, and per date, with the insurance carrier on each line, organized the way billers actually read the work.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M15 3h6v6"/><path d="M10 14 21 3"/></svg></span>
                    <h3>Excel is the hand-off</h3>
                    <p>Export the batch to Excel and send it to your biller. That is the hand-off, by design. Need Navigator prepares claims; it does not submit them electronically or connect to a clearinghouse, and we would rather say that plainly here than have you discover it later.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3 2.8-4.7 5.5-4.7 1 0 1.9.2 2.7.6"/><path d="M14.5 19.5 20 14l-2-2-5.5 5.5-.5 2.5Z"/></svg></span>
                    <h3>Manual entry, full attribution</h3>
                    <p>Enter a record by hand when the work did not start as a visit or a need, from the billing screens or the quick-action menu on a client's profile. Every record, generated or manual, keeps who created it.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>The last Friday of the month</h3>
                <p>It is the last working day of March, and the billing coordinator has not typed a single billing record all month. Visits created them as caseworkers logged their time; assistance requests added theirs from need types. They pull up the unbatched records, look them over, and generate the batch. Two records are excluded (a client's coverage ended mid-month), and the rest convert from minutes to billable units under the 8-minute rule, totaled by client, code, and date with each carrier stamped on its lines.</p>
                <p>They export the batch to Excel and send it to the agency's billing service before lunch: the hand-off. As answers come back over the following weeks, they update statuses to paid or rejected, and a filtered view shows exactly which records are still waiting on an answer.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions billing staff ask</h2>
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
                <a href="/features/casework">Visits, notes &amp; goals</a>
                <a href="/features/emergency-assistance">Needs &amp; emergency assistance</a>
                <a href="/features/client-records">Client records &amp; insurance</a>
                <a href="/reporting">Reports &amp; dashboards</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Walk a month of billing in the demo', 'blurb' => 'Bring your billing codes and a typical month of visits. We will build a batch live, from logged minutes to the Excel file your biller takes from there.'])

@endsection
