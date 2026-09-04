@extends('site::partials.layout')

@section('title', 'Case Management for Parent Education Programs')
@section('description', 'For parent education providers: bilingual applications, verified registration, fidelity completion and certificates, and check-in that guards privacy.')

@php
    $faqs = [
        [
            'q' => 'Our funding requires an evidence-based curriculum delivered to fidelity. Can Need Navigator document that?',
            'a' => 'Each course carries its own completion-fidelity threshold — the attendance bar a participant must meet — and completion is computed against it automatically from the attendance record. Completion certificates generate as PDFs for qualifying participants, and enrollment and completion outcomes are reportable on dashboards. Your curriculum\'s requirements stay yours to define; we make no compliance claims for any named program.',
        ],
        [
            'q' => 'Can families apply in Spanish?',
            'a' => 'Yes. Your intake forms can be presented in Spanish on the public portal — an AI drafts the complete translation in seconds, and your bilingual staff review and polish it in a side-by-side editor before a family ever sees it. Stored answers stay in English behind the scenes, so conditional logic and reporting are unaffected. Spanish descriptions of your open class offerings can also appear on your own website through the secure class feed.',
        ],
        [
            'q' => 'How does Need Navigator protect participants who are domestic-violence survivors?',
            'a' => 'Check-in is designed so the roster can never be discovered from the room: scanning the session\'s QR poster reveals no names, confirmed participants receive single-use, short-lived check-in links by text or email, and confidential household members are never disclosed — even when a household checks in together. On the record side, a client\'s profile can carry a domestic-violence-survivor flag, and every staff view of a client record is logged and screened for unusual access patterns.',
        ],
        [
            'q' => 'Do families need an account to apply or register?',
            'a' => 'No. Applications on the public portal require no account, and class registration verifies the family\'s phone number or email with a one-time code before it is accepted — so rosters start clean, with no login for anyone to remember. Application submissions arrive in a staff review queue where a matching engine ranks likely existing records; nothing attaches to a client record until staff confirm it.',
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
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions', 'item' => 'https://'.$host.'/solutions'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Parent education'],
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
                    <li><a href="/solutions">Solutions</a></li>
                    <li aria-current="page">Parent education</li>
                </ol>
            </nav>
            <p class="eyebrow">For parent education providers</p>
            <h1>From first application to certificate night</h1>
            <p class="lede">Case management for parent education programs starts long before session one and ends well after the last chair is folded. Need Navigator carries that whole span — bilingual applications a family completes online, verified registration, automatic reminders, attendance, completion computed to fidelity — and it treats participant privacy as a safety matter, because for some families it is one.</p>
        </div>
    </section>

    {{-- ================= Cohort completion UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: parent-ed-solutions-cohort | replace with: real screenshot of a course offering's completion view, light theme, landscape — fidelity threshold visible, per-participant attendance, at least one credit override and one certificate-ready participant. Placeholder: stylized HTML recreation of a cohort completion list. --}}
            <figure style="margin:0">
                <div class="uiframe ui-cohort" aria-hidden="true">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Course completion — Tuesday evening cohort</span></div>
                    <div class="uiframe-body">
                        <div class="co-list">
                            <div class="co-head">
                                <span><strong>8 sessions</strong> · fidelity threshold: attend 6</span>
                                <span>Session 8 of 8 complete</span>
                            </div>
                            <div class="co-row">
                                <span class="co-name">Alex R.</span>
                                <span class="co-dots"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i class="d-off"></i></span>
                                <span class="co-count">7 of 8</span>
                                <span class="co-chip is-ready">Certificate ready</span>
                            </div>
                            <div class="co-row">
                                <span class="co-name">Sam K.<small>Checked in with household</small></span>
                                <span class="co-dots"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
                                <span class="co-count">8 of 8</span>
                                <span class="co-chip is-ready">Certificate ready</span>
                            </div>
                            <div class="co-row">
                                <span class="co-name">Jordan M.<small>Credit override — session 5</small></span>
                                <span class="co-dots"><i></i><i></i><i></i><i></i><i class="d-ov"></i><i></i><i class="d-off"></i><i></i></span>
                                <span class="co-count">6 of 8</span>
                                <span class="co-chip is-ready">Certificate ready</span>
                            </div>
                            <div class="co-row">
                                <span class="co-name">Morgan L.</span>
                                <span class="co-dots"><i></i><i></i><i class="d-off"></i><i class="d-off"></i><i></i><i class="d-off"></i><i class="d-off"></i><i></i></span>
                                <span class="co-count">4 of 8</span>
                                <span class="co-chip is-below">Below threshold</span>
                            </div>
                            <div class="co-foot">
                                <span class="co-generate">Generate certificates (PDF)</span>
                                <span class="co-legend">Attendance marked from the facilitator's phone</span>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="ui-caption">An illustration of cohort completion: attendance counted against the course's fidelity threshold, a credit override where life intervened, and certificates ready for everyone who met the bar.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Workflow sections ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Built for the way a cohort actually runs</h2>
                <p class="muted">Eight pieces of Need Navigator that carry parent education work. The classes module itself — catalog, registration, reminders, attendance, certificates — has <a href="/features/parent-education-classes">its own page</a>.</p>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="5" r="2"/><path d="M5 7v7a4 4 0 0 0 4 4h10"/><path d="M16 15l3 3-3 3"/></svg></span>
                    <h3>One module carries the whole arc</h3>
                    <p>Courses hold the curriculum and its completion-fidelity threshold. Offerings are the runs families enroll in — online, in person, or hybrid, each with its own capacity and public page — and sessions generate from a weekday pattern, so the spring schedule takes minutes, not an afternoon.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5H4l2.2-3.2A8.5 8.5 0 1 1 21 11.5Z"/><path d="M8.5 11.5l2.5 2.5 4.5-5"/></svg></span>
                    <h3>Sign-ups verified, reminders automatic</h3>
                    <p>Every offering gets a public registration page with bot protection, and the phone number or email a family gives must pass a one-time code before the registration is accepted. From there, reminders go out by text message (SMS) and email before every session — a few days ahead and again day-of — with opt-in managed per offering.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="13" rx="2"/><path d="M8 8h8M8 11h5"/><circle cx="15.5" cy="16.5" r="2.5"/><path d="M14.5 18.7 13.8 22l1.7-1 1.7 1-.7-3.3"/></svg></span>
                    <h3>Completion computed, certificates ready</h3>
                    <p>Each course carries the attendance threshold your curriculum calls for, and completion is computed against it automatically — with facilitator credit overrides for the nights life intervenes. Certificates generate as PDFs for everyone who qualifies, ready before certificate night.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 4H5a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v3l4-3h3a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Z"/><path d="M17 9h2a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-1v3l-4-3h-3"/></svg></span>
                    <h3>Intake in the family's language</h3>
                    <p>Present your intake forms in Spanish: an AI drafts the complete translation in seconds, and your bilingual staff review and polish it side by side before a family ever sees it. Answers store in English behind the scenes, so conditional logic and reporting carry on unaffected.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 9.5V20h12V9.5"/><path d="M12 12.5v5M9.5 15h5"/></svg></span>
                    <h3>One application, the whole household</h3>
                    <p>Families apply online through the MyNeedNav portal — no account needed, in English or Spanish. When one application names several people, a guided stepper matches or creates each member and builds the household in one pass; nothing attaches to a record until staff confirm it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/><path d="M7 12.5h6M7 9h10"/></svg></span>
                    <h3>Your class schedule, on your website</h3>
                    <p>A secure, read-only feed serves your open class offerings to your own website automatically — in English and Spanish — so the schedule families see is always current. The feed carries marketing content only; by construction, no client information ever passes through it.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.6-3 8.4-7 10-4-1.6-7-5.4-7-10V6Z"/><circle cx="12" cy="10.5" r="1.6"/><path d="M12 12.1V15"/></svg></span>
                    <h3>Privacy designed for survivors</h3>
                    <p>Scanning the check-in poster never reveals who is enrolled. Confirmed participants get single-use, short-lived check-in links by text or email, households check in together, and confidential members are never disclosed. The client record itself can carry a domestic-violence-survivor flag.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 17v-4M11 17V9M15 17v-6M19 17V7"/></svg></span>
                    <h3>Enrollment and completion, on the dashboard</h3>
                    <p>Class enrollment and completion outcomes are reportable on dashboards — watch a cohort move from sign-up to certificate without building a spreadsheet, with build-your-own query tables and fiscal-year date presets. The rest of your program's work — visits, needs, referrals — flows into a report builder with scheduled delivery and Excel export.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>One cohort, start to finish</h3>
                <p>A family finds the spring parenting class on the agency's website — the schedule is there because the site reads the secure class feed, in Spanish as well as English. They apply through the public portal in Spanish, no account needed, on an intake form the AI translated and a bilingual staff member polished weeks earlier. When the application arrives, the program coordinator runs the household stepper: each family member matched or created, the household built, in one pass. The family registers for the Tuesday offering, and the phone number they give passes a one-time code before the registration is accepted.</p>
                <p>Week after week, the reminder texts go out on their own. On class nights the poster by the door names no one — each parent's single-use check-in link arrives by text, whole households check in together, and the facilitator marks attendance from their phone, including one credit override for a parent who stayed home with a sick kid. After the final session, completion computes against the course's fidelity threshold and certificates generate as PDFs for everyone who met it. On certificate night the coordinator hands them out — and the cohort's enrollment and completion numbers are already on the program dashboard when the funder asks.</p>
            </aside>
            {{-- [TESTIMONIAL: parent-education program director — on documenting fidelity completion for an evidence-based curriculum, and what verified registration and automatic reminders changed about attendance] --}}
        </div>
    </section>

    {{-- ================= FAQ ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Questions parent education providers ask</h2>
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
            <p class="eyebrow" style="margin-bottom: 1rem">Dig into the modules</p>
            <div class="crosslinks">
                <a href="/features/parent-education-classes">Parent education classes</a>
                <a href="/features/forms">Multilingual forms &amp; translation</a>
                <a href="/features/public-intake-portal">MyNeedNav public intake portal</a>
                <a href="/features/intake-management">Intake &amp; household capture</a>
                <a href="/reporting">Reports &amp; dashboards</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'See a whole cohort run through it', 'blurb' => 'Bring your spring schedule and your intake form to the demo — we will set up the course, take a registration, and show you where the completion numbers land.'])

@endsection
