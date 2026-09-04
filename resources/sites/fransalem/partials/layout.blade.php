@php
    $isEs = str(request()->path())->startsWith('es');
    $prefix = $isEs ? '/es' : '';
    $home = $prefix ?: '/';
    $togglePath = $isEs
        ? preg_replace('#^/?es/?#', '/', '/'.request()->path())
        : '/es'.(request()->path() === '/' ? '' : '/'.request()->path());
    $togglePath = '/'.ltrim($togglePath, '/');
    if ($togglePath === '/es/') $togglePath = '/es';

    // Every nav item is a real page (client direction, Aug 2026: distinct
    // subpages, no scroll-to anchors), so each carries a current-page state.
    $nav = [
        ['href' => $prefix.'/find-support', 'label' => $isEs ? 'Buscar Apoyo' : 'Find Support', 'match' => $prefix.'/find-support'],
        ['href' => $prefix.'/about', 'label' => $isEs ? 'Quiénes Somos' : 'About', 'match' => $prefix.'/about'],
        ['href' => $prefix.'/events', 'label' => $isEs ? 'Eventos y Clases' : 'Events & Classes', 'match' => $prefix.'/events'],
        ['href' => $prefix.'/contact', 'label' => $isEs ? 'Contacto' : 'Contact', 'match' => $prefix.'/contact'],
    ];
    $current = '/'.trim(request()->path(), '/');
    $isCurrent = fn (?string $match) => $match !== null && rtrim($match, '/') === rtrim($current, '/');
@endphp
<!doctype html>
<html lang="{{ $isEs ? 'es' : 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FRAN | Family Resource Advocacy Network')</title>
    <meta name="description" content="@yield('description', $isEs ? 'Conéctese con recursos familiares, organizaciones comunitarias y apoyo a través de FRAN, la Red de Defensa de Recursos Familiares en el noreste de Salem.' : 'Connect with family resources, community partners, advocacy, and support through FRAN, the Family Resource Advocacy Network in Northeast Salem.')">
    <link rel="preload" href="/sites/fransalem/fonts/shantell-sans-var-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/sites/fransalem/fonts/nunito-var-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="/sites/fransalem/css/styles.css">
    <link rel="stylesheet" href="/sites/fransalem/css/sitehub.css">
</head>
<body>
    <a class="skip-link" href="#main">{{ $isEs ? 'Saltar al contenido' : 'Skip to content' }}</a>

    <header class="site-header">
        <div class="container nav">
            <a class="brand brand-logo" href="{{ $home }}" aria-label="{{ $isEs ? 'Página de inicio de FRAN' : 'FRAN homepage' }}">
                <img src="/sites/fransalem/assets/logos/fran-official.png" alt="FRAN — {{ $isEs ? 'Red de Defensa de Recursos Familiares' : 'Family Resource Advocacy Network' }}">
            </a>
            <button class="nav-toggle" type="button" data-nav-toggle aria-controls="primary-navigation" aria-expanded="false">{{ $isEs ? 'Menú' : 'Menu' }}</button>
            <nav class="nav-links" id="primary-navigation" data-nav-links aria-label="{{ $isEs ? 'Navegación principal' : 'Primary navigation' }}">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}" @if ($isCurrent($item['match'] ?? null)) class="active" aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <a class="button small lang-toggle" href="{{ $togglePath }}" lang="{{ $isEs ? 'en' : 'es' }}">{{ $isEs ? 'English' : 'Español' }}</a>
            </nav>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-grid brand-footer-grid">
            <div class="footer-brand-col">
                <a class="brand footer-logo-card" href="{{ $home }}" aria-label="{{ $isEs ? 'Página de inicio de FRAN' : 'FRAN homepage' }}">
                    <img src="/sites/fransalem/assets/logos/fran-logo-footer.png" alt="FRAN — {{ $isEs ? 'Red de Defensa de Recursos Familiares' : 'Family Resource Advocacy Network' }}">
                </a>
                <p class="footer-tagline">
                    <strong>{{ $isEs ? 'Familia. Conexión. Comunidad.' : 'Family. Connection. Community.' }}</strong><br>
                    <em>{{ $isEs ? 'Apoyando juntos al noreste de Salem.' : 'Supporting Northeast Salem Together.' }}</em>
                </p>
                <div class="managed-by-logo">
                    <img src="/sites/fransalem/assets/logos/fhi-managed-by.png" alt="{{ $isEs ? 'Gestionado profesionalmente por Fostering Hope Initiative' : 'Professionally Managed By Fostering Hope Initiative' }}">
                </div>
            </div>
            <div class="footer-contact-col">
                <strong>{{ $isEs ? 'Contacto FRAN' : 'Contact FRAN' }}</strong>
                <p>3803 Lancaster Dr NE<br>Salem, OR 97305</p>
                <p><a href="mailto:Info@FranSalem.com">Info@FranSalem.com</a></p>
            </div>
            <div class="footer-links">
                <p>
                    @foreach ($nav as $item)
                        <a href="{{ $item['href'] }}">{{ $item['label'] }}</a><br>
                    @endforeach
                </p>
            </div>
        </div>
        <div class="container footer-bottom">
            <small>{{ $isEs ? 'Red de Defensa de Recursos Familiares (FRAN)' : 'Family Resource Advocacy Network (FRAN)' }}</small>
        </div>
    </footer>

    <x-accessibility-toolbar />
    <x-scroll-to-top />
    <script defer src="/sites/fransalem/js/main.js"></script>
</body>
</html>
