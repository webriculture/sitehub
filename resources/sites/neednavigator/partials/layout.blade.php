@php
    /** @var \App\Models\Site|null $site */
    $site = \App\Tenancy\Tenancy::current();
    $primaryHost = $site?->primaryDomain()?->hostname ?? request()->getHost();
    $path = '/'.trim(request()->path(), '/');
    if ($path === '//') $path = '/';
    $canonical = 'https://'.$primaryHost.($path === '/' ? '/' : $path);
    $ogImage = 'https://'.$primaryHost.'/sites/neednavigator/og/og-default.png';

    $nav = [
        ['href' => '/features',  'label' => 'Features'],
        ['href' => '/solutions', 'label' => 'Solutions'],
        ['href' => '/pricing',   'label' => 'Pricing'],
        ['href' => '/security',  'label' => 'Security'],
        ['href' => '/about',     'label' => 'About'],
    ];
    $current = $path;
    // .active highlights the section; aria-current="page" is exact-match only.
    $isExact = fn (string $href) => rtrim($href, '/') === rtrim($current, '/');
    $inSection = fn (string $href) => $isExact($href) || ($href !== '/' && str_starts_with($current, $href.'/')) || ($href === '/features' && str_starts_with($current, '/reporting'));

    $orgJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Need Navigator',
        'url' => 'https://'.$primaryHost.'/',
        'logo' => 'https://'.$primaryHost.'/sites/neednavigator/img/nn-logo.png',
        'telephone' => '+1-971-719-2251',
        'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Salem', 'addressRegion' => 'OR', 'addressCountry' => 'US'],
        'parentOrganization' => ['@type' => 'Organization', 'name' => 'Webriculture'],
    ];
    $appJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => 'Need Navigator',
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'Web',
        'url' => 'https://'.$primaryHost.'/',
        'description' => 'Case management software for human-services organizations: client records, households, assistance requests, referrals, visits, goals, shelters, classes, and reporting. Each agency runs on its own isolated instance with its own private database.',
        // Two commercial line items, both published on /pricing: the recurring
        // per-seat subscription (five-user minimum) and the one-time setup fee.
        'offers' => [
            [
                '@type' => 'Offer',
                'name' => 'Subscription',
                'price' => '25.00',
                'priceCurrency' => 'USD',
                'priceSpecification' => [
                    '@type' => 'UnitPriceSpecification',
                    'price' => '25.00',
                    'priceCurrency' => 'USD',
                    'unitText' => 'per user per month',
                    'eligibleQuantity' => ['@type' => 'QuantitativeValue', 'minValue' => 5, 'unitText' => 'users'],
                ],
            ],
            [
                '@type' => 'Offer',
                'name' => 'One-time setup: implementation and up to 12 hours of virtual training',
                'price' => '2000.00',
                'priceCurrency' => 'USD',
                'description' => 'Baseline. May be higher for substantially more training or work outside the standard setup; any difference is quoted before work starts.',
            ],
        ],
        'provider' => ['@type' => 'Organization', 'name' => 'Webriculture', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Salem', 'addressRegion' => 'OR']],
    ];
@endphp
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Need Navigator | Case Management for Human Services')</title>
    <meta name="description" content="@yield('description', 'Case management software built with human-services agencies: client records, assistance, reporting, and transparent per-seat pricing.')">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:site_name" content="Need Navigator">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Need Navigator | Case Management for Human Services')">
    <meta property="og:description" content="@yield('description', 'Case management software built with human-services agencies: client records, assistance, reporting, and transparent per-seat pricing.')">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Need Navigator | Case Management for Human Services')">
    <meta name="twitter:description" content="@yield('description', 'Case management software built with human-services agencies: client records, assistance, reporting, and transparent per-seat pricing.')">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="theme-color" content="#14382a">
    <link rel="icon" href="/sites/neednavigator/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/sites/neednavigator/img/favicon-32.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="/sites/neednavigator/img/apple-touch-icon.png">
    <link rel="preload" href="/sites/neednavigator/fonts/source-serif-4-var-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/sites/neednavigator/fonts/public-sans-var-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="/sites/neednavigator/css/site.css">
    <script type="application/ld+json">{!! json_encode($orgJsonLd, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($appJsonLd, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
    @yield('structured')
</head>
<body @class(['is-home' => $path === '/'])>
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="/" aria-label="Need Navigator homepage">
                {{-- IMAGE SLOT: logo-header | replace with: vector (SVG) of the white wordmark. The raster below is the original artwork and is clipped: the final R touches the right canvas edge at 250x29 with no margin. The masthead is dark (see .site-header) so no recolored variant is needed. --}}
                <img src="/sites/neednavigator/img/nn-logo.png" alt="Need Navigator" width="207" height="24">
            </a>
            <button class="nav-toggle" type="button" data-nav-toggle aria-controls="primary-navigation" aria-expanded="false">Menu</button>
            <nav class="nav-links" id="primary-navigation" data-nav-links aria-label="Primary navigation">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}" @class(['active' => $inSection($item['href'])]) @if($isExact($item['href'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <a class="button primary" href="/contact">Request a demo</a>
            </nav>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a class="brand" href="/" aria-label="Need Navigator homepage">
                        <img src="/sites/neednavigator/img/nn-logo.png" alt="Need Navigator" width="207" height="24">
                    </a>
                    <p>Case management software for human-services organizations, built in Salem, Oregon with the agencies that use it.</p>
                    <p><a href="tel:+19717192251">971-719-2251</a></p>
                </div>
                <div>
                    <strong>Product</strong>
                    <ul>
                        <li><a href="/features">All features</a></li>
                        <li><a href="/reporting">Reporting &amp; dashboards</a></li>
                        <li><a href="/security">Security &amp; trust</a></li>
                        <li><a href="/pricing">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <strong>Solutions</strong>
                    <ul>
                        <li><a href="/solutions/community-action-agencies">Community action agencies</a></li>
                        <li><a href="/solutions/shelters-housing">Shelters &amp; housing</a></li>
                        <li><a href="/solutions/food-banks-community-aid">Food banks &amp; community aid</a></li>
                        <li><a href="/solutions/parent-education">Parent education</a></li>
                    </ul>
                </div>
                <div>
                    <strong>Company</strong>
                    <ul>
                        <li><a href="/about">About Webriculture</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/contact">Request a demo</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-meta">
                <span>&copy; {{ date('Y') }} Webriculture. Need Navigator is built and supported in Salem, Oregon.</span>
                <span>Helping you help others.</span>
            </div>
        </div>
    </footer>

    <x-accessibility-toolbar />
    <x-scroll-to-top />
    <script defer src="/sites/neednavigator/js/site.js"></script>
</body>
</html>
