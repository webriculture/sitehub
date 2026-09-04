@extends('site::partials.layout')

@section('title', 'Parent Education Class Management Software | Need Navigator')
@section('description', 'Run parent education classes from public registration and reminders to private QR check-in, attendance, fidelity completion, and PDF certificates.')

@php
    $faqs = [
        [
            'q' => 'Can someone learn who is enrolled by scanning the check-in QR code?',
            'a' => 'No. The QR check-in poster is deliberately enumeration-proof: scanning it never reveals who is enrolled in the class. Confirmed participants receive their own single-use, short-lived check-in link by text or email, and confidential household members are never disclosed. The design assumes some participants — domestic-violence survivors among them — have real reasons to keep their attendance private.',
        ],
        [
            'q' => 'What does completing a course "to fidelity" mean?',
            'a' => 'Many evidence-based parenting curricula only count a participant as completing the program if they attend a minimum share of sessions — the fidelity threshold. Each course in Need Navigator carries its own threshold, and completion is computed against it automatically from the attendance record. Facilitators can apply credit overrides when circumstances warrant.',
        ],
        [
            'q' => 'How do class reminders work?',
            'a' => 'Reminders go out automatically for each session — a few days ahead and again on the day of class — by text message (SMS) and email, with opt-in managed per offering. And because registration verifies the phone number or email with a one-time code before it is accepted, reminders reach contact points that actually work.',
        ],
        [
            'q' => 'Do participants receive certificates?',
            'a' => 'Yes. Completion certificates generate as PDFs for every participant who meets the course\'s fidelity threshold. The same module produces printable roster sheets and per-session QR check-in posters, so class night runs from one place.',
        ],
        [
            'q' => 'Can families register and take classes in Spanish?',
            'a' => 'Need Navigator\'s hosted class pages and registration render in English today. Spanish descriptions of your open offerings can appear on your own website through the secure class feed, which serves content in English and Spanish. And your agency\'s intake forms can be presented in Spanish, with translations drafted by AI and reviewed and polished by your bilingual staff.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Parent education classes'],
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
                    <li aria-current="page">Parent education classes</li>
                </ol>
            </nav>
            <p class="eyebrow">Parent education classes</p>
            <h1>From sign-up to certificate, without the clipboard</h1>
            <p class="lede">Parent education class management software has to carry the whole arc — catalog, public registration, reminders, check-in, attendance, completion, certificates. Need Navigator carries all of it, protects participant privacy at the most exposed step, and is in use at agencies today.</p>
        </div>
    </section>

    {{-- ================= Attendance grid UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: parent-ed-attendance-grid | replace with: real screenshot of the facilitator mobile attendance grid, light theme, portrait phone crop — present/absent/late/excused marks, a credit override, a walk-in row, and the walk-in button visible. Placeholder: stylized HTML recreation of the grid. --}}
            <figure style="margin:0">
                <div class="uiframe ui-attendgrid" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Attendance — Tuesday parenting class</span></div>
                    <div class="uiframe-body">
                        <div class="ag-head">
                            <span><strong>Session 4 of 8</strong> · Tue 6:00 p.m.</span>
                            <span>8 of 12 checked in</span>
                        </div>
                        <div class="ag-row">
                            <span class="ag-name">Alex P.</span>
                            <span class="ag-pills">
                                <span class="ag-pill is-present">P</span><span class="ag-pill">A</span><span class="ag-pill">L</span><span class="ag-pill">E</span>
                            </span>
                        </div>
                        <div class="ag-row">
                            <span class="ag-name">Jordan M.<small>Credit override — counts toward completion</small></span>
                            <span class="ag-pills">
                                <span class="ag-pill">P</span><span class="ag-pill">A</span><span class="ag-pill is-late">L</span><span class="ag-pill">E</span>
                            </span>
                        </div>
                        <div class="ag-row">
                            <span class="ag-name">Sam R.</span>
                            <span class="ag-pills">
                                <span class="ag-pill">P</span><span class="ag-pill is-absent">A</span><span class="ag-pill">L</span><span class="ag-pill">E</span>
                            </span>
                        </div>
                        <div class="ag-row">
                            <span class="ag-name">Casey L.<small>Walk-in — enrolled at the door</small></span>
                            <span class="ag-pills">
                                <span class="ag-pill is-present">P</span><span class="ag-pill">A</span><span class="ag-pill">L</span><span class="ag-pill">E</span>
                            </span>
                        </div>
                        <div class="ag-row">
                            <span class="ag-name">Riley T.</span>
                            <span class="ag-pills">
                                <span class="ag-pill">P</span><span class="ag-pill">A</span><span class="ag-pill">L</span><span class="ag-pill is-excused">E</span>
                            </span>
                        </div>
                        <div class="ag-foot">
                            <span class="ag-walkin">+ Enroll walk-in</span>
                        </div>
                        <div class="ag-note">Session note: reviewed week-3 skills — strong discussion.</div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the facilitator's mobile attendance grid: each participant marked present, absent, late, or excused in a tap, with a credit override, a walk-in enrolled at the door, and a session note.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the classes module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 3 8l9 5 9-5-9-5Z"/><path d="M3 12l9 5 9-5"/><path d="M3 16l9 5 9-5"/></svg></span>
                    <h3>A catalog built the way you teach</h3>
                    <p>Courses hold the curriculum and its completion-fidelity threshold. Offerings are the enrollable runs — online, in person, or hybrid, each with its own capacity and public page. Sessions generate from a weekday pattern, so an eight-week Tuesday class schedules in seconds.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.4-3 7.4-7 9-4-1.6-7-4.6-7-9V6Z"/><path d="M9 11.5l2 2 4-4.5"/></svg></span>
                    <h3>Registration that verifies before it stores</h3>
                    <p>Each offering gets a public registration page with bot protection, and the required phone number or email must pass a one-time code before the registration is accepted. Your roster starts clean, and every reminder has somewhere real to go.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 16H6c1.2-1.4 1.5-3.1 1.5-5a4.5 4.5 0 0 1 9 0c0 1.9.3 3.6 1.5 5Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg></span>
                    <h3>Reminders that reach families</h3>
                    <p>Automatic reminders go out for every session — a few days ahead and on the day of class — by text message (SMS) and email, with opt-in managed per offering. Nobody on staff spends Monday calling the roster.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h3v3M20 14v3M14 20h3M20 20h.01"/></svg></span>
                    <h3>Check-in that protects privacy</h3>
                    <p>Scanning the session's QR poster never reveals who is enrolled. Confirmed participants get a single-use, short-lived check-in link by text or email, households check in together, and confidential members are never disclosed — designed with domestic-violence survivors in mind.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M10.5 5h3"/><path d="M9.5 13.5l1.8 1.8 3.2-3.8"/></svg></span>
                    <h3>Attendance from the facilitator's phone</h3>
                    <p>Mark each participant present, absent, late, or excused from a mobile grid, apply credit overrides when circumstances warrant, enroll walk-ins on the spot, and jot session notes before the room empties.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5"/><path d="M9.2 13.2 7.5 21l4.5-2.5L16.5 21l-1.7-7.8"/></svg></span>
                    <h3>Completion to fidelity, with proof</h3>
                    <p>Completion is computed against the course's fidelity threshold — the attendance bar many evidence-based curricula require. Completion certificates generate as PDFs for qualifying participants, alongside printable rosters and per-session QR posters.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8Z"/><path d="M14 3v5h5"/><path d="M12 11v6M9.5 14.5 12 17l2.5-2.5"/></svg></span>
                    <h3>Handouts without the copy machine</h3>
                    <p>Attach class materials at the course or session level. They hand off to participants at check-in through short-lived secure links — the week's worksheet arrives with the check-in, not in a forgotten folder.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M4 16l5-5 4 3 7-8"/><path d="M16 6h4v4"/></svg></span>
                    <h3>Outcomes on the dashboard</h3>
                    <p>Class enrollment and completion outcomes are reportable on dashboards, so a program director can watch a cohort move from sign-up to certificate without building a spreadsheet.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Tuesday night, 6 p.m.</h3>
                <p>It is session four of an eight-week parenting class. The day-of reminder texts went out automatically that morning — nobody on staff sent a thing. A parent arrives with their two kids a few minutes early and scans the QR poster by the door; the poster names no one. Their single-use check-in link comes by text, one tap checks the whole household in, and the session's handouts hand off at the same moment as short-lived secure links.</p>
                <p>The facilitator never opens a laptop. From their phone they mark the room — present, present, late for the parent who slips in at 6:15, with a credit override so the session still counts — and enroll a walk-in on the spot. A quick session note, and the record is done before the chairs are folded. When the course wraps, completion computes against the fidelity threshold, and certificates generate as PDFs for everyone who met it.</p>
            </aside>
            {{-- [TESTIMONIAL: parent-education program coordinator — on running class night from a phone, and what verified contact info and automatic reminders changed about attendance] --}}
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions parent educators ask</h2>
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
                <a href="/features/events">Events &amp; registration</a>
                <a href="/features/forms">Multilingual forms</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/solutions/parent-education">For parent education programs</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a class night, start to finish', 'blurb' => 'Bring one of your curricula to the demo — we will build the course, generate a session schedule from your weekday pattern, and walk it from registration through check-in to certificates.'])

@endsection
