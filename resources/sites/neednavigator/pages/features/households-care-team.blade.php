@extends('site::partials.layout')

@section('title', 'Household Tracking for Social Services | Need Navigator')
@section('description', 'Group clients into typed households with synced addresses, shared answers, and income rollups, plus care teams and one-step caseload transfer.')

@php
    $faqs = [
        [
            'q' => 'When a family moves, do we update every member\'s record separately?',
            'a' => 'No. Update one household member\'s address, and Need Navigator prompts you to copy the new address, phone, and housing status to the household members you select: one step, and you stay in control of exactly who it applies to. Form answers marked to sync across the household travel the same way, copying between members\' submissions and pre-filling new ones.',
        ],
        [
            'q' => 'Can someone outside our agency be on a client\'s care team?',
            'a' => 'Yes. A care-team member can be your own staff or a contact at a partner organization (a school or another agency you work with), and every assignment carries a role, a program, and start and end dates. That means the people actually involved in a case are on the record together, not scattered across sticky notes.',
        ],
        [
            'q' => 'What happens to a caseload when a worker leaves?',
            'a' => 'A supervisor reassigns the departing worker\'s entire active caseload, or just one program\'s worth of it, to another worker in one operation. The old assignments are ended and kept as history, never erased, so every client\'s record still shows who worked with them and when.',
        ],
        [
            'q' => 'How does household income work for program eligibility?',
            'a' => 'Household income rolls up automatically, so eligibility is evaluated against what the whole household brings in, not just the applicant. A minor\'s income is counted only where a program\'s rules say it should be. The rollup is what program income thresholds, set by federal poverty level (FPL) or area median income (AMI) and household size, are checked against.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Households & care teams'],
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
                    <li aria-current="page">Households &amp; care teams</li>
                </ol>
            </nav>
            <p class="eyebrow">Households &amp; care teams</p>
            <h1>The whole household, and everyone helping them</h1>
            <p class="lede">Household tracking software for social services has to match how people actually live: in families whose addresses, answers, and income belong together. Need Navigator groups clients into typed households that stay in sync, maps the relationships between them, and puts a full care team on every client. When a worker leaves, the caseload moves in one operation and the history stays.</p>
        </div>
    </section>

    {{-- ================= Household panel UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: households-panel | filled 2026-09-05 with a real screenshot: img/screens/household-edit (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Edit household</span></div>
                    @include('site::partials.screen', ['name' => 'household-edit', 'alt' => 'Editing a household: the Gamgee Family with Samwise Gamgee as head of household, four member cards, a relationships panel setting how Merry, Pippin and Sam relate to Frodo Baggins, an Add Member search, and a Manage ROI panel with a PDF and an expiration date', 'width' => 1667, 'height' => 637])
                </div>
                <figcaption class="ui-caption">A household on a test instance: the head of household, a card for each member, and the relationships panel that records how everyone relates to the selected person. The release of information lives on the same screen, with its expiration date, and covers the household through its head.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What households and care teams do</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V9l6-5 6 5v11"/><circle cx="9.5" cy="13" r="1.8"/><circle cx="14.5" cy="13" r="1.8"/><path d="M7.5 20c.4-1.8 2-2.8 4.5-2.8s4.1 1 4.5 2.8"/></svg></span>
                    <h3>Households with a shape</h3>
                    <p>Group clients into typed households with a designated head of household, so income, addresses, and everyday casework can treat the family as one unit instead of a list of disconnected individuals.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="6" cy="18" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="M8.5 6h7M6 8.5v7M18 8.5v7M8.5 18h7M7.8 7.8l8.4 8.4"/></svg></span>
                    <h3>Relationships, mapped</h3>
                    <p>A member-to-member relationship matrix records how everyone is connected, including relationships that extend outside the household, so the grandparent across town stays on the map.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V9l6-5 6 5v11"/><path d="M9.2 13.6a3 3 0 0 1 5.3-1.2M14.8 14.4a3 3 0 0 1-5.3 1.2"/><path d="M14.9 10.5v2h-2M9.1 17.5v-2h2"/></svg></span>
                    <h3>One move, one update</h3>
                    <p>When a member's address changes, staff are prompted to copy the new address, phone, and housing status to the household members they select. One step, no member-by-member re-entry.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="12" height="15" rx="1.5"/><path d="M7 7h6M7 10h6M7 13h4"/><path d="M14.5 19.3a3.2 3.2 0 0 0 5.6-1.6M20.4 19.5a3.2 3.2 0 0 0-5.6 1.6"/><path d="M20.4 15.6v2.1h-2.1M14.5 23v-2.1h2.1"/></svg></span>
                    <h3>Answers that follow the family</h3>
                    <p>Form answers marked "sync across household" copy between household members' submissions and pre-fill new ones. A family's tenth form should not start from zero.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="9" cy="6" rx="5" ry="2.2"/><path d="M4 6v5c0 1.2 2.2 2.2 5 2.2s5-1 5-2.2V6"/><path d="M4 11v5c0 1.2 2.2 2.2 5 2.2 1 0 1.9-.1 2.7-.4"/><circle cx="17.5" cy="16.5" r="4"/><path d="M17.5 14.8v3.4M15.8 16.5h3.4"/></svg></span>
                    <h3>Income that adds itself up</h3>
                    <p>Household income rolls up automatically for program eligibility, and a minor's income is counted only where a program's rules say so. The math is ready before anyone reaches for a calculator.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="16.5" cy="9.5" r="2.2"/><path d="M3.5 19c0-2.8 2.3-4.6 5.5-4.6s5.5 1.8 5.5 4.6"/><path d="M15 16.7c.6-1.6 2-2.4 3.7-2.4 1 0 1.8.3 2.4.8"/></svg></span>
                    <h3>The whole care team, on the record</h3>
                    <p>Each client can have multiple care-team members at once: your own staff or a contact at a partner organization, each with a role, a program, and start and end dates.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 3v18"/><path d="M11.5 7.5h5M11.5 10.5h5"/><circle cx="13.8" cy="15.2" r="1.6"/><path d="M11.3 19.3c.4-1.2 1.3-1.9 2.5-1.9s2.1.7 2.5 1.9"/></svg></span>
                    <h3>A directory that knows who does what</h3>
                    <p>Browse every assignment with filters for program, role, provider type, and status, plus summary counts. Roles are agency-defined and tied to your staff teams, so role dropdowns only offer people who actually hold that role.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="6.5" cy="7" r="2.5"/><path d="M2.5 14.5c.5-1.7 2-2.6 4-2.6s3.5.9 4 2.6"/><circle cx="17.5" cy="12.5" r="2.5"/><path d="M13.5 20c.5-1.7 2-2.6 4-2.6s3.5.9 4 2.6"/><path d="M13 4.5h6M19 4.5l-2-2M19 4.5l-2 2"/></svg></span>
                    <h3>Turnover without dropped clients</h3>
                    <p>Reassign a departing worker's entire active caseload (or just one program's worth) to another worker in one operation. Ended assignments are kept as history, never erased.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Two weeks' notice</h3>
                <p>A caseworker turns in their notice on a Friday. Their supervisor opens the care-team directory first (filtered by program and role, with summary counts) to see who has room to take the work on. Then, in one operation, they transfer the departing worker's entire active caseload to a colleague. If the load had needed splitting, one program's worth could have moved on its own.</p>
                <p>Monday morning, the new worker is already on every client's care team, with notes, documents, and history right where the last person left them. The old assignments were ended, not erased. Months from now, when someone asks who worked with a family last spring, the record still answers.</p>
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
    <section class="section section--crosslinks">
        <div class="container">
            <p class="eyebrow" style="margin-bottom: 1rem">Works with</p>
            <div class="crosslinks">
                <a href="/features/client-records">Client records &amp; profiles</a>
                <a href="/features/income-eligibility">Income &amp; eligibility screening</a>
                <a href="/features/intake-management">Intake &amp; household capture</a>
                <a href="/features/referrals-partners">Referrals &amp; partner directory</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a household come together', 'blurb' => 'Bring a family scenario to the demo, and we will build the household, map the relationships, and move a caseload from one worker to another in one operation.'])

@endsection
