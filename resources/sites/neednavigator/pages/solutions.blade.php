@extends('site::partials.layout')

@section('title', "Who It's For | Need Navigator")
@section('description', 'Find the Need Navigator page written for your agency: community action, shelters and housing, food banks and community aid, or parent education.')

@php
    $faqs = [
        [
            'q' => 'We run many kinds of programs. Do these pages still apply?',
            'a' => 'Yes. The solutions pages are different doors into the same product, not separate editions. Client records, assistance requests, referrals, visits, goals, and reporting all live in one system at your agency, and each program carries its own forms, folders, and eligibility rules. Start with the page closest to your largest program.',
        ],
        [
            'q' => 'What if our agency spans categories (say, community action plus a shelter)?',
            'a' => 'That combination runs in one place. Programs are defined per agency, so an energy-assistance program and a shelter can live side by side, with funding pools, bed reservations, and reporting included. Read both pages; everything they describe belongs to the same system.',
        ],
        [
            'q' => 'Our agency is not on this list. Is Need Navigator still a fit?',
            'a' => 'Possibly. Community action agencies, shelters, food banks, and parent education providers are the kinds of agencies Need Navigator was built alongside, but it serves human-services organizations broadly, including other community aid organizations. Each agency chooses its own profile fields, forms, programs, and vocabularies, so the record adapts to your intake practice rather than the other way around. The fastest way to find out is a conversation with us.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions'],
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
                    <li aria-current="page">Solutions</li>
                </ol>
            </nav>
            <p class="eyebrow">Who it's for</p>
            <h1>Which describes your agency?</h1>
            <p class="lede">Need Navigator is case-management software for human-services organizations, configured to each agency's programs, forms, roles, and vocabulary. These four pages map the product to your kind of work: the funding you answer to, the line at your front desk, the outcomes you report. Pick the closest fit; they all lead back to the same product.</p>
        </div>
    </section>

    {{-- ================= Audience rows ================= --}}
    <section class="section sol-hub">
        <div class="container">

            <div class="sol-row reveal">
                <div>
                    <h2>Community action agencies</h2>
                    <p>Your work answers to eligibility rules and the documentation behind them. Need Navigator captures income with proof attached, keeps staff-verified amounts distinct from self-reported ones, and screens program eligibility against federal poverty level (FPL) and area median income (AMI) thresholds by year, geographic area, and household size. Assistance requests move through a clear review-and-approval ladder, funding pools track every dollar by funder and program, and the eligibility math prints right on the voucher. When the quarter closes, demographic breakdowns and Excel exports support your funder reporting.</p>
                </div>
                <a class="audience" href="/solutions/community-action-agencies">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V8l7-5 7 5v13"/><path d="M9 21v-6h6v6"/><path d="M9 11h.01M15 11h.01"/></svg></span>
                    <strong>From eligibility to audit trail</strong>
                    <span>Income capture, FPL and AMI screening, funding pools, and the reporting that follows the grant.</span>
                    <em>For community action &rarr;</em>
                </a>
            </div>

            <div class="sol-row reveal">
                <div>
                    <h2>Shelters &amp; housing</h2>
                    <p>Run the building the way you see it: floors, rooms, and beds on a visual floor plan with live status colors, and the week ahead in a bed-by-date matrix you can read in a second. Families book together and check in or out in one action, and check-out captures a categorized exit reason your agency defined. Outside the building, GeoTracker logs a GPS-stamped location for a client encounter in one tap, which also makes it a strong tool for Point-in-Time (PIT) count fieldwork. And every client-record view is logged and screened for unusual access patterns.</p>
                </div>
                <a class="audience" href="/solutions/shelters-housing">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6"/><path d="M3 18h18M5 10V7M7 10c0-1.1.9-2 2-2h2v2"/></svg></span>
                    <strong>Beds, stays &amp; street outreach</strong>
                    <span>Floor plans, family check-in and check-out, exit reasons, and GPS-stamped field work.</span>
                    <em>For shelters &amp; housing &rarr;</em>
                </a>
            </div>

            <div class="sol-row reveal">
                <div>
                    <h2>Food banks &amp; community aid</h2>
                    <p>When the line is out the door, intake speed matters most. Requests land in a live grid the whole team works in at once, and everyone sees edits and status changes as they happen. A matching engine ranks likely matches so staff can tie each submission to an existing client (or create the person, or the whole household) in one pass. Needs are logged against your agency's own catalog of resources, referrals close the loop when the receiving provider scans a QR code, and community events run from online registration through day-of check-in.</p>
                </div>
                <a class="audience" href="/solutions/food-banks-community-aid">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 11h14l-1.4 9a2 2 0 0 1-2 1.7H8.4a2 2 0 0 1-2-1.7Z"/><path d="M8 11c0-4 1.8-7 4-7s4 3 4 7"/></svg></span>
                    <strong>Fast intake, closed loops</strong>
                    <span>A live intake grid, household matching, referrals with QR loop closure, and community events.</span>
                    <em>For food banks &amp; community aid &rarr;</em>
                </a>
            </div>

            <div class="sol-row reveal">
                <div>
                    <h2>Parent education providers</h2>
                    <p>Run parent education end to end. Build a course catalog, open offerings for public registration, and let reminders go out by text and email before every session. Participants check in with a QR code designed to protect privacy: scanning the poster never reveals who is enrolled, and confidential household members are never disclosed. Attendance drives completion against each course's fidelity threshold, with completion certificates for qualifying participants. Intake forms can be presented in Spanish, too: an AI drafts the translation and your bilingual staff polish it in a side-by-side editor.</p>
                </div>
                <a class="audience" href="/solutions/parent-education">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-2-1.8-5-2.2-8-2v14c3-.2 6 .2 8 2 2-1.8 5-2.2 8-2V4c-3-.2-6 .2-8 2Z"/><path d="M12 6v14"/></svg></span>
                    <strong>Catalog to certificates</strong>
                    <span>Public registration, session reminders, privacy-first QR check-in, and bilingual forms.</span>
                    <em>For parent education &rarr;</em>
                </a>
            </div>

            <p class="mt-2 muted">Not one of these four? Need Navigator also serves other community aid organizations. Each agency runs its own copy of the product, configured to its programs, forms, roles, and vocabulary. If your work is people, programs, and the paperwork between them, <a href="/features">explore the features</a> or <a href="/contact">ask us directly</a>.</p>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Questions about fit</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">Keep exploring</p>
            <div class="crosslinks">
                <a href="/features">Every feature, mapped</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/security">Security &amp; trust</a>
                <a href="/pricing">Transparent pricing</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Not sure which door fits?', 'blurb' => 'Tell us what your agency does and we will walk through the modules that matter to you: your programs, your forms, your funders.'])

@endsection
