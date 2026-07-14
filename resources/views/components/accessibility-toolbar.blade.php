{{--
    Platform-layer accessibility toolbar — uniform on every SiteHub site.
    Self-contained (inline CSS/JS, localStorage persistence, no build step).
    Toggles: high contrast, larger text, link highlighting, legible font,
    large cursor.
--}}
<div class="sh-a11y" id="sh-a11y">
    <button type="button" class="sh-a11y__toggle" aria-expanded="false" aria-controls="sh-a11y-panel" title="{{ __('Accessibility options') }}">
        <span aria-hidden="true">&#9855;</span>
        <span class="sh-a11y__sr">{{ __('Accessibility options') }}</span>
    </button>
    <div class="sh-a11y__panel" id="sh-a11y-panel" hidden>
        <button type="button" data-a11y="contrast">{{ __('High contrast') }}</button>
        <button type="button" data-a11y="text">{{ __('Larger text') }}</button>
        <button type="button" data-a11y="links">{{ __('Highlight links') }}</button>
        <button type="button" data-a11y="font">{{ __('Legible font') }}</button>
        <button type="button" data-a11y="cursor">{{ __('Large cursor') }}</button>
        <button type="button" data-a11y-reset>{{ __('Reset') }}</button>
    </div>
</div>

<style>
    .sh-a11y { position: fixed; bottom: 1rem; right: 1rem; z-index: 9999; font-family: system-ui, sans-serif; }
    .sh-a11y__toggle { width: 3rem; height: 3rem; border-radius: 50%; border: 2px solid #1f2937; background: #fff; color: #1f2937; font-size: 1.5rem; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.25); }
    .sh-a11y__sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
    .sh-a11y__panel { position: absolute; bottom: 3.75rem; right: 0; display: flex; flex-direction: column; gap: .25rem; background: #fff; border: 1px solid #d1d5db; border-radius: .5rem; padding: .5rem; box-shadow: 0 4px 16px rgba(0,0,0,.2); min-width: 12rem; }
    .sh-a11y__panel button { padding: .5rem .75rem; border: 1px solid #d1d5db; border-radius: .375rem; background: #f9fafb; cursor: pointer; text-align: left; font-size: .9rem; }
    .sh-a11y__panel button[aria-pressed="true"] { background: #1f2937; color: #fff; }

    html.a11y-contrast { filter: contrast(1.25); }
    html.a11y-contrast body { background: #fff !important; color: #000 !important; }
    html.a11y-text { font-size: 125%; }
    html.a11y-links a { text-decoration: underline !important; background: #fef08a !important; color: #1e3a8a !important; }
    html.a11y-font body, html.a11y-font button, html.a11y-font input, html.a11y-font textarea { font-family: Verdana, Arial, sans-serif !important; letter-spacing: .02em; }
    html.a11y-cursor, html.a11y-cursor * { cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path d="M4 2l16 11h-7l4 7-3 2-4-7-6 5z" fill="black" stroke="white" stroke-width="1.5"/></svg>') 4 2, auto !important; }
</style>

<script>
    (function () {
        var KEY = 'sh-a11y';
        var root = document.documentElement;
        var widget = document.getElementById('sh-a11y');
        var toggle = widget.querySelector('.sh-a11y__toggle');
        var panel = widget.querySelector('.sh-a11y__panel');
        var state = {};

        try { state = JSON.parse(localStorage.getItem(KEY) || '{}'); } catch (e) { state = {}; }

        function apply() {
            ['contrast', 'text', 'links', 'font', 'cursor'].forEach(function (k) {
                root.classList.toggle('a11y-' + k, !!state[k]);
                var btn = panel.querySelector('[data-a11y="' + k + '"]');
                if (btn) btn.setAttribute('aria-pressed', state[k] ? 'true' : 'false');
            });
            try { localStorage.setItem(KEY, JSON.stringify(state)); } catch (e) {}
        }

        toggle.addEventListener('click', function () {
            var open = panel.hasAttribute('hidden');
            if (open) { panel.removeAttribute('hidden'); } else { panel.setAttribute('hidden', ''); }
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        panel.addEventListener('click', function (e) {
            var btn = e.target.closest('button');
            if (!btn) return;
            if (btn.hasAttribute('data-a11y-reset')) {
                state = {};
            } else {
                var k = btn.getAttribute('data-a11y');
                state[k] = !state[k];
            }
            apply();
        });

        apply();
    })();
</script>
