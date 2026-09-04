{{--
    Platform-layer scroll-to-top button — uniform on every SiteHub site.
    Self-contained (inline CSS/JS, no build step). Hidden until the page is
    scrolled; respects prefers-reduced-motion.
--}}
<button type="button" class="sh-top" id="sh-top" hidden title="{{ __('Back to top') }}">
    <span aria-hidden="true">&#8593;</span>
    <span class="sh-top__sr">{{ __('Back to top') }}</span>
</button>

<style>
    .sh-top { position: fixed; bottom: 1rem; right: 1rem; z-index: 9999; width: 3rem; height: 3rem; border-radius: 50%; border: 2px solid #1f2937; background: #fff; color: #1f2937; font-size: 1.5rem; font-family: system-ui, sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.25); }
    .sh-top[hidden] { display: none; }
    .sh-top__sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
</style>

<script>
    (function () {
        var btn = document.getElementById('sh-top');

        function update() {
            if (window.scrollY > 300) { btn.removeAttribute('hidden'); } else { btn.setAttribute('hidden', ''); }
        }

        btn.addEventListener('click', function () {
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
        });

        window.addEventListener('scroll', update, { passive: true });
        update();
    })();
</script>
