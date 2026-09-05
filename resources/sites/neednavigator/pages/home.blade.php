@extends('site::partials.layout')

@section('title', 'Nonprofit Case Management Software | Need Navigator')
@section('description', 'Case management software built with human-services agencies: intake to outcomes, the numbers your funders ask for, and transparent per-seat pricing.')

@section('content')

    {{-- ================= Hero ================= --}}
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <p class="eyebrow">Helping you help others</p>
                <h1>Nonprofit case management software that works the way your agency does</h1>
                <p class="lede">Need Navigator keeps the people you serve in one place: individuals, households, needs, visits, referrals, goals. It is configured to your programs instead of someone else's template. Built in Salem, Oregon, side by side with the agencies that use it.</p>
                <div class="hero-ctas">
                    <a class="button primary" href="/contact">Request a demo</a>
                    <a class="button ghost" href="/features">Explore the features</a>
                </div>
                <p class="hero-note">$25 per user per month, published right on the <a href="/pricing">pricing page</a>. Every agency runs on its own private database.</p>
            </div>
            <div class="hero-art">
                {{-- IMAGE SLOT: home-hero | filled 2026-09-04 with a real screenshot: img/screens/hero-jimmy-calvert (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
                @include('site::partials.screen', ['name' => 'hero-jimmy-calvert', 'alt' => 'A client profile card in Need Navigator: a black and white photo of a scowling baby, Jimmy Calvert, age 2, with an insurance renewal reminder and the demographic fields his agency chose to show', 'width' => 529, 'height' => 698, 'class' => 'hero-card', 'eager' => true])
            </div>
        </div>
    </section>

    {{-- ================= Pain → solution ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>The work is hard. The software shouldn't be.</h2>
                <p class="muted">Four problems we hear from every agency, and what Need Navigator does about them.</p>
            </div>
            <div class="pains">
                <article class="pain reveal">
                    <span class="icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3h8l4 4v14H8z"/><path d="M16 3v4h4"/><path d="M4 7v14h12"/><path d="M11 12h6M11 16h6"/></svg>
                    </span>
                    <span class="pain-tag">Intake still lives on paper and gets typed twice.</span>
                    <h3>From application to client record without re-keying</h3>
                    <p>People apply online in English or Spanish, no account needed, with guided income capture that walks them through each source. A matching engine classifies every submission as an exact match, probable match, or new person, and a family application can build the whole household in one pass.</p>
                    <p><a href="/features/intake-management">How intake works</a></p>
                </article>
                <article class="pain reveal">
                    <span class="icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V10M10 20V4M16 20v-8M21 20H3"/></svg>
                    </span>
                    <span class="pain-tag">Report season eats a week, every quarter.</span>
                    <h3>The numbers your funders ask for, on a schedule</h3>
                    <p>Build reports across eleven record types, break demographics down by race, ethnicity, gender, language, and ZIP, and export everything to Excel. Set redaction levels so a board packet never carries sensitive identifiers, then schedule delivery: every month, done before you ask.</p>
                    <p><a href="/reporting">See reporting</a></p>
                </article>
                <article class="pain reveal">
                    <span class="icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v10M9.5 9.5c0-1 1.1-1.7 2.5-1.7s2.5.7 2.5 1.7c0 2.8-5 1.6-5 4.4 0 1 1.1 1.7 2.5 1.7s2.5-.7 2.5-1.7"/></svg>
                    </span>
                    <span class="pain-tag">Assistance dollars tracked in a spreadsheet nobody quite trusts.</span>
                    <h3>Every dollar tied to a funder, a client, and a voucher</h3>
                    <p>Assistance requests move through a clear review-and-approval ladder. Funding pools carry balances by funder and program, requests can split across pools with reconciliation warnings, and the eligibility math prints right on the voucher.</p>
                    <p><a href="/features/emergency-assistance">How assistance tracking works</a></p>
                </article>
                <article class="pain reveal">
                    <span class="icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="3.5"/><circle cx="17" cy="10" r="2.5"/><path d="M3 20c0-3 2.2-5 5-5s5 2 5 5"/><path d="M14.5 19.5c.3-2.3 1.8-3.5 4-3.5 1 0 1.9.3 2.5.8"/><path d="M18 3l3 3-3 3"/></svg>
                    </span>
                    <span class="pain-tag">When a caseworker leaves, their caseload leaves with them.</span>
                    <h3>Continuity that survives turnover</h3>
                    <p>Care teams keep every assignment (internal staff and partner contacts) with full history, and a departing worker's active caseload transfers to a colleague in one operation. Notes, threads, and documents stay on the record, where the next person can find them.</p>
                    <p><a href="/features/households-care-team">Care teams &amp; caseload transfer</a></p>
                </article>
            </div>
        </div>
    </section>

    {{-- ================= Dashboard feature moment ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="hero-grid">
                <div>
                    <p class="eyebrow">Dashboards</p>
                    <h2>Your programs at a glance, arranged your way</h2>
                    <p>Each program gets a configurable dashboard the whole team shares: drag-and-drop widgets for recent clients, funding-pool balances with health indicators, and build-your-own query tables over visits, needs, and class outcomes, with fiscal-year date presets, because that's how your grants think.</p>
                    <p><a href="/reporting">Reporting &amp; dashboards</a></p>
                </div>
                <div>
                    {{-- IMAGE SLOT: home-dashboard | filled 2026-09-04 with a real screenshot: img/screens/dashboard (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
                    <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Resource Center dashboard</span></div>
                    @include('site::partials.screen', ['name' => 'dashboard', 'alt' => 'The configurable program dashboard: a funding pool widget with amount spent and remaining, a list of needs pending approval, an emergency financial assistance submissions grid, and a referrals list', 'width' => 1665, 'height' => 870])
                </div>
                <figcaption class="ui-caption">The configurable program dashboard on a test instance: a funding-pool widget with spend and remaining balance, the needs waiting for approval, the emergency assistance submissions grid, and pending referrals, all on one board the program shares.</figcaption>
            </figure>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Feature map ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>One system for the whole agency</h2>
                <p class="muted">One product, one price. Explore the modules your work runs on.</p>
            </div>
            <div class="module-index">
                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="2"/><path d="M5.5 16c.5-1.5 1.7-2.3 3-2.3s2.5.8 3 2.3"/><path d="M14 9h5M14 12.5h5M14 16h3"/></svg></span>
                        <h3>Client &amp; household records</h3>
                        <p>The person, their household, and their paperwork: complete, current, and deduplicated.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/client-records"><strong>Client records</strong><span>Configurable profiles, alerts, duplicate prevention</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/documents"><strong>Documents &amp; files</strong><span>Typed files, folders, PDF merge, scanner inbox</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/households-care-team"><strong>Households &amp; care teams</strong><span>Relationships, shared data, caseload transfer</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/income-eligibility"><strong>Income &amp; eligibility</strong><span>Verified income and poverty-level screening</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M9 5V3.5A1.5 1.5 0 0 1 10.5 2h3A1.5 1.5 0 0 1 15 3.5V5"/><path d="M8.5 13.5l2.5 2.5 4.5-4.5"/></svg></span>
                        <h3>Service delivery</h3>
                        <p>The daily work: assistance requests, visits, notes, goals, and the billing that follows from them.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/emergency-assistance"><strong>Emergency assistance</strong><span>Requests, funding pools, printable vouchers</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/casework"><strong>Casework</strong><span>Visits, notes, goals, tasks, calendar</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/billing"><strong>Billing</strong><span>Claim preparation and Excel export</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/programs-automation"><strong>Programs &amp; automation</strong><span>Enrollment, smart buttons, no-code rules</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M8 12h5M8 16h8"/><path d="M17.5 3.5l3 3L14 13h-3v-3z"/></svg></span>
                        <h3>Forms &amp; intake</h3>
                        <p>Build the forms yourselves, then work the submissions together as they arrive.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/forms"><strong>Form builder</strong><span>Staff-built forms with conditional logic</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/intake-management"><strong>Intake management</strong><span>A live submissions grid the whole team works in</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/public-intake-portal"><strong>Public intake portal</strong><span>Apply online, no account needed</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.8 2.4 4 5.6 4 9s-1.2 6.6-4 9c-2.8-2.4-4-5.6-4-9s1.2-6.6 4-9Z"/></svg></span>
                        <h3>Community-facing</h3>
                        <p>What the public and your partners see: applications, events, classes, and referrals that close the loop.</p>
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
                        <h3>Facilities &amp; field work</h3>
                        <p>Beds and buildings inside; GPS-stamped outreach outside.</p>
                    </div>
                    <div class="module-links">
                        <a href="/features/shelters"><strong>Shelters &amp; beds</strong><span>Floor plans, reservations, family check-in</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/features/geotracker"><strong>GeoTracker</strong><span>One-tap GPS logging, mapped for supervisors</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="module-row reveal">
                    <div class="module-head">
                        <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-5M11 17V7M15 17v-7M19 17V5"/></svg></span>
                        <h3>Insight &amp; oversight</h3>
                        <p>What happened, proven: reports, dashboards, and the audit trail behind them.</p>
                    </div>
                    <div class="module-links">
                        <a href="/reporting"><strong>Reports &amp; dashboards</strong><span>Build, schedule, redact, export</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                        <a href="/security"><strong>Audit &amp; access monitoring</strong><span>Client-record views logged, unusual patterns flagged</span><span class="arrow" aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Audience router ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Which describes your agency?</h2>
            </div>
            <div class="audiences">
                <a class="audience reveal" href="/solutions/community-action-agencies">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V8l7-5 7 5v13"/><path d="M9 21v-6h6v6"/><path d="M9 11h.01M15 11h.01"/></svg></span>
                    <strong>Community action agencies</strong>
                    <span>Eligibility, assistance dollars, and the reporting that follows the grant.</span>
                    <em>For community action &rarr;</em>
                </a>
                <a class="audience reveal" href="/solutions/shelters-housing">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6"/><path d="M3 18h18M5 10V7M7 10c0-1.1.9-2 2-2h2v2"/></svg></span>
                    <strong>Shelters &amp; housing</strong>
                    <span>Beds, stays, exits, and outreach in the field.</span>
                    <em>For shelters &rarr;</em>
                </a>
                <a class="audience reveal" href="/solutions/food-banks-community-aid">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 11h14l-1.4 9a2 2 0 0 1-2 1.7H8.4a2 2 0 0 1-2-1.7Z"/><path d="M8 11c0-4 1.8-7 4-7s4 3 4 7"/></svg></span>
                    <strong>Food banks &amp; community aid</strong>
                    <span>Fast intake, households, and referrals that close the loop.</span>
                    <em>For food banks &rarr;</em>
                </a>
                <a class="audience reveal" href="/solutions/parent-education">
                    <span class="icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-2-1.8-5-2.2-8-2v14c3-.2 6 .2 8 2 2-1.8 5-2.2 8-2V4c-3-.2-6 .2-8 2Z"/><path d="M12 6v14"/></svg></span>
                    <strong>Parent education providers</strong>
                    <span>Classes from catalog to certificates, with bilingual intake forms.</span>
                    <em>For parent education &rarr;</em>
                </a>
            </div>
            <p class="mt-2 muted">Also a fit for other community aid organizations. If your work is people, programs, and the paperwork between them, it likely fits. <a href="/solutions">See all solutions</a>.</p>
        </div>
    </section>

    {{-- ================= Trust strip ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Built to be trusted with client data</h2>
            </div>
            <div class="trust">
                <div class="trust-item reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5.5" rx="7" ry="2.5"/><path d="M5 5.5V18.5c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5V5.5"/><path d="M5 12c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5"/></svg></span>
                    <h3>Your own private database</h3>
                    <p>Each agency runs its own isolated copy of Need Navigator with its own database. No shared tenancy. Cross-agency queries are impossible by construction.</p>
                </div>
                <div class="trust-item reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/><circle cx="12" cy="15" r="1.4"/></svg></span>
                    <h3>Encrypted where it counts</h3>
                    <p>Client data is encrypted at rest on the application server, and every client database is backed up nightly to redundant, encrypted cloud storage with integrity verification on every run.</p>
                </div>
                <div class="trust-item reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    <h3>Every client-record view, logged</h3>
                    <p>Every client-record view is logged (who, when, from where) and screened by suspicious-access rules that flag unusual patterns for administrators to review.</p>
                </div>
                <div class="trust-item reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7 4 7"/><path d="M20 12H4M20 17H4"/><circle cx="9" cy="7" r="1.6" fill="currentColor" stroke="none"/><circle cx="15" cy="12" r="1.6" fill="currentColor" stroke="none"/><circle cx="7" cy="17" r="1.6" fill="currentColor" stroke="none"/></svg></span>
                    <h3>Pricing fit for a board packet</h3>
                    <p>$25 per user per month, published in full on the <a href="/pricing">pricing page</a>. No sales-call gate, no surprise tiers.</p>
                </div>
            </div>
            <p class="mt-2"><a href="/security">Read the full security overview</a></p>
        </div>
    </section>

    @include('site::partials.cta')

@endsection
