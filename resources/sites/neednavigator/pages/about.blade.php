@extends('site::partials.layout')

@section('title', 'About Webriculture | Need Navigator')
@section('description', 'Need Navigator is built by Webriculture, a Salem, Oregon web firm about 25 years in, working in close partnership with the agencies that use it.')

@php
    $faqs = [
        [
            'q' => 'Where is our data hosted?',
            'a' => 'Each agency runs its own isolated copy of Need Navigator with its own private database. Nothing is pooled with other agencies. Instances run on Amazon Web Services (AWS), client data is encrypted at rest on the application server, and every client database is backed up nightly to redundant, encrypted cloud storage with integrity verification on every run. Our security page walks through access controls, audit logging, and backups in detail.',
        ],
        [
            'q' => 'Do you build custom features for agencies?',
            'a' => 'A lot of what feels custom is configuration your own staff control: forms, programs, eligibility rules, smart buttons, automations, and option lists, none of which require a developer. When an agency needs something the product does not do yet, we talk it through together; several modules, including the scanner-fed Document Inbox, began as one agency\'s request. We cannot promise every idea a place on the roadmap, but the roadmap has always been set by agencies doing the work.',
        ],
        [
            'q' => 'Who is Webriculture?',
            'a' => 'Webriculture is a web development firm in Salem, Oregon, about twenty-five years in and part of the Compass Visual family. We build and support Need Navigator ourselves; the team that writes the code is the team that answers when you call.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'About'],
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
                    <li aria-current="page">About</li>
                </ol>
            </nav>
            <p class="eyebrow">About Webriculture</p>
            <h1>The people behind Need Navigator</h1>
            <p class="lede">Need Navigator is built by Webriculture, a web firm in Salem, Oregon. The firm is about twenty-five years in, and part of the Compass Visual family. The product is shaped by one working arrangement: the agencies that use it tell us what the work needs, and we build it with them.</p>
        </div>
    </section>

    {{-- ================= Who we are ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="hero-grid">
                <div>
                    <p class="eyebrow">Who we are</p>
                    <h2>A web firm that got pulled into human services, and stayed</h2>
                    <p>Webriculture has spent about twenty-five years in Salem, Oregon building websites and web applications. Need Navigator is our case-management software for human-services organizations: community action agencies, shelters, food banks, parent-education providers, and other community aid organizations.</p>
                    <p>We build it in close partnership with the agencies that use it. That is not a slogan; it is the development model. Caseworkers, front-desk staff, and program directors ask for what the work needs, and the product grows in that direction. That is why the features on this site read like a caseworker's day rather than a vendor's brochure.</p>
                </div>
                <div>
                    {{-- IMAGE SLOT: about-team | replace with: real photograph of the Webriculture team, or of the team working alongside agency staff - candid, natural light, landscape; no stock photography. Placeholder: abstract line illustration of two people working through a shared workflow at a table. --}}
                    <svg viewBox="0 0 420 340" role="img" aria-label="Illustration: two people at a table working through a shared workflow together" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="210" cy="170" r="160" fill="#e9efe8"/>
                        <g stroke="#1e4d3a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            {{-- table --}}
                            <path d="M84 222 H336"/>
                            <path d="M104 222 V254 M316 222 V254"/>
                            {{-- left person --}}
                            <circle cx="126" cy="150" r="15"/>
                            <path d="M98 222 c4-32 13-48 28-48 s24 16 28 48"/>
                            {{-- right person --}}
                            <circle cx="294" cy="150" r="15"/>
                            <path d="M266 222 c4-32 13-48 28-48 s24 16 28 48"/>
                            {{-- shared workflow sheet --}}
                            <rect x="172" y="108" width="76" height="102" rx="6" fill="#fffdf9"/>
                            <rect x="186" y="120" width="48" height="16" rx="4"/>
                            <path d="M210 136 V148 M206 144 L210 148 L214 144"/>
                            <rect x="186" y="152" width="48" height="16" rx="4"/>
                            <path d="M210 168 V180 M206 176 L210 180 L214 176"/>
                            <rect x="186" y="184" width="48" height="16" rx="4"/>
                            <path d="M201 192 l5 5 8-9"/>
                            {{-- attention lines --}}
                            <path d="M144 146 C 156 138, 162 132, 170 126" stroke-dasharray="1 7"/>
                            <path d="M276 146 C 264 138, 258 132, 250 126" stroke-dasharray="1 7"/>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= How we build ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>How we build</h2>
                <p class="muted">Partnership development, in practice: where the features on this site actually come from.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 15a2 2 0 0 1-2 2H9l-5 4V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2Z"/><path d="M8 9h8M8 12.5h5"/></svg></span>
                    <h3>Features start as requests</h3>
                    <p>The scanner-fed Document Inbox exists because one agency needed its paper flow triaged. It is now available to any agency. The billing module was built to an agency's contract, down to the Medicare 8-minute rule. That is the pattern: someone doing the work asks, and the product answers.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5"/></svg></span>
                    <h3>Real use before marketing</h3>
                    <p>Newer modules go live with the agencies that asked for them and prove themselves in daily work before we lead with them here. This site covers what the product does today, not a roadmap dressed up as a product.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/><circle cx="14" cy="6" r="2"/><circle cx="8" cy="12" r="2"/><circle cx="17" cy="18" r="2"/></svg></span>
                    <h3>Your staff hold the keys</h3>
                    <p>Forms, programs, roles, demographic answer sets, document types: your administrators maintain them in a settings hub built for it. Changing a dropdown never requires a vendor request.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="3.5"/><circle cx="17" cy="10" r="2.5"/><path d="M3 20c0-3 2.2-5 5-5s5 2 5 5"/><path d="M14.5 19.5c.3-2.3 1.8-3.5 4-3.5 1 0 1.9.3 2.5.8"/></svg></span>
                    <h3>Support is the same team</h3>
                    <p>When you ask for help, you are talking with the people who build the product. Questions do not disappear into a tiered queue. They land with someone who knows exactly which screen you are looking at.</p>
                </div>
            </div>
            {{-- [TESTIMONIAL: executive director of a mid-size human-services agency - on the partnership / build-with-us experience] --}}
        </div>
    </section>

    {{-- ================= How onboarding works ================= --}}
    <section class="section section--wash nn-about">
        <div class="container">
            <div class="section-head">
                <h2>How onboarding works</h2>
                <p class="muted">Your instance is your agency's own copy of Need Navigator with its own private database, configured to your programs, so onboarding is real work, done together.</p>
            </div>
            <ol class="steps">
                <li>
                    <h3>Configure together</h3>
                    <p>Our implementation team sets up your instance and builds your custom workflows with you: programs, forms, roles, and the option lists that hold your vocabulary. Modules that need agency-specific setup, like the scanner-fed Document Inbox and the public intake portal, are switched on here.</p>
                </li>
                <li>
                    <h3>Train weekly</h3>
                    <p>Our trainers run weekly onboarding meetings (usually 6 to 8), working through your actual workflows with your staff until the team runs on its own.</p>
                </li>
                <li>
                    <h3>Keep building</h3>
                    <p>The partnership does not end at go-live. Agencies keep asking, the product keeps growing in the direction of the people using it, and support stays with the team that builds it.</p>
                </li>
            </ol>
        </div>
    </section>

    {{-- ================= Where we are ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Where we are</h2>
            </div>
            <p>Salem, Oregon. Need Navigator is built and supported here, by Webriculture, alongside the rest of our work in the Compass Visual family.</p>
            <p>If you want to talk to a person, call <a href="tel:+19717192251">971-719-2251</a>. If you would rather write first, the <a href="/contact">contact page</a> is the fastest way to reach us.</p>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Questions agencies ask us</h2>
            </div>
            <div class="faq">
                @foreach ($faqs as $f)
                    <details class="faq-item">
                        <summary>{{ $f['q'] }}</summary>
                        <div class="faq-body"><p>{{ $f['a'] }}</p></div>
                    </details>
                @endforeach
            </div>
            <p class="mt-2 muted">For hosting, access controls, and backups in full, read the <a href="/security">security overview</a>.</p>
        </div>
    </section>

    {{-- ================= Cross-links ================= --}}
    <section class="section section--crosslinks">
        <div class="container">
            <p class="eyebrow" style="margin-bottom: 1rem">Keep reading</p>
            <div class="crosslinks">
                <a href="/security">Security &amp; trust</a>
                <a href="/pricing">Pricing, published in full</a>
                <a href="/contact">Talk to us</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Start the partnership with a conversation', 'blurb' => 'A demo here is a conversation with the Salem team that builds and supports Need Navigator. Bring your programs, your forms, and your questions. You will get plain answers.'])

@endsection
