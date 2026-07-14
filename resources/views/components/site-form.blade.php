@props(['key' => 'contact'])

@php
    $site = \App\Tenancy\Tenancy::current();
    $enabled = $site?->hasFeature('forms') ?? false;
    $siteKey = $site?->settings['turnstile_site_key'] ?? config('services.turnstile.site_key');
    $sent = request()->query('sent') === $key;
    $error = request()->query('error');
@endphp

@if ($enabled)
    <div class="sh-form">
        @if ($sent)
            <p class="sh-form__success" role="status">{{ __('Thank you! Your message has been sent.') }}</p>
        @else
            @if ($error === 'verification')
                <p class="sh-form__error" role="alert">{{ __('We could not verify that you are human. Please try again.') }}</p>
            @elseif ($error === 'validation')
                <p class="sh-form__error" role="alert">{{ __('Please fill in your name, email, and message.') }}</p>
            @endif

            <form method="POST" action="{{ route('forms.submit', ['key' => $key]) }}">
                <p class="sh-form__field">
                    <label for="sh-form-name">{{ __('Name') }}</label>
                    <input id="sh-form-name" name="name" type="text" required maxlength="255" autocomplete="name">
                </p>
                <p class="sh-form__field">
                    <label for="sh-form-email">{{ __('Email') }}</label>
                    <input id="sh-form-email" name="email" type="email" required maxlength="255" autocomplete="email">
                </p>
                <p class="sh-form__field">
                    <label for="sh-form-phone">{{ __('Phone (optional)') }}</label>
                    <input id="sh-form-phone" name="phone" type="tel" maxlength="50" autocomplete="tel">
                </p>
                <p class="sh-form__field">
                    <label for="sh-form-message">{{ __('Message') }}</label>
                    <textarea id="sh-form-message" name="message" rows="5" required maxlength="5000"></textarea>
                </p>

                {{-- Honeypot: hidden from humans, irresistible to bots. --}}
                <p class="sh-form__hp" aria-hidden="true">
                    <label for="sh-form-website">Website</label>
                    <input id="sh-form-website" name="website" type="text" tabindex="-1" autocomplete="off">
                </p>

                @if ($siteKey)
                    <div class="cf-turnstile" data-sitekey="{{ $siteKey }}"></div>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                @endif

                <p class="sh-form__actions">
                    <button type="submit">{{ __('Send message') }}</button>
                </p>
            </form>
        @endif
    </div>
@endif
