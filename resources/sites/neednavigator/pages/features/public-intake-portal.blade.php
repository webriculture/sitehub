@extends('site::partials.layout')

@section('title', 'Online Application Portal for Social Services | MyNeedNav')
@section('description', 'Let people apply for help online, no account needed, in English or Spanish. Submissions land in staff review. Nothing auto-links to a client record.')

@php
    $faqs = [
        [
            'q' => 'Do applicants need to create an account?',
            'a' => 'No. A community member opens a published form, fills it out, and submits it. There is no login, no password, and no account to abandon halfway through. Self-service without sign-up is the whole point of the portal.',
        ],
        [
            'q' => 'What languages does the portal support?',
            'a' => 'English and Spanish today, with more languages planned. A Spanish version starts as an AI-drafted translation that bilingual staff review and polish in a side-by-side editor, and the portal renders the form in the language the visitor chooses. Stored answers stay in English behind the scenes, so conditional logic and reporting work the same in either language.',
        ],
        [
            'q' => 'What do staff see when a submission arrives?',
            'a' => 'A standard form submission in the same review queue as everything else. A matching engine classifies it as an exact match, probable match, or new individual, and staff confirm the match, pick among ranked candidates, or create the person in one click. Any income the applicant reported arrives marked unverified and stays that way until a staff member verifies it.',
        ],
        [
            'q' => 'How does the portal stay locked down?',
            'a' => 'Several layers deep. The portal is a separate application that reaches Need Navigator only through a server access token, only forms on an explicit allow-list are ever exposed, and every submission is attributed to a designated system user, so portal activity is always distinguishable from staff activity. The portal is disabled until your agency configures it; nothing is public by default.',
        ],
        [
            'q' => 'Can one application cover a whole family?',
            'a' => 'Yes. Repeatable sections let an applicant add each household member, including income for several members, in a single submission. On the staff side, a guided stepper matches or creates each person, designates the primary member, and builds the household in one pass, with a human reviewing every step.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Public intake portal'],
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
                    <li aria-current="page">Public intake portal</li>
                </ol>
            </nav>
            <p class="eyebrow">MyNeedNav public intake portal</p>
            <h1>Open for applications, even when the office isn't</h1>
            <p class="lede">MyNeedNav is Need Navigator's online application portal for social services. Community members apply for help from any device, no account needed, in English or Spanish. Their submission lands in your review queue, where staff, not software, decide what happens next.</p>
        </div>
    </section>

    {{-- ================= Portal phone + arrival UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: portal-phone-intake | filled 2026-09-05 with real screenshots: img/screens/portal-application and img/screens/portal-income-step (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe shot-medium">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>MyNeedNav: Emergency Financial Assistance Application</span></div>
                    @include('site::partials.screen', ['name' => 'portal-application', 'alt' => 'The public intake portal: a green header with the Need Navigator wordmark, a language selector and sign in link, the application title, a Helpful to have checklist, and the Contact Information section with required first name, last name, date of birth and phone fields', 'width' => 1181, 'height' => 852])
                </div>
                <figcaption class="ui-caption">The public portal on a test instance: the agency&rsquo;s form rendered for the applicant, in their language, with a plain checklist of what helps and no account to create.</figcaption>
            </figure>
            <figure style="margin:1.4rem 0 0">
                <div class="uiframe shot-medium">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>MyNeedNav: guided income capture</span></div>
                    @include('site::partials.screen', ['name' => 'portal-income-step', 'alt' => 'The guided income step of the portal: an income source from the State of Oregon paid monthly, two recent pay records of 2,500 with dates and optional photo buttons, links to add a record or another income source, and a Submit application button', 'width' => 1178, 'height' => 958])
                </div>
                <figcaption class="ui-caption">Guided income capture: one source at a time, recent pay records with an optional paystub photo, and a submit button. Everything arrives on the staff side marked unverified until someone confirms it.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the portal does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M10.5 18.5h3"/><path d="M9.5 10.5l2 2 4-4"/></svg></span>
                    <h3>No account, no barrier</h3>
                    <p>A community member opens a published form, fills it out, and submits it: no login, no password, no account to create. It works from any device, at any hour, in the language they choose.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="6" rx="3"/><circle cx="18" cy="7" r="1.7"/><rect x="3" y="14" width="18" height="6" rx="3"/><circle cx="6" cy="17" r="1.7"/></svg></span>
                    <h3>You choose what's public</h3>
                    <p>Nothing goes online by accident. Forms appear on the portal only when you add them to an explicit allow-list. Everything else stays internal, and the portal itself stays disabled until your agency configures it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7.5h8M8 11.5h8M8 15.5h4.5"/></svg></span>
                    <h3>The whole form, faithfully rendered</h3>
                    <p>Portal forms are the same forms your staff build. Sections, conditional logic, repeatable sections, required fields, helper text, and helper images all render for the applicant just as they were designed.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4.5h11v8.5H9.5L6 16v-3H4Z"/><path d="M17.5 9h2.5v7h-2.2v2.8L14.6 16H12"/></svg></span>
                    <h3>English and Spanish</h3>
                    <p>Applicants complete forms in English or Spanish. Translations start as an AI draft that bilingual staff review and polish, and stored answers stay in English behind the scenes, so conditional logic and reporting work identically in both languages.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h5v-4h4v-4h4V8h5V4"/></svg></span>
                    <h3>Guided income capture</h3>
                    <p>A step-by-step wizard asks about income one source at a time, and choosing "no income" records an explicit declaration rather than a blank. A single family application can capture income for several household members, and every dollar arrives marked unverified for staff review.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13.5 5.5 5h13L21 13.5"/><path d="M3 13.5V19a1.5 1.5 0 0 0 1.5 1.5h15A1.5 1.5 0 0 0 21 19v-5.5h-5a4 4 0 0 1-8 0H3Z"/></svg></span>
                    <h3>A request, not a record</h3>
                    <p>Submissions land in the standard review queue, where a matching engine classifies each one as an exact match, probable match, or new individual. Staff confirm, choose among ranked candidates, or create the person; nothing links to a client record without a human deciding it should.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="7.5" cy="15.5" r="3.5"/><path d="M10.5 12.5 20 3M14.5 8.5 17 11M17.5 5.5 20 8"/></svg></span>
                    <h3>Locked down by design</h3>
                    <p>The portal is a separate application that reaches Need Navigator only through a server access token, only for allow-listed forms, and every submission is attributed to a designated system user. Off by default; on when you say so.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21v-7"/><path d="M12 14c0-3.9 2.6-6.5 7-6.5 0 3.9-2.6 6.5-7 6.5Z"/><path d="M12 16.5c0-2.9-2-4.8-5.5-4.8 0 2.9 2 4.8 5.5 4.8Z"/></svg></span>
                    <h3>New, and built to grow</h3>
                    <p>The portal shipped in June 2026 and is already live with its first agencies. We built it deliberately as a foundation. Expect it to keep expanding.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Sunday night, Monday morning</h3>
                <p>It is 9:40 on a Sunday night when a parent finally has the apartment quiet. They open the agency's website on their phone, tap the rent-assistance application, and choose Spanish. There is no account to create, just the form, one section at a time. Guided income capture walks them through both of their jobs, and a helper image shows exactly where to find the numbers it asks for. They submit at 10:05 and go to bed.</p>
                <p>At 8:15 Monday morning, an intake specialist opens the review queue and finds the submission waiting. The matching engine has ranked the applicant a probable match to someone the agency served two winters ago. They confirm it in one click, and the application attaches to the family's existing records instead of becoming a duplicate. The income the parent reported sits marked unverified, plainly separated from anything staff have confirmed, and the eligibility conversation starts from real information.</p>
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
                <a href="/features/forms">Form builder &amp; translation</a>
                <a href="/features/intake-management">Intake management &amp; matching</a>
                <a href="/features/income-eligibility">Income &amp; eligibility</a>
                <a href="/solutions/community-action-agencies">For community action agencies</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Put your application online', 'blurb' => 'Bring one of your paper intake forms to the demo. We will show you what it looks like on a phone, and what your staff see the morning after someone applies.'])

@endsection
