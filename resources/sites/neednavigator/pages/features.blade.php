@extends('site::partials.layout')

@section('title', 'Features | Need Navigator')
@section('description', "Every Need Navigator module, grouped and explained, from client records to reporting. All configured to your agency's programs, forms, and vocabulary.")

@php
    $host = \App\Tenancy\Tenancy::current()?->primaryDomain()?->hostname ?? request()->getHost();
    $breadcrumbJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://'.$host.'/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Features'],
        ],
    ];
@endphp

@section('structured')
    <script type="application/ld+json">{!! json_encode($breadcrumbJsonLd, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')

    <section class="section" style="padding-bottom: clamp(2rem, 4vw, 3rem)">
        <div class="container">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li aria-current="page">Features</li>
                </ol>
            </nav>
            <p class="eyebrow">The whole product</p>
            <h1>Everything Need Navigator does, on one page</h1>
            <p class="lede">Need Navigator is one system for the whole agency, and every module is configured to your agency: your programs, your forms, your roles, your vocabulary. A searchable Settings hub lets your own staff maintain the option lists behind the product, from demographic answer sets to document types and bed types, with no vendor request to change a dropdown. Here is the whole map, grouped the way agencies think about the work.</p>
        </div>
    </section>

    {{-- ================= Module map ================= --}}
    <section class="section">
        <div class="container">
            <div class="module-index features-hub">

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="2"/><path d="M5.5 16c.5-1.5 1.7-2.3 3-2.3s2.5.8 3 2.3"/><path d="M14 9h5M14 12.5h5M14 16h3"/></svg></span>
                        <h2>Client &amp; household records</h2>
                        <p>For the intake desk and everyone after it. Each agency chooses which profile fields appear and which are required, so the record matches your intake practice instead of forcing a template onto it. Duplicate prevention blocks exact copies at save and warns about likely ones; a merge tool consolidates history when one slips through anyway.</p>
                        <p>Households group people under a head of household with a member-to-member relationship matrix, and income, with proof documents attached, feeds eligibility checks against federal poverty level (FPL) and area median income (AMI) thresholds. Every client file gets a document type, organized in folders with team-based visibility, and funder demographics are first-class fields: race, ethnicity, gender, language, housing status, veteran status, and more.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/client-records"><strong>Client records</strong><span>Configurable profiles, duplicate prevention, alerts</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/documents"><strong>Documents &amp; files</strong><span>Typed files, folders, PDF merge, scanner inbox</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/households-care-team"><strong>Households &amp; care teams</strong><span>Relationships, shared data, caseload transfer</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/income-eligibility"><strong>Income &amp; eligibility</strong><span>Verified income, FPL and AMI screening</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M9 5V3.5A1.5 1.5 0 0 1 10.5 2h3A1.5 1.5 0 0 1 15 3.5V5"/><path d="M8.5 13.5l2.5 2.5 4.5-4.5"/></svg></span>
                        <h2>Service delivery</h2>
                        <p>The daily work of helping someone: a request comes in, a supervisor approves it, dollars move, and the record proves it. Assistance requests climb a clear status ladder: pending, review, approval, all the way to voucher printed. Funding pools tie every dollar to a funder or program and warn when allocations don't reconcile.</p>
                        <p>Visits, case notes, goals, and tasks keep the casework itself in one place, with manager review where your policy wants a second set of eyes. Billing records generate automatically from visits and needs, validate against insurance coverage dates, and export as claim-ready batches to Excel. Smart Buttons and no-code Automations turn your repeated multi-step workflows into a single tap.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/emergency-assistance"><strong>Emergency assistance</strong><span>Status ladder, funding pools, printable vouchers</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/casework"><strong>Casework</strong><span>Visits, notes, goals, tasks, calendar</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/billing"><strong>Billing</strong><span>Claim preparation and Excel export</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/programs-automation"><strong>Programs &amp; automation</strong><span>Enrollment rules, Smart Buttons, no-code automations</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M8 12h5M8 16h8"/><path d="M17.5 3.5l3 3L14 13h-3v-3z"/></svg></span>
                        <h2>Forms &amp; intake</h2>
                        <p>Built for the front desk and the people applying. Staff build their own forms (conditional logic, repeatable sections, live client-record fields) without a developer, and an AI-drafted translation puts a whole form in Spanish in seconds for bilingual staff to review and polish.</p>
                        <p>Submissions land in Quick Forms, a live spreadsheet-style grid where the whole team works at once and every edit and status change appears in real time. A matching engine classifies each submission as an exact match, probable match, or new person, and a family application can build the entire household in one pass. The public intake portal lets community members apply for help online, in English or Spanish, with no account needed.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/forms"><strong>Form builder</strong><span>Conditional logic, live client fields, translation</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/intake-management"><strong>Intake management</strong><span>Real-time submissions grid, client matching</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/public-intake-portal"><strong>Public intake portal</strong><span>Apply online, no account needed</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.8 2.4 4 5.6 4 9s-1.2 6.6-4 9c-2.8-2.4-4-5.6-4-9s1.2-6.6 4-9Z"/></svg></span>
                        <h2>Community-facing</h2>
                        <p>What the public and your partner organizations see. Events get a public page with online registration, promo codes, and QR check-in on the day itself. Parent education runs end to end: course catalog, public registration that verifies a phone or email before it stores one, SMS and email reminders, attendance against a fidelity threshold, and printable completion certificates.</p>
                        <p>Referrals close the loop with a QR code the receiving provider scans (no login needed), while a partner directory keeps the organizations and contacts you work with organized, and a partner portal gives them controlled channels of their own. Agencies that both run Need Navigator can opt in to work together, sending referrals system to system.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/referrals-partners"><strong>Referrals &amp; partners</strong><span>QR loop closure, partner directory and portal</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/events"><strong>Events</strong><span>Registration, promo codes, day-of check-in</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/parent-education-classes"><strong>Parent education classes</strong><span>Catalog to certificates, reminders to check-in</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-5.3-6.5-10a6.5 6.5 0 0 1 13 0c0 4.7-6.5 10-6.5 10Z"/><circle cx="12" cy="11" r="2.5"/></svg></span>
                        <h2>Facilities &amp; field work</h2>
                        <p>Beds and buildings inside; outreach in the field outside. Shelter staff work from a floor plan they can actually see: multi-floor layouts with live bed-status colors, drawn by hand or drafted by an AI assistant from your room and bed inventory. A reservation workflow runs alongside it from booking through check-out, with families booked and checked in or out together as one group. A week-at-a-glance bed-by-date matrix shows what is open tonight.</p>
                        <p>For street outreach and home-visiting teams, GeoTracker logs a GPS-stamped location for a client encounter in one tap and puts everything on a clustered supervisor map. It is well suited to Point-in-Time (PIT) count fieldwork.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/shelters"><strong>Shelters &amp; beds</strong><span>Floor plans, bed matrix, family check-in</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/geotracker"><strong>GeoTracker</strong><span>One-tap GPS logging, supervisor map</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-5M11 17V7M15 17v-7M19 17V5"/></svg></span>
                        <h2>Insight &amp; oversight</h2>
                        <p>For the director, the board, and the funder questionnaire. A report builder spans eleven record types (clients, households, visits, needs, referrals, and more) with saved definitions, scheduled delivery, Excel export, and per-report redaction levels for personally identifiable information (PII), so a board-ready export doesn't carry sensitive identifiers. Program dashboards put the metrics your team watches on a shared widget board: funding-pool balances, build-your-own query tables, recent clients.</p>
                        <p>Underneath it all runs the audit trail: every create, update, delete, and client-record view is logged, and suspicious-access rules flag unusual patterns for an administrator to review. The data model is HMIS-adjacent (HMIS is the Homeless Management Information System), built to support your funder reporting.</p>
                    </div>
                    <div class="module-links">
                        <a href="/reporting"><strong>Reports &amp; dashboards</strong><span>Build, schedule, redact, export</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/security"><strong>Security, audit &amp; access monitoring</strong><span>Private databases, logged views, flagged patterns</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See the modules your work runs on', 'blurb' => 'A demo is a walk through your own workflows. Bring your programs, your forms, and your intake practice, and we will show you the modules that carry them.'])

@endsection
