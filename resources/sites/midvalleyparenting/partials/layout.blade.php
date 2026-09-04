@php
    $isEs = str(request()->path())->startsWith('es');
    $prefix = $isEs ? '/es' : '';
    $togglePath = $isEs
        ? preg_replace('#^/?es/?#', '/', '/'.request()->path())
        : '/es'.(request()->path() === '/' ? '' : '/'.request()->path());
    $togglePath = '/'.ltrim($togglePath, '/');
    if ($togglePath === '/es/') $togglePath = '/es';
    $nav = $isEs
        ? [
            ['href' => '/es', 'label' => 'Inicio'],
            ['href' => '/es/recursos', 'label' => 'Recursos'],
            ['href' => '/classes', 'label' => 'Clases'],
            ['href' => '/contact', 'label' => 'Contacto'],
        ]
        : [
            ['href' => '/classes', 'label' => 'Find Classes'],
            ['href' => '/resources', 'label' => 'Resources'],
            ['href' => '/events', 'label' => 'Events'],
            ['href' => '/providers', 'label' => 'For Providers'],
            ['href' => '/about', 'label' => 'About'],
            ['href' => '/contact', 'label' => 'Contact'],
        ];
@endphp
<!doctype html>
<html lang="{{ $isEs ? 'es' : 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mid-Valley Parenting | Classes, Resources, and Support for Families')</title>
    <meta name="description" content="@yield('description', $isEs ? 'Encuentre clases para padres, recursos familiares, eventos y apoyo para padres y cuidadores en los condados de Polk y Yamhill.' : 'Find parenting classes, family resources, events, and support for parents and caregivers in Polk and Yamhill Counties.')">
    <link rel="stylesheet" href="/sites/midvalleyparenting/css/styles.css?v=20260904">
</head>
<body>
    <a class="skip-link" href="#main">{{ $isEs ? 'Saltar al contenido principal' : 'Skip to main content' }}</a>

    <div class="site-shell">
        <div class="announcement">
            <p>{{ $isEs ? 'Las clases para padres ya están abiertas para inscripción.' : 'Parenting classes are now open for registration.' }}</p>
            <a href="/classes">{{ $isEs ? 'Buscar una clase' : 'Find a class' }}</a>
        </div>

        <header class="site-header" data-header>
            <a class="brand" href="{{ $prefix ?: '/' }}" aria-label="{{ $isEs ? 'Inicio de Mid-Valley Parenting' : 'Mid-Valley Parenting home' }}">
                <img class="brand-logo" src="/sites/midvalleyparenting/img/mvp-logo.png" alt="Mid-Valley Parenting">
            </a>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-menu-toggle>
                <span class="menu-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ $isEs ? 'Abrir menú' : 'Open menu' }}</span>
            </button>

            <nav class="primary-nav" id="primary-nav" aria-label="{{ $isEs ? 'Navegación principal' : 'Primary navigation' }}" data-nav>
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ $togglePath }}" lang="{{ $isEs ? 'en' : 'es' }}">{{ $isEs ? 'English' : 'Español' }}</a>
            </nav>

            <a class="header-cta" href="/classes">{{ $isEs ? 'Buscar una Clase' : 'Find a Class' }}</a>
        </header>

        <main id="main">
            @yield('content')
        </main>

        <footer class="site-footer">
            <div>
                <a class="brand footer-brand" href="{{ $prefix ?: '/' }}" aria-label="{{ $isEs ? 'Inicio de Mid-Valley Parenting' : 'Mid-Valley Parenting home' }}">
                    <img class="brand-logo" src="/sites/midvalleyparenting/img/mvp-logo.png" alt="Mid-Valley Parenting">
                </a>
                <p>{{ $isEs ? 'Sirviendo a las familias de los condados de Polk y Yamhill.' : 'Serving families in Polk and Yamhill Counties.' }}</p>
                <p>1407 Monmouth Independence Hwy., Monmouth, OR 97361<br>
                   807 NE 3rd Street, McMinnville, OR 97128</p>
                <p><a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook</a> ·
                   <a href="https://orparenting.org/" rel="noopener">OPEC</a></p>
            </div>
            <nav aria-label="{{ $isEs ? 'Navegación del pie de página' : 'Footer navigation' }}">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ $togglePath }}" lang="{{ $isEs ? 'en' : 'es' }}">{{ $isEs ? 'English' : 'Español' }}</a>
            </nav>
        </footer>
    </div>

    <x-accessibility-toolbar />
    <x-scroll-to-top />
    <script src="/sites/midvalleyparenting/js/site.js" defer></script>
</body>
</html>
