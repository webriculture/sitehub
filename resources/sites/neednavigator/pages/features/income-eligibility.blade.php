@extends('site::partials.layout')

@section('title', 'Income Eligibility Screening Software | Need Navigator')
@section('description', 'Capture income with proof, keep verified and self-reported amounts distinct, and screen households against FPL and AMI limits by year and area.')

@php
    $faqs = [
        [
            'q' => 'What is the difference between verified and self-reported income?',
            'a' => 'Self-reported income is what a client or applicant entered themselves, on a public application or through the guided income wizard, and it arrives on the record marked unverified. A staff member confirms the amount before it counts, attaching proof (a paystub photo or PDF) to the record as they go. The distinction is enforced, not just displayed: a client\'s own income must be staff-verified before the eligibility engine counts it, and where each amount came from stays visible on the profile.',
        ],
        [
            'q' => 'What is the difference between FPL and AMI?',
            'a' => 'The federal poverty level (FPL) is a set of income thresholds published nationally each year by household size; area median income (AMI) is the midpoint household income for a specific geographic area, so it reflects local conditions. Different funding sources screen against different standards: one program may use a percentage of FPL while a housing program uses a percentage of AMI. Need Navigator stores both threshold types, by year, geographic area, and household size, with a percentage multiplier, so each program checks against the standard its funding actually uses.',
        ],
        [
            'q' => 'What happens when income limits change each year?',
            'a' => 'Thresholds are stored by year, and a bulk tool generates the next year\'s thresholds from the current year\'s. That means annual updates are one step, not an afternoon of re-keying every combination of program, threshold type, area, and household size.',
        ],
        [
            'q' => 'Does a minor\'s income count toward eligibility?',
            'a' => 'Only when a program says it should. Household income rolls up automatically across members for eligibility, and each program controls whether minors\' income is included in that roll-up. A teenager\'s part-time job counts toward a program whose rules require it and stays out of one whose rules do not, without staff doing side math.',
        ],
        [
            'q' => 'Can one application capture income for the whole household?',
            'a' => 'Yes. A single public submission can capture income for multiple household members, each source recorded per person through the guided wizard. Everything arrives marked unverified; staff review the submission, match or create each member, and confirm the amounts before anything counts toward eligibility.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Income & program eligibility'],
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
                    <li aria-current="page">Income &amp; program eligibility</li>
                </ol>
            </nav>
            <p class="eyebrow">Income &amp; program eligibility</p>
            <h1>Income you can verify, eligibility you can defend</h1>
            <p class="lede">Income eligibility screening software has one job: get the number right and show where it came from. Need Navigator records every income source with proof attached, keeps staff-verified amounts clearly apart from self-reported ones, and checks whole households against federal poverty level (FPL) and area median income (AMI) limits by year, geography, and household size.</p>
        </div>
    </section>

    {{-- ================= Eligibility verdict UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: income-eligibility-verdict | filled 2026-09-05 with real screenshots: img/screens/income-verdict (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Income and eligibility</span></div>
                    @include('site::partials.screen', ['name' => 'income-verdict', 'alt' => 'An income and eligibility panel: one earned income source at Safeway with three records, monthly, an estimated annual income of 28,355.08, household size 5, maximum income allowed 29,600.00, a difference of 1,244.92 and an Under Limit verdict', 'width' => 1170, 'height' => 276])
                </div>
                <figcaption class="ui-caption">The eligibility math on a test record: income sources annualized, the household size, the program&rsquo;s maximum allowed income, and the verdict, here under the limit by 1,244.92.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the income &amp; eligibility module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12v18l-2-1.4-2 1.4-2-1.4-2 1.4-2-1.4L6 21Z"/><path d="M9.5 8h5M9.5 12h5M9.5 16h2.5"/></svg></span>
                    <h3>Every source, with the proof attached</h3>
                    <p>Record each income source (type, employer, current or past) with per-pay-period amounts. Staff attach proof to the record as they go: a paystub photo or PDF, snapped directly on a phone at the desk or in the field.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2.5" width="10" height="19" rx="2"/><path d="M10 7h4M10 10.5h2.5"/><path d="M11 18.5h2"/></svg></span>
                    <h3>A wizard that asks the next question</h3>
                    <p>Guided income capture walks an applicant through each source step by step, on a phone, in English or Spanish. It starts with "Does this person have income?" Answering no records an explicit no-income declaration, clearly different from a question that was never asked.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-2.9 8-7 10-4.1-2-7-5.5-7-10V6Z"/><path d="M9 11.5l2 2 4-4"/></svg></span>
                    <h3>Verified means a staff member said so</h3>
                    <p>Income from a public form lands on the record marked unverified until a staff member confirms it, and only staff-verified income counts toward eligibility, the client's and every household member's alike. Where each amount came from stays visible on the profile.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18"/><path d="M4 16l4.5-4.5 3 3L18 8"/><path d="M14.5 8H18v3.5"/></svg></span>
                    <h3>Annualized without a calculator</h3>
                    <p>Each source projects to an annual figure, per source and per household, and household income rolls up automatically across members. Minors' income is counted only where a program says so.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/><circle cx="9" cy="6" r="2"/><circle cx="15" cy="12" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                    <h3>Limits the way your funders write them</h3>
                    <p>Set income thresholds by year, type (FPL or AMI), geographic area (metro area, Continuum of Care (CoC) region, county, or state), and household size, with a percentage multiplier. Programs combine income rules with age ranges and required fields, and show clients as eligible or partially eligible.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M9.5 15.5h5M12.7 13.2l2.3 2.3-2.3 2.3"/></svg></span>
                    <h3>New year, one step</h3>
                    <p>When the new figures publish, a bulk tool generates next year's thresholds from the current year's. No re-keying every combination of program, area, and household size.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 8V3.5h10V8"/><rect x="3.5" y="8" width="17" height="8" rx="2"/><rect x="7" y="13.5" width="10" height="7" rx="1"/><path d="M10 16.5h4"/></svg></span>
                    <h3>The math prints on the request</h3>
                    <p>Financial-assistance requests pull the household's recent income, within a tracking window you configure, and compare it to the program's maximum allowed income right on the printable request. The reviewer and the file both get the same answer.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 9.5V20h12V9.5"/><circle cx="10" cy="13.5" r="1.6"/><circle cx="14" cy="13.5" r="1.6"/><path d="M8.5 20c.5-1.6 1.9-2.5 3.5-2.5s3 .9 3.5 2.5"/></svg></span>
                    <h3>One application, the whole household</h3>
                    <p>A single public submission can capture income for several household members at once. Staff review each person and each amount before anything counts; nothing links to a record without confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>From a no-income declaration to a verified file</h3>
                <p>An applicant fills out the energy-assistance form on their phone, in Spanish, from their kitchen table. The guided wizard asks whether they have income; they answer no, and the system records an explicit no-income declaration: not a blank field, not a question skipped. When the submission reaches the review queue, staff can see exactly what was declared, and any income that does arrive from a public form lands marked unverified.</p>
                <p>A month later, they start part-time work and bring their first paystub to an appointment. A caseworker adds the income source, snaps a photo of the paystub, records the pay-period amount, and marks it verified. The household's annualized projection updates, and when the assistance request prints, the household's income, the program's limit, and the under-limit verdict are on the page, ready for whoever reviews the file.</p>
            </aside>
            {{-- [TESTIMONIAL: community action agency intake or eligibility staffer - on how the verified vs self-reported distinction holds up during a funder's file review] --}}
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
                <a href="/features/emergency-assistance">Assistance requests &amp; vouchers</a>
                <a href="/features/public-intake-portal">Public intake portal</a>
                <a href="/features/programs-automation">Programs &amp; enrollment rules</a>
                <a href="/solutions/community-action-agencies">For community action agencies</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Screen a household against your limits', 'blurb' => 'Bring one program\'s income limit to the demo; we will set up the threshold, walk an application through guided income capture, and print the request that shows the math.'])

@endsection
