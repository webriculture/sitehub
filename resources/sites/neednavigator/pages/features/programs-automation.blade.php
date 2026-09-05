@extends('site::partials.layout')

@section('title', 'Program Enrollment Software for Nonprofits | Need Navigator')
@section('description', 'Per-program forms, folders, and eligibility rules, enrollment episodes with exit history, plus Smart Buttons and no-code automations staff maintain.')

@php
    $faqs = [
        [
            'q' => 'Who can change a dropdown or an answer list?',
            'a' => 'Your own permissioned staff, through a searchable admin Settings hub. Demographic answer sets (race, ethnicity, gender, language, housing status, veteran status, disability, education level, insurance providers, relationships) and operational vocabularies such as document types, event types, and organization types are all maintained by your agency. No vendor request is needed to change a dropdown.',
        ],
        [
            'q' => 'What can an automation actually do?',
            'a' => 'An automation is a no-code rule attached to a resource, form, referral reason, visit reason, or exit reason, and it fires when a record is created or when a specific field changes to a value you define. It can send a templated email with variables and optional attachments, create a task, post a message to the need\'s conversation thread, or enroll a client in a program, or close their enrollment, from a visit or a shelter check-out. Staff set these up in admin screens, not in code.',
        ],
        [
            'q' => 'How do exit reasons and automations work together?',
            'a' => 'Exit reasons are defined by your agency and grouped into categories you choose, so the record of why people leave is kept in your own terms. An automation attached to an exit reason acts the moment the exit is recorded. At a shelter check-out, for example, it can close the client\'s program enrollment, send a templated email, or create a follow-up task. The paperwork and the follow-through stay consistent no matter who records the exit.',
        ],
        [
            'q' => 'Can we build eligibility rules without a developer?',
            'a' => 'Yes, that is the point of the rule builder. You combine income thresholds tied to the federal poverty level (FPL) or area median income (AMI) with age ranges and required-field or field-value rules on core client fields such as veteran status, insurance provider, disabling condition, and housing status. Clients then show as eligible or partially eligible for the program, with no custom development involved.',
        ],
        [
            'q' => 'What is an enrollment episode?',
            'a' => 'Each stretch a client spends in a program is its own episode, with an entry date, an exit date, and a record of who enrolled and who exited them. Because episodes are kept as history, someone who returns next year starts a new episode instead of overwriting the old one. Program statistics like retention rate, average enrollment duration, and the six-month enrollment trend live on the program\'s homepage.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Programs & automation'],
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
                    <li aria-current="page">Programs &amp; automation</li>
                </ol>
            </nav>
            <p class="eyebrow">Programs, Smart Buttons &amp; Automations</p>
            <h1>Run each program your way, down to the dropdowns</h1>
            <p class="lede">Program enrollment software for nonprofits should hold a program's whole design, not just its name. In Need Navigator, every program carries its own intake and exit forms, folders, eligibility rules, and wiki. Smart Buttons turn the front desk's multi-step routines into one tap, and no-code automations handle the follow-through.</p>
        </div>
    </section>

    {{-- ================= Smart Button composer UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: programs-smart-button-composer | filled 2026-09-05 with real screenshots: img/screens/smart-button-composer (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe shot-medium">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Edit Smart Button action</span></div>
                    @include('site::partials.screen', ['name' => 'smart-button-composer', 'alt' => 'Editing a Smart Button action titled Essential Items for the Drop-in items resource: supply options for diapers, baby wipes and a shower hygiene kit with a prompt-at-runtime toggle, transportation options for weekly and monthly bus passes with another, then status, quantity, amount and a description that uses template variables, beside a panel listing the variable fields', 'width' => 1295, 'height' => 878])
                </div>
                <figcaption class="ui-caption">One action in a Smart Button on a test instance: the resource it creates, the options the worker is asked about at click time, and a description written with template variables that fill in the worker, the client, the resource and the program when the button runs.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Programs & Enrollment ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What a program carries</h2>
                <p class="muted">Define it once; every enrollment after that inherits the setup.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/><path d="M8 13h8M8 16h5"/></svg></span>
                    <h3>The whole setup, attached to the program</h3>
                    <p>Each program holds its own intake and exit forms, default document folders that are created the moment a client enrolls, visit reason and topic requirements, and a program wiki where the staff reference lives.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h3M11 6h9M4 12h9M17 12h3M4 18h5M13 18h7"/><circle cx="9" cy="6" r="2"/><circle cx="15" cy="12" r="2"/><circle cx="11" cy="18" r="2"/></svg></span>
                    <h3>Eligibility rules you build yourself</h3>
                    <p>Combine income thresholds tied to the federal poverty level (FPL) or area median income (AMI) with age ranges and required-field or field-value rules on core client fields: veteran status, insurance provider, disabling condition, housing status. Clients show as eligible or partially eligible, with no custom development.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M15 8l4 4-4 4M19 12H9"/></svg></span>
                    <h3>Enrollment episodes, not just a checkbox</h3>
                    <p>Every enrollment is an episode with entry and exit dates and a record of who enrolled and who exited the client. Exit reasons are agency-defined and grouped into categories you choose. At a shelter check-out, an exit reason can fire automations, including closing the enrollment.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 15l3-3 2.5 2.5L17 10"/><path d="M13.5 10H17v3.5"/></svg></span>
                    <h3>A homepage for every program</h3>
                    <p>Enrollment counts, average enrollment duration, retention rate, a six-month enrollment trend, resources distributed, dollars disbursed, and activity totals across visits, needs, goals, tasks, and referrals, plus embedded task lists and a live program-wide message thread.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Smart Buttons ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Smart Buttons: a whole intake in one tap</h2>
                <p class="muted">Admins compose them; the front desk just taps.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="6" r="1.6"/><path d="M10 6h11"/><circle cx="5" cy="12" r="1.6"/><path d="M10 12h11"/><circle cx="5" cy="18" r="1.6"/><path d="M10 18h11"/></svg></span>
                    <h3>Compose the sequence once</h3>
                    <p>A button is a sequence of create-a-need, create-a-referral, and create-a-visit actions, executed in the order you add them, with pre-set field values, template variables like client name, program, and date, and forms embedded right in the flow.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3.5v2.5M4.6 5.4l1.8 1.8M3.5 10H6"/><path d="M10 10l9.5 3.7-4.2 1.6-1.6 4.2Z"/></svg></span>
                    <h3>Blanks ask at click time</h3>
                    <p>Anything you leave unset can prompt the worker when they tap, so one button covers the everyday case and still handles today's exception without a workaround.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2Z"/><path d="M9 8h6M9 12h6"/></svg></span>
                    <h3>The bookkeeping comes out identical</h3>
                    <p>Billing records and funding-pool allocations are created exactly as they would be by hand. That is consistency without retraining: a new hire's records look like a veteran's.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4l2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.5-4.8 2.5.9-5.4L4.2 9.7l5.4-.8Z"/></svg></span>
                    <h3>Easy to spot, easy to reach</h3>
                    <p>Give a button a color and icon or a short text abbreviation, mark your favorites, and land on the created record the moment the sequence finishes.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Automations ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Automations: the follow-through, handled</h2>
                <p class="muted">No-code rules that react to casework the moment it happens.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 3 5 13h6l-1 8 8-10h-6Z"/></svg></span>
                    <h3>Triggers where the work happens</h3>
                    <p>Attach a rule to a resource, a form, a referral reason, a visit reason, or an exit reason. It fires when the record is created, or when a specific field changes to the value you define.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7.5l9 6 9-6"/></svg></span>
                    <h3>Actions that close the loop</h3>
                    <p>Send a templated email with variables and optional attachments, create a task, post a message to the need's thread, or enroll a client in a program (or close their enrollment) from a visit or a shelter check-out.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Settings hub & per-user defaults ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Your vocabulary, maintained by you</h2>
                <p class="muted">The Settings hub keeps the language of your data in your agency's hands.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4v4M6 12v8M12 4v10M12 18v2M18 4v2M18 10v10"/><path d="M4 10h4M10 16h4M16 8h4"/></svg></span>
                    <h3>No vendor request to change a dropdown</h3>
                    <p>A searchable admin Settings hub lets your permissioned staff maintain demographic answer sets (race, ethnicity, gender, language, housing status, veteran status, disability, education level, insurance providers, relationships) and operational vocabularies like document types, event types, and organization types.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c0-3 2.4-5 5.5-5 1.1 0 2.1.2 2.9.7"/><circle cx="17.5" cy="16.5" r="2.8"/><path d="M17.5 12.2v1.5M17.5 19.3v1.5M21.8 16.5h-1.5M14.7 16.5h-1.5"/></svg></span>
                    <h3>Defaults that follow each person</h3>
                    <p>Every staff member sets their own workflow defaults (default visit duration, message-delivery delay, review-alert scope, and calendar view), so the system opens the way each person actually works.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Friday at the front desk</h3>
                <p>Every Friday the front desk runs the same intake dozens of times: log a pantry visit, fill the check-in form, create a need for a food box against the right funding pool. Three screens, several minutes, and every worker doing it in a slightly different order.</p>
                <p>An administrator composes a Smart Button instead. The visit reason, the embedded form, the resource, and the pool allocation are pre-set; the note fills in the client's name and today's date from template variables; the one thing that changes, the quantity, prompts at click. Now that intake is one tap on the client's profile, and a worker hired on Monday produces exactly the record the ten-year veteran does.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions program directors ask</h2>
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
                <a href="/features/income-eligibility">Income &amp; eligibility screening</a>
                <a href="/features/emergency-assistance">Needs, vouchers &amp; funding pools</a>
                <a href="/features/forms">The form builder</a>
                <a href="/reporting">Reports &amp; dashboards</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring your messiest intake', 'blurb' => 'In the demo, we will compose it into a Smart Button together: the same steps your team runs today, pre-set into one tap that comes out the same every time.'])

@endsection
