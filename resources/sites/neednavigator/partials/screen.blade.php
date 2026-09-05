{{--
    A real product screenshot, WebP with PNG fallback, served from
    public/sites/neednavigator/img/screens/. Sources for re-cropping live
    outside the repo at /home/ubuntu/sitehub-image-sources/neednavigator/.

    @include('site::partials.screen', ['name' => 'dashboard', 'alt' => '…', 'width' => 1665, 'height' => 870])
    Optional: 'class' (defaults to uiframe-shot), 'eager' => true for above-the-fold images.
--}}
@php
    $base = '/sites/neednavigator/img/screens/'.$name;
    $eager = $eager ?? false;
@endphp
<picture>
    <source srcset="{{ $base }}.webp" type="image/webp">
    <img src="{{ $base }}.png" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}" class="{{ $class ?? 'uiframe-shot' }}" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async" @if($eager) fetchpriority="high" @endif>
</picture>
