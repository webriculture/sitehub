@php
    $isEs = str(request()->path())->startsWith('es');
    $prefix = $isEs ? '/es' : '';
    $togglePath = $isEs
        ? preg_replace('#^/?es/?#', '/', '/'.request()->path())
        : '/es'.(request()->path() === '/' ? '' : '/'.request()->path());
    $togglePath = '/'.ltrim($togglePath, '/');
    if ($togglePath === '/es/') $togglePath = '/es';
    $nav = [
        ['href' => $prefix.'/', 'label' => $isEs ? 'Inicio' : 'Home'],
        ['href' => $prefix.'/about', 'label' => $isEs ? 'Quiénes Somos' : 'About'],
        ['href' => $prefix.'/partners', 'label' => $isEs ? 'Organizaciones' : 'Partners'],
        ['href' => $prefix.'/events', 'label' => $isEs ? 'Eventos y Clases' : 'Events & Classes'],
        ['href' => $prefix.'/contact', 'label' => $isEs ? 'Contacto' : 'Contact'],
    ];
@endphp
<!doctype html>
<html lang="{{ $isEs ? 'es' : 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FRAN — Family Resource Advocacy Network')</title>
    <meta name="description" content="@yield('description', $isEs ? 'FRAN: un centro comunitario en el noreste de Salem para navegar servicios sociales y programas de autosuficiencia.' : 'FRAN: a Northeast Salem community hub for navigating social services and self-sufficiency programs.')">
    {{-- PLACEHOLDER DESIGN — real design lands when the designer delivers. --}}
    <style>
        :root {
            --brand: #1d6a4f; --brand-dark: #14503b; --accent: #e8a33d;
            --ink: #24312b; --paper: #fbfaf7; --soft: #eef2ee; --line: #d8ded9;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, 'Segoe UI', sans-serif; color: var(--ink); background: var(--paper); line-height: 1.6; }
        a { color: var(--brand); }
        .wrap { max-width: 68rem; margin: 0 auto; padding: 0 1.25rem; }
        .site-header { background: #fff; border-bottom: 3px solid var(--brand); }
        .site-header .wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; padding-top: .9rem; padding-bottom: .9rem; }
        .brand { font-weight: 800; font-size: 1.35rem; color: var(--brand-dark); text-decoration: none; letter-spacing: -.01em; }
        .brand small { display: block; font-weight: 500; font-size: .72rem; color: var(--ink); letter-spacing: .02em; }
        nav.main { display: flex; flex-wrap: wrap; gap: .25rem; margin-left: auto; }
        nav.main a { text-decoration: none; padding: .45rem .7rem; border-radius: .4rem; color: var(--ink); font-size: .95rem; }
        nav.main a:hover { background: var(--soft); }
        .lang-toggle { border: 1.5px solid var(--brand); border-radius: 2rem; padding: .3rem .8rem; text-decoration: none; font-size: .85rem; font-weight: 600; }
        .hero { background: linear-gradient(160deg, var(--brand) 0%, var(--brand-dark) 100%); color: #fff; padding: 3.5rem 0; }
        .hero h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); margin: 0 0 .5rem; line-height: 1.2; }
        .hero p { font-size: 1.15rem; max-width: 42rem; margin: 0; opacity: .95; }
        .hero .cta { display: inline-block; margin-top: 1.5rem; background: var(--accent); color: var(--ink); font-weight: 700; text-decoration: none; padding: .7rem 1.3rem; border-radius: .5rem; }
        main { padding: 2.5rem 0 3.5rem; }
        main h1 { color: var(--brand-dark); }
        main h2 { color: var(--brand-dark); margin-top: 2.25rem; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr)); gap: 1rem; margin: 1.5rem 0; padding: 0; list-style: none; }
        .cards li { background: #fff; border: 1px solid var(--line); border-radius: .6rem; padding: 1.1rem 1.2rem; }
        .cards h3 { margin: 0 0 .4rem; font-size: 1.05rem; color: var(--brand-dark); }
        .cards p { margin: 0; font-size: .95rem; }
        .site-footer { background: var(--brand-dark); color: #e7efe9; padding: 2rem 0; font-size: .9rem; }
        .site-footer a { color: #fff; }
        /* component defaults */
        .sh-partners { display: grid; gap: 1rem; }
        .sh-partner { display: flex; gap: 1rem; background: #fff; border: 1px solid var(--line); border-radius: .6rem; padding: 1.2rem; }
        .sh-partner__logo { width: 5.5rem; height: 5.5rem; object-fit: contain; flex: none; }
        .sh-partner__name { margin: 0 0 .3rem; color: var(--brand-dark); }
        .sh-partner__programs { padding-left: 1.1rem; }
        .sh-partner__meta { display: flex; gap: 1rem; margin-top: .5rem; }
        .sh-events { display: grid; gap: 1rem; }
        .sh-event { display: flex; gap: 1rem; background: #fff; border: 1px solid var(--line); border-radius: .6rem; padding: 1.2rem; }
        .sh-event__date { flex: none; width: 3.6rem; text-align: center; background: var(--soft); border-radius: .5rem; padding: .5rem 0; height: fit-content; }
        .sh-event__month { display: block; font-size: .75rem; text-transform: uppercase; color: var(--brand-dark); font-weight: 700; }
        .sh-event__day { display: block; font-size: 1.5rem; font-weight: 800; line-height: 1.1; }
        .sh-event__title { margin: 0 0 .2rem; color: var(--brand-dark); }
        .sh-event__when, .sh-event__location { margin: 0; font-size: .9rem; color: #4b5563; }
        .sh-event__description { margin: .5rem 0 0; }
        .sh-event__register { display: inline-block; margin-top: .6rem; background: var(--brand); color: #fff; text-decoration: none; padding: .45rem .9rem; border-radius: .4rem; font-size: .9rem; }
        .sh-form { max-width: 34rem; }
        .sh-form__field label { display: block; font-weight: 600; margin-bottom: .25rem; }
        .sh-form__field input, .sh-form__field textarea { width: 100%; padding: .55rem .65rem; border: 1px solid var(--line); border-radius: .4rem; font: inherit; background: #fff; }
        .sh-form__hp { position: absolute; left: -9999px; }
        .sh-form__actions button { background: var(--brand); color: #fff; border: 0; font: inherit; font-weight: 700; padding: .65rem 1.4rem; border-radius: .5rem; cursor: pointer; }
        .sh-form__success { background: #e7f6ec; border: 1px solid #9fd7b2; padding: .8rem 1rem; border-radius: .5rem; }
        .sh-form__error { background: #fdeeee; border: 1px solid #f0b6b6; padding: .8rem 1rem; border-radius: .5rem; }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="wrap">
            <a class="brand" href="{{ $prefix ?: '/' }}">FRAN
                <small>{{ $isEs ? 'Red de Defensa de Recursos Familiares' : 'Family Resource Advocacy Network' }}</small>
            </a>
            <nav class="main" aria-label="{{ $isEs ? 'Navegación principal' : 'Main navigation' }}">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <a class="lang-toggle" href="{{ $togglePath }}" lang="{{ $isEs ? 'en' : 'es' }}">{{ $isEs ? 'English' : 'Español' }}</a>
        </div>
    </header>

    @yield('hero')

    <main class="wrap">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="wrap">
            <p><strong>FRAN — {{ $isEs ? 'Red de Defensa de Recursos Familiares' : 'Family Resource Advocacy Network' }}</strong><br>
            {{ $isEs ? 'Noreste de Salem, Oregón' : 'Northeast Salem, Oregon' }}</p>
            <p>{{ $isEs ? 'Una iniciativa de la Fundación Familiar Larry y Jeanette Epping.' : 'An initiative of the Larry and Jeanette Epping Family Foundation.' }}</p>
        </div>
    </footer>

    <x-accessibility-toolbar />
</body>
</html>
