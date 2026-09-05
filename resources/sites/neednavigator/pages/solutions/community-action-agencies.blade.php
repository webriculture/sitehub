@extends('site::partials.layout')

@section('title', 'Case Management Software for Community Action Agencies')
@section('description', 'For community action agencies: FPL/AMI eligibility, verified income, funding pools tracked to the penny, and reports that support your funder reporting.')

@php
    $faqs = [
        [
            'q' => 'How does the eligibility engine work?',
            'a' => 'You load income thresholds by year, type, geographic area, and household size, with a percentage multiplier for programs set at, say, 125 percent of poverty. The type is either federal poverty level (FPL) or area median income (AMI). Programs combine income rules with age ranges and required-field rules, and clients show as eligible or partially eligible. When new guidelines publish, a bulk tool generates next year\'s thresholds from the current year\'s.',
        ],
        [
            'q' => 'We braid funding from several sources. Can it keep them straight?',
            'a' => 'Yes. Funding pools carry a budget, a date range, and the funder organization or program they belong to, and a single assistance request can split across multiple pools. The system warns when the allocations do not add up to the request amount. Spending and remaining balances report by funder, so you always know whose dollars went where.',
        ],
        [
            'q' => 'Will it handle our CSBG reporting?',
            'a' => 'The Community Services Block Grant (CSBG) is the funding stream most community action agencies report against, and Need Navigator\'s demographic and spending breakdowns are built with that kind of reporting in mind. There are no pre-built federal report templates. You assemble reports in the flexible report builder and export them to Excel. The system supports your funder reporting; it does not make compliance claims on your behalf.',
        ],
        [
            'q' => 'Is our data separate from other agencies?',
            'a' => 'Yes. Each agency runs its own copy of Need Navigator with its own private database. There is no shared tenancy, and cross-agency queries are impossible by construction. Client data is encrypted at rest on the application server, and every client database is backed up nightly to redundant, encrypted cloud storage with integrity verification on every run.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Community action agencies'],
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
                    <li aria-current="page">Community action agencies</li>
                </ol>
            </nav>
            <p class="eyebrow">For community action agencies</p>
            <h1>Eligibility you can document, dollars you can trace</h1>
            <p class="lede">Case management software for community action agencies gets tested twice: once at intake, and again when the monitor visits. Need Navigator screens households against federal poverty level (FPL) and area median income (AMI) guidelines, keeps staff-verified income apart from self-reported, tracks every assistance dollar to the penny by funder, and holds the audit trail that backs it all up.</p>
        </div>
    </section>

    {{-- ================= Funding pools UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: caa-funding-pools | filled 2026-09-04 with a real screenshot: img/screens/funding-pools-fy, composited from funding-pools3 without its "Community Action Agency DAP" row (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Funding pools</span></div>
                    @include('site::partials.screen', ['name' => 'funding-pools-fy', 'alt' => 'Three fiscal-year funding pools: a utilities fund at 87 percent spent with 12 requests, a state family-preservation fund at 62 percent with 35 requests, and a reimbursements pool at zero, each with start and end dates', 'width' => 1373, 'height' => 284])
                </div>
                <figcaption class="ui-caption">Fiscal-year funding pools on a test instance: each pool&rsquo;s spend against its total, how many requests have drawn on it, and the year it covers, with a reimbursement pool that has no ceiling.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Workflow sections ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Built for the way community action runs</h2>
                <p class="muted">Six workflows every community action agency carries, and how Need Navigator handles them.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4H7a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2"/><rect x="9" y="2.5" width="6" height="3" rx="1"/><path d="M8.5 13l2.5 2.5 4.5-5"/></svg></span>
                    <h3>Eligibility against FPL and AMI</h3>
                    <p>Set income thresholds by year, type (FPL or AMI), geographic area, and household size, with a percentage multiplier per program. Programs combine income rules with age ranges and field rules, clients show as eligible or partially eligible, and a bulk tool generates next year's thresholds from this year's.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="11" rx="2"/><circle cx="12" cy="12.5" r="2.5"/><path d="M6.5 10h.01M17.5 15h.01"/></svg></span>
                    <h3>Income you can stand behind</h3>
                    <p>Income sources carry proof (a pay-stub photo or PDF, snapped on a phone), and the system enforces the line between staff-verified and self-reported amounts. Income from a public application arrives marked unverified and does not count toward eligibility until a staff member confirms it. Household income rolls up automatically.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3v9l6.4 6.3"/><path d="M12 12L3.6 15"/></svg></span>
                    <h3>Assistance tracked to the penny</h3>
                    <p>Requests move through a clear status ladder: pending, ready for review, approved, finalized, voucher printed. Supervisors have a queue, not a pile. Funding pools carry balances and date ranges by funder or program, one request can split across pools, and the system warns when allocations do not add up. The eligibility math prints right on the voucher.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M9 13.5h6M12 10.5v6"/></svg></span>
                    <h3>Programs with real enrollment history</h3>
                    <p>Enrollment episodes keep entry and exit dates, who enrolled and exited the client, and, where configured, agency-defined exit reasons grouped into categories. Each program's homepage shows enrollment counts, retention, resources distributed, and dollars disbursed: the shape of the program at a glance.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-5M11 17V8M15 17v-3"/><circle cx="18.5" cy="6.5" r="2.8"/><path d="M18.5 5.4v1.3l.9.6"/></svg></span>
                    <h3>Reporting that follows the grant</h3>
                    <p>Break demographics down by race, ethnicity, gender, language, and ZIP, the kind of breakdowns that support Community Services Block Grant (CSBG)-style funder reporting. Schedule delivery weekly or monthly, done before anyone asks. Per-report redaction levels keep personally identifiable information (PII) out of a board packet, and everything exports to Excel.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h12M4 9h12M4 13h6"/><circle cx="15" cy="15" r="4"/><path d="M18 18l3 3"/></svg></span>
                    <h3>Ready for the monitor's visit</h3>
                    <p>Every create, update, delete, and client-record view is logged (who, when, from where), and toggleable rules flag unusual access patterns for administrators to review. When a monitor asks who touched a record, the answer is a filter, not a hunt, and access logs export to CSV.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>An eligibility intake day</h3>
                <p>A family of five applies for energy assistance through the public portal on Sunday night. Monday morning the application is waiting in the submissions grid: the matching engine has flagged the parent as a probable match to an existing record, and the intake specialist confirms it, then lets household capture build the rest of the family in one pass. The income the family entered through guided capture sits on the record marked unverified, visible but not yet counting toward eligibility.</p>
                <p>At the afternoon appointment the family brings pay stubs. The specialist snaps each one on a tablet, attaches it to its income source, and marks the amounts verified; household income rolls up on its own. The assistance request compares that income to the program's maximum right on the printable request: under the limit, with the verdict printed where a monitor can see it. They split the award across the county energy pool and a utility partner fund, the totals reconcile, and the request lands in the supervisor's review queue before the family reaches the parking lot.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions community action agencies ask</h2>
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
                <a href="/features/income-eligibility">Income &amp; eligibility screening</a>
                <a href="/features/emergency-assistance">Emergency assistance &amp; funding pools</a>
                <a href="/features/programs-automation">Programs, enrollment &amp; automation</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/security">Security &amp; audit trail</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See it with your income guidelines in hand', 'blurb' => 'Bring this year\'s guidelines and the funder report you dread. We will build a program\'s eligibility rules live and walk an assistance request from intake to printed voucher.'])

@endsection
