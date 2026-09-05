@extends('site::partials.layout')

@section('title', 'Referral Tracking Software for Nonprofits | Need Navigator')
@section('description', 'Track referrals from send to close: the printed referral carries a QR code the receiving provider scans (no login), recording feedback and a timestamp.')

@php
    $faqs = [
        [
            'q' => 'What does the receiving provider need to close a referral?',
            'a' => 'Just a phone camera. The printed referral carries a QR (quick-response) code; scanning it opens a simple page where the provider records who received the client and their feedback. No login and no account required. The referral completes with a timestamp.',
        ],
        [
            'q' => 'Do partner organizations need Need Navigator to receive referrals?',
            'a' => 'No. You can refer to any organization and contact in your directory, and the printed QR-code loop closure asks nothing of the partner but a scan. If a partner agency also runs Need Navigator, the two of you can additionally opt in to the Need Navigator Network and send referrals directly system-to-system.',
        ],
        [
            'q' => 'What can a partner do in the partner portal?',
            'a' => 'Where an agency has the portal configured, partner contacts sign in with their own credentials to manage their class offerings and events, record attendance and register walk-ins, submit needs against resources flagged for portal use, and post to task lists marked as accepting portal posts. Every write is attributed to the acting contact, validated against their organization, and subject to the same rules as staff actions.',
        ],
        [
            'q' => 'Is the Need Navigator Network something we are automatically part of?',
            'a' => 'No. It is an opt-in capability, not an active exchange. Two agencies that both run Need Navigator choose to connect, with token-secured server-to-server connections and per-connection permissions for sending messages, sending referrals, and viewing or searching individuals. Each agency keeps its own private database throughout.',
        ],
        [
            'q' => 'Can we report on referral outcomes?',
            'a' => 'Yes. Loop-closure timestamps and provider feedback are recorded on each referral, and referrals are one of the eleven record types in the report builder: choose your columns, stack condition filters, and export to Excel. Those breakdowns support your funder reporting.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Referrals & partners'],
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
                    <li aria-current="page">Referrals &amp; partners</li>
                </ol>
            </nav>
            <p class="eyebrow">Referrals &amp; partners</p>
            <h1>Referrals that come back closed</h1>
            <p class="lede">Referral tracking software for nonprofits tends to stop at "sent." Need Navigator follows through: the printed referral carries a QR (quick-response) code the receiving provider scans, with no login and no account, to record who received the client and how it went, closing the loop with a timestamp. Behind it sits a real partner directory, a portal partners can log into, and an opt-in network for agencies that both run Need Navigator.</p>
        </div>
    </section>

    {{-- ================= Printed referral UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: referrals-printed-qr | replace with: real screenshot of a printed referral, light theme, portrait or landscape: destination organization, referral reason, the QR code, and the recorded loop closure (received-by, feedback, timestamp) all visible. Placeholder: stylized HTML recreation of the printed referral with its closure record. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Referral #1873: print preview</span></div>
                    <div class="uiframe-body">
                        <div class="ui-referral">
                            <div class="r-head">
                                <span class="r-title">Referral &middot; #1873</span>
                                <span class="r-chip">Completed</span>
                            </div>
                            <div class="r-grid">
                                <div class="r-rows">
                                    <div class="r-row"><span>Referred to</span><strong>Cedarwood Community Pantry</strong></div>
                                    <div class="r-row"><span>Contact</span><strong>Front desk</strong></div>
                                    <div class="r-row"><span>Reason</span><strong>Emergency food box</strong></div>
                                    <div class="r-row"><span>Referred by</span><strong>Housing Stability program</strong></div>
                                    <div class="r-row"><span>Printed</span><strong>Tue, Mar 3</strong></div>
                                </div>
                                <div class="r-qr">
                                    <svg width="92" height="92" viewBox="0 0 21 21" fill="currentColor">
                                        <path d="M0 0h7v7H0zm1 1v5h5V1z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/>
                                        <path d="M14 0h7v7h-7zm1 1v5h5V1z" fill-rule="evenodd"/><rect x="16" y="2" width="3" height="3"/>
                                        <path d="M0 14h7v7H0zm1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="16" width="3" height="3"/>
                                        <path d="M8 6h1v1H8zM10 6h1v1h-1zM12 6h1v1h-1zM6 8h1v1H6zM6 10h1v1H6zM6 12h1v1H6zM8 1h1v1H8zM10 2h1v1h-1zM12 1h1v1h-1zM9 3h1v1H9zM11 4h1v1h-1zM13 3h1v1h-1zM8 5h1v1H8zM1 8h1v1H1zM3 9h1v1H3zM0 10h1v1H0zM2 11h1v1H2zM4 12h1v1H4zM5 9h1v1H5zM1 13h1v1H1zM8 8h1v1H8zM10 8h1v1h-1zM13 8h1v1h-1zM15 8h1v1h-1zM17 9h1v1h-1zM19 8h1v1h-1zM20 10h1v1h-1zM9 10h1v1H9zM11 10h1v1h-1zM12 11h1v1h-1zM14 10h1v1h-1zM16 11h1v1h-1zM18 10h1v1h-1zM8 12h1v1H8zM10 13h1v1h-1zM12 12h1v1h-1zM15 12h1v1h-1zM17 13h1v1h-1zM19 12h1v1h-1zM9 14h1v1H9zM11 15h1v1h-1zM13 14h1v1h-1zM16 14h1v1h-1zM18 15h1v1h-1zM20 15h1v1h-1zM8 16h1v1H8zM10 17h1v1h-1zM12 16h1v1h-1zM14 17h1v1h-1zM19 17h1v1h-1zM9 18h1v1H9zM11 19h1v1h-1zM13 18h1v1h-1zM15 19h1v1h-1zM17 18h1v1h-1zM20 18h1v1h-1zM8 20h1v1H8zM10 20h1v1h-1zM14 20h1v1h-1zM16 20h1v1h-1zM18 20h1v1h-1zM20 20h1v1h-1z"/>
                                    </svg>
                                    <span>Scan to record receipt (no login needed)</span>
                                </div>
                            </div>
                            <div class="r-closure">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                <p><span class="r-when">Loop closed: Thu, Mar 5, 2:41 p.m.</span>Received by front-desk staff, who noted the household picked up a three-day food box.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of a printed referral: where the client is headed and why, the QR code the receiving provider scans to record receipt with no login, and the loop closure that comes back with feedback and a timestamp.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the referral &amp; partner tools do</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/></svg></span>
                    <h3>Send it anywhere the client needs to go</h3>
                    <p>Refer to an internal program or staff member, or to an external organization and contact from your directory. Referrals can be spawned straight from a visit or a task, so follow-through starts where the conversation happened.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3h-3zM21 14v.01M14 21h.01M18 18h3v3h-3z"/></svg></span>
                    <h3>A QR code closes the loop</h3>
                    <p>Every printed referral carries a QR code. The receiving provider scans it (no login, no account), records who received the client and their feedback, and the referral completes with a timestamp.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a8 8 0 0 1-8 8H4l2.5-2.5A8 8 0 1 1 21 12Z"/><path d="M8.5 10.5h7M8.5 14h4.5"/></svg></span>
                    <h3>A conversation attached to every referral</h3>
                    <p>A message thread rides along with each referral, and messages appear for other participants in real time, so the follow-up conversation lives with the referral instead of scattering across inboxes.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h7l-1 8 10-12h-7l1-8z"/></svg></span>
                    <h3>Reasons your agency defines, with automations</h3>
                    <p>Referral reasons are your vocabulary, not ours, and each reason can carry automations, such as sending a templated email the moment a referral is created.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5v14A2.5 2.5 0 0 0 6.5 22H20v-5"/><path d="M9 7h7M9 10.5h5"/></svg></span>
                    <h3>A partner directory with real depth</h3>
                    <p>Organizations carry a type, parent/child hierarchy, a funder flag, and per-organization service listings: areas served, hours, services offered, eligibility notes, and languages spoken. Search spans names, phone numbers, types, and contacts.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9.5" r="2.2"/><path d="M3.5 19c0-2.8 2.3-4.6 5.5-4.6s5.5 1.8 5.5 4.6"/><path d="M15.5 16.7c.6-1.6 2-2.4 3.7-2.4 1 0 1.8.3 2.4.8"/></svg></span>
                    <h3>Partner contacts on the care team</h3>
                    <p>A contact at a partner organization can sit on a client's care team as a first-class member, with a role, program, and start and end dates, so the record shows everyone who is actually helping, not just your own staff.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/><path d="M10 8l4 4-4 4M14 12H3"/></svg></span>
                    <h3>A portal partners log into</h3>
                    <p>Where an agency turns it on, partner contacts get their own logins to manage their class offerings and events, record attendance and register walk-ins, submit needs against resources you flag for portal use, and post to task lists that accept portal posts. Every write is attributed to the acting contact and validated against their organization.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="6" r="2.5"/><circle cx="19" cy="6" r="2.5"/><circle cx="12" cy="18" r="2.5"/><path d="M7.3 7.2l7-.01M6.2 8.3l4.4 7.5M17.8 8.3l-4.4 7.5"/></svg></span>
                    <h3>An opt-in network between agencies</h3>
                    <p>Agencies that both run Need Navigator can opt in to work together: search and link shared clients, send referrals system-to-system, and hold shared live message threads, with each agency keeping its own private database. It is a capability you can adopt, never a network you are placed into.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>The referral that came back closed</h3>
                <p>A caseworker finishes a home visit and hears the same worry twice: the cupboards are nearly empty. From the visit, they spawn a referral to the food pantry two blocks from the family's apartment, check the pantry's hours and languages spoken in the partner directory, and hand the printed referral to the parent before they leave.</p>
                <p>Two days later, someone at the pantry scans the QR code on the page, no login or account needed, and records who received the family and their feedback. The loop closes with a timestamp the caseworker can see right on the referral. No phone tag, no wondering whether the family ever made it there.</p>
            </aside>
            {{-- [TESTIMONIAL: partnership or resource coordinator at a community action agency - on referrals coming back with feedback and timestamps instead of disappearing] --}}
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
                <a href="/features/casework">Visits, notes &amp; threads</a>
                <a href="/features/emergency-assistance">Needs &amp; funding pools</a>
                <a href="/features/parent-education-classes">Parent education classes</a>
                <a href="/solutions/food-banks-community-aid">For food banks &amp; community aid</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Watch a loop close', 'blurb' => 'In a demo we will create a referral, print it, scan the code from a phone, and watch the closure land: feedback, timestamp, and all. Bring the partner you refer to most.'])

@endsection
