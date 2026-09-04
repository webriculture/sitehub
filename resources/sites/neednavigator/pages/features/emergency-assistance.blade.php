@extends('site::partials.layout')

@section('title', 'Emergency Assistance Tracking Software | Need Navigator')
@section('description', 'Track assistance requests from intake to voucher — a clear approval ladder, funding pools with balances, and eligibility math printed on the voucher.')

@php
    $faqs = [
        [
            'q' => 'Can one request be paid from more than one funding pool?',
            'a' => 'Yes. Funding pools are budgets tied to funder organizations or programs, each with its own balance and date range, and a single request can be split across several pools at once. The system warns when the allocations do not add up to the request amount, and funder-level spending and remaining balances are there for reporting.',
        ],
        [
            'q' => 'What prints on the voucher?',
            'a' => 'The voucher carries the request details and the eligibility math behind the decision: household size, the household\'s recent income pulled from a tracking window your agency configures, the program\'s maximum allowed income, and a clear under-or-over-limit verdict. A funder or auditor can see why the request qualified without ever opening the software.',
        ],
        [
            'q' => 'How do supervisors review and approve requests?',
            'a' => 'Every request moves up a fixed status ladder — Pending, Ready for Review, Approved, Finalized, Voucher Printed, with Denied and Closed as off-ramps — so the review queue is always explicit. Supervisors can also update status inline from the Quick Forms submissions grid, where changes appear for the whole team in real time. Every status change is recorded in the audit trail.',
        ],
        [
            'q' => 'How are payments actually made?',
            'a' => 'Need Navigator prepares and tracks the payment; it does not move the money. There is no check printing, bank-transfer integration, or online payment — staff attach the invoice PDF to the disbursement, email it to the payee directly from the system, and track its sent and finalized status while your finance office issues payment the way it already does.',
        ],
        [
            'q' => 'Can we track help that isn\'t money?',
            'a' => 'Yes. The resource catalog holds financial and non-financial resources alike, so a box of food, a bus pass, or a car seat is logged with the same need types and quantities as a rent payment. Non-financial needs simply skip the payment record.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Needs & emergency assistance'],
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
                    <li aria-current="page">Needs &amp; emergency assistance</li>
                </ol>
            </nav>
            <p class="eyebrow">Needs &amp; emergency assistance</p>
            <h1>A clear path from request to voucher</h1>
            <p class="lede">Emergency assistance tracking software has two jobs: show where every request stands, and show whose dollars are paying for it. Need Navigator moves each request up a clear approval ladder, ties every dollar to a funding pool with a real balance, and prints the eligibility math right on the voucher.</p>
        </div>
    </section>

    {{-- ================= Voucher UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: emergency-assistance-voucher | replace with: real screenshot of the printable assistance request/voucher, light theme — request details, eligibility math (household size, recent income vs. program maximum, under-limit verdict), and a split allocation across two funding pools all visible. Placeholder: stylized HTML recreation of the voucher. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Assistance request — print preview</span></div>
                    <div class="uiframe-body">
                        <div class="ui-voucher">
                            <div class="v-head">
                                <span class="v-title">Assistance voucher &middot; Request #2481</span>
                                <span class="v-status">Approved</span>
                            </div>
                            <div class="v-block">
                                <span class="v-label">Request</span>
                                <div class="v-row"><span>Resource</span><strong>Utility assistance &mdash; electric</strong></div>
                                <div class="v-row"><span>Amount requested</span><strong>$240.00</strong></div>
                                <div class="v-row"><span>Payee</span><strong>Riverbend Electric Co-op</strong></div>
                            </div>
                            <div class="v-block">
                                <span class="v-label">Eligibility</span>
                                <div class="v-row"><span>Household size</span><strong>3</strong></div>
                                <div class="v-row"><span>Recent household income, annualized</span><strong>$26,180</strong></div>
                                <div class="v-row"><span>Program maximum allowed</span><strong>$32,150</strong></div>
                                <div class="v-verdict"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>Under the program limit &mdash; eligible</div>
                            </div>
                            <div class="v-block">
                                <span class="v-label">Funding allocation</span>
                                <div class="v-row"><span>Energy assistance pool &mdash; County</span><strong>$150.00</strong></div>
                                <div class="v-row"><span>Emergency fund &mdash; General</span><strong>$90.00</strong></div>
                                <div class="v-row v-total"><span>Allocated</span><strong>$240.00 of $240.00</strong></div>
                                <div class="v-check"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>Allocations match the request amount</div>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the printable voucher: the request, the eligibility math &mdash; household size, recent income, the program limit, and the verdict &mdash; and a split across two funding pools, reconciled to the penny.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the assistance module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg></span>
                    <h3>A catalog of what you give</h3>
                    <p>Log a need against your agency's own catalog of resources &mdash; financial or non-financial &mdash; with need types, quantity, amount, and the organization that gets paid. The catalog is yours to define, in your agency's vocabulary.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h5v-5h5v-5h5V5h3"/></svg></span>
                    <h3>A ladder every request climbs</h3>
                    <p>Pending &rarr; Ready for Review &rarr; Approved &rarr; Finalized &rarr; Voucher Printed, with Denied and Closed as off-ramps. Anyone can see where a request stands, and every status change lands in the audit trail.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5.5" rx="7" ry="2.5"/><path d="M5 5.5v6c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5v-6"/><path d="M5 11.5v6c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5v-6"/></svg></span>
                    <h3>Funding pools with real balances</h3>
                    <p>Budgets tied to funder organizations or programs carry balances, date ranges, and per-need allocations &mdash; so knowing what is left in the county grant takes a glance, not an afternoon of spreadsheet work.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v5"/><path d="M12 9c0 4-6 3.2-6 7v4"/><path d="M12 9c0 4 6 3.2 6 7v4"/></svg></span>
                    <h3>Split one request across funders</h3>
                    <p>A single request can draw from several pools at once, and the system warns when the allocations do not add up to the request amount &mdash; mismatches surface now, not at reporting time.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 7h6"/><path d="M9 12h.01M12 12h.01M15 12h.01M9 15.5h.01M12 15.5h.01M15 15.5h.01"/></svg></span>
                    <h3>Eligibility math, printed where it counts</h3>
                    <p>The printable voucher shows household size, recent household income &mdash; pulled automatically from a tracking window your agency configures &mdash; the program's maximum allowed income, and an under-or-over-limit verdict.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 8 9 6 9-6"/></svg></span>
                    <h3>Disbursements, tracked honestly</h3>
                    <p>Each financial need carries a payment record: attach the invoice PDF, email it to the payee straight from the system, and track sent and finalized status. There is no check printing or bank-transfer integration &mdash; your finance process stays yours, and the record stays complete.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11M15 9v11"/></svg></span>
                    <h3>A review queue that moves</h3>
                    <p>Supervisors can work approvals right from the Quick Forms submissions grid &mdash; each row shows its linked request's status, updates inline, and changes appear for the whole team in real time.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 3 5 13h6l-1 8 8-10h-6l1-8Z"/></svg></span>
                    <h3>The follow-through is automatic</h3>
                    <p>Automations can send an email, create a task, or post to the request's message thread when a status changes &mdash; an approval, a denial &mdash; and billing records can be generated from the need's types without separate data entry.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A shut-off notice, gone by end of day</h3>
                <p>A client comes in at 9:40 on a Tuesday holding a disconnection notice dated for Friday. The intake worker logs a need against the electric-utility resource and enters the amount from the notice; the request pulls the household's recent income on its own &mdash; under the program limit, and the verdict says so. They set the status to Ready for Review and turn to the next person in the lobby.</p>
                <p>The program supervisor clears their review queue before lunch: they split the request between the county energy pool and the general emergency fund — no mismatch warning, the allocations add up — and they approve it. By early afternoon the voucher is printed with the eligibility math on it, the invoice is attached and emailed to the utility, and the disbursement shows as sent. The client left hours ago with a copy in hand.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions agencies ask</h2>
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
                <a href="/features/income-eligibility">Income &amp; eligibility screening</a>
                <a href="/features/billing">Billing &amp; claim preparation</a>
                <a href="/features/programs-automation">Programs, smart buttons &amp; automations</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/solutions/community-action-agencies">For community action agencies</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Walk a request end to end', 'blurb' => 'Bring a real scenario — a rent shortfall, a shut-off notice — and we will take it from intake through review, the funding split, and the printed voucher.'])

@endsection
