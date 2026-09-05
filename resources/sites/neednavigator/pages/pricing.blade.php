@extends('site::partials.layout')

@section('title', 'Case Management Software Pricing | Need Navigator')
@section('description', 'Need Navigator is $25 per user per month with a five-user minimum, plus a one-time setup fee from $2,000 covering implementation and up to 12 hours of virtual training.')

@php
    $faqs = [
        [
            'q' => 'Who counts as a user?',
            'a' => 'A user is a staff member with their own login to your instance: caseworkers, front-desk staff, supervisors, administrators. The people you serve are never seats: applying for help online, registering for an event or class, and QR check-in all work without an account. If your staffing makes the count unclear (part-time staff, volunteers, seasonal programs), ask us and we will work through it with you plainly.',
        ],
        [
            'q' => 'What is an instance?',
            'a' => 'Your instance is your agency\'s own copy of the Need Navigator application, running with its own private database, not a login on a shared system. Nothing is pooled with other agencies, so cross-agency queries are impossible by construction. It is configured to your programs, forms, roles, and vocabulary, and it is where your seat limit is enforced.',
        ],
        [
            'q' => 'Who owns our data?',
            'a' => 'You do. Your records live in your agency\'s own private database, and client data is backed up automatically every night to secure, encrypted off-site storage. Day to day, staff can export data to Excel across roughly sixteen record types (clients, households, visits, needs, referrals, and more) without asking us for anything.',
        ],
        [
            'q' => 'What does onboarding look like?',
            'a' => 'Our implementation team configures Need Navigator to your agency and builds your custom workflows with you: programs, forms, roles, and the option lists that hold your vocabulary. Training is up to 12 hours, delivered virtually, and our trainers usually spread it across weekly meetings until your staff are comfortable working on their own. Modules that need agency-specific setup, such as the scanner-fed Document Inbox or the public intake portal, are switched on during that same work. All of it is covered by the one-time setup fee.',
        ],
        [
            'q' => 'Is data migration included?',
            'a' => 'No, and we would rather say so here than surprise you later. Need Navigator has no bulk client-data importer, so migrations from a previous system are handled as a service: our team maps and moves the data with you, and the work is quoted per project, because every legacy system is different. Tell us what you are coming from and you will get a real number before you commit to anything.',
        ],
        [
            'q' => 'Are there tiers, contracts, or surprise costs?',
            'a' => 'There are no tiers. $25 per user per month is the price whether you use three modules or all of them, and it does not step up when you switch something on. There are exactly two other numbers: the one-time setup fee, published above, and data migration if you need it. Both are quoted before you sign, never after.',
        ],
        [
            'q' => 'What does the setup fee cover, and when would it be more than $2,000?',
            'a' => '$2,000 is our baseline, and it covers the whole standard setup: your own database and code branch at your own address on neednavigator.com, email relay, user accounts, your first program and teams, your option lists, your partner portal if you use one (the login for contacts at partner organizations), help building your initial custom forms and automations, and up to 12 hours of virtual training. It goes up only when you want materially more than that; substantially more training time than 12 hours is the usual reason. If your request falls outside the standard scope, you get a separate quote for it before any work starts, not an invoice afterward.',
        ],
        [
            'q' => 'How long is the commitment?',
            'a' => 'The term is twelve months, and a signed copy of our Terms of Service accompanies the order. Within the term your seat count is not locked: users can be added or removed month to month at $25 each, without new paperwork. That is deliberate, because seasonal programs and grant cycles move staffing around and your bill should follow.',
        ],
        [
            'q' => 'Why is there a five-user minimum?',
            'a' => 'Because we would not be a good fit below it, and we would rather say that here than halfway through a demo. Need Navigator earns its keep for agencies that have outgrown spreadsheets and shared drives and are growing their staff, the point where the do-it-yourself approach has started to cost real time. A one or two person organization getting started is better served by something simpler and cheaper, and we will tell you so.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Pricing'],
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
                    <li aria-current="page">Pricing</li>
                </ol>
            </nav>
            <p class="eyebrow">Pricing</p>
            <h1>Transparent pricing for easy budgeting</h1>
            <p class="lede">Most case management software pricing hides behind a quote request. Ours doesn't. Need Navigator is $25 per user per month with a five-user minimum, plus a one-time setup fee from $2,000 that covers implementation and training. That is the whole cost structure, so you can build the budget line tonight and spend the demo on your actual questions.</p>
        </div>
    </section>

    {{-- ================= Price card + what's included ================= --}}
    <section class="section section--surface">
        <div class="container nn-pricing">
            <div class="price-grid">
                <div class="price-stack">
                <div class="price-card">
                    <p class="price-tag">Need Navigator</p>
                    <p class="price-figure">
                        <span class="price-amount">$25</span>
                        <span class="price-unit">per user<br>per month</span>
                    </p>
                    <p class="price-terms">Per seat, with a five-user minimum, so <strong>$125 per month</strong> is the floor. Seat limits are enforced per instance, and seats move up or down monthly.</p>
                    <ul class="price-includes">
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>All modules described on this site</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Your own instance and private database</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Custom workflows built with you</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Support from the people who build it</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Nightly backups to secure, encrypted off-site storage</li>
                    </ul>
                    <a class="button primary" href="/contact">Request a demo</a>
                    <p class="price-note">No tiers. No modules sold separately.</p>
                </div>

                <div class="price-card price-card--setup">
                    <p class="price-tag">One-time setup</p>
                    <p class="price-figure">
                        <span class="price-amount">$2,000</span>
                        <span class="price-unit">baseline<br>one time</span>
                    </p>
                    <p class="price-terms">Covers implementation and training. Invoiced once, at the start of the term.</p>
                    <ul class="price-includes">
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Your database, code branch and server files</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Your own address on neednavigator.com, with email relay</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>User accounts, your first program and teams</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Your option lists and other configurable data</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Your partner portal, if you use one</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Help building your initial forms and automations</li>
                        <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l5 5 10-11"/></svg>Up to 12 hours of virtual training</li>
                    </ul>
                    <p class="price-note">Rises only if you want materially more, and you see that number first.</p>
                </div>
                </div>
                <div class="price-detail">
                    <h2>What the subscription includes</h2>
                    <p>Every module described on this site is included. A few (the scanner-fed Document Inbox, the public intake portal, the partner portal) are set up and switched on per agency as part of onboarding.</p>
                    <p>It also includes the relationship. Our implementation team configures Need Navigator to your agency, meaning your programs, your forms, your roles and your vocabulary, and builds custom workflows with you. Training runs up to 12 hours, delivered virtually and usually spread across weekly meetings until your team is running on its own. After that, support means talking to the people who build the product, by phone, email or Google Spaces during our <a href="https://www.webriculture.com/hosting/SLA" rel="noopener">published business hours</a>.</p>
                    <h2>Why there is a setup fee</h2>
                    <p>Because you are not renting a login on a shared system. Every agency gets its own database, its own branch of the code, its own server files and its own address on neednavigator.com, and someone has to build and configure all of it around how you actually work. That is the $2,000, and it is a baseline rather than a ceiling: if you want substantially more than 12 hours of training, or something outside the standard setup, we quote that separately and you approve the number before the work starts.</p>
                    <p>One cost is separate, and we would rather say so here: data migration. Need Navigator has no bulk client-data importer, so migrations from your previous system are handled as a service by our team and quoted per project. Ask, and you will get a real number.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Transparency positioning ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Why the price is on the page</h2>
            </div>
            <p>In this category, pricing tends to arrive at the end of a sales process, after the discovery call, the scoping call, and a quote shaped around what a vendor thinks your budget will bear. We think that is backwards. An Executive Director writing a grant budget needs the number first.</p>
            <p>So here it is. A five-person team is $125 a month, a ten-person team is $250, and setup starts at $2,000 in year one. You can put all of that in a board packet without sending us a single email.</p>
            <p>And the number stays honest in the software itself: seat limits are enforced per instance, so the seats you pay for and the seats that exist are the same number.</p>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions we get about pricing</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">Keep reading</p>
            <div class="crosslinks">
                <a href="/security">How client data is protected</a>
                <a href="/about">Who builds Need Navigator</a>
                <a href="/contact">Request a demo</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring your seat count', 'blurb' => 'Multiply it by $25 and that is the budget line. The demo is for everything else: your programs, your forms, and what onboarding would look like for your agency.'])

@endsection
