@extends('site::partials.layout')

@section('title', 'Nonprofit Intake Management Software | Need Navigator')
@section('description', 'Work intake in a live grid the whole team shares — every submission matched to the right client record, whole households built from one application.')

@php
    $faqs = [
        [
            'q' => 'How does matching prevent duplicate client records?',
            'a' => 'Every incoming submission is classified as an exact match, a probable match, or a new individual, using name, date of birth, and signals like Social Security number or HMIS (Homeless Management Information System) number. For probable matches, staff pick from a ranked list of candidates instead of guessing; for new people, one click creates the record from the submission. Nothing links automatically without staff review, so the person deciding is always looking at the evidence.',
        ],
        [
            'q' => 'What happens when one application covers a whole family?',
            'a' => 'A guided household-capture stepper walks through the submission one person at a time — matching or creating each member, designating the primary member, and building the household with everyone attached, in one pass. A single family application can even carry income details for more than one household member. You get a complete, connected household from one form, not five disconnected records.',
        ],
        [
            'q' => 'Who sees edits while the team is working the grid?',
            'a' => 'Everyone with the grid open. Edits, row and column colors, layout changes, and status updates are pushed to every viewer in real time — no refreshing — and cell-level presence shows who is editing what, so teammates can steer around each other instead of working the same row. It works like a shared spreadsheet, except every row is wired to your client records.',
        ],
        [
            'q' => 'Can the grid really serve as our review queue?',
            'a' => 'Yes. The status shown on each row is the linked assistance request\'s status — Pending, Ready for Review, Approved, and so on — and staff can update it inline without leaving the grid. Filter to one status, save that as a shared view, and your review queue is a bookmark.',
        ],
        [
            'q' => 'Do intake submissions show up on the client\'s profile?',
            'a' => 'Program intake submissions surface on the client\'s profile automatically, and any other form can be shown there with a per-form toggle. A form\'s grid can also be embedded on a program dashboard as a widget, so the queue is visible where the team already starts the day.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Intake management'],
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
                    <li aria-current="page">Intake management</li>
                </ol>
            </nav>
            <p class="eyebrow">Intake management</p>
            <h1>Intake your whole team can work at once</h1>
            <p class="lede">Nonprofit intake management software should end the re-keying, not just move it. Need Navigator gives your team a live submissions grid everyone can work in at the same time — edits, colors, and statuses land for every viewer as they happen — and a matching engine that turns each submission into the right client record, or a whole household, without typing any of it twice.</p>
        </div>
    </section>

    {{-- ================= Live submissions grid UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: intake-submissions-grid | replace with: real screenshot of the Quick Forms submissions grid, light theme, landscape — cell presence visible on at least one cell, match classifications per row, the status column showing the linked assistance-request statuses, and a saved shared view selected. Placeholder: stylized HTML recreation of the grid. --}}
            <figure style="margin:0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Quick Forms — Energy assistance application</span></div>
                    <div class="uiframe-body">
                        <div class="ui-intake">
                            <div class="grid-toolbar">
                                <span class="view-chip">Saved view: Morning review &middot; shared</span>
                                <span class="searchbox"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="6"/><path d="M15 15l5.5 5.5"/></svg>Search all submissions</span>
                                <span class="presence"><i class="p-a">DM</i><i class="p-b">JR</i>2 teammates in this view</span>
                            </div>
                            <table>
                                <thead>
                                    <tr><th scope="col">Submission</th><th scope="col">Received</th><th scope="col">Match</th><th scope="col">Household</th><th scope="col">Status</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Applicant 1185</th>
                                        <td>Fri 4:51 p.m.</td>
                                        <td><span class="badge badge-exact">Exact match</span></td>
                                        <td>1 person</td>
                                        <td><span class="st st-approved"><i></i>Approved</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Applicant 1186</th>
                                        <td>8:12 a.m.</td>
                                        <td><span class="badge badge-exact">Exact match</span></td>
                                        <td>1 person</td>
                                        <td><span class="st st-ready"><i></i>Ready for review</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Applicant 1187</th>
                                        <td>8:26 a.m.</td>
                                        <td class="cell-editing"><span class="badge badge-probable">Probable &middot; 3 candidates</span><span class="editor-tag">JR</span></td>
                                        <td>2 people</td>
                                        <td><span class="st"><i></i>Pending</span></td>
                                    </tr>
                                    <tr class="row-tint">
                                        <th scope="row">Applicant 1188</th>
                                        <td>8:31 a.m.</td>
                                        <td><span class="badge badge-new">New individual</span></td>
                                        <td>1 person</td>
                                        <td><span class="st"><i></i>Pending</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Applicant 1189</th>
                                        <td>8:44 a.m.</td>
                                        <td><span class="badge badge-new">New individual</span></td>
                                        <td>4 people</td>
                                        <td><span class="st"><i></i>Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="grid-foot">
                                <span>Showing 50 of 312 &mdash; more load as you scroll</span>
                                <span>Colors, columns, and statuses sync live to every viewer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the live submissions grid: cell presence shows a teammate working a row, every submission carries a match classification, and the status column is the linked assistance request's status — the grid doubles as the review queue.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the intake workspace does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9.5 9v11"/><circle cx="6.2" cy="14.5" r="1.6" fill="currentColor" stroke="none"/><circle cx="15.5" cy="14.5" r="1.6" fill="currentColor" stroke="none"/></svg></span>
                    <h3>One grid, the whole team</h3>
                    <p>Cell-level presence shows who is editing what, and inline edits land for every viewer the moment they happen — updates are pushed, not polled. It is real-time collaboration on live case data, so the queue never has to be divided up by email.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h14M8 1 5 3l3 2M16 1l3 2-3 2"/><rect x="3" y="7" width="5" height="13" rx="1"/><rect x="10" y="7" width="5" height="13" rx="1"/><rect x="17" y="7" width="4" height="13" rx="1"/></svg></span>
                    <h3>Arrange it once, for everyone</h3>
                    <p>Resize columns, drag them into a new order, and color rows and columns to flag what matters to your team. Layout and color changes sync live to everyone viewing the grid.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h10a1 1 0 0 1 1 1v17l-6-4-6 4V4a1 1 0 0 1 1-1Z"/><path d="M9.5 8.5h5"/></svg></span>
                    <h3>Saved views the team shares</h3>
                    <p>Name a combination of column order and visibility, status filter, and sort — then share a default view for the whole team. Monday's reviewer sees exactly what Friday's reviewer saw.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="5.5"/><path d="M15 15l5.5 5.5"/><path d="M8 9h5M9.2 12h2.6"/></svg></span>
                    <h3>Built for volume</h3>
                    <p>Large forms load incrementally, so the workspace stays fast as submissions pile up. A unified search box plus filters by date, client, submitter, program membership, and status cut the pile down to the rows you need.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6h12M9 12h12M9 18h8"/><path d="M3 5.5 4.2 7 6.5 4.5"/><path d="M3 11.5 4.2 13 6.5 10.5"/><circle cx="4.7" cy="18" r="1.5"/></svg></span>
                    <h3>A review queue, built in</h3>
                    <p>Each row shows the status of its linked assistance request — Pending, Ready for Review, Approved — and staff update it inline without leaving the grid. Supervisors get a clear approval queue inside a workspace the team is already in.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c0-3 2.3-5 5.5-5 1.6 0 2.9.5 3.9 1.3"/><circle cx="17" cy="8.5" r="2.8"/><path d="M14.5 17.5l2 2 4-4"/></svg></span>
                    <h3>Exact, probable, or new</h3>
                    <p>The matching engine classifies every incoming submission using name, date of birth, and signals like Social Security number or HMIS (Homeless Management Information System) number, then ranks the likely candidates. Staff confirm a match or create the person in one click — fewer duplicates, no re-typing.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 9.5V20h12V9.5"/><circle cx="10" cy="13.5" r="1.8"/><circle cx="14" cy="13.5" r="1.8"/><path d="M8 20c.4-1.8 1.7-2.8 4-2.8s3.6 1 4 2.8"/></svg></span>
                    <h3>One application, a whole household</h3>
                    <p>When one submission collects several people — a family application — a guided stepper matches or creates each member, designates the primary member, and builds the household with everyone attached in one pass. Income for more than one household member can arrive from that same submission.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><rect x="6" y="12" width="5" height="5" rx="1"/><path d="M14 13h5M14 16h4"/></svg></span>
                    <h3>Where staff already look</h3>
                    <p>Program intake submissions surface on the client's profile automatically, and any form can be shown there with a per-form toggle. Embed a form's grid on a program dashboard as a widget, and the day starts with the queue already on screen.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>The morning after outreach night</h3>
                <p>Saturday was the community resource fair, and Monday's grid holds sixty-three new applications. At 8:30, an intake specialist and a program assistant open the same shared view. Cell presence shows each of them exactly where the other is working, so they split the queue without a word — no duplicated effort, no working the same row twice.</p>
                <p>The specialist works the match column: exact matches confirmed in a click, probable matches decided from the ranked candidates. The assistant takes the new individuals — and when a family of five's application comes up, the household stepper matches or creates each member, designates the primary, and attaches everyone in one pass. By ten, every row carries a status, and the ones marked Ready for Review are already sitting in the supervisor's approval queue.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions intake teams ask</h2>
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
                <a href="/features/forms">Form builder</a>
                <a href="/features/public-intake-portal">Public intake portal</a>
                <a href="/features/client-records">Client records &amp; duplicate prevention</a>
                <a href="/features/emergency-assistance">Emergency assistance workflow</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a submission become a client', 'blurb' => 'Bring one of your intake forms to the demo — we will run a submission through the grid, match it, and build a household while you watch.'])

@endsection
