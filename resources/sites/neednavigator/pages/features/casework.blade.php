@extends('site::partials.layout')

@section('title', 'Case Notes Software for Social Services | Need Navigator')
@section('description', 'Case notes with visibility controls and an undo window, visits with manager review, goal plans, tasks, and a shared calendar, all connected to the client record.')

@php
    $faqs = [
        [
            'q' => 'Who can see a case note?',
            'a' => 'Whoever you say. Every note carries its own visibility (everyone, a program, or selected teams), and you can address it to specific recipients, with read tracking that shows who has actually seen it. Sensitive notes stay inside the circle that needs them.',
        ],
        [
            'q' => 'What if I send a note to the wrong place?',
            'a' => 'Notes deliver after a personal grace period you choose, typically 60 seconds to 10 minutes. Until the timer runs out, the note has not been delivered, and you can undo it before anyone sees it. A mis-click gets a second chance instead of an apology.',
        ],
        [
            'q' => 'Can supervisors sign off on visits?',
            'a' => 'Yes. Flag any visit reason as requiring review, and visits logged under it queue in the manager\'s review panel with four statuses: Unreviewed, Reviewed, Completed, and Staff Action Needed. Review notes on the panel are editable only by the manager, so the sign-off record stays theirs.',
        ],
        [
            'q' => 'How do group visits work?',
            'a' => 'One visit can include multiple clients, and a single entry can be recorded across multiple dates at once. A month of weekly group sessions does not mean re-typing the same visit four times. If the visit reason has an attached form, it is filled out per client, per visit, so each person\'s record stays individually complete.',
        ],
        [
            'q' => 'Does the calendar sync with Teams, Google Calendar, or Zoom?',
            'a' => 'No. It generates meeting links as a convenience, and we say so plainly. You get a "Meet now" link plus pre-filled scheduling links for Microsoft Teams or Google Calendar; Zoom opens its scheduling page without prefill, and each agency picks one provider. This is link generation, not calendar sync: Need Navigator does not read from or write to your external calendars.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Casework'],
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
                    <li aria-current="page">Casework</li>
                </ol>
            </nav>
            <p class="eyebrow">Casework: visits, notes, goals, tasks &amp; calendar</p>
            <h1>The whole day's casework, in one record</h1>
            <p class="lede">Case notes software for social services works best when the note isn't an island. In Need Navigator, visits, notes, goal plans, and tasks all hang off the same client record, with live threads on its needs and referrals and one shared calendar over all of it, so what happened, who saw it, and what comes next live in one place.</p>
        </div>
    </section>

    {{-- ================= Visit record screenshot ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: casework-note-thread | filled 2026-09-04 with a real screenshot: img/screens/visit-record (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Viewing a visit</span></div>
                    @include('site::partials.screen', ['name' => 'visit-record', 'alt' => 'A visit record: program, type, location, who completed it, status, scheduled time, three reasons for visit, and a narrative, with a side panel for the per-visit form, referrals, current goals, files, and billing records', 'width' => 1665, 'height' => 565])
                </div>
                <figcaption class="ui-caption">A visit record on a test instance: program, type and location, who completed it and when, the reasons and topics, the narrative, and on the right the per-visit form to complete plus the referrals, goals, files and billing records that hang off the same visit.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Notes, messages & threads ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Notes that reach the right people, and only them</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    <h3>Visibility, set per note</h3>
                    <p>Each note is visible to everyone, one program, or selected teams. Your call, note by note. Address it to specific recipients, and read tracking shows who has actually seen it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4v6h6"/><path d="M3.5 15a9 9 0 1 0 2.1-9.4L3 10"/><path d="M12 9v4l3 2"/></svg></span>
                    <h3>A grace period for second thoughts</h3>
                    <p>Notes deliver after a personal undo window (typically 60 seconds to 10 minutes, and each person picks their own), so a note sent to the wrong place can be pulled back before anyone sees it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-3.5 7"/></svg></span>
                    <h3>Pull in the right colleague</h3>
                    <p>&#64;mention a colleague in a rich-text note to notify them directly. Notes carry reply chains, pinning, and file attachments, so the follow-up conversation stays attached to the note that started it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 12h.01M12 12h.01M16 12h.01"/><path d="M21 12c0 4-4 7-9 7-1 0-2-.1-2.9-.4L4 20l1.5-3.6C4 15.2 3 13.7 3 12c0-4 4-7 9-7s9 3 9 7Z"/></svg></span>
                    <h3>Live threads where decisions happen</h3>
                    <p>A live chat thread attaches to any need, referral, or program. Messages appear for other participants in real time, typing indicators included. The conversation about the request lives on the request.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Visits ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Visits, logged the way they actually happen</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="16.5" cy="9.5" r="2.2"/><path d="M3.5 19c0-2.8 2.3-4.6 5.5-4.6s5.5 1.8 5.5 4.6"/><path d="M15 16.7c.6-1.6 2-2.4 3.7-2.4 1 0 1.8.3 2.4.8"/></svg></span>
                    <h3>Group visits, multiple dates, one entry</h3>
                    <p>One visit can include several clients, and a single entry can be recorded across multiple dates at once: a recurring group session gets logged once, not session by session.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M9 4V2.5h6V4"/><path d="M8 9h8M8 12.5h8M8 16h5"/></svg></span>
                    <h3>Your reasons, your topics, your forms</h3>
                    <p>Visit reasons, topics, and types are agency-configurable, and a reason can attach a form that gets filled per client, per visit. Start and end times are captured, so the record shows real duration.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.2-7 10-4-1.8-7-5.5-7-10V6Z"/><path d="M9 12l2 2 4-4"/></svg></span>
                    <h3>Manager review, built in</h3>
                    <p>Flag any visit reason as requiring review. The caseworker's manager gets a review panel (Unreviewed, Reviewed, Completed, Staff Action Needed) with review notes only the manager can edit.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="8" width="13" height="13" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"/></svg></span>
                    <h3>Less re-typing, fewer dropped steps</h3>
                    <p>Copy a visit for the next appointment, or edit inline from the list. With an Automation on the reason, recording a visit can enroll an un-enrolled client in the program, and logging a visit from a task marks the task complete.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Goals & case plans ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Goal plans with steps, dates, and an end</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 9v12"/></svg></span>
                    <h3>Start from a template</h3>
                    <p>Build goal templates once (ordered steps with default durations), and every new goal pre-populates its steps from the template. The plan starts complete instead of blank.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="10" width="6" height="4" rx="1"/><rect x="15" y="4" width="6" height="4" rx="1"/><rect x="15" y="16" width="6" height="4" rx="1"/><path d="M9 12h2c3 0 1.5-6 4-6M11 12c3 0 1.5 6 4 6"/></svg></span>
                    <h3>Steps that schedule themselves</h3>
                    <p>Steps run sequentially, each starting when the prior one ends, or in parallel where the work allows. Every step carries start and due dates and records who completed it, and when.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5"/></svg></span>
                    <h3>Progress that rolls up</h3>
                    <p>When the last step is done, the goal completes on its own. Lists and client profiles show progress at a glance ("3 of 5 steps"), so nobody has to open the plan to know where it stands.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4v16"/><path d="M6 7h6M9 12h8M13 17h6"/></svg></span>
                    <h3>See the plan on a timeline</h3>
                    <p>A Gantt-style timeline lays the steps out across their dates, so a caseworker and a client can look at the same picture of what happens next, and what has to finish first.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Tasks & calendar (compact) ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>The to-do list and the calendar, wired in</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><path d="M4.5 6.5l1.5 1.5 2.5-3"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><path d="M14 5h7M14 9h5M14 16h7M14 20h5"/></svg></span>
                    <h3>Tasks &amp; task lists</h3>
                    <p>Tasks carry a priority, assignee, team, and due date, with threaded comments, attachments, and &#64;mentions. Link a task to a client, need, or visit, or create one straight from a note. Saved filtered views keep badge counts in the sidebar, tasks can optionally stamp a GPS (Global Positioning System) location for field programs, and everything exports to Excel.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M7 14h3M12 14h3M7 17.5h3"/></svg></span>
                    <h3>One shared calendar</h3>
                    <p>Overlay visits, tasks, needs, referrals, goals, reservations, and events on one calendar; filter by shelter, room, resource, user, or client, and save your default view. As a convenience, it generates "Meet now" and pre-filled scheduling links for Microsoft Teams or Google Calendar (Zoom opens its scheduling page). This is link generation, not calendar sync.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>A Tuesday, filed properly</h3>
                <p>A family advocate finishes a morning home visit that was already sitting on their task list. They log the visit straight from the task (which marks itself complete), fill in the reason's form on their phone, and the start and end times land on the record.</p>
                <p>That visit reason is flagged for review, so it queues in their supervisor's review panel by early afternoon. The supervisor reads it, marks it Reviewed, and adds a review note only they can edit. Back at the office, the advocate opens the client's housing-stability goal and marks the step complete. The profile now shows 3 of 5 steps done, and the timeline shows what comes next.</p>
                {{-- [TESTIMONIAL: caseworker or program supervisor at a family-services agency, on manager review and notes cutting down end-of-day paperwork] --}}
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions caseworkers ask</h2>
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
                <a href="/features/billing">Billing generated from visits</a>
                <a href="/features/programs-automation">Programs &amp; automations</a>
                <a href="/features/geotracker">GPS logging for field work</a>
                <a href="/features/client-records">The client record it lands on</a>
                <a href="/reporting">Reports &amp; dashboards</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Walk a real day through it', 'blurb' => 'Bring one workflow to the demo: a home visit, the note that follows, the goal step it advances. We will log it end to end, manager sign-off included.'])

@endsection
