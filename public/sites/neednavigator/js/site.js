/* Need Navigator — progressive enhancement only.
   Everything on this site works with JavaScript disabled:
   - nav collapses to a toggle on small screens (server-rendered links)
   - FAQs are native <details>/<summary>
   - .reveal elements render visible by default when JS or IO is absent */
(function () {
  document.documentElement.classList.remove('no-js');
  document.documentElement.classList.add('js');

  // Mobile nav toggle
  var toggle = document.querySelector('[data-nav-toggle]');
  var links = document.querySelector('[data-nav-links]');
  if (toggle && links) {
    toggle.addEventListener('click', function () {
      var open = links.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && links.classList.contains('open')) {
        links.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  // Screenshot lightbox: any a[data-lightbox] opens the shared <dialog>;
  // the link itself points at the PNG, so it still works without JS.
  var dlg = document.querySelector('[data-lightbox-dialog]');
  if (dlg && typeof dlg.showModal === 'function') {
    var dlgImg = dlg.querySelector('[data-lightbox-img]');
    var dlgCap = dlg.querySelector('[data-lightbox-caption]');
    document.addEventListener('click', function (e) {
      var a = e.target.closest && e.target.closest('a[data-lightbox]');
      if (!a) return;
      e.preventDefault();
      var img = a.querySelector('img');
      dlgImg.src = (img && img.currentSrc) || a.href;
      dlgImg.alt = img ? img.alt : '';
      dlgCap.textContent = img ? img.alt : '';
      dlg.showModal();
    });
    dlg.addEventListener('click', function (e) {
      if (e.target === dlg || e.target.closest('[data-lightbox-close]')) dlg.close();
    });
    dlg.addEventListener('close', function () { dlgImg.removeAttribute('src'); });
  }

  // Gentle scroll-in reveal; disabled for reduced motion, absent without IO
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!('IntersectionObserver' in window) || reduced) {
    document.documentElement.classList.add('no-io');
    return;
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { rootMargin: '0px 0px -8% 0px' });
  document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
})();
