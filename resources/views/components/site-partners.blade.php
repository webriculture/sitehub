@php
    $site = \App\Tenancy\Tenancy::current();
    $partners = $site?->hasFeature('partners')
        ? \App\Models\Tenant\Partner::query()->published()->get()
        : collect();
@endphp

@if ($partners->isNotEmpty())
    <section class="sh-partners">
        @foreach ($partners as $partner)
            <article class="sh-partner">
                @if ($partner->logo_path)
                    <img class="sh-partner__logo" src="{{ Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}">
                @endif
                <div class="sh-partner__body">
                    <h3 class="sh-partner__name">{{ $partner->name }}</h3>
                    @if ($description = $partner->localizedDescription())
                        <p class="sh-partner__description">{{ $description }}</p>
                    @endif
                    @if (! empty($partner->programs))
                        <ul class="sh-partner__programs">
                            @foreach ($partner->programs as $program)
                                <li class="sh-partner__program">
                                    <strong>{{ \App\Support\Translate::pick($program['name'] ?? null) }}</strong>
                                    @if ($programDescription = \App\Support\Translate::pick($program['description'] ?? null))
                                        <span> — {{ $programDescription }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <footer class="sh-partner__meta">
                        @if ($partner->website_url)
                            <a class="sh-partner__link" href="{{ $partner->website_url }}" rel="noopener">{{ __('Visit website') }}</a>
                        @endif
                        @if ($partner->phone)
                            <a class="sh-partner__phone" href="tel:{{ preg_replace('/[^0-9+]/', '', $partner->phone) }}">{{ $partner->phone }}</a>
                        @endif
                    </footer>
                </div>
            </article>
        @endforeach
    </section>
@endif
