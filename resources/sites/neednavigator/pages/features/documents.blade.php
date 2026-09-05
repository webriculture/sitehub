@extends('site::partials.layout')

@section('title', 'Client Document Management Software | Need Navigator')
@section('description', 'Every client\'s paperwork in one permission-controlled place: typed files, team folders, PDF packet merge, and a scanner-fed inbox for the daily stack.')

@php
    $faqs = [
        [
            'q' => 'Who can see a client\'s files?',
            'a' => 'You decide, folder by folder and file by file. Visibility can be open to everyone at the agency, limited to staff in the client\'s program, or restricted to selected teams. Client-file downloads pass a program-security check on top of that. Role-based permissions govern who can manage documents in the first place.',
        ],
        [
            'q' => 'What does the Document Inbox need to be set up?',
            'a' => 'A way to land scans in a drop folder: a scanner that saves to one, or an SFTP (secure file transfer) connection. The inbox is an optional module, set up and tailored per agency. Once it is on, incoming files queue on a triage screen where staff preview each one and file it to the right client, visit, or need with a type and folder in a couple of clicks.',
        ],
        [
            'q' => 'What happens when someone deletes a file by mistake?',
            'a' => 'Deleting a client file is a soft delete: the file leaves the folder, but it is not destroyed, and it can be recovered. A misclick does not cost a client the only copy of their lease.',
        ],
        [
            'q' => 'Can a file attach to something besides the client?',
            'a' => 'Yes. Files attach to a client, a need, a visit, a task, or an organization. That means an eviction notice can live on the assistance request it supports, and a sign-in sheet on the visit it documents. When you open that record later, its paperwork is already there.',
        ],
        [
            'q' => 'What kinds of files can merge into one PDF?',
            'a' => 'PDFs, images, and Office documents. Select the files on the client\'s record and they combine into a single PDF. That is how agencies assemble a complete application packet as one attachment instead of a loose stack of files.',
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
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Documents & files'],
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
                    <li aria-current="page">Documents &amp; files</li>
                </ol>
            </nav>
            <p class="eyebrow">Documents &amp; files</p>
            <h1>Every document in its place, attached to the work</h1>
            <p class="lede">Client document management software should keep the paperwork with the work it proves. Need Navigator gives every file a type, a folder, and a home on the client's record (or on the need, visit, or task it belongs to) and turns the morning scanner stack into filed records a couple of clicks at a time.</p>
        </div>
    </section>

    {{-- ================= Document Inbox UI representation ================= --}}
    <section class="section section--surface">
        <div class="container">
            {{-- IMAGE SLOT: documents-inbox-triage | filled 2026-09-05 with real screenshots: img/screens/document-inbox (source in /home/ubuntu/sitehub-image-sources/neednavigator) --}}
            <figure style="margin:0">
                <div class="uiframe">
                    <div class="uiframe-bar"><i></i><i></i><i></i><span>Document Inbox</span></div>
                    @include('site::partials.screen', ['name' => 'document-inbox', 'alt' => 'The Document Inbox: fifty files awaiting processing listed on the left with sizes and times, one PDF selected and previewed on the right with program, document type and file name fields, an individual search, and a Process Document button', 'width' => 1656, 'height' => 785])
                </div>
                <figcaption class="ui-caption">The Document Inbox on a test instance: this morning&rsquo;s scans queued on the left, the selected file previewed on the right, and the three steps that file it, a program and document type, then the person it belongs to.</figcaption>
            </figure>
        </div>
    </section>

    {{-- ================= Capabilities ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>What the documents module does</h2>
            </div>
            <div class="caps">
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M8.5 13h7M8.5 16.5h4.5"/></svg></span>
                    <h3>Typed files, not a junk drawer</h3>
                    <p>Upload one file or a batch; each gets a document type from your agency's own list, and types carry their own custom fields for the details that matter. The utility bill is a utility bill, not scan_0412.pdf.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/><circle cx="10" cy="13" r="1.8"/><path d="M6.8 18c.5-1.5 1.7-2.3 3.2-2.3s2.7.8 3.2 2.3"/><circle cx="15.5" cy="13.5" r="1.4"/></svg></span>
                    <h3>Folders your teams control</h3>
                    <p>Organize files into folders with team-based visibility: open to everyone, limited to the client's program, or restricted to selected teams. Drag files between folders as things change.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.5l-8.2 8.2a5 5 0 0 1-7.1-7.1l8.5-8.5a3.4 3.4 0 0 1 4.8 4.8l-8.2 8.2a1.8 1.8 0 0 1-2.5-2.5L15.5 8.4"/></svg></span>
                    <h3>Attached to the work itself</h3>
                    <p>A file can live on a client, a need, a visit, a task, or an organization. The paperwork that justifies an assistance request sits on the request itself, not three folders away.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/><path d="M12 10.5v5M9.5 13h5"/></svg></span>
                    <h3>Organized from day one</h3>
                    <p>When a client enrolls in a program, the program's default folder set is created automatically. Every enrollee's record starts out organized the same way.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v5a3 3 0 0 0 3 3h2M18 3v5a3 3 0 0 1-3 3h-2"/><path d="M12 11v9m0 0-2.5-2.5M12 20l2.5-2.5"/></svg></span>
                    <h3>Many files, one packet</h3>
                    <p>Select PDFs, images, and Office documents and merge them into a single PDF: a complete application packet as one attachment instead of five.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13h5l2 3h4l2-3h5"/><path d="M3 13v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5"/><path d="M12 3v7m0 0-2.5-2.5M12 10l2.5-2.5"/></svg></span>
                    <h3>A scanner inbox for the daily stack</h3>
                    <p>Optional per agency: a scanner or SFTP (secure file transfer) drop folder feeds a triage screen. Staff preview each file, find the right client, visit, or need, and file it with a type and folder in a couple of clicks.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4v5h5"/><path d="M4.6 9a8 8 0 1 1-.6 4"/></svg></span>
                    <h3>Deleted is not destroyed</h3>
                    <p>Deleting a client file is reversible. Files are soft-deleted and can be recovered, so one wrong click never destroys a client's only copy of a document.</p>
                </div>
                <div class="cap reveal">
                    <span class="icon" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 7.6-7 10-4-2.4-7-5.5-7-10V6Z"/><path d="M9 11.5l2 2 4-4"/></svg></span>
                    <h3>Access checks that travel with the file</h3>
                    <p>Team-based permission levels apply to files and folders, and downloads of client files pass a program-security check. Visibility rules are enforced, not suggested.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Vignette ================= --}}
    <section class="section section--wash">
        <div class="container">
            <aside class="vignette">
                <h3>Friday: the application packet</h3>
                <p>An energy-assistance application needs everything in one file: the signed application, a photo ID, two paystubs, and last month's utility bill. Most of it is already on the client's record: the front desk scanned the morning stack, and a staffer triaged the Document Inbox over coffee, filing each piece to the right client with a type and a folder.</p>
                <p>So the caseworker's part takes minutes, not an afternoon. They select the five files and merge them into one PDF. The result is a complete, legible packet instead of a loose stack of scans and photos.</p>
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
                <a href="/features/client-records">Client records &amp; profiles</a>
                <a href="/features/emergency-assistance">Needs &amp; emergency assistance</a>
                <a href="/features/income-eligibility">Income &amp; eligibility</a>
                <a href="/security">Security &amp; access controls</a>
            </div>
        </div>
    </section>

    @include('site::partials.cta', ['heading' => 'Watch a stack become a filed record', 'blurb' => 'Bring your messiest intake packet to the demo. We will walk it from the scanner inbox to the client record, then merge it into one clean PDF.'])

@endsection
