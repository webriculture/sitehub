@extends('site::partials.layout')

@section('title', 'Nonprofit Form Builder Software | Need Navigator')
@section('description', 'Staff build their own intake forms (conditional logic, live client-record fields) and offer them in Spanish with AI-drafted, staff-reviewed translation.')

@php
    $faqs = [
        [
            'q' => 'Do we really not need a developer to build forms?',
            'a' => 'Right. Staff with the right permission build forms in the browser: add sections and fields, set what is required, drag everything into order, and attach the finished form to a program, visit reason, or smart button. When a question needs to change, the person who runs the program changes it. A System Form Locations screen shows administrators everywhere a form is in use before they change or retire it.',
        ],
        [
            'q' => 'Can questions appear or disappear based on earlier answers?',
            'a' => 'Yes. Conditional show-and-hide works on individual fields and on whole sections, so a follow-up section can appear only when an earlier answer calls for it. Repeatable sections handle the "add another" cases (household members, multiple income sources) without padding the form with blank copies.',
        ],
        [
            'q' => 'What does the AI translation do, and what does it not do?',
            'a' => 'One click drafts a complete Spanish baseline for a form: title, sections, field labels, helper text, and answer options. The draft is written at an approachable reading level, with program and organization names preserved. It does not replace review: bilingual staff polish the draft in a side-by-side editor, and each language version records when its baseline was generated and when a person last edited it. Form translation is one of exactly two AI features in Need Navigator; there is no AI chat or summarization.',
        ],
        [
            'q' => 'If a client fills out the Spanish version, what happens to our reporting?',
            'a' => 'Nothing changes. Stored answer values stay in English behind the scenes, so conditional logic, reports, and exports behave identically whichever language the form was completed in. The public intake portal renders the form in the visitor\'s language, English or Spanish today.',
        ],
        [
            'q' => 'Can we reuse a form, or move it to another Need Navigator system?',
            'a' => 'Within your own system, staff can deep-copy any form and adapt the copy. A form design (sections, fields, options, and translations) can also be exported and imported into another Need Navigator system, with internal references remapped automatically. Today that import is an administrator operation handled with our team rather than a self-service screen.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Form builder & multilingual forms'],
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
                    <li aria-current="page">Form builder &amp; multilingual forms</li>
                </ol>
            </nav>
            <p class="eyebrow">Form builder &amp; multilingual forms</p>
            <h1>Ask exactly what your program needs to know</h1>
            <p class="lede">Nonprofit form builder software should put program staff in charge of the questions. In Need Navigator, your team builds its own intake and case-management forms, with conditional logic, repeatable sections, and fields wired to the live client record, and offers them in Spanish, drafted by AI and polished by your bilingual staff.</p>
        </div>
    </section>

    {{-- ================= Form builder + translation editor screenshots ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: forms-translation-editor | filled 2026-09-05 with real screenshots: img/screens/form-builder and img/screens/translation-editor (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe shot-medium">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Edit form</span></div>
                    @include('site::partials.screen', ['name' => 'form-builder', 'alt' => 'The form editor: program checkboxes with Homeless Prevention and HRSN Program ticked, the form title Emergency Financial Assistance Application, toggles for showing form data on the profile and allowing household submissions, and a Contact Information section listing its fields with a required flag on each', 'width' => 1305, 'height' => 877])
                </div>
                <figcaption class="ui-caption">The form builder on a test instance: which programs the form belongs to, whether its answers show on the client profile, whether a household can submit it together, and the fields of its first section with a required flag on each.</figcaption>
            </figure>
            <figure style="margin:1.4rem 0 0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Viewing Spanish translation</span></div>
                    @include('site::partials.screen', ['name' => 'translation-editor', 'alt' => 'The translation editor for the Emergency Financial Assistance Application: generated by an AI model and initiated by a staff member, last modified by a staff member, with English on the left and editable Spanish on the right for the form title, a section title and a section description', 'width' => 1658, 'height' => 875])
                </div>
                <figcaption class="ui-caption">The side-by-side translation editor on a test instance: the AI draft on record with who generated it and when, then English on the left and editable Spanish on the right, section by section, saved as one set.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the form builder does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9h10M7 13h7M7 17h4"/></svg></span>
                    <h3>Built in the browser, by your staff</h3>
                    <p>Short and long text, dates, times, numbers with precision control, email, radio buttons, checkboxes with an "other" option, dropdowns. Sections and fields drag into order, and per-field edit permissions by team or user decide who can change an answer.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="12" height="14" rx="2"/><path d="M6 9h6M6 12.5h4.5M6 16h6"/><path d="M15 10h6m0 0-2.2-2.2M21 10l-2.2 2.2"/><path d="M21 15h-6m0 0 2.2-2.2M15 15l2.2 2.2"/></svg></span>
                    <h3>Fields wired to the real record</h3>
                    <p>Live client-record fields read and write the actual client record: name, address, phone, date of birth, Social Security number, HMIS (Homeless Management Information System) number, demographics, income. Lookup fields pull from funding pools, schools, class offerings, and staff.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16"/><path d="M7 8c6 0 4 8 10 8"/><path d="M14.5 13 17.5 16 14.5 19"/></svg></span>
                    <h3>Logic on fields and whole sections</h3>
                    <p>Show or hide a single question, or an entire section, based on earlier answers. The form stays short for the person with a simple situation and complete for the one whose situation is complicated.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="5" rx="1.5"/><rect x="4" y="11" width="16" height="5" rx="1.5"/><path d="M12 18.5v4M10 20.5h4"/></svg></span>
                    <h3>"Add Another," built in</h3>
                    <p>Repeatable sections capture households as they actually are: one section for a household member or an income source, repeated as many times as the family needs.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="14" rx="2"/><circle cx="8.5" cy="9" r="1.8"/><path d="M3 15.5l5-4.5 4 3.5 3.5-3 5.5 4.5"/></svg></span>
                    <h3>A picture on any question</h3>
                    <p>Attach a helper image to any field (where to find the account number on a utility bill, what a completed example looks like) so the form explains itself to the person filling it out.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 12.5 15 6a3.2 3.2 0 0 1 4.5 4.5l-7.8 7.8a5 5 0 0 1-7-7L11 5"/></svg></span>
                    <h3>Attached where the work happens</h3>
                    <p>Forms attach to programs as intake and exit forms, to visit reasons, to resources, and to smart buttons. A form cannot be archived while anything still depends on it, and the System Form Locations screen shows administrators every place a form is in use.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h9v7H8.5L5.5 15v-3H4z"/><path d="M16 9h4v6h-1.5v2.5L15.5 15H14v-3"/></svg></span>
                    <h3>Spanish in one click, then a human pass</h3>
                    <p>An AI drafts the full translation in seconds; bilingual staff refine it form by section by field by option. Each language version tracks when its baseline was generated and when a person last hand-edited it. One of exactly two AI features in the product.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="9" width="11" height="11" rx="2"/><path d="M13 4h7v7"/><path d="M20 4l-8 8"/></svg></span>
                    <h3>Forms that travel</h3>
                    <p>Deep-copy a form in place to adapt it for a new program. Export a whole form design, translations included, and import it into another Need Navigator system with internal references remapped automatically (an administrator operation today).</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Built Friday, polished Monday</h3>
                <p>On Friday afternoon, a program manager builds the intake form for a new rent-assistance program. They add live client-record fields so answers land on the real record, a repeatable "Add Another" section for household members, and a condition that shows the income section only when someone in the home is working. Before leaving, one more click drafts the Spanish baseline.</p>
                <p>On Monday, a bilingual staffer opens the side-by-side editor and works through the draft section by section, field by field, option by option, tuning the wording to how their community actually speaks. They save, and the form records when the baseline was generated and when they last edited it. The form attaches to the program's intake, and on the public portal it renders in the visitor's language. Portal submissions land in the review queue, where staff match each one to a client record before anything is written.</p>
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
                <a href="/features/intake-management">The live submissions workspace</a>
                <a href="/features/public-intake-portal">Public intake portal</a>
                <a href="/features/programs-automation">Programs &amp; automation</a>
                <a href="/solutions/parent-education">For parent education providers</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring your longest paper form', 'blurb' => 'We will rebuild a piece of it live in the demo: conditional sections, household fields, and a Spanish draft before the call ends.'])

@endsection
