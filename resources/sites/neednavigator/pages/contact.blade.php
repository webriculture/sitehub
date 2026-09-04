@extends('site::partials.layout')

@section('title', 'Request a Demo | Need Navigator')
@section('description', 'Request a demo of Need Navigator — a low-pressure conversation with the people who build it. No marketing lists; a human replies.')

@php
    $faqs = [
        [
            'q' => 'What happens after I write?',
            'a' => 'A person on the team that builds Need Navigator reads your message and replies — there is no sales queue to clear first. Expect a short reply with a few questions about your agency and some times to talk. Your email address is used to answer you, not to add you to a marketing list.',
        ],
        [
            'q' => 'How long is a demo?',
            'a' => 'As long as it is useful, and no longer. A demo is a conversation, not a fixed presentation — tell us what your agency runs and where the friction is, and we spend the time there. If half an hour between client appointments is all you have, we will make it count.',
        ],
        [
            'q' => 'Can we bring our own forms and data questions?',
            'a' => 'Please do — a demo lands better when it is about your work. Bring your paper intake packet and we will walk through how staff rebuild it in the form builder, or bring a funder report and hold it up against the report builder. If you are coming from another system, bring your data questions too: there is no self-serve importer, so migrations are handled as a service by our team, and we will tell you plainly what that involves.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact'],
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
                    <li aria-current="page">Contact</li>
                </ol>
            </nav>
            <p class="eyebrow">Contact</p>
            <h1>Request a demo</h1>
            <p class="lede">A case management software demo works best as a conversation, and ours is with the people who build the product. Bring your programs, your forms, and your reporting headaches — we would rather talk about your work than run a script.</p>
        </div>
    </section>

    {{-- ================= Form + phone ================= --}}
    <section class="section section--surface">
        <div class="container nn-contact">
            <div class="hero-grid">
                <div>
                    <h2>Send a message</h2>
                    <p>Tell us a little about your agency — what you run, what is not working, and what you would want to see. That is enough to get started.</p>
                    {{-- [FORM NOTE: recipients + mail transport pending — SITE-PLAN §6] --}}
                    <x-site-form key="demo" />
                    <p class="muted"><small>No marketing lists and no automated follow-up sequence. A person on the team that builds Need Navigator reads your message and replies.</small></p>
                </div>
                <div class="contact-aside">
                    <h3>Prefer to call?</h3>
                    <p>Call Need Navigator at <a href="tel:+19717192251">971-719-2251</a>. You will reach the people who build and support the product, in Salem, Oregon.</p>
                    <h3 class="mt-2">Worth having on hand</h3>
                    <ul>
                        <li>The intake packet you use today — paper is fine</li>
                        <li>The funder report that takes the longest</li>
                        <li>Your list of programs and who works in them</li>
                        <li>Any question you have been saving for a vendor</li>
                    </ul>
                    <p class="muted"><small>None of it is required. "We are a food pantry and intake is chaos" is a fine first message.</small></p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions people ask before they write</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">While you decide</p>
            <div class="crosslinks">
                <a href="/pricing">Pricing, published in full</a>
                <a href="/features">The features, documented</a>
                <a href="/solutions">Find your kind of agency</a>
                <a href="/security">How client data is protected</a>
            </div>
        </div>
    </section>

@endsection
