{{--
    A real product screenshot, WebP with PNG fallback, served from
    public/sites/neednavigator/img/screens/. Sources for re-cropping live
    outside the repo at /home/ubuntu/sitehub-image-sources/neednavigator/.

    @include('site::partials.screen', ['name' => 'dashboard', 'alt' => '…', 'width' => 1654, 'height' => 873])
    Optional: 'class' (defaults to uiframe-shot), 'eager' => true above the fold,
    'zoom' => false to skip the enlarge link (framed shots get it by default; the hero card does not).
--}}
@php
    $base = '/sites/neednavigator/img/screens/'.$name;
    $eager = $eager ?? false;
    $class = $class ?? 'uiframe-shot';
    $zoom = $zoom ?? ($class !== 'hero-card');
@endphp
@if($zoom)<a class="shot-zoom" href="{{ $base }}.png" data-lightbox aria-label="Enlarge: {{ $alt }}">@endif
<picture>
    <source srcset="{{ $base }}.webp" type="image/webp">
    <img src="{{ $base }}.png" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}" class="{{ $class }}" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async" @if($eager) fetchpriority="high" @endif>
</picture>
@if($zoom)</a>@endif
