@extends('site::partials.layout')

@section('title', 'Funder Reporting Software for Nonprofits | Need Navigator')
@section('description', 'Build reports across eleven record types, set PII redaction for board packets, schedule delivery on your funder\'s calendar, and export it all to Excel.')

@php
    $faqs = [
        [
            'q' => 'Can Need Navigator produce my funder\'s report?',
            'a' => 'You assemble it, and then it repeats itself. Need Navigator does not ship pre-built templates for named federal reports, and we do not make compliance claims. What you get is a builder that spans eleven record types with condition filters and Excel export on every one, an HMIS-adjacent data model (HMIS is the Homeless Management Information System, the record-keeping standard many housing funders expect), and built-in demographic and spending breakdowns that support your funder reporting. Build the report once, save the definition, and schedule it.',
        ],
        [
            'q' => 'What does PII redaction do?',
            'a' => 'PII is personally identifiable information: the details that tie a row of data to a specific person. Every saved report carries its own redaction level, so an export headed for a board packet or an outside audience does not carry sensitive identifiers, while a caseworker\'s working version of the same report keeps the detail they need. You set the level per report, not system-wide.',
        ],
        [
            'q' => 'How does scheduled delivery work?',
            'a' => 'Choose weekly or monthly delivery, including calendar patterns like the 3rd Tuesday or the last Friday of the month, plus a time of day, and whether the report arrives by email, in-app message, or both. Each delivery runs the saved definition against current data, so the numbers that arrive are the numbers as of that morning.',
        ],
        [
            'q' => 'Who can see which reports and dashboards?',
            'a' => 'Each saved report definition carries its own visibility level: everyone, the same program, or selected teams. The report library is grouped by program, so people find what belongs to their work. Program dashboards are shared by everyone in the program, and editing the widget board is permission-gated. Access to the client data underneath is governed by Need Navigator\'s role-based permissions.',
        ],
        [
            'q' => 'What exports to Excel?',
            'a' => 'Every one of the eleven report types exports to Excel, and Excel export runs platform-wide across roughly sixteen record types: clients, households, visits, needs, referrals, goals, tasks, events, reservations, billing batches, form submissions, and location logs among them. Charts on form reports download as PDF, and on-screen report views are paginated for a quick check before you export.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Reporting'],
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
                    <li aria-current="page">Reporting</li>
                </ol>
            </nav>
            <p class="eyebrow">Reports &amp; dashboards</p>
            <h1>The report your funder wants, on the day it is due</h1>
            <p class="lede">Funder reporting software for nonprofits should know your deadlines. Need Navigator's report builder spans eleven record types, redacts identifiers for board-ready exports, sends everything to Excel, and delivers on schedules like "the 3rd Tuesday of the month" by email, in-app message, or both.</p>
        </div>
    </section>

    {{-- ================= Report-builder UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: reporting-report-builder | replace with: real screenshot of a saved report definition in the report builder - record type, chosen columns, condition filters, PII redaction level, visibility, and a monthly "3rd Tuesday" scheduled delivery all visible; light theme, landscape. Placeholder: stylized HTML recreation of the definition card. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Report builder – Board packet: Emergency assistance</span></div>
                    <div class="uiframe-body">
                        <div class="ui-repdef">
                            <div class="rd-row">
                                <span class="rd-label">Record type</span>
                                <span class="rd-chips"><span class="rd-chip rd-chip--on">Needs</span><span class="rd-chip">Clients</span><span class="rd-chip">Visits</span><span class="rd-chip">Referrals</span><span class="rd-chip">+7 more</span></span>
                            </div>
                            <div class="rd-row">
                                <span class="rd-label">Columns</span>
                                <span class="rd-chips"><span class="rd-chip">Program</span><span class="rd-chip">Amount</span><span class="rd-chip">Funding pool</span><span class="rd-chip">Status</span><span class="rd-chip">Created</span></span>
                            </div>
                            <div class="rd-row">
                                <span class="rd-label">Filters</span>
                                <span class="rd-chips"><span class="rd-chip">Program is Emergency Rent Assistance</span><span class="rd-chip">Status is Finalized</span><span class="rd-chip">Created Jan 1 &ndash; Mar 31</span></span>
                            </div>
                            <div class="rd-row">
                                <span class="rd-label">PII redaction</span>
                                <span class="rd-val"><span class="rd-chip rd-chip--on">On</span> identifiers removed from the export</span>
                            </div>
                            <div class="rd-row">
                                <span class="rd-label">Visibility</span>
                                <span class="rd-val">Same program</span>
                            </div>
                            <div class="rd-row">
                                <span class="rd-label">Schedule</span>
                                <span class="rd-val">Monthly &middot; 3rd Tuesday &middot; 7:00 a.m. &middot; Email + in-app message</span>
                            </div>
                            <div class="rd-actions"><span class="rd-btn">Save definition</span><span class="rd-btn rd-btn--ghost">Export to Excel</span></div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of a saved report definition: record type, columns, condition filters, a PII (personally identifiable information) redaction level, visibility, and a monthly "3rd Tuesday" delivery schedule.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Reports capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Build the report you actually need</h2>
                <p class="muted">Pick a record type, choose columns, stack filters, save the definition. Everything else on this page starts from that.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11M15 9v11"/></svg></span>
                    <h3>Eleven record types, one builder</h3>
                    <p>Clients, households, visits, needs, referrals, goals, forms, events, reservations, billing, and funders. Pick your columns, stack condition filters (programs, exit reasons, shelters, users, date ranges, and more), and save the definition.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18"/><path d="M10.6 5.1c.5-.07.9-.1 1.4-.1 6 0 9.5 7 9.5 7a17.4 17.4 0 0 1-3 3.9M6.6 6.6C4 8.3 2.5 12 2.5 12s3.5 7 9.5 7c1.4 0 2.7-.3 3.9-.9"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg></span>
                    <h3>Board-ready without the identifiers</h3>
                    <p>Every saved report carries a PII (personally identifiable information) redaction level, so the export you hand a board or an outside audience shows totals and breakdowns, not sensitive identifiers.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M12 11v6M9.5 14.5 12 17l2.5-2.5"/></svg></span>
                    <h3>Excel, everywhere</h3>
                    <p>Every report type exports to Excel. Beyond reports, Excel export runs across roughly sixteen record types platform-wide, from clients and visits to billing batches and location logs.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7.5 16.5v-5M12 16.5v-9M16.5 16.5v-3"/></svg></span>
                    <h3>Charts where a picture helps</h3>
                    <p>Form reports draw bar and pie charts that download as PDF, the right shape for a one-page handout at a staff meeting or in a board packet.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l5.2-5.2 3.6 3.6L21 7"/><path d="M15.5 7H21v5.5"/></svg></span>
                    <h3>The money questions, pre-wired</h3>
                    <p>Built-in analytics cover spending by program, resources distributed, funds remaining by funder, and requests over time. A funder report aggregates funding-pool spending by calendar year.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="16.5" cy="9.5" r="2.2"/><path d="M3.5 19c0-2.8 2.3-4.6 5.5-4.6s5.5 1.8 5.5 4.6"/><path d="M15 16.7c.6-1.6 2-2.4 3.7-2.4 1 0 1.8.3 2.4.8"/></svg></span>
                    <h3>Demographic breakdowns</h3>
                    <p>Break results down by race, ethnicity, gender, language, and ZIP code: the cross-sections most funder reports are built from, there to support your funder reporting.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M12 13.5v2.5l1.8 1.2"/></svg></span>
                    <h3>Delivery that knows your deadlines</h3>
                    <p>Schedule any saved report weekly or monthly (including patterns like the 3rd Tuesday or the last Friday) at a chosen time, delivered by email, in-app message, or both.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2.5h8a2 2 0 0 1 2 2V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M8 13h8"/></svg></span>
                    <h3>A library, not a junk drawer</h3>
                    <p>Saved reports live in a library grouped by program, with reordering and batch management. Each definition carries its own visibility level: everyone, same program, or selected teams.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Honest framing on funder formats ================= --}}
    <section class="section section--wash">
        <div class="container">
            <div class="section-head">
                <h2>A straight answer on funder formats</h2>
            </div>
            <p>You deserve a plain answer here: Need Navigator does not ship pre-built templates for named federal reports, and we do not make compliance claims.</p>
            <p>What it gives you is the material those reports are made of. The data model is HMIS-adjacent; HMIS is the Homeless Management Information System, the record-keeping standard many housing funders expect. The builder, the demographic and spending breakdowns, and Excel export on every report type are designed to support your funder reporting. You assemble what your funder asks for once; after that, it is a saved definition on a schedule.</p>
        </div>
    </section>

    {{-- ================= Dashboards ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Dashboards for the day, and for the program</h2>
                <p class="muted">A personal landing page of your open work, and a shared widget board for the metrics your team watches.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 9v12"/></svg></span>
                    <h3>Start the day on one page</h3>
                    <p>The home dashboard gathers your upcoming visits, goals with step progress, needs (including a pending-approval queue), referrals, events, unread messages, and a client search, with a toggle between "mine" and "everyone."</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 6h13M8 12h13M8 18h9"/><circle cx="4" cy="6" r="1.4" fill="currentColor" stroke="none"/><circle cx="4" cy="12" r="1.4" fill="currentColor" stroke="none"/><circle cx="4" cy="18" r="1.4" fill="currentColor" stroke="none"/></svg></span>
                    <h3>Counts that are to-do lists</h3>
                    <p>Sidebar counts track needs awaiting action, pending referrals, today's visits and reservations, and open tasks and goals. Each one links straight to the filtered list it represents.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="5" rx="1.5"/><rect x="13" y="10" width="8" height="11" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/></svg></span>
                    <h3>A widget board per program</h3>
                    <p>The configurable program dashboard is a drag-and-drop widget board: recent clients, funding-pool balances with health indicators, client search, and embedded Quick Forms views. Everyone in the program shares the board; editing is permission-gated.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><circle cx="11.5" cy="14.5" r="2.6"/><path d="M13.4 16.4 16 19"/></svg></span>
                    <h3>Query tables you define</h3>
                    <p>Build your own tables over a curated data catalog (visits, needs, and class outcomes among them), choosing columns, filters, and sort. Date presets include fiscal year, because that is how grants count.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>The third Tuesday of the month</h3>
                <p>The board meets tonight, and the program director has not opened a spreadsheet. The report they saved last fall (finalized assistance requests, spending by program, funds remaining by funder) arrived at 7 a.m. by email and in-app message, scheduled for the third Tuesday of every month. The redaction level they set means the export carries totals and breakdowns, not sensitive identifiers.</p>
                <p>They skim the Excel file, drop the demographic breakdown into the board packet, and forward the email to the treasurer. Next month the same report arrives the same way, without anyone remembering to build it.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions we hear about reporting</h2>
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
                <a href="/features/emergency-assistance">Funding pools &amp; assistance</a>
                <a href="/features/forms">Forms &amp; data collection</a>
                <a href="/security">Security &amp; audit trail</a>
                <a href="/solutions/community-action-agencies">For community action agencies</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring your hardest funder report', 'blurb' => 'Bring last quarter\'s spreadsheet to the demo. We will rebuild it in the report builder, set a redaction level, and schedule it for the day it is due.'])

@endsection
