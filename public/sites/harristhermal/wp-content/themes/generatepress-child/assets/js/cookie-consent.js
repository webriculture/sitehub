/**
 * Lightweight, dependency-free cookie/tracking consent.
 *
 * Works with Google Consent Mode v2 (see the inline default set in
 * inc/site-widgets.php, printed early in <head>). Analytics/ad storage
 * default to "denied"; clicking "Accept" flips them to "granted" so the
 * MonsterInsights / Site Kit gtag can drop cookies. "Only Necessary"
 * stores the choice and leaves consent denied.
 */
(function () {
    var KEY = 'cookie-consent';
    var banner = document.getElementById('cookie-consent');
    if (!banner) return;

    function stored() {
        try { return localStorage.getItem(KEY); } catch (e) { return null; }
    }
    function save(value) {
        try { localStorage.setItem(KEY, value); } catch (e) {}
    }
    function hide() { banner.setAttribute('hidden', ''); }

    function grantConsent() {
        if (typeof window.gtag === 'function') {
            window.gtag('consent', 'update', {
                ad_storage: 'granted',
                analytics_storage: 'granted',
                ad_user_data: 'granted',
                ad_personalization: 'granted'
            });
        }
    }

    // Show only if the visitor hasn't decided yet.
    if (!stored()) { banner.removeAttribute('hidden'); }

    document.getElementById('cc-accept').addEventListener('click', function () {
        save('accepted');
        grantConsent();
        hide();
    });

    document.getElementById('cc-decline').addEventListener('click', function () {
        save('declined');
        hide();
    });

    // Let other UI re-open the banner, e.g. a footer "Cookie settings" link.
    window.openCookieConsent = function () { banner.removeAttribute('hidden'); };
})();
