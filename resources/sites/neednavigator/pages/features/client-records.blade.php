@extends('site::partials.layout')

@section('title', 'Client Records Software for Human Services | Need Navigator')
@section('description', 'One configurable page per client: alerts, insurance, releases of information, duplicate prevention and merge, and data freshness tracking.')

@php
    $faqs = [
        [
            'q' => 'How does duplicate prevention work?',
            'a' => 'Exact duplicates are blocked when a record is saved: the same name and date of birth, or the same HMIS (Homeless Management Information System) number. A fuzzy matcher also warns staff about likely duplicates before a new record is created. If one slips through anyway, two records can be merged, with case history, submissions, program history, and documents consolidated onto the surviving record.',
        ],
        [
            'q' => 'What does data freshness tracking do?',
            'a' => 'Your agency sets a review interval on any profile field, and the system tracks when each value was last confirmed. A count of clients whose data needs review appears right in the menu, and staff can re-verify a value without editing it. Each user chooses the scope of their own review alerts.',
        ],
        [
            'q' => 'Can we control which fields appear on the client record?',
            'a' => 'Yes. Each agency chooses which profile fields appear on the create, edit, view, and list screens, and which are required, without custom development. The record adapts to your intake practice rather than the other way around.',
        ],
        [
            'q' => 'Can staff train in the system without touching real client data?',
            'a' => 'Yes. Any record can be flagged as a test individual, which excludes it from lists, searches, and reports by default, so training and demos never pollute real data. Each user can opt in to see test records when they need them.',
        ],
        [
            'q' => 'Do releases of information cover the whole household?',
            'a' => 'A release of information (ROI) is recorded per client with its expiration date and the signed document attached. A client is covered if they or their head of household holds a current release, and coverage automatically follows the current head of household, so household members are covered without re-entering the release. It is deliberately simple: one active release per client.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Client records'],
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
                    <li aria-current="page">Client records</li>
                </ol>
            </nav>
            <p class="eyebrow">Client records</p>
            <h1>The whole person, on one page</h1>
            <p class="lede">Client records software for human services has one job: when someone sits down at your desk, show the whole picture. Need Navigator keeps each person your agency serves on one configurable page (alerts, insurance, income, care team, and program history), with duplicate prevention at the front door and every next step one tap away.</p>
        </div>
    </section>

    {{-- ================= One-page dossier UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>The one-page dossier</h2>
                <p class="muted">Alerts, insurance, income, care team, relationships, and program enrollments up top; tabs for history, needs, visits, referrals, goals, billing, notes, and files below. A radial quick-action menu on every profile creates a visit, referral, need, goal, task, billing record, note, or field location log in one tap.</p>
            </div>
            {{-- IMAGE SLOT: client-records-dossier | filled 2026-09-05 with a real screenshot: img/screens/hero-jimmy-calvert, the Jimmy Calvert test record cropped above the address (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure class="shot-duo" style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Client profile</span></div>
                    @include('site::partials.screen', ['name' => 'hero-jimmy-calvert', 'alt' => 'The top of a client profile: an Add Alert Message button, a black and white photo of a scowling baby, the name Jimmy Calvert with date of birth and age 2, a Renew OHP reminder with its expiry date beside an Add Insurance button, and the first rows of profile fields', 'width' => 529, 'height' => 698])
                </div>
                <figcaption class="ui-caption">The top of a client&rsquo;s one-page dossier on a test instance: the photo and identity, an insurance renewal that is coming due, the alert button for anything staff must see the moment the record opens, and the fields your agency chose to display. Below it on the real screen, tabs carry history, needs, visits, referrals, goals, billing, notes and files, and every change lands in the history timeline with who, when and what.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Inside the client record</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h8M16 7h4M4 12h3M11 12h9M4 17h10M18 17h2"/><circle cx="14" cy="7" r="2"/><circle cx="9" cy="12" r="2"/><circle cx="16" cy="17" r="2"/></svg></span>
                    <h3>Fields your agency chooses</h3>
                    <p>Choose which profile fields appear on the create, edit, view, and list screens, and which are required. The record adapts to your intake practice rather than the other way around, with no custom development.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="2"/><path d="M5.5 16c.5-1.5 1.7-2.3 3-2.3s2.5.8 3 2.3"/><path d="M14 9h5M14 12.5h5M14 16h3"/></svg></span>
                    <h3>Demographics your funders ask about</h3>
                    <p>Race, ethnicity, gender, language, education level, veteran status, current and prior housing status, disability with multiple conditions supported, income, and insurance. Recent additions include pronouns (off by default), a domestic-violence-survivor flag, and an expected-member flag for anticipated household members such as an unborn child.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8.5A1.5 1.5 0 0 1 4.5 7H7l2-2.5h6L17 7h2.5A1.5 1.5 0 0 1 21 8.5v10a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 18.5Z"/><circle cx="12" cy="13.5" r="3.5"/></svg></span>
                    <h3>A photo that lines itself up</h3>
                    <p>Add a client photo by file upload or webcam. Live face detection helps line up the shot. A photo on the record helps front-desk staff confirm they are talking with the right person.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="6.5"/><path d="M16 16l5 5"/></svg></span>
                    <h3>Search that finds the right person</h3>
                    <p>Search by name, date of birth, phone, Social Security number, or HMIS (Homeless Management Information System) number. The matched text is highlighted in the results, so staff can see why each record came back.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="13" height="13" rx="2"/><rect x="8" y="8" width="13" height="13" rx="2"/><path d="M14.5 12.5v3M14.5 18.5h.01"/></svg></span>
                    <h3>Duplicates stopped at the door</h3>
                    <p>Exact duplicates (the same name and date of birth, or the same HMIS number) are blocked at save. A fuzzy matcher also warns about likely duplicates before a new record is created, so the question gets asked while the person is still at the desk.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16"/><path d="M17 4v4a4 4 0 0 1-4 4H7"/><path d="M10 9l-3 3 3 3"/></svg></span>
                    <h3>Merge, when one slips through</h3>
                    <p>Consolidate two records onto one survivor: case history, submissions, program history, and documents all move together. No side-by-side retyping, no lost paperwork.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3"/><path d="M8.5 3h7M7.5 15h9"/></svg></span>
                    <h3>Test records for safe training</h3>
                    <p>Flag any record as a test individual and it disappears from lists, searches, and reports by default. Each user can opt in to see them. Train new staff and run demos without polluting real data.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a8 8 0 1 1-2.3-5.6"/><path d="M20 4v4h-4"/><path d="M9 12.5l2 2 4-4"/></svg></span>
                    <h3>Data freshness you can stand behind</h3>
                    <p>Set a review interval on any profile field and the system tracks when each value was last confirmed. A count of clients due for review sits right in the menu, staff re-verify a value without editing it, and each user chooses the scope of their own review alerts.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Alerts, insurance, ROI, access logging ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>On the same record</h2>
                <p class="muted">Three companions to the individual record, and the logging behind all of it.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 16H6c1.2-1.4 1.8-3.4 1.8-5.5C7.8 7 9.6 5 12 5s4.2 2 4.2 5.5c0 2.1.6 4.1 1.8 5.5Z"/><path d="M10.3 19a2 2 0 0 0 3.4 0"/><path d="M12 3v2"/></svg></span>
                    <h3>Alerts staff can't miss</h3>
                    <p>Colored banner alerts pinned to the top of the record, visible the moment it opens: safety notes, reminders, expiring notices. Each carries a custom color and icon, an expiration date, and an order, and entry is fast because the most recently used style pre-fills.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/><path d="M7 15h4"/><path d="M16.5 13.5v3M15 15h3"/></svg></span>
                    <h3>Insurance with the card attached</h3>
                    <p>Store each policy with provider, member ID, group number, plan type, and coverage dates, plus front and back card images by photo or PDF, merged into a single PDF for viewing or printing. The primary policy is managed automatically, renewals pre-fill from the prior policy, and coverage dates feed <a href="/features/billing">billing validation</a>.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h7l5 5v12a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/><path d="M14 3v5h5"/><path d="M9.5 16c.8-1 2-1 2.8 0s2 1 2.7 0"/></svg></span>
                    <h3>Releases of information, household-wide</h3>
                    <p>Record a release of information (ROI) with its expiration date and the signed document attached. A client is covered if they or their head of household holds a current release. Coverage follows the current head of household automatically, so members are covered without re-entering the release.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    <h3>Every view of the record, logged</h3>
                    <p>Every profile view by agency staff is logged (who, when, from where) and screened by configurable suspicious-access rules that flag unusual patterns for administrators to review. Read how it works in the <a href="/security">security overview</a>.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A morning at the front desk</h3>
                <p>A walk-in sits down at the front desk and gives their name and date of birth. The intake worker starts a new record, and before it saves, a warning appears: a likely duplicate, an existing client with the same name and a birth date one keystroke apart. One click opens the existing record instead. The photo confirms it is the same person, and their insurance card, program history, and release of information are already there.</p>
                <p>Months earlier, a duplicate had slipped through from a paper backlog. The office manager merged the two records: case history, submissions, program history, and documents consolidated onto the surviving one. Nothing retyped, nothing lost, and the agency's counts stayed honest.</p>
                {{-- [TESTIMONIAL: intake coordinator or front-desk supervisor at a community action agency - on duplicate prevention or how the one-page dossier changed intake] --}}
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions agencies ask about client records</h2>
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
                <a href="/features/households-care-team">Households &amp; care teams</a>
                <a href="/features/documents">Documents &amp; files</a>
                <a href="/features/intake-management">Intake &amp; submission matching</a>
                <a href="/security">Audit trail &amp; access monitoring</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a record shaped like your intake', 'blurb' => 'Bring your current intake packet to the demo, and we will map your fields onto the record and show the duplicate catch as it happens.'])

@endsection
