@extends('site::partials.layout')

@section('title', 'Nonprofit Event Registration Software | Need Navigator')
@section('description', 'Publish event pages, take registrations with ticket types and promo codes, and run day-of QR check-in — attendees never need an account.')

@php
    $faqs = [
        [
            'q' => 'How do attendees cancel a registration?',
            'a' => 'With a 6-digit code emailed to them — no account, no password. The code lets an attendee look up their registration and cancel it themselves, and staff can always cancel a registration from the back office as well.',
        ],
        [
            'q' => 'What happens when an event reaches capacity?',
            'a' => 'Registration closes when the event is full. The public page shows a capacity indicator as spots fill, so people can see where things stand before they start the form. Capacity is part of the event setup, and staff can watch registrations against it from the back office.',
        ],
        [
            'q' => 'How do donations work if nothing is charged online?',
            'a' => 'The event page records a donation pledge at a preset or custom amount. Money changes hands offline — staff record the cash and check donations they receive in the back office, so what you report is what actually arrived.',
        ],
        [
            'q' => 'Can our website list our events automatically?',
            'a' => 'Yes. The Website Event & Class Feed is a token-protected, read-only feed of your published events — and optionally your open class offerings — in English and Spanish. Each website gets its own token with scoping, revocation, and rate limits, and the feed carries marketing data only, never client information.',
        ],
        [
            'q' => 'Can we show auction items and sponsor tables on the event page?',
            'a' => 'Yes. Event items — auction items, merchandise, and sponsor tables — display on the public page with images, prices or starting bids, and quantities, so guests can browse before they arrive. Display is the whole story: there is no online bidding or purchasing.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Events'],
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
                    <li aria-current="page">Events</li>
                </ol>
            </nav>
            <p class="eyebrow">Events</p>
            <h1>From the published page to the check-in line</h1>
            <p class="lede">Nonprofit event registration software should carry the whole event — the public page, the registrations, the promo codes, and the door on the night itself. Need Navigator does, and your attendees never need an account.</p>
        </div>
    </section>

    {{-- ================= Event page + day-of check-in UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="ui-event">
                <div class="duo">
                    {{-- IMAGE SLOT: events-public-page | replace with: real screenshot of a published public event page, light theme — hero image, schedule, location, capacity indicator, and ticket types visible; demo event data only. Placeholder: stylized HTML recreation of the page. --}}
                    <figure style="margin:0">
                        <div class="uiframe" aria-hidden="true">
                            <div class="uiframe-bar"><i></i><i></i><i></i><span>Harvest Dinner &amp; Auction — published event page</span></div>
                            <div class="uiframe-body">
                                <div class="ev-page">
                                    <div class="ev-hero">Hero image</div>
                                    <div class="ev-title">Harvest Dinner &amp; Auction</div>
                                    <div class="ev-meta">
                                        <span>Sat, Oct 17 &middot; 5:30&ndash;9:00 p.m.</span>
                                        <span>Riverfront Hall, Salem</span>
                                    </div>
                                    <div class="ev-capline"><strong>86 of 120 seats reserved</strong><span>Registration closes when full</span></div>
                                    <div class="ev-track"><i style="width:72%"></i></div>
                                    <div class="ev-ticket"><span>Dinner seat</span><span class="qty">Qty 2</span></div>
                                    <div class="ev-ticket"><span>Student seat</span><span class="qty">Qty 1</span></div>
                                    <span class="ev-chip">Code FALL10 applied &mdash; 10% off</span>
                                    <div class="ev-ticket"><span>Add a donation pledge</span><span class="qty">$25 &middot; $50 &middot; $100 &middot; custom</span></div>
                                    <p class="ev-note">Pledges are recorded now and collected at the event.</p>
                                    <span class="ev-btn">Register</span>
                                </div>
                            </div>
                        </div>
                        <figcaption class="ui-caption">An illustration of a public event page: hero image, schedule and location, a capacity indicator, ticket types, a promo code applied, and a donation pledge option.</figcaption>
                    </figure>
                    {{-- IMAGE SLOT: events-dayof-checkin | replace with: real screenshot of the day-of check-in screen, light theme — checked-in guests, undo, a walk-in registration, and a no-show visible; test attendees only, no real names. Placeholder: stylized HTML recreation of the list. --}}
                    <figure style="margin:0">
                        <div class="uiframe" aria-hidden="true">
                            <div class="uiframe-bar"><i></i><i></i><i></i><span>Day-of check-in — Harvest Dinner &amp; Auction</span></div>
                            <div class="uiframe-body">
                                <div class="ev-checkin">
                                    <div class="ev-counts">
                                        <span><strong>64</strong> checked in</span>
                                        <span><strong>89</strong> registered</span>
                                        <span><strong>3</strong> walk-ins</span>
                                    </div>
                                    <div class="ev-row">
                                        <span class="who">Guest 041<span>2 seats &middot; QR check-in</span></span>
                                        <span class="acts"><span class="st st-in">Checked in 5:42</span><span class="undo">Undo</span></span>
                                    </div>
                                    <div class="ev-row">
                                        <span class="who">Guest 042<span>1 seat</span></span>
                                        <span class="acts"><svg class="qr" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h3v3h-3zM20 20h-3"/></svg><span class="st st-open">Check in</span></span>
                                    </div>
                                    <div class="ev-row">
                                        <span class="who">Guest 057<span>Walk-in &middot; registered at the door 6:04</span></span>
                                        <span class="acts"><span class="st st-in">Checked in 6:04</span></span>
                                    </div>
                                    <div class="ev-row">
                                        <span class="who">Guest 019<span>1 seat</span></span>
                                        <span class="acts"><span class="st st-no">No-show</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <figcaption class="ui-caption">An illustration of the day-of check-in list: QR check-ins with undo, a walk-in registered at the door, and a no-show marked.</figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the events module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 8h18"/><circle cx="8.5" cy="12.5" r="1.3"/><path d="M6 17l3.5-3 2.5 2 3.5-3.5L18.5 16"/></svg></span>
                    <h3>Public only when you say so</h3>
                    <p>Every event gets a page with a hero image, schedule, location or virtual link, capacity indicators, and a rich description — and none of it is public until you explicitly publish it. The hosted page renders in English today; Spanish event content reaches your website through the feed.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a3 3 0 0 0 0 6v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a3 3 0 0 0 0-6Z"/><path d="M14 5v2M14 11v2M14 17v2"/></svg></span>
                    <h3>Registration that fits the event</h3>
                    <p>Ticket types with quantities and per-attendee details when the night calls for it; a free name-and-email signup when the event is ticketless. Duplicate registrations are prevented, and registration windows open and close on the dates you set.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5a2 2 0 0 1 2-2h6l10 10-8 8L3 11Z"/><circle cx="8" cy="8" r="1.5"/><path d="M12 16l4-4"/></svg></span>
                    <h3>Promo codes with guardrails</h3>
                    <p>Percentage or fixed-amount discounts, each with an expiration date and a usage limit — so the board's code stops working exactly when it should.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4.5 5.2 3h13.6L20 4.5"/><path d="M3 7.5 4 4.5h16l1 3a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0Z"/><path d="M5 11v9h14v-9M10 20v-5h4v5"/></svg></span>
                    <h3>The auction, on display early</h3>
                    <p>Auction items, merchandise, and sponsor tables show on the public page with images, prices or starting bids, and quantities. Display only — there is no online bidding or purchasing, so the paddles stay in the room.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20s-7-4.6-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.4-7 10-7 10Z"/></svg></span>
                    <h3>Donation pledges, kept honest</h3>
                    <p>The event page records a pledge at preset or custom amounts. Nothing is charged online — staff record the cash and check donations that actually arrive, so your books match the cashbox.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7.5 9 6 9-6"/></svg></span>
                    <h3>Cancel with a code, not an account</h3>
                    <p>Attendees look up and cancel their own registrations with a 6-digit code emailed to them. No account, no password, no Monday-morning phone calls to your office.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><path d="M14 14h3v3h-3zM20 14v.01M14 20h.01M17.5 20H20v-2.5"/></svg></span>
                    <h3>Tools for the door</h3>
                    <p>Per-attendee QR check-in links keep the line moving. Manual check-in with undo, no-show marking, and walk-in registration handle everything else the evening throws at you.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M9 5V3.5A1.5 1.5 0 0 1 10.5 2h3A1.5 1.5 0 0 1 15 3.5V5"/><path d="M8 10.5h8M8 14h8M8 17.5h5"/></svg></span>
                    <h3>One back office for the whole event</h3>
                    <p>Registrations, orders, attendees, donations, and promo codes in one staff workspace. Events also appear on the shared staff calendar and are a first-class type in the report builder, with Excel export.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Website Event & Class Feed ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Your website stays current on its own</h2>
            </div>
            <p>The Website Event &amp; Class Feed serves your published events — and, if you choose, your open class offerings — to your own website or a partner's, in English and Spanish. Publish the event once in Need Navigator, and every connected site lists it.</p>
            <p>The feed is read-only and token-protected, and it carries marketing data only — no client information, by construction. Each site gets its own token with scoping, revocation, and rate limits, so a partner's access can be narrowed or switched off without touching anyone else's.</p>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>The night of the annual dinner</h3>
                <p>Doors open at 5:30 for the agency's annual fundraiser. The development coordinator props a tablet at the front table and opens the day-of check-in list: 89 registrations, ready for the door. Most of the line moves at the speed of a scan — every attendee carries their own QR check-in link — and a guest whose phone has died is checked in manually in two taps. When someone is checked in twice by mistake, undo fixes it before the count drifts.</p>
                <p>At 6:10 a couple arrives who never registered. Walk-in registration adds them on the spot, without leaving the list. After dessert the coordinator marks the no-shows, and the back office already holds the night in one place — registrations, orders, attendees, and donation pledges — with the cash and check donations recorded by staff once they are counted.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions event teams ask</h2>
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
                <a href="/features/parent-education-classes">Parent education classes</a>
                <a href="/features/referrals-partners">Partners &amp; the partner portal</a>
                <a href="/reporting">Reports &amp; dashboards</a>
                <a href="/solutions/food-banks-community-aid">For food banks &amp; community aid</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring your annual fundraiser', 'blurb' => 'Tell us about your biggest night of the year — we will build the event page in the demo and run a registration through to day-of check-in.'])

@endsection
