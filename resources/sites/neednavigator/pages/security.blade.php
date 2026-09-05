@extends('site::partials.layout')

@section('title', 'Case Management Data Security | Need Navigator')
@section('description', 'Case management data security in plain language: isolated per-agency databases, scoped encryption, verified nightly backups, and a full audit trail.')

@php
    $faqs = [
        [
            'q' => 'Who can see a client\'s data?',
            'a' => 'Only the people your agency decides can see it. Role-based access control (RBAC) provides nearly 80 granular permissions assigned to roles your agency defines, individual records such as notes, documents, and needs can be scoped to everyone, one program, or selected teams, and forms support field-level edit permissions. Every client-record view is also logged, so "who can see" is always backed by "who did see."',
        ],
        [
            'q' => 'What does the audit trail record?',
            'a' => 'Every create, update, and delete across the system is logged, and every view of a client record by agency staff is logged with the user, the time, the IP address, and the device. Eight toggleable rules screen that record-view activity for suspicious patterns, such as night-hours access or unusually many records viewed in one day, and flagged activity queues for administrator resolution. Access logs export to CSV for auditors and funders.',
        ],
        [
            'q' => 'Where does our agency\'s data live?',
            'a' => 'On your agency\'s own instance of Need Navigator with its own private database, hosted on AWS (Amazon Web Services) behind a load balancer. There is no shared multi-tenant database, so cross-tenant queries are impossible by construction. Another agency\'s system cannot query your database. Per-agency secrets are managed in AWS Systems Manager Parameter Store.',
        ],
        [
            'q' => 'What exactly is encrypted?',
            'a' => 'Two scoped claims: client data is encrypted at rest on the application server, and backups are encrypted in transit (TLS) and at rest (AES-256). The application does not additionally encrypt individual PII columns (personally identifiable information such as Social Security numbers) inside the database, which is why we state the scope instead of rounding it up. An encryption claim that names its scope is the kind worth trusting.',
        ],
        [
            'q' => 'How are backups handled?',
            'a' => 'Every client database is backed up automatically every night to redundant, encrypted cloud storage. Each run is verified for restorability, with success or failure alerting our team immediately, and backups are retained for 35 days (13 months for monthly archives) in multiple independent locations, protected against deletion from the production server\'s credentials. Because backups run nightly, the honest recovery point is up to 24 hours.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Security'],
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
                    <li aria-current="page">Security</li>
                </ol>
            </nav>
            <p class="eyebrow">Security &amp; trust</p>
            <h1>Case management data security, in plain language</h1>
            <p class="lede">This page is written for two readers: the board member who asks whether client data is safe, and the funder whose security questionnaire wants specifics. Here is how Need Navigator protects the people in your records. Every claim is scoped to exactly what it covers, and the limits are stated out loud.</p>
        </div>
    </section>

    {{-- ================= 1. Isolation ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Your agency's data lives alone</h2>
                <p class="muted">Isolation is the first decision everything else builds on.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5.5" rx="7" ry="2.5"/><path d="M5 5.5V18.5c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5V5.5"/><path d="M5 12c0 1.4 3.1 2.5 7 2.5s7-1.1 7-2.5"/></svg></span>
                    <h3>One agency, one instance</h3>
                    <p>Each agency runs its own copy of the application with its own private database. Your data shares a system with nobody. There is no shared multi-tenant database at all.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v6c0 4.4-2.9 7.3-7 9-4.1-1.7-7-4.6-7-9V6Z"/><path d="M9 12h6"/></svg></span>
                    <h3>Impossible by construction</h3>
                    <p>Cross-tenant queries are impossible by construction. A bug or a bad filter in another agency's system cannot touch your records, because your database is not connected to theirs.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 18.5h10a4 4 0 0 0 .9-7.9A5.5 5.5 0 0 0 7.2 9.4 4.6 4.6 0 0 0 7 18.5Z"/></svg></span>
                    <h3>Hosted on AWS</h3>
                    <p>Instances run on AWS (Amazon Web Services) behind a load balancer, infrastructure your IT committee will already recognize from its own questionnaires.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="15.5" r="3.5"/><path d="M10.5 13 19 4.5M15.5 8l3 3M13 10.5l2 2"/></svg></span>
                    <h3>Secrets kept separately</h3>
                    <p>Per-agency secrets are managed in AWS Systems Manager Parameter Store, each agency's separately.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= 2. Encryption & backups ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Encryption and backups, scoped exactly</h2>
                <p class="muted">Security pages love the word "encrypted." We use it carefully.</p>
            </div>
            <p>Two encryption claims, each scoped to exactly what it covers: client data is encrypted at rest on the application server, and backups are encrypted in transit (TLS) and at rest (AES-256).</p>
            <p>The backup record, line by line:</p>
            <ul>
                <li>Automated backups of every client database run nightly.</li>
                <li>Backups are stored off-site in redundant cloud storage (AWS S3, designed for 99.999999999% durability).</li>
                <li>Every backup run is automatically verified for restorability, and its success or failure alerts our team immediately.</li>
                <li>Backups are retained on a rolling schedule: 35 days of daily backups, 13 months of monthly archives.</li>
                <li>Backups are maintained in multiple independent locations.</li>
                <li>Backup copies are protected against deletion from the production server: the server's credentials cannot delete or overwrite backup history.</li>
            </ul>
            <p>Where a stronger-sounding word would need an asterisk, we leave the word out.</p>
        </div>
    </section>

    {{-- ================= 3. Access control ================= --}}
    <section class="section section--surface">
        <div class="container">
            <div class="section-head">
                <h2>Who sees what is your call</h2>
                <p class="muted">Access is granted by role, scoped by record, and controlled by your agency, not by us.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M4 12h16M4 17h16"/><circle cx="9" cy="7" r="1.8" fill="none"/><circle cx="15" cy="12" r="1.8" fill="none"/><circle cx="7" cy="17" r="1.8" fill="none"/></svg></span>
                    <h3>Nearly 80 granular permissions</h3>
                    <p>Role-based access control (RBAC) means staff hold roles, and roles carry permissions: create, manage, and view rights per module, nearly 80 in all, assigned through an admin screen to roles your agency defines.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    <h3>Record-level visibility</h3>
                    <p>Notes, documents, folders, goals, visits, needs, referrals, and reports each carry their own visibility: everyone, the same program, or selected teams. A sensitive note can be held tighter than the record it sits on.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9h7M7 13h10M7 17h6"/><path d="M17.5 8.2v1.6M16.5 9.8h2a.8.8 0 0 1 .8.8v1.4a.8.8 0 0 1-.8.8h-2a.8.8 0 0 1-.8-.8v-1.4a.8.8 0 0 1 .8-.8Z"/></svg></span>
                    <h3>Field-level control in forms</h3>
                    <p>Inside the form builder, individual fields can be limited to specific teams or users for editing, so a form that passes through many hands only changes in the right ones.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.5"/><path d="M5.5 20c.9-3.2 3.4-5 6.5-5s5.6 1.8 6.5 5"/><path d="M17.5 3.5l2 2-2 2"/></svg></span>
                    <h3>Support access, restricted</h3>
                    <p>When our team needs to see what you see for support, admin impersonation is restricted to designated super-users.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= 4. Sign-in ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Sign-in that fits your agency</h2>
                <p class="muted">From a five-person shelter to an agency already running single sign-on, the front door adapts.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="8" rx="2"/><path d="M7 12h.01M11 12h.01M15 12h.01"/></svg></span>
                    <h3>Passwords with rules</h3>
                    <p>Password sign-in enforces complexity rules and supports forced changes when staffing or policy demands it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="2"/><path d="M5.5 16c.5-1.5 1.7-2.3 3-2.3s2.5.8 3 2.3"/><path d="M14 10h5M14 13.5h4"/></svg></span>
                    <h3>SAML single sign-on</h3>
                    <p>SAML single sign-on (SSO) connects Need Navigator to the identity provider your organization already uses (one identity provider per agency).</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 11.5a4 4 0 1 1 8 0c0 3.5-1.2 6-2 7.5"/><path d="M11 11.5c0 2.8-.6 5.2-1.6 7"/><path d="M14 11.5a2 2 0 0 0-4 0"/><path d="M17 11.5c0 2.3-.4 4.4-1 6"/></svg></span>
                    <h3>Passkeys</h3>
                    <p>Passkeys (WebAuthn) are supported, so staff can sign in with the device in their hand instead of a password.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2.5" width="8" height="19" rx="2"/><path d="M8 6h8M8 18h8M10.5 12h3"/></svg></span>
                    <h3>Two-factor, per user</h3>
                    <p>Each user can add two-factor authentication (2FA) to their account: a one-time code from an authenticator app (TOTP) or a code sent by email.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.8 2.4 4 5.6 4 9s-1.2 6.6-4 9c-2.8-2.4-4-5.6-4-9s1.2-6.6 4-9Z"/></svg></span>
                    <h3>IP access modes</h3>
                    <p>Choose your agency's mode: open access; an allowlist of approved IP addresses only; the allowlist plus a 2FA-verified override for remote staff; or SSO-only.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v6c0 4.4-2.9 7.3-7 9-4.1-1.7-7-4.6-7-9V6Z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></svg></span>
                    <h3>Bot protection that fails open</h3>
                    <p>Cloudflare Turnstile screens sign-in, password reset, and public registration against bots. It is designed to fail open, so an outage on Cloudflare's side never locks your staff out.</p>
                </div>
            </div>
            <p class="mt-2">Underneath all of it: HTTPS on all traffic, secure cookies, server-side sessions, and passwords and one-time codes stored hashed.</p>
        </div>
    </section>

    {{-- ================= 5. Audit trail & access monitoring (featured) ================= --}}
    <section class="section section--surface ui-audit">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Audit trail &amp; access monitoring</p>
                <h2>Every action logged. Unusual access flagged.</h2>
                <p class="muted">Access control decides who can open a record. The audit trail proves who did.</p>
            </div>
            <p>Need Navigator automatically logs every create, update, and delete across the system and renders them as a readable, permission-gated history timeline on each client. And every client-record view by agency staff is logged too: who, when, from which IP address, on what device.</p>

            {{-- IMAGE SLOT: security-flag-queue | replace with: real screenshot of the suspicious-access flag resolution queue, light theme, landscape - rule names visible, at least one open and one resolved flag, no real client or staff names. Placeholder: stylized HTML recreation of the queue. --}}
            <figure style="margin: 2rem 0">
                <div class="uiframe" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Access monitoring: flag queue</span></div>
                    <div class="uiframe-body">
                        <div class="fq">
                            <div class="fq-head">
                                <strong>Suspicious-access flags &middot; 2 open</strong>
                                <span class="fq-export">Export access log (CSV)</span>
                            </div>
                            <div class="fq-row">
                                <span class="fq-ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4 21 19H3Z"/><path d="M12 10v4M12 16.6h.01"/></svg></span>
                                <div class="fq-main">
                                    <strong>Night-hours access</strong>
                                    <span>A front-desk account viewed 6 client records between 2:04 and 2:19 a.m.</span>
                                    <em>Flagged today &middot; 2:19 a.m. &middot; 203.0.113.44 &middot; Windows &middot; Chrome</em>
                                </div>
                                <span class="fq-badge">Open</span>
                            </div>
                            <div class="fq-row">
                                <span class="fq-ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4 21 19H3Z"/><path d="M12 10v4M12 16.6h.01"/></svg></span>
                                <div class="fq-main">
                                    <strong>Sequential record walking</strong>
                                    <span>Client records opened in ID order, 14 in a row over 9 minutes.</span>
                                    <em>Flagged today &middot; 11:02 a.m. &middot; 203.0.113.17 &middot; macOS &middot; Safari</em>
                                </div>
                                <span class="fq-badge">Open</span>
                            </div>
                            <div class="fq-row is-resolved">
                                <span class="fq-ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5.5"/></svg></span>
                                <div class="fq-main">
                                    <strong>Unusually many clients in a day</strong>
                                    <span>58 client records viewed against a 30-day baseline of 11. Resolved: annual file review, noted by the administrator.</span>
                                    <em>Tuesday &middot; 4:41 p.m. &middot; 203.0.113.29 &middot; Windows &middot; Chrome</em>
                                </div>
                                <span class="fq-badge">Resolved</span>
                            </div>
                            <div class="fq-row is-resolved">
                                <span class="fq-ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5.5"/></svg></span>
                                <div class="fq-main">
                                    <strong>Access outside assigned programs</strong>
                                    <span>Viewed two records enrolled only in the housing program. Resolved: covering a colleague's caseload.</span>
                                    <em>Monday &middot; 9:15 a.m. &middot; 203.0.113.51 &middot; Windows &middot; Edge</em>
                                </div>
                                <span class="fq-badge">Resolved</span>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of the suspicious-access queue: flagged patterns wait for an administrator to review and resolve, and the access log exports to CSV, a plain spreadsheet file.</figcaption>
            </figure>

            <h3>Eight toggleable monitoring rules</h3>
            <p>Turn on the ones that fit your agency. Each screens staff access for patterns worth a second look:</p>
            <ol class="rules">
                <li><strong>Repeated views of one client</strong><span>the same record opened again and again by one user.</span></li>
                <li><strong>Unusually many clients in a day</strong><span>far more records than that user's normal working day.</span></li>
                <li><strong>Unusually many clients in a minute</strong><span>faster than anyone actually reads case files.</span></li>
                <li><strong>Access outside assigned programs</strong><span>viewing clients the user's programs do not serve.</span></li>
                <li><strong>Night-hours access</strong><span>activity at hours when the office is dark.</span></li>
                <li><strong>Sudden spikes against a 30-day baseline</strong><span>a jump measured against the user's own recent pattern.</span></li>
                <li><strong>Return after long inactivity</strong><span>a quiet account that abruptly starts reading records.</span></li>
                <li><strong>Sequential record walking</strong><span>paging through client records one after another, in order.</span></li>
            </ol>
            <p>Flagged activity lands in an administrator resolution queue, cleared one at a time or in batches, and access logs export to CSV so a funder's security question gets a file rather than a promise.</p>
            <p>This is the machinery of a HIPAA-style minimum-necessary review. HIPAA (the Health Insurance Portability and Accountability Act) expects staff to access only the records their role requires, and the access log and flag queue let you review exactly that. We say "HIPAA-style" deliberately: compliance with a named framework is a legal determination for your counsel, not a claim software should make for you.</p>
            {{-- [TESTIMONIAL: executive director or program director at a community action agency - on answering a funder's data-security questionnaire or passing an access review using the audit trail and CSV access logs] --}}
        </div>
    </section>

    {{-- ================= 6. Honest limits ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Where the limits are</h3>
                <p>The application does not additionally encrypt individual PII columns (personally identifiable information such as Social Security numbers and dates of birth) inside the database. That is why the encryption claims on this page are scoped to the application server and to backups, and no further. Backups run nightly, so the honest recovery point is up to 24 hours.</p>
                <p>And because every agency runs its own deployment, optional modules and per-site settings genuinely vary. When you ask "is this switched on for us?", we confirm your site's exact configuration during the sales conversation instead of reading a generic yes off a page.</p>
            </aside>
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions boards and funders ask</h2>
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
                <a href="/reporting">PII redaction &amp; scheduled reports</a>
                <a href="/features/client-records">Client records &amp; duplicate prevention</a>
                <a href="/pricing">Transparent per-seat pricing</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Bring the security questionnaire', 'blurb' => 'Send it ahead or bring it to the demo. We will answer it line by line, in writing, the same way this page does: specific and scoped.'])

@endsection
