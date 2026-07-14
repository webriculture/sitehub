@props(['kind' => null])

@php
    $site = \App\Tenancy\Tenancy::current();
    $events = $site?->hasFeature('events')
        ? \App\Models\Tenant\Event::query()->upcoming()->when($kind ?? null, fn ($q, $k) => $q->where('kind', $k))->get()
        : collect();
@endphp

@if ($events->isNotEmpty())
    <section class="sh-events">
        @foreach ($events as $event)
            <article class="sh-event sh-event--{{ $event->kind }}">
                <time class="sh-event__date" datetime="{{ $event->starts_at->toIso8601String() }}">
                    <span class="sh-event__month">{{ $event->starts_at->translatedFormat('M') }}</span>
                    <span class="sh-event__day">{{ $event->starts_at->format('j') }}</span>
                </time>
                <div class="sh-event__body">
                    <h3 class="sh-event__title">{{ $event->localizedTitle() }}</h3>
                    <p class="sh-event__when">
                        {{ $event->starts_at->translatedFormat('l, F j') }}
                        @unless ($event->all_day)
                            · {{ $event->starts_at->format('g:i A') }}@if ($event->ends_at) – {{ $event->ends_at->format('g:i A') }}@endif
                        @endunless
                    </p>
                    @if ($location = $event->localizedLocation())
                        <p class="sh-event__location">{{ $location }}</p>
                    @endif
                    @if ($description = $event->localizedDescription())
                        <p class="sh-event__description">{{ $description }}</p>
                    @endif
                    @if ($event->registration_url)
                        <a class="sh-event__register" href="{{ $event->registration_url }}">{{ __('Register') }}</a>
                    @endif
                </div>
            </article>
        @endforeach
    </section>
@endif
